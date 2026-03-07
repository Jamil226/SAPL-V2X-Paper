<?php

namespace App\Services;

class LocalizationService
{
    /**
     * Estimate distance from transmitter (RSU) using Log-Distance Path Loss model.
     * d = 10 ^ ((Pt - RSSI) / (10 * gamma))
     */
    public function estimateDistance($txPower, $rssi, $gamma = 2.5)
    {
        $exponent = ($txPower - $rssi) / (10 * $gamma);
        return pow(10, $exponent);
    }

    /**
     * Perform Multi-lateration to estimate (x,y) location based on 
     * multiple reference points and distances.
     * Uses a simplified centroid or least-squares approximation.
     * 
     * $rsuData format: 
     * [
     *    ['x' => float, 'y' => float, 'd' => float],
     *    ...
     * ]
     */
    public function multilaterate(array $rsuData)
    {
        // Require at least 3 points for 2D multilateration
        if (count($rsuData) < 3) {
            throw new \Exception("Insufficient RSU data for multilateration. Need at least 3 points.");
        }

        // We use a simplified weighted centroid approximation for simulation speed.
        // x = sum(w_i * x_i) / sum(w_i), where w_i = 1 / d_i
        $sumW = 0;
        $sumWx = 0;
        $sumWy = 0;

        foreach ($rsuData as $rsu) {
            // Add a tiny epsilon to distance to prevent division by zero
            $weight = 1 / max($rsu['d'], 0.0001);
            $sumW += $weight;
            $sumWx += $weight * $rsu['x'];
            $sumWy += $weight * $rsu['y'];
        }

        return [
            'x' => $sumWx / $sumW,
            'y' => $sumWy / $sumW,
        ];
    }

    /**
     * Apply Differential Privacy using Laplace mechanism.
     * L_dp = L_true + Laplace(0, S / \varepsilon)
     */
    public function addLaplaceNoise($location, $sensitivity = 1.0, $epsilon = 0.5)
    {
        $scale = $sensitivity / $epsilon;
        
        $location['x'] += $this->laplace(0, $scale);
        $location['y'] += $this->laplace(0, $scale);

        return $location;
    }

    /**
     * Generate Laplace noise using uniform distributed random numbers
     * Laplace(mu, b) = mu - b * sgn(U) * ln(1 - 2|U|)
     * where U is a random variable uniformly distributed in (-0.5, 0.5]
     */
    private function laplace($mu, $b)
    {
        // Generate uniform random float between -0.5 and 0.5
        $u = mt_rand() / mt_getrandmax() - 0.5;
        
        // Log of 0 is undefined, avoid it
        $u = max($u, -0.499999);
        $u = min($u, 0.499999);
        
        $sgn = $u < 0 ? -1 : 1;
        return $mu - $b * $sgn * log(1 - 2 * abs($u));
    }
}
