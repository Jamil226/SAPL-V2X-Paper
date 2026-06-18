<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SecurityService;
use App\Services\LocalizationService;
use App\Models\Vehicle;
use App\Models\AuthSession;
use App\Models\Rsu;
use Carbon\Carbon;
use Exception;

class SimulatorController extends Controller
{
    protected $securityService;
    protected $localizationService;

    public function __construct(SecurityService $securityService, LocalizationService $localizationService)
    {
        $this->securityService = $securityService;
        $this->localizationService = $localizationService;
    }

    /**
     * POST /simulate/auth
     * Authenticate a vehicle (V2I or V2V)
     */
    public function auth(Request $request)
    {
        try {
            $type = $request->input('auth_type', 'v2i');

            if ($type === 'v2i') {
                $vehicleUid = $request->input('vehicle_uid');

                // If vehicle doesn't exist, we can register/create it dynamically for convenience,
                // except if it is the known demo vehicles
                $vehicle = Vehicle::where('vehicle_uid', $vehicleUid)->first();
                if (!$vehicle && !in_array($vehicleUid, ['VEH-DEMO-001', 'VEH-DEMO-002', 'VEH-DEMO-003'])) {
                    $vehicle = Vehicle::create([
                        'vehicle_uid' => $vehicleUid,
                        'secret_key' => bin2hex(random_bytes(32)),
                        'group_key' => 'STATIC_GROUP_KEY_FOR_SIMULATION',
                        'is_active' => true,
                    ]);
                }

                $requestData = $request->only(['vehicle_uid', 'message', 'timestamp', 'seq', 'mac']);
                $result = $this->securityService->v2iAuthenticate($requestData);

                return response()->json([
                    'status' => 'success',
                    'message' => 'V2I Authentication successful. Session token issued.',
                    'data' => array_merge($result, [
                        'vehicle_uid' => $vehicleUid,
                    ])
                ]);
            } elseif ($type === 'v2v') {
                $vehicleAId = $request->input('vehicle_a_uid');
                $vehicleBId = $request->input('vehicle_b_uid');
                
                $vehicleA = Vehicle::where('vehicle_uid', $vehicleAId)->first();
                $vehicleB = Vehicle::where('vehicle_uid', $vehicleBId)->first();
                
                if (!$vehicleA || !$vehicleB) {
                    throw new Exception("One or both vehicles not registered.");
                }

                $requestData = [
                    'vehicle_b_uid' => $vehicleBId,
                    'challenge' => $request->input('challenge'),
                    'timestamp' => $request->input('timestamp'),
                    'mac' => $request->input('mac'),
                ];
                
                $result = $this->securityService->v2vAuthenticate($vehicleA, $requestData);

                return response()->json([
                    'status' => 'success',
                    'message' => 'V2V Mutual Authentication successful. Secure channel active.',
                    'session_key' => $result['session_key'],
                    'challenge_a' => $result['challenge_a']
                ]);
            }

            return response()->json(['status' => 'error', 'message' => 'Invalid authentication type.'], 400);

        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * POST /simulate/localization
     * Calculate true coordinates and obfuscated DP coordinates
     */
    public function localization(Request $request)
    {
        try {
            $sessionToken = $request->input('session_token');
            $session = AuthSession::where('session_token', $sessionToken)->first();

            if (!$session || $session->expires_at->isPast()) {
                throw new Exception("Invalid or expired session token.");
            }

            $signals = $request->input('signals', []);
            $rsuData = [];

            foreach ($signals as $signal) {
                $rsu = Rsu::where('rsu_uid', $signal['rsu_uid'])->first();
                if ($rsu) {
                    $distance = $this->localizationService->estimateDistance($rsu->tx_power, $signal['rssi']);
                    $rsuData[] = [
                        'x' => $rsu->latitude,
                        'y' => $rsu->longitude,
                        'd' => $distance
                    ];
                }
            }

            if (count($rsuData) < 3) {
                throw new Exception("Insufficient RSU signals (Need at least 3).");
            }

            $locationBase = $this->localizationService->multilaterate($rsuData);
            $dpLocation = $this->localizationService->addLaplaceNoise($locationBase);

            return response()->json([
                'status' => 'success',
                'message' => 'Localization updated successfully.',
                'original_location' => $locationBase,
                'privacy_location' => $dpLocation,
            ]);

        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * POST /simulate/messages
     * Send safety message (CAM) via V2I or V2V
     */
    public function messages(Request $request)
    {
        try {
            $sender = $request->input('sender');
            $receiver = $request->input('receiver');
            $msgType = $request->input('message_type', 'CAM');
            $channel = $request->input('channel', 'V2I');

            if ($channel === 'V2I') {
                $sessionToken = $request->input('session_token');
                $session = AuthSession::where('session_token', $sessionToken)->first();
                if (!$session || $session->expires_at->isPast()) {
                    throw new Exception("Access Denied: Invalid or expired session token.");
                }
            } else {
                // V2V
                $sessionKey = $request->input('session_key');
                if (empty($sessionKey)) {
                    throw new Exception("Access Denied: V2V session key required.");
                }
            }

            // Simulate slight execution latency and successful delivery
            $latency = round(5 + (mt_rand() / mt_getrandmax()) * 10, 1); // 5 to 15 ms

            return response()->json([
                'status' => 'success',
                'message' => "{$msgType} message successfully sent from {$sender} to {$receiver}.",
                'data' => [
                    'latency_ms' => $latency,
                    'packet_success' => true,
                    'timestamp' => now()->format('H:i:s'),
                ]
            ]);

        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * GET /stats
     * Retrieve current system statistics
     */
    public function stats(Request $request)
    {
        // Dynamically compute stats based on current database state
        $activeSessions = AuthSession::where('expires_at', '>', Carbon::now())->count();
        $totalVehicles = Vehicle::where('is_active', true)->count();

        // Calculate simulated metrics based on active count
        $baseLatency = 8.5;
        $activeLoadModifier = $activeSessions * 4.2;
        $latency = round($baseLatency + $activeLoadModifier + (mt_rand() / mt_getrandmax()) * 2, 1);

        $packetSuccess = 100.0;
        if ($activeSessions > 0) {
            $packetSuccess = round(99.0 + (mt_rand() / mt_getrandmax()) * 0.9, 1);
        }

        // Generate loads per RSU
        $rsuLoads = [];
        $rsus = Rsu::all();
        $totalRsuLoadSum = 0;
        foreach ($rsus as $rsu) {
            // base load + active sessions load modifier
            $loadVal = mt_rand(4, 8) + ($activeSessions * mt_rand(2, 5));
            $rsuLoads[$rsu->rsu_uid] = "{$loadVal}%";
            $totalRsuLoadSum += $loadVal;
        }

        $bsLoadVal = mt_rand(15, 25) + ($activeSessions * mt_rand(5, 8));
        $bsLoad = "{$bsLoadVal}%";

        return response()->json([
            'status' => 'success',
            'connected_vehicles' => $totalVehicles,
            'authenticated_nodes' => $activeSessions,
            'message_latency_ms' => $latency,
            'packet_success_rate' => $packetSuccess,
            'rsu_load' => $rsuLoads,
            'bs_load' => $bsLoad,
            'timestamp' => Carbon::now()->toIso8601String()
        ]);
    }

    /**
     * GET /simulate/vehicle-info/{uid}
     * Fetch keys for a specific vehicle UID (or initialize if needed)
     */
    public function getVehicleInfo(Request $request, $uid)
    {
        try {
            $vehicle = Vehicle::where('vehicle_uid', $uid)->first();
            if (!$vehicle) {
                $vehicle = Vehicle::create([
                    'vehicle_uid' => $uid,
                    'secret_key' => bin2hex(random_bytes(32)),
                    'group_key' => 'STATIC_GROUP_KEY_FOR_SIMULATION',
                    'is_active' => ($uid !== 'VEH-DEMO-003'),
                ]);
            }
            return response()->json([
                'status' => 'success',
                'data' => [
                    'vehicle_uid' => $vehicle->vehicle_uid,
                    'secret_key' => $vehicle->secret_key,
                    'group_key' => $vehicle->group_key,
                    'is_active' => (bool)$vehicle->is_active,
                ]
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * POST /simulate/reset
     * Reset all active auth sessions in the database
     */
    public function reset(Request $request)
    {
        AuthSession::truncate();
        return response()->json([
            'status' => 'success',
            'message' => 'All simulation sessions have been reset.'
        ]);
    }
}

