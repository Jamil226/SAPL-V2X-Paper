<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SAPL-V2X Simulation</title>
</head>
<body>
    <h1>SAPL-V2X-Paper Performance Simulation</h1>
    <button id="runSimBtn">Run Simulation</button>
    <pre id="output"></pre>

    <script>
        // SHA-256 Polyfill/Helper (Simple for simulation)
        async function sha256(message) {
            const msgBuffer = new TextEncoder().encode(message);
            const hashBuffer = await crypto.subtle.digest('SHA-256', msgBuffer);
            const hashArray = Array.from(new Uint8Array(hashBuffer));
            return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
        }

        function logOutput(msg) {
            document.getElementById('output').textContent += msg + "\n";
        }

        document.getElementById('runSimBtn').addEventListener('click', async () => {
            logOutput("Starting simulation...");
            let metrics = [];
            
            // 1. Register
            let start = performance.now();
            let reqStart = Date.now();
            let res = await fetch('/api/register', { method: 'POST' });
            let regData = await res.json();
            let timeTaken = performance.now() - start;
            
            metrics.push({
                request: 'register',
                transfer_start_time_ms: reqStart,
                total_execution_time_ms: timeTaken,
                status: res.status
            });

            if (!regData.data) {
                logOutput("Registration failed");
                return;
            }

            let vehicle = regData.data;
            logOutput("Registered Vehicle: " + vehicle.vehicle_uid);

            // 2. Authenticate
            start = performance.now();
            reqStart = Date.now();
            let timestamp = Date.now();
            let seq = '1';
            let message = 'AuthRequest';
            
            // MAC = H(K || m || Ts || Seq)
            let macInput = vehicle.secret_key + message + timestamp + seq;
            let mac = await sha256(macInput);

            res = await fetch('/api/authenticate', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    auth_type: 'v2i',
                    vehicle_uid: vehicle.vehicle_uid,
                    message: message,
                    timestamp: timestamp,
                    seq: seq,
                    mac: mac
                })
            });
            let authData = await res.json();
            timeTaken = performance.now() - start;
            metrics.push({
                request: 'authenticate',
                transfer_start_time_ms: reqStart,
                total_execution_time_ms: timeTaken,
                status: res.status
            });

            if (!authData.data) {
                logOutput("Auth failed");
                return;
            }

            let sessionToken = authData.data.session_token;
            logOutput("Authenticated. Session Token: " + sessionToken.substring(0, 8) + '...');

            // 3. Localize (10 times)
            for (let i = 1; i <= 10; i++) {
                start = performance.now();
                reqStart = Date.now();
                
                // Simulate RSSI readings from 4 RSUs
                let signals = [
                    { rsu_uid: 'RSU-1', rssi: -50 - (Math.random() * 10) },
                    { rsu_uid: 'RSU-2', rssi: -55 - (Math.random() * 10) },
                    { rsu_uid: 'RSU-3', rssi: -52 - (Math.random() * 10) },
                    { rsu_uid: 'RSU-4', rssi: -58 - (Math.random() * 10) }
                ];

                res = await fetch('/api/localize', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        session_token: sessionToken,
                        signals: signals
                    })
                });
                let locData = await res.json();
                timeTaken = performance.now() - start;
                metrics.push({
                    request: 'localize_' + i,
                    transfer_start_time_ms: reqStart,
                    total_execution_time_ms: timeTaken,
                    status: res.status
                });
            }

            logOutput("Localization tests complete.");

            // Output metrics as JSON
            console.log(JSON.stringify(metrics, null, 2));

            // Send metrics back to server to log to JSON file matching paper section
            res = await fetch('/api/log-metrics', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ metrics: metrics })
            });

            logOutput("Metrics saved. Check storage/logs/performance_metrics.json");
            logOutput("SIMULATION_COMPLETE");
        });
    </script>
</body>
</html>
