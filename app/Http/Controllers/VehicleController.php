<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VehicleController extends Controller
{
    protected $securityService;
    protected $localizationService;

    public function __construct(\App\Services\SecurityService $securityService, \App\Services\LocalizationService $localizationService)
    {
        $this->securityService = $securityService;
        $this->localizationService = $localizationService;
    }

    public function register()
    {
        try {
            $vehicle = $this->securityService->registerVehicle();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Vehicle registered successfully.',
                'data' => [
                    'vehicle_uid' => $vehicle->vehicle_uid,
                    'secret_key' => $vehicle->secret_key,
                    'group_key' => $vehicle->group_key,
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function authenticate(Request $request)
    {
        try {
            $type = $request->input('auth_type', 'v2i');

            if ($type === 'v2i') {
                $requestData = $request->only(['vehicle_uid', 'message', 'timestamp', 'seq', 'mac']);
                $result = $this->securityService->v2iAuthenticate($requestData);
                return response()->json(['status' => 'success', 'data' => $result]);
            } elseif ($type === 'v2v') {
                $vehicleAId = $request->input('vehicle_a_uid');
                $vehicleA = \App\Models\Vehicle::where('vehicle_uid', $vehicleAId)->first();
                
                if (!$vehicleA) {
                    throw new \Exception("Vehicle A not found.");
                }

                $requestData = $request->only(['vehicle_b_uid', 'challenge', 'timestamp', 'mac']);
                $result = $this->securityService->v2vAuthenticate($vehicleA, $requestData);
                return response()->json($result);
            }

            return response()->json(['status' => 'error', 'message' => 'Invalid auth_type'], 400);
            
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 401);
        }
    }

    public function localize(Request $request)
    {
        try {
            $sessionToken = $request->input('session_token');
            $session = \App\Models\AuthSession::where('session_token', $sessionToken)->first();

            if (!$session || $session->expires_at->isPast()) {
                throw new \Exception("Invalid or expired session token.");
            }

            $signals = $request->input('signals', []);
            $rsuData = [];

            foreach ($signals as $signal) {
                $rsu = \App\Models\Rsu::where('rsu_uid', $signal['rsu_uid'])->first();
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
                throw new \Exception("Insufficient authenticated RSU signals.");
            }

            $locationBase = $this->localizationService->multilaterate($rsuData);
            $dpLocation = $this->localizationService->addLaplaceNoise($locationBase);

            return response()->json([
                'status' => 'success',
                'original_location' => $locationBase,
                'privacy_location' => $dpLocation,
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }
}
