# Secure Authentication and Privacy-Preserving Localization Framework for V2V and V2I Communications in 6G Vehicular Networks

This repository contains the backend simulation implementation for the SAPL-V2X paper. It is built using Laravel 12 and provides API endpoints for cryptographic authentication, multilateration-based localization, and differential privacy filtering.

## Overview

The simulation handles the following key functionalities:
1. **Hash-Based MAC Authentication**: Secure communication via MAC computation ($MAC = H(K \| m \| T_s \| \text{Seq})$).
2. **V2I Authentication**: 4-Phase secure registration and session token provisioning.
3. **V2V Authentication**: Mutual challenge-response protocol using shared group keys ($K_G$) and derivation of session keys ($K_{session}$).
4. **Replay Protection**: Validation of request freshness across a $\Delta T = 5s$ window.
5. **Distance Estimation**: Log-Distance Path Loss model calculations ($d = 10^{(P_t - RSSI) / (10 \gamma)}$).
6. **Multilateration**: 2D coordinate estimation from multiple authenticated signal sources.
7. **Differential Privacy**: Obfuscation of exact locations by applying Laplace Noise ($L_{dp} = L_{true} + \text{Laplace}(0, S/\varepsilon)$).

## Project Setup

1. Copy `.env.example` to `.env` and configure your local MySQL database.
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sapl_v2x_paper
   DB_USERNAME=root
   DB_PASSWORD=root
   ```
2. Run database migrations and seeders to populate initial Roadside Units (RSUs).
   ```bash
   php artisan migrate:fresh --seed
   ```
3. Start the Laravel development server.
   ```bash
   php artisan serve
   ```

## Running the Simulation

A built-in simulator view is available to automatically run through the registration, authentication, and localization requests.

1. Navigate to `http://localhost:8000/simulator`.
2. Click **Run Simulation**.
3. Performance metrics (transfer start times and total execution times) are generated and stored in `storage/logs/performance_metrics.json`.

These metrics match the requirements for the "Results and Discussion" section of the paper, enabling latency analysis of the cryptographic and localization services.
