<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Vehicle;
use App\Models\AuthSession;
use Carbon\Carbon;
use Exception;

class SecurityService
{
    /**
     * Replay protection window in seconds (\Delta T = 5s)
     */
    const REPLAY_WINDOW = 5;

    /**
     * Compute Hash-Based MAC using SHA-256.
     * MAC = H(K || m || Ts || Seq)
     */
    public function generateMac($key, $message, $timestamp, $seq)
    {
        $data = $key . $message . $timestamp . $seq;
        return hash('sha256', $data);
    }

    /**
     * Validate timestamp freshness to prevent replay attacks.
     */
    public function verifyFreshness($timestamp)
    {
        // Timestamp is normally in milliseconds for high-precision
        $timestampSec = floor($timestamp / 1000);
        $requestTime = Carbon::createFromTimestamp($timestampSec);
        $currentTime = Carbon::now();
        
        $diff = $currentTime->diffInSeconds($requestTime);
        
        if (abs($diff) > self::REPLAY_WINDOW) {
            throw new Exception("Timestamp is outside of the allowed replay window.");
        }
        
        return true;
    }

    /**
     * V2I Auth Phase 1 & 2: Register a new vehicle and provision keys.
     * In a real 6G network, this happens securely offline or via secure channel.
     */
    public function registerVehicle()
    {
        $vehicleUid = (string) Str::uuid();
        $secretKey = bin2hex(random_bytes(32));
        $groupKey = 'STATIC_GROUP_KEY_FOR_SIMULATION'; // In reality, securely distributed

        $vehicle = Vehicle::create([
            'vehicle_uid' => $vehicleUid,
            'secret_key' => $secretKey,
            'group_key' => $groupKey,
            'is_active' => true,
        ]);

        return $vehicle;
    }

    /**
     * V2I Auth Phase 3 & 4: Authenticate a vehicle with RSU and generate session token.
     * 
     * Request Data must contain:
     * - vehicle_uid: The UID of the vehicle
     * - message: Any payload
     * - timestamp: Request timestamp in ms
     * - seq: Sequence number
     * - mac: The MAC computed by the vehicle
     */
    public function v2iAuthenticate(array $requestData)
    {
        $vehicle = Vehicle::where('vehicle_uid', $requestData['vehicle_uid'])->first();
        
        if (!$vehicle || !$vehicle->is_active) {
            throw new Exception("Vehicle not found or inactive.");
        }

        // Verify Freshness
        $this->verifyFreshness($requestData['timestamp']);

        // Verify MAC
        $expectedMac = $this->generateMac(
            $vehicle->secret_key, 
            $requestData['message'], 
            $requestData['timestamp'], 
            $requestData['seq']
        );

        if (!hash_equals($expectedMac, $requestData['mac'])) {
            throw new Exception("Authentication failed: Invalid MAC.");
        }

        // Generate Session Token
        $sessionToken = bin2hex(random_bytes(32));
        $expiresAt = Carbon::now()->addHours(1);

        $session = $vehicle->authSessions()->create([
            'session_token' => $sessionToken,
            'expires_at' => $expiresAt,
        ]);

        return [
            'session_token' => $sessionToken,
            'expires_at' => $expiresAt,
        ];
    }

    /**
     * V2V Auth: Mutual authentication between two vehicles using Group Key ($K_G$).
     * Returns a derived session key if successful.
     */
    public function v2vAuthenticate(Vehicle $vehicleA, array $requestData)
    {
        // Vehicle A is verifying a request from Vehicle B using the shared group key
        
        // Structure of $requestData from Vehicle B:
        // - vehicle_b_uid: UID
        // - challenge: Random nonce from B
        // - timestamp: Request timestamp
        // - mac: MAC using Group Key

        $this->verifyFreshness($requestData['timestamp']);

        // Verify MAC from B using $K_G
        $expectedMacB = $this->generateMac(
            $vehicleA->group_key, 
            $requestData['challenge'], 
            $requestData['timestamp'], 
            '0' // seq=0 for initial challenge
        );

        if (!hash_equals($expectedMacB, $requestData['mac'])) {
            throw new Exception("V2V Authentication failed: Invalid MAC.");
        }

        // Derivation of K_session
        // K_session = H(K_G || challenge_A || challenge_B)
        // Since we are simulating, we'll generate a server-side response challenge
        $challengeA = bin2hex(random_bytes(16));
        $kSession = hash('sha256', $vehicleA->group_key . $challengeA . $requestData['challenge']);

        return [
            'status' => 'success',
            'session_key' => $kSession,
            'challenge_a' => $challengeA
        ];
    }
}
