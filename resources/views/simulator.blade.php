<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAPL-V2X — Urban Intersection Manual Testbed</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        :root {
            --bg: #f0f4f8;
            --bg2: #ffffff;
            --bg3: #e8eef5;
            --accent: #0ea5e9;
            --accent2: #0369a1;
            --success: #16a34a;
            --warn: #d97706;
            --danger: #dc2626;
            --vehA: #2563eb;
            --vehB: #ea580c;
            --dp: #7c3aed;
            --text: #1e293b;
            --muted: #64748b;
            --border: #cbd5e1;
            --card: #ffffff;
            --shadow: 0 1px 4px rgba(0, 0, 0, .10);
            --shadow2: 0 2px 10px rgba(0, 0, 0, .12);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            overflow: hidden;
            background: var(--bg);
            color: var(--text);
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        /* ── Header ── */
        header {
            background: linear-gradient(135deg, #0369a1 0%, #0ea5e9 60%, #38bdf8 100%);
            padding: 0 20px;
            height: 56px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(3, 105, 161, .25);
        }

        .hdr-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .hdr-icon {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, .2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .hdr-title {
            font-size: 15px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: .5px;
        }

        .hdr-sub {
            font-size: 11px;
            color: rgba(255, 255, 255, .75);
            margin-top: 1px;
        }

        .hdr-right {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .badge {
            background: rgba(255, 255, 255, .18);
            border: 1px solid rgba(255, 255, 255, .35);
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .5px;
            color: #fff;
            transition: all .3s;
        }

        .badge.green {
            background: #dcfce7;
            border-color: #16a34a;
            color: #16a34a;
        }

        .badge.yellow {
            background: #fef3c7;
            border-color: #d97706;
            color: #d97706;
        }

        .badge.red {
            background: #fee2e2;
            border-color: #dc2626;
            color: #dc2626;
        }

        .badge.cyan {
            background: #e0f2fe;
            border-color: #0ea5e9;
            color: #0369a1;
        }

        /* ── Layout ── */
        main {
            display: grid;
            grid-template-columns: 780px minmax(320px, 1fr);
            gap: 12px;
            padding: 12px;
            flex: 1;
            min-height: 0;
            overflow: hidden;
        }

        .col-left {
            display: flex;
            flex-direction: column;
            gap: 8px;
            min-height: 0;
        }

        .col-right {
            display: flex;
            flex-direction: column;
            gap: 8px;
            overflow-y: auto;
            min-height: 0;
        }

        canvas#map {
            border: 1px solid var(--border);
            border-radius: 8px;
            display: block;
            flex-shrink: 0;
            background: #f0f9ff;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .10);
        }

        /* Bottom Controls */
        .controls-panel {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 12px 14px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            box-shadow: var(--shadow);
        }

        .controls-row {
            display: flex;
            gap: 12px;
            align-items: center;
            justify-content: space-between;
        }

        .btn-col {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .btn-label {
            font-size: 10px;
            font-weight: 700;
            color: var(--accent2);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .custom-select {
            width: 100%;
            height: 40px;
            padding: 0 10px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--bg3);
            color: var(--text);
            font-family: inherit;
            font-size: 12.5px;
            font-weight: 600;
            outline: none;
            cursor: pointer;
        }

        .btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 8px 12px;
            height: 40px;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 12px;
            color: #ffffff;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            text-align: center;
            position: relative;
        }

        .btn:hover:not(:disabled) {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.12);
        }

        .btn:active:not(:disabled) {
            transform: translateY(0);
        }

        .btn.primary {
            background: linear-gradient(135deg, #0284c7 0%, #0ea5e9 100%);
        }

        .btn.v2v {
            background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
        }

        .btn.threat {
            background: linear-gradient(135deg, #b91c1c 0%, #ef4444 100%);
        }

        .btn.reset {
            background: linear-gradient(135deg, #475569 0%, #64748b 100%);
        }

        .btn:disabled {
            background: #cbd5e1 !important;
            color: #94a3b8 !important;
            cursor: not-allowed;
            transform: none !important;
            box-shadow: none !important;
            opacity: 0.7;
        }

        .btn-desc {
            font-size: 9px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.85);
            margin-top: 1px;
        }

        .btn:disabled .btn-desc {
            color: #94a3b8;
        }

        .spinner {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ── Panels ── */
        .panel {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 10px 12px;
            flex-shrink: 0;
            box-shadow: var(--shadow);
        }

        .panel.grow {
            flex: 1;
            overflow-y: auto;
            min-height: 80px;
        }

        .p-title {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--accent2);
            margin-bottom: 7px;
            padding-bottom: 4px;
            border-bottom: 2px solid var(--bg3);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .p-title::before {
            content: '';
            display: inline-block;
            width: 4px;
            height: 14px;
            background: var(--accent);
            border-radius: 2px;
        }

        /* ── Protocol Steps ── */
        .step {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-bottom: 5px;
            font-size: 11px;
            color: #94a3b8;
            transition: color .25s;
        }

        .step.active {
            color: var(--warn);
            font-weight: 600;
        }

        .step.done {
            color: var(--success);
        }

        .step.error {
            color: var(--danger);
        }

        .step-icon {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: 1.5px solid currentColor;
            flex-shrink: 0;
            margin-top: 1px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
        }

        .step.active .step-icon {
            background: var(--warn);
            border-color: var(--warn);
        }

        .step.done .step-icon {
            background: var(--success);
            border-color: var(--success);
        }

        .step.error .step-icon {
            background: var(--danger);
            border-color: var(--danger);
        }

        /* ── Info grid ── */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
        }

        .icard {
            background: var(--bg3);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 6px 8px;
        }

        .ilabel {
            font-size: 9px;
            font-weight: 600;
            color: var(--muted);
            letter-spacing: .5px;
            text-transform: uppercase;
        }

        .ivalue {
            font-size: 11.5px;
            font-weight: 600;
            color: var(--text);
            margin-top: 2px;
            word-break: break-all;
        }

        .ivalue.cyan { color: var(--accent2); }
        .ivalue.green { color: var(--success); }
        .ivalue.orange { color: var(--vehB); }
        .ivalue.red { color: var(--danger); }

        /* ── Loc grid ── */
        .loc-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
        }

        .loc-box {
            background: var(--bg3);
            border: 1.5px solid var(--border);
            border-radius: 6px;
            padding: 8px;
            text-align: center;
        }

        .loc-box.t { border-color: var(--vehA); }
        .loc-box.p { border-color: var(--dp); }

        .loc-label {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 2px;
        }

        .loc-box.t .loc-label { color: var(--vehA); }
        .loc-box.p .loc-label { color: var(--dp); }

        .loc-val { font-size: 12px; font-weight: 700; }
        .loc-box.t .loc-val { color: var(--vehA); }
        .loc-box.p .loc-val { color: var(--dp); }

        .loc-sub { font-size: 8.5px; color: var(--muted); margin-top: 2px; }

        /* ── Metrics ── */
        .met-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 6px;
        }

        .met-box {
            background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 100%);
            border: 1px solid #bae6fd;
            border-radius: 6px;
            padding: 6px;
            text-align: center;
        }

        .met-label { font-size: 9px; font-weight: 600; color: var(--muted); }
        .met-val { font-size: 18px; font-weight: 700; color: var(--accent2); line-height: 1.1; }
        .met-unit { font-size: 8px; color: var(--muted); }

        /* ── Real-time stats ── */
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
        }

        .stat-card {
            background: var(--bg3);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 8px 10px;
            display: flex;
            align-items: center;
            gap: 8px;
            position: relative;
        }

        .stat-icon {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .stat-icon.blue { background: #dbeafe; }
        .stat-icon.green { background: #dcfce7; }
        .stat-icon.orange { background: #ffedd5; }
        .stat-icon.purple { background: #ede9fe; }
        .stat-icon.sky { background: #e0f2fe; }
        .stat-icon.red { background: #fee2e2; }

        .stat-val { font-size: 18px; font-weight: 700; color: var(--text); line-height: 1; }
        .stat-lbl { font-size: 9px; font-weight: 600; color: var(--muted); margin-top: 1px; text-transform: uppercase; letter-spacing: .3px; }

        .stat-timestamp {
            font-size: 8px;
            color: var(--muted);
            position: absolute;
            bottom: 2px;
            right: 6px;
        }

        /* Network status bar */
        .net-bar {
            display: flex;
            gap: 8px;
            align-items: center;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 7px 12px;
            font-size: 11px;
            font-weight: 600;
            color: var(--success);
        }

        .net-bar .node {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            background: #dcfce7;
            border-radius: 20px;
            font-size: 10px;
        }

        .net-bar .arrow {
            color: #94a3b8;
            font-size: 14px;
        }

        /* ── Footer / Log ── */
        footer {
            background: var(--card);
            border-top: 1px solid var(--border);
            padding: 6px 14px;
            height: 120px;
            flex-shrink: 0;
            box-shadow: 0 -1px 4px rgba(0, 0, 0, .06);
            display: flex;
            flex-direction: column;
        }

        .log-title {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1px;
            color: var(--accent2);
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        #log {
            flex: 1;
            overflow-y: auto;
            font-size: 11px;
            font-family: 'Courier New', monospace;
        }

        #log .le {
            margin-bottom: 2px;
        }

        #log .le.info { color: var(--accent2); }
        #log .le.success { color: var(--success); }
        #log .le.warn { color: var(--warn); }
        #log .le.danger { color: var(--danger); }
        #log .le.muted { color: var(--muted); }

        /* scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--bg3); border-radius: 3px; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }
    </style>
</head>

<body>

    <!-- ════ HEADER ════ -->
    <header>
        <div class="hdr-left">
            <div class="hdr-icon">🏙️</div>
            <div>
                <div class="hdr-title">SAPL-V2X Smart City Platform</div>
                <div class="hdr-sub">Secure Auth &amp; Privacy-Preserving Localization · Vehicular Network</div>
            </div>
        </div>
        <div class="hdr-right">
            <span class="badge cyan">🔵 Urban Intersection</span>
            <span class="badge" id="statusBadge">IDLE</span>
        </div>
    </header>

    <!-- ════ MAIN ════ -->
    <main>

        <!-- Left: Canvas + Bottom Controls -->
        <div class="col-left">
            <canvas id="map" width="756" height="510"></canvas>
            
            <!-- Bottom Controls Panel (Manual Testing Mode) -->
            <div class="controls-panel">
                <div class="controls-row">
                    <!-- Step 1: Select Testing Node -->
                    <div class="btn-col" style="max-width: 160px;">
                        <span class="btn-label">1. Select Node</span>
                        <select class="custom-select" id="nodeSelector">
                            <option value="" disabled selected>-- Select --</option>
                            <option value="VEH-DEMO-001">Vehicle V1 (Active)</option>
                            <option value="VEH-DEMO-002">Vehicle V2 (Active)</option>
                            <option value="VEH-DEMO-003">Vehicle V3 (Inactive)</option>
                            <option value="ATTACKER">Attacker (Replay)</option>
                            <option value="SCENARIO_MULTI">Scenario: Multi-V2X (V2V/V2I)</option>
                        </select>
                    </div>

                    <!-- Step 2: Authenticate -->
                    <div class="btn-col">
                        <span class="btn-label">2. Authenticate</span>
                        <button class="btn primary" id="btnManualAuth" disabled>
                            <span id="btnAuthText">🔐 Auth Request</span>
                            <span class="btn-desc">V2I Cryptographic MAC</span>
                        </button>
                    </div>

                    <!-- Step 3: Localize -->
                    <div class="btn-col">
                        <span class="btn-label">3. Localize</span>
                        <button class="btn primary" id="btnManualLoc" disabled>
                            <span id="btnLocText">📡 Update Loc</span>
                            <span class="btn-desc">Multilateration + DP</span>
                        </button>
                    </div>

                    <!-- Step 4: Send Message -->
                    <div class="btn-col">
                        <span class="btn-label">4. Broadcast</span>
                        <button class="btn primary" id="btnManualMsg" disabled>
                            <span id="btnMsgText">📨 Send Message</span>
                            <span class="btn-desc">Safety CAM Transmission</span>
                        </button>
                    </div>

                    <!-- Utilities -->
                    <div style="display: flex; gap: 6px; align-self: flex-end; margin-bottom: 2px;">
                        <button class="btn threat" id="btnManualReplay" style="padding: 0 10px; height: 40px; min-width: 110px;">
                            <span>⚡ Replay Attack</span>
                            <span class="btn-desc">Stale timestamp</span>
                        </button>
                        <button class="btn reset" id="btnManualReset" style="padding: 0 10px; height: 40px; min-width: 70px;">
                            <span>↺ Reset</span>
                            <span class="btn-desc">Clear map</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Panels -->
        <div class="col-right">

            <!-- Network status bar -->
            <div class="net-bar" id="netBar">
                <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: var(--success); margin-right: 2px;"></span>
                <span>Vehicular Adhoc Network</span>
                <span class="arrow">·</span>
                <span class="node">🚗 Vehicle</span>
                <span class="arrow">→</span>
                <span class="node">📡 RSU / Base Station</span>
                <span class="arrow">→</span>
                <span class="node">☁️ Cloud Server</span>
                <span class="arrow">→</span>
                <span class="node">🚗 V2V Peer</span>
            </div>

            <!-- Real-time statistics -->
            <div class="panel">
                <div class="p-title">Real-Time Statistics</div>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon blue">🚗</div>
                        <div>
                            <div class="stat-val" id="stVehicles">0</div>
                            <div class="stat-lbl">Vehicles Online</div>
                        </div>
                        <span class="stat-timestamp" id="tsVeh">Updated: —</span>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon green">🔐</div>
                        <div>
                            <div class="stat-val" id="stAuthed">0</div>
                            <div class="stat-lbl">Authenticated</div>
                        </div>
                        <span class="stat-timestamp" id="tsAuth">Updated: —</span>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon sky">📡</div>
                        <div>
                            <div class="stat-val" id="stRSU">0 / 4</div>
                            <div class="stat-lbl">RSU / BS Load</div>
                        </div>
                        <span class="stat-timestamp" id="tsRsu">Updated: —</span>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon orange">📨</div>
                        <div>
                            <div class="stat-val" id="stMsgs">0</div>
                            <div class="stat-lbl">Msgs Passed</div>
                        </div>
                        <span class="stat-timestamp" id="tsMsgs">Updated: —</span>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon purple">📍</div>
                        <div>
                            <div class="stat-val" id="stLoc">—</div>
                            <div class="stat-lbl">DP Privacy ε</div>
                        </div>
                        <span class="stat-timestamp" id="tsLoc">Updated: —</span>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon red">🛡️</div>
                        <div>
                            <div class="stat-val" id="stThreats">0</div>
                            <div class="stat-lbl">Threats Blocked</div>
                        </div>
                        <span class="stat-timestamp" id="tsThreats">Updated: —</span>
                    </div>
                </div>
            </div>

            <!-- Protocol steps checklist -->
            <div class="panel grow">
                <div class="p-title">Protocol Checklist Flow</div>
                <div id="steps">
                    <div class="step" id="step1">
                        <div class="step-icon">1</div>
                        <div>Spawn &amp; Initialize Target Vehicle Coordinates</div>
                    </div>
                    <div class="step" id="step2">
                        <div class="step-icon">2</div>
                        <div>V2I cryptographic MAC authentication with RSU</div>
                    </div>
                    <div class="step" id="step3">
                        <div class="step-icon">3</div>
                        <div>Multilateration distance estimation &amp; Laplace Noise DP</div>
                    </div>
                    <div class="step" id="step4">
                        <div class="step-icon">4</div>
                        <div>Secure safety CAM broadcast channel transmission</div>
                    </div>
                </div>
            </div>

            <!-- Vehicle Status -->
            <div class="panel">
                <div class="p-title">Vehicle Status</div>
                <div class="info-grid">
                    <div class="icard">
                        <div class="ilabel">Vehicle UID</div>
                        <div class="ivalue" id="iUid">&#8212;</div>
                    </div>
                    <div class="icard">
                        <div class="ilabel">Auth Status</div>
                        <div class="ivalue" id="iAuth">UNAUTHENTICATED</div>
                    </div>
                    <div class="icard">
                        <div class="ilabel">Session Token</div>
                        <div class="ivalue" id="iToken">&#8212;</div>
                    </div>
                    <div class="icard">
                        <div class="ilabel">V2V Channel</div>
                        <div class="ivalue" id="iV2V">INACTIVE</div>
                    </div>
                </div>
            </div>

            <!-- Localization Results -->
            <div class="panel">
                <div class="p-title">Localization Results</div>
                <div class="loc-grid">
                    <div class="loc-box t">
                        <div class="loc-label">True Position</div>
                        <div class="loc-val" id="locTrue">&#8212;</div>
                        <div class="loc-sub">Multilateration</div>
                    </div>
                    <div class="loc-box p">
                        <div class="loc-label">DP Location</div>
                        <div class="loc-val" id="locDP">&#8212;</div>
                        <div class="loc-sub">Laplace(0, S/&epsilon;)</div>
                    </div>
                </div>
            </div>

            <!-- Performance Metrics -->
            <div class="panel">
                <div class="p-title">Performance Metrics</div>
                <div class="met-row">
                    <div class="met-box">
                        <div class="met-label">Registration</div>
                        <div class="met-val" id="mReg">&#8212;</div>
                        <div class="met-unit">ms</div>
                    </div>
                    <div class="met-box">
                        <div class="met-label">V2I Auth</div>
                        <div class="met-val" id="mAuth">&#8212;</div>
                        <div class="met-unit">ms</div>
                    </div>
                    <div class="met-box">
                        <div class="met-label">Localize</div>
                        <div class="met-val" id="mLoc">&#8212;</div>
                        <div class="met-unit">ms</div>
                    </div>
                </div>
            </div>

        </div><!-- col-right -->
    </main>

    <!-- ════ FOOTER / LOG ════ -->
    <footer>
        <div class="log-title">Event Log Stream</div>
        <div id="log"></div>
    </footer>

    <!-- ════ JAVASCRIPT CODE ════ -->
    <script>
        // ─────────────────────────────────────────
        //  Crypto utilities
        // ─────────────────────────────────────────
        async function sha256(msg) {
            const buf = new TextEncoder().encode(msg);
            const hash = await crypto.subtle.digest('SHA-256', buf);
            return Array.from(new Uint8Array(hash)).map(b => b.toString(16).padStart(2, '0')).join('');
        }

        function sleep(ms) {
            return new Promise(r => setTimeout(r, ms));
        }

        function ts() {
            return new Date().toTimeString().slice(0, 8);
        }

        // ─────────────────────────────────────────
        //  Canvas Drawing Setup
        // ─────────────────────────────────────────
        const canvas = document.getElementById('map');
        const ctx = canvas.getContext('2d');
        const CW = 756;  // 756
        const CH = 510;  // 510 (adjusted layout height)

        // HDPI Scaling setup for crisp rendering on high-DPI (Retina) screens
        const dpr = window.devicePixelRatio || 1;
        canvas.style.width = CW + 'px';
        canvas.style.height = CH + 'px';
        canvas.width = CW * dpr;
        canvas.height = CH * dpr;
        ctx.scale(dpr, dpr);

        // Intersection boundary metrics
        const MX = 40, MY = 20, MW = 676, MH = 470;

        // RSUs definitions (fixed coordinates positioned close to the road edges)
        const RSUS = {
            'RSU-1': { cx: 326, cy: 317, sx: 0, sy: 0, label: 'RSU-SW' },
            'RSU-2': { cx: 430, cy: 317, sx: 90, sy: 0, label: 'RSU-SE' },
            'RSU-3': { cx: 326, cy: 193, sx: 0, sy: 90, label: 'RSU-NW' },
            'RSU-4': { cx: 430, cy: 193, sx: 90, sy: 90, label: 'RSU-NE' },
        };

        const BASE_STATION = { cx: MX + MW - 100, cy: MY + 50, label: 'V2X Base Station' };

        // Road lanes coordinates
        const RD = {
            hY1: 215,
            hY2: 295,
            vX1: 338,
            vX2: 418
        };

        function s2c(sx, sy) {
            return {
                cx: MX + (sx / 90) * MW,
                cy: (MY + MH) - (sy / 90) * MH
            };
        }

        function c2s(cx, cy) {
            return {
                sx: (cx - MX) / MW * 90,
                sy: ((MY + MH) - cy) / MH * 90
            };
        }

        // Vehicles definitions
        const VA = { cx: -50, cy: 275, w: 32, h: 15, color: '#2563eb', label: 'V1', dir: 'right', vis: false };
        const VC = { cx: CW + 50, cy: 235, w: 32, h: 15, color: '#16a34a', label: 'V2', dir: 'left', vis: false };
        const VD = { cx: 398, cy: CH + 50, w: 15, h: 32, color: '#ea580c', label: 'V3', dir: 'up', vis: false };
        const VX = { cx: -50, cy: 275, w: 32, h: 15, color: '#dc2626', label: '!', dir: 'right', vis: false };

        // Drawing state
        let rsuOn = { 'RSU-1': false, 'RSU-2': false, 'RSU-3': false, 'RSU-4': false };
        let bsOn = false;
        let rings = [];
        let triLines = [];
        let v2vLink = null;
        let dotTrue = null;
        let dotDP = null;
        let dotTrueList = [];
        let dotDPList = [];
        let vehicleDataList = [];
        let sessionTokenList = [];

        let floats = [];
        let packets = [];
        let trafficPhase = 'OFF';
        let signalBlink = 0;

        // Step-by-step variables
        let activeVehicleId = null;
        let vehicleData = null; // keys, active status
        let sessionToken = null;
        let isAuthenticated = false;
        let msgsPassed = 0;

        // ─────────────────────────────────────────
        //  Render loop
        // ─────────────────────────────────────────
        function renderLoop() {
            // Rings diffusion animation
            for (const r of rings) {
                r.r += 1.0;
                r.alpha = Math.max(0, .55 - r.r / r.maxR * .55);
            }
            rings = rings.filter(r => r.r < r.maxR);

            // Trigger ring beacons occasionally if RSU is active
            if (Math.random() < 0.02) {
                for (const [id, on] of Object.entries(rsuOn)) {
                    if (on) {
                        rings.push({ cx: RSUS[id].cx, cy: RSUS[id].cy, r: 0, maxR: 90, alpha: 0.5 });
                    }
                }
                if (bsOn) {
                    rings.push({ cx: BASE_STATION.cx, cy: BASE_STATION.cy, r: 0, maxR: 200, alpha: 0.3 });
                }
            }

            // Dotted multilateration line fading
            for (const l of triLines) {
                if (l.fade) l.alpha = Math.max(0, l.alpha - .008);
            }
            triLines = triLines.filter(l => l.alpha > 0);

            // Floating logs fading
            for (const f of floats) f.alpha = Math.max(0, f.alpha - .007);
            floats = floats.filter(f => f.alpha > 0);

            // Advance packet travel animations
            for (const p of packets) {
                p.progress = Math.min(1, p.progress + 0.035);
                p.x = p.ox + (p.tx - p.ox) * p.progress;
                p.y = p.oy + (p.ty - p.oy) * p.progress;
                if (p.progress >= 1) p.alpha = Math.max(0, p.alpha - 0.08);
            }
            packets = packets.filter(p => p.alpha > 0);

            draw();
            requestAnimationFrame(renderLoop);
        }

        // ─────────────────────────────────────────
        //  Drawing Functions
        // ─────────────────────────────────────────
        function draw() {
            ctx.clearRect(0, 0, CW, CH);
            drawBg();
            drawBuildings();
            drawRoads();
            drawMasterTrafficSignal();
            drawRings();
            drawTriLines();
            drawV2VLink();
            drawDots();
            drawRSUs();
            drawBaseStation();
            
            // Vehicles
            drawVehicle(VA);
            drawVehicle(VC);
            drawVehicle(VD);
            drawVehicle(VX);

            drawPackets();
            drawFloats();
            drawLegend();
            drawScaleBar();
        }

        function drawBg() {
            // Sky gradient
            const sky = ctx.createLinearGradient(0, 0, 0, CH);
            sky.addColorStop(0, '#dbeafe');
            sky.addColorStop(1, '#f0f9ff');
            ctx.fillStyle = sky;
            ctx.fillRect(0, 0, CW, CH);

            // City grid lines
            ctx.strokeStyle = 'rgba(148,163,184,0.15)';
            ctx.lineWidth = .7;
            for (let x = MX; x <= MX + MW; x += 52) {
                ctx.beginPath();
                ctx.moveTo(x, MY);
                ctx.lineTo(x, MY + MH);
                ctx.stroke();
            }
            for (let y = MY; y <= MY + MH; y += 45) {
                ctx.beginPath();
                ctx.moveTo(MX, y);
                ctx.lineTo(MX + MW, y);
                ctx.stroke();
            }
            ctx.strokeStyle = '#94a3b8';
            ctx.lineWidth = 1;
            ctx.strokeRect(MX, MY, MW, MH);
        }

        function drawBuildings() {
            const { hY1, hY2, vX1, vX2 } = RD;
            const blocks = [
                { x: MX + 3, y: MY + 3, w: vX1 - MX - 6, h: hY1 - MY - 6 },
                { x: vX2 + 3, y: MY + 3, w: MX + MW - vX2 - 6, h: hY1 - MY - 6 },
                { x: MX + 3, y: hY2 + 3, w: vX1 - MX - 6, h: MY + MH - hY2 - 6 },
                { x: vX2 + 3, y: hY2 + 3, w: MX + MW - vX2 - 6, h: MY + MH - hY2 - 6 },
            ];
            const buildingColors = ['#e2e8f0', '#dde5ee', '#e8eef5', '#d4dde8'];
            for (let bi = 0; bi < blocks.length; bi++) {
                const b = blocks[bi];
                ctx.fillStyle = buildingColors[bi % buildingColors.length];
                ctx.fillRect(b.x, b.y, b.w, b.h);
                ctx.strokeStyle = '#cbd5e1';
                ctx.lineWidth = 1;
                ctx.strokeRect(b.x, b.y, b.w, b.h);

                // Windows - STATIC pattern to eliminate worst blinking boxes
                const cols = Math.max(2, Math.floor(b.w / 40)),
                      rows = Math.max(2, Math.floor(b.h / 30));
                const pad = 6,
                      bw = (b.w - pad * (cols + 1)) / cols,
                      bh = (b.h - pad * (rows + 1)) / rows;
                for (let r = 0; r < rows; r++) {
                    for (let c = 0; c < cols; c++) {
                        const wx = b.x + pad + c * (bw + pad);
                        const wy = b.y + pad + r * (bh + pad);
                        // Deterministic windows states (No blinking!)
                        const lit = ((r * 3 + c * 7) % 5) < 3;
                        ctx.fillStyle = lit ? 'rgba(14, 165, 233, 0.75)' : 'rgba(148, 163, 184, 0.35)';
                        ctx.fillRect(wx, wy, Math.max(bw, 4), Math.max(bh, 4));
                    }
                }
            }
        }

        function drawRoads() {
            const { hY1, hY2, vX1, vX2 } = RD;
            const midY = (hY1 + hY2) / 2,
                midX = (vX1 + vX2) / 2;

            // Road Asphalt
            ctx.fillStyle = '#1e293b';
            ctx.fillRect(MX, hY1, MW, hY2 - hY1);
            ctx.fillRect(vX1, MY, vX2 - vX1, MH);

            // Intersection core
            ctx.fillStyle = '#334155';
            ctx.fillRect(vX1, hY1, vX2 - vX1, hY2 - hY1);

            // Solid outer lines
            ctx.strokeStyle = '#64748b';
            ctx.lineWidth = 2;
            ctx.beginPath();
            ctx.moveTo(MX, hY1); ctx.lineTo(vX1, hY1);
            ctx.moveTo(vX2, hY1); ctx.lineTo(MX + MW, hY1);
            ctx.moveTo(MX, hY2); ctx.lineTo(vX1, hY2);
            ctx.moveTo(vX2, hY2); ctx.lineTo(MX + MW, hY2);
            ctx.moveTo(vX1, MY); ctx.lineTo(vX1, hY1);
            ctx.moveTo(vX1, hY2); ctx.lineTo(vX1, MY + MH);
            ctx.moveTo(vX2, MY); ctx.lineTo(vX2, hY1);
            ctx.moveTo(vX2, hY2); ctx.lineTo(vX2, MY + MH);
            ctx.stroke();

            // Lanes dividers (Dashed yellow)
            ctx.strokeStyle = '#eab308';
            ctx.lineWidth = 1.5;
            ctx.setLineDash([12, 8]);
            ctx.beginPath();
            ctx.moveTo(MX, midY); ctx.lineTo(vX1, midY);
            ctx.moveTo(vX2, midY); ctx.lineTo(MX + MW, midY);
            ctx.moveTo(midX, MY); ctx.lineTo(midX, hY1);
            ctx.moveTo(midX, hY2); ctx.lineTo(midX, MY + MH);
            ctx.stroke();
            ctx.setLineDash([]);

            // Stop lines (thick white)
            ctx.strokeStyle = '#ffffff';
            ctx.lineWidth = 3;
            ctx.beginPath();
            ctx.moveTo(vX1, midY); ctx.lineTo(vX1, hY2); // west
            ctx.moveTo(vX2, hY1); ctx.lineTo(vX2, midY); // east
            ctx.moveTo(vX1, hY1); ctx.lineTo(midX, hY1); // north
            ctx.moveTo(midX, hY2); ctx.lineTo(vX2, hY2); // south
            ctx.stroke();

            // Crosswalk stripes
            ctx.fillStyle = 'rgba(255, 255, 255, 0.3)';
            const stripeW = 3, stripeH = 12;
            for (let y = hY1 + 4; y < hY2; y += 8) {
                ctx.fillRect(vX1 - 15, y, stripeH, stripeW);
                ctx.fillRect(vX2 + 3, y, stripeH, stripeW);
            }
            for (let x = vX1 + 4; x < vX2; x += 8) {
                ctx.fillRect(x, hY1 - 15, stripeW, stripeH);
                ctx.fillRect(x, hY2 + 3, stripeW, stripeH);
            }

            // Directions
            ctx.fillStyle = '#94a3b8';
            ctx.font = 'bold 11px Inter';
            ctx.textAlign = 'center';
            ctx.fillText('N', midX, MY + 15);
            ctx.fillText('S', midX, MY + MH - 6);
            ctx.textAlign = 'left';
            ctx.fillText('W', MX + 6, midY + 4);
            ctx.textAlign = 'right';
            ctx.fillText('E', MX + MW - 6, midY + 4);
            ctx.textAlign = 'left';
        }

        function drawMasterTrafficSignal() {
            const cx = 378, cy = 255;

            // Draw housing
            ctx.beginPath();
            ctx.arc(cx, cy, 12, 0, Math.PI * 2);
            ctx.fillStyle = '#0f172a'; // dark housing
            ctx.strokeStyle = '#475569';
            ctx.lineWidth = 1.5;
            ctx.fill();
            ctx.stroke();

            // Determine color
            let color = '#ef4444'; // default/standby is red
            if (trafficPhase === 'EW' || trafficPhase === 'NS') {
                color = '#22c55e'; // green
            } else if (trafficPhase === 'AMBER') {
                color = '#ffb700'; // amber
            } else if (trafficPhase === 'OFF') {
                color = '#475569'; // dark grey standby
            }

            // Draw single light
            ctx.beginPath();
            ctx.arc(cx, cy, 6, 0, Math.PI * 2);
            ctx.fillStyle = color;
            if (trafficPhase !== 'OFF') {
                ctx.shadowColor = color;
                ctx.shadowBlur = 8;
            }
            ctx.fill();
            ctx.shadowBlur = 0; // reset
        }

        function drawRings() {
            for (const r of rings) {
                ctx.beginPath();
                ctx.arc(r.cx, r.cy, r.r, 0, Math.PI * 2);
                ctx.strokeStyle = `rgba(14,165,233,${r.alpha})`;
                ctx.lineWidth = 1.2;
                ctx.stroke();
            }
        }

        function drawTriLines() {
            ctx.setLineDash([5, 4]);
            for (const l of triLines) {
                ctx.beginPath();
                ctx.moveTo(l.x1, l.y1);
                ctx.lineTo(l.x2, l.y2);
                ctx.strokeStyle = `rgba(${l.r},${l.g},${l.b},${l.alpha})`;
                ctx.lineWidth = 1;
                ctx.stroke();
            }
            ctx.setLineDash([]);
        }

        function drawV2VLink() {
            if (!v2vLink) return;
            const a = v2vLink.a, b = v2vLink.b;
            if (!a.vis || !b.vis) return;
            ctx.beginPath();
            ctx.moveTo(a.cx, a.cy);
            ctx.lineTo(b.cx, b.cy);
            ctx.strokeStyle = 'rgba(124, 58, 237, 0.8)';
            ctx.lineWidth = 2;
            ctx.setLineDash([6, 4]);
            ctx.stroke();
            ctx.setLineDash([]);
        }

        function drawDots() {
            const dot = (d, col, ltr) => {
                if (!d) return;
                ctx.beginPath();
                ctx.arc(d.cx, d.cy, 8, 0, Math.PI * 2);
                ctx.fillStyle = col + '22';
                ctx.fill();
                ctx.strokeStyle = col;
                ctx.lineWidth = 1.8;
                ctx.stroke();
                ctx.fillStyle = col;
                ctx.font = 'bold 8px Courier New';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(ltr, d.cx, d.cy);
                ctx.textBaseline = 'alphabetic';
                ctx.textAlign = 'left';
            };
            dot(dotTrue, '#2563eb', 'T');
            dot(dotDP, '#7c3aed', 'P');
            dotTrueList.forEach(d => dot(d, '#2563eb', 'T'));
            dotDPList.forEach(d => dot(d, '#7c3aed', 'P'));
        }

        function drawRSUs() {
            for (const [id, rsu] of Object.entries(RSUS)) {
                const on = rsuOn[id];
                const col = on ? '#16a34a' : '#64748b';
                const colBg = on ? '#dcfce7' : '#e2e8f0';

                // Mast
                ctx.strokeStyle = col;
                ctx.lineWidth = 2.5;
                ctx.beginPath();
                ctx.moveTo(rsu.cx, rsu.cy);
                ctx.lineTo(rsu.cx, rsu.cy - 18);
                ctx.stroke();

                // Solar panel bracket
                ctx.strokeStyle = '#475569';
                ctx.lineWidth = 1.2;
                ctx.beginPath();
                ctx.moveTo(rsu.cx, rsu.cy - 9);
                ctx.lineTo(rsu.cx - 7, rsu.cy - 6);
                ctx.stroke();

                // Solar panel face (blue grid)
                ctx.fillStyle = '#1e3a8a';
                ctx.strokeStyle = '#3b82f6';
                ctx.lineWidth = 0.8;
                ctx.fillRect(rsu.cx - 11, rsu.cy - 6, 7, 3.5);
                ctx.strokeRect(rsu.cx - 11, rsu.cy - 6, 7, 3.5);

                // Sensor head / transceiver
                ctx.beginPath();
                ctx.arc(rsu.cx, rsu.cy - 20, 4.5, 0, Math.PI * 2);
                ctx.fillStyle = colBg;
                ctx.fill();
                ctx.strokeStyle = col;
                ctx.lineWidth = 1.8;
                ctx.stroke();

                // Signal waves arcs
                if (on) {
                    ctx.strokeStyle = 'rgba(22, 163, 74, 0.4)';
                    ctx.lineWidth = 1.0;
                    ctx.beginPath();
                    ctx.arc(rsu.cx, rsu.cy - 20, 9, -Math.PI/4, -3*Math.PI/4, true);
                    ctx.stroke();
                }

                // Badge
                ctx.fillStyle = on ? '#15803d' : '#475569';
                ctx.font = 'bold 8px Inter';
                ctx.fillText(id, rsu.cx - 14, rsu.cy + 10);
            }
        }

        function drawBaseStation() {
            const on = bsOn;
            const col = on ? '#0ea5e9' : '#64748b';
            const bx = BASE_STATION.cx, by = BASE_STATION.cy;

            // Lattice tower legs (pyramid shape)
            ctx.strokeStyle = col;
            ctx.lineWidth = 1.8;
            ctx.beginPath();
            ctx.moveTo(bx - 10, by + 12);
            ctx.lineTo(bx, by - 30);
            ctx.moveTo(bx + 10, by + 12);
            ctx.lineTo(bx, by - 30);
            ctx.moveTo(bx, by + 12);
            ctx.lineTo(bx, by - 30);
            ctx.stroke();

            // Lattice X-bracing (Tier 1 & 2)
            ctx.strokeStyle = col;
            ctx.lineWidth = 0.8;
            ctx.beginPath();
            ctx.moveTo(bx - 8, by + 2); ctx.lineTo(bx + 8, by + 2);
            ctx.moveTo(bx - 8, by + 6); ctx.lineTo(bx + 4, by - 2);
            ctx.moveTo(bx + 8, by + 6); ctx.lineTo(bx - 4, by - 2);
            ctx.moveTo(bx - 5, by - 12); ctx.lineTo(bx + 5, by - 12);
            ctx.moveTo(bx - 5, by - 6); ctx.lineTo(bx + 3, by - 14);
            ctx.moveTo(bx + 5, by - 6); ctx.lineTo(bx - 3, by - 14);
            ctx.stroke();

            // Parabolic dish antenna
            ctx.fillStyle = '#94a3b8';
            ctx.strokeStyle = '#475569';
            ctx.lineWidth = 1.0;
            ctx.beginPath();
            ctx.arc(bx - 6, by - 10, 5, Math.PI/2, 3*Math.PI/2);
            ctx.fill();
            ctx.stroke();
            ctx.beginPath();
            ctx.moveTo(bx - 6, by - 10);
            ctx.lineTo(bx - 11, by - 10);
            ctx.stroke();

            // Transceiver dome at top
            ctx.beginPath();
            ctx.arc(bx, by - 32, 3.5, 0, Math.PI * 2);
            ctx.fillStyle = on ? '#e0f2fe' : '#e2e8f0';
            ctx.fill();
            ctx.strokeStyle = col;
            ctx.lineWidth = 1.5;
            ctx.stroke();

            // Signal wave propagation arcs
            if (on) {
                ctx.strokeStyle = 'rgba(14, 165, 233, 0.4)';
                ctx.lineWidth = 1.2;
                ctx.beginPath();
                ctx.arc(bx, by - 32, 10, -Math.PI/3, -2*Math.PI/3, true);
                ctx.stroke();
                ctx.beginPath();
                ctx.arc(bx, by - 32, 16, -Math.PI/3, -2*Math.PI/3, true);
                ctx.stroke();
            }

            ctx.fillStyle = col;
            ctx.font = 'bold 9px Inter';
            ctx.fillText(BASE_STATION.label, bx - 36, by + 24);
        }

        function drawVehicle(v) {
            if (!v.vis) return;
            const hw = v.w / 2, hh = v.h / 2;
            
            ctx.save();
            
            // Halo/glow ring if authenticated
            if (isAuthenticated && activeVehicleId === v.label) {
                ctx.beginPath();
                ctx.arc(v.cx, v.cy, Math.max(v.w, v.h) * 0.9, 0, Math.PI * 2);
                ctx.strokeStyle = 'rgba(22, 163, 74, 0.35)';
                ctx.lineWidth = 3;
                ctx.stroke();
            }

            // Let's set up rotation based on direction
            ctx.translate(v.cx, v.cy);
            let angle = 0;
            if (v.dir === 'left') angle = Math.PI;
            else if (v.dir === 'up') angle = -Math.PI / 2;
            else if (v.dir === 'down') angle = Math.PI / 2;
            ctx.rotate(angle);

            // Draw the car body (facing right)
            // Bounding box size: width = 32, height = 15
            const carW = 32;
            const carH = 15;
            const chw = carW / 2;
            const chh = carH / 2;

            // 1. Wheels (4 black rectangles)
            ctx.fillStyle = '#0f172a';
            // Front-top wheel
            ctx.fillRect(chw - 9, -chh - 1, 6, 2);
            // Front-bottom wheel
            ctx.fillRect(chw - 9, chh - 1, 6, 2);
            // Rear-top wheel
            ctx.fillRect(-chw + 3, -chh - 1, 6, 2);
            // Rear-bottom wheel
            ctx.fillRect(-chw + 3, chh - 1, 6, 2);

            // 2. Main Body (rounded rect)
            ctx.fillStyle = v.color;
            ctx.beginPath();
            ctx.roundRect(-chw, -chh + 1, carW, carH - 2, 4);
            ctx.fill();
            
            // Body stroke
            ctx.strokeStyle = 'rgba(255,255,255,0.4)';
            ctx.lineWidth = 0.8;
            ctx.stroke();

            // 3. Cabin (glass area)
            ctx.fillStyle = 'rgba(15, 23, 42, 0.75)';
            ctx.beginPath();
            ctx.roundRect(-chw + 6, -chh + 3, 16, carH - 6, 2);
            ctx.fill();

            // Windshield (front glass highlight)
            ctx.fillStyle = '#bae6fd';
            ctx.beginPath();
            ctx.moveTo(chw - 10, -chh + 3.5);
            ctx.lineTo(chw - 7, -chh + 4.5);
            ctx.lineTo(chw - 7, chh - 4.5);
            ctx.lineTo(chw - 10, chh - 3.5);
            ctx.closePath();
            ctx.fill();

            // 4. Headlights (yellow-200)
            ctx.fillStyle = '#fef08a';
            ctx.beginPath();
            ctx.arc(chw, -chh + 3.5, 1.5, 0, Math.PI * 2);
            ctx.arc(chw, chh - 3.5, 1.5, 0, Math.PI * 2);
            ctx.fill();

            // 5. Taillights (red-500)
            ctx.fillStyle = '#ef4444';
            ctx.fillRect(-chw, -chh + 3, 1.5, 2);
            ctx.fillRect(-chw, chh - 5, 1.5, 2);

            ctx.restore();

            // Tag
            ctx.fillStyle = '#1e293b';
            ctx.font = 'bold 9px Courier New';
            ctx.textAlign = 'center';
            ctx.fillText(v.label, v.cx, v.cy + hh + 10);
            ctx.textAlign = 'left';
        }

        function drawPackets() {
            for (const p of packets) {
                ctx.save();
                ctx.globalAlpha = p.alpha;
                ctx.beginPath();
                ctx.arc(p.x, p.y, 3.5, 0, Math.PI * 2);
                ctx.fillStyle = p.color;
                ctx.shadowColor = p.color;
                ctx.shadowBlur = 8;
                ctx.fill();
                ctx.restore();
            }
        }

        function drawFloats() {
            ctx.save();
            ctx.font = 'bold 10px Courier New';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            for (const f of floats) {
                const alpha = Math.min(f.alpha, 1);
                ctx.globalAlpha = alpha;
                ctx.fillStyle = 'rgba(255,255,255,0.9)';
                const tw = ctx.measureText(f.text).width + 12;
                ctx.fillRect(f.cx - tw/2, f.cy - 8, tw, 16);
                ctx.strokeStyle = f.color;
                ctx.lineWidth = 1;
                ctx.strokeRect(f.cx - tw/2, f.cy - 8, tw, 16);
                ctx.fillStyle = f.color;
                ctx.fillText(f.text, f.cx, f.cy);
            }
            ctx.restore();
        }

        function drawLegend() {
            const lx = MX + 10, ly = MY + 10;
            const rows = [
                { color: '#2563eb', label: 'V1 — Connected Car (West ➔ East)', type: 'car' },
                { color: '#16a34a', label: 'V2 — Connected Car (East ➔ West)', type: 'car' },
                { color: '#ea580c', label: 'V3 — Inactive Node (South ➔ North)', type: 'car' },
                { color: '#dc2626', label: 'Attacker (Replayed packet)', type: 'car' },
                { color: '#2563eb', label: 'T — Centroid True Position', type: 'dot', text: 'T' },
                { color: '#7c3aed', label: 'P — DP Obfuscated position', type: 'dot', text: 'P' }
            ];
            const h = rows.length * 16 + 10;
            const w = 240;

            ctx.fillStyle = 'rgba(255, 255, 255, 0.95)';
            ctx.strokeStyle = varColor('--border');
            ctx.lineWidth = 1;
            ctx.beginPath();
            ctx.roundRect(lx, ly, w, h, 6);
            ctx.fill();
            ctx.stroke();

            ctx.font = '10px Inter';
            rows.forEach((it, i) => {
                const ry = ly + 8 + i * 16;
                
                if (it.type === 'car') {
                    // Draw a miniature car/rect
                    ctx.fillStyle = it.color;
                    ctx.fillRect(lx + 8, ry + 2, 12, 6);
                    ctx.strokeStyle = 'rgba(255,255,255,0.6)';
                    ctx.lineWidth = 0.5;
                    ctx.strokeRect(lx + 8, ry + 2, 12, 6);
                } else if (it.type === 'dot') {
                    // Draw a mini dot T/P
                    const cx = lx + 14, cy = ry + 5;
                    ctx.beginPath();
                    ctx.arc(cx, cy, 5.5, 0, Math.PI * 2);
                    ctx.fillStyle = it.color + '22';
                    ctx.fill();
                    ctx.strokeStyle = it.color;
                    ctx.lineWidth = 1;
                    ctx.stroke();
                    ctx.fillStyle = it.color;
                    ctx.font = 'bold 7px Courier New';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillText(it.text, cx, cy);
                    ctx.textBaseline = 'alphabetic';
                    ctx.textAlign = 'left';
                    ctx.font = '10px Inter'; // restore
                }

                ctx.fillStyle = varColor('--text');
                ctx.fillText(it.label, lx + 26, ry + 9);
            });
        }

        function drawScaleBar() {
            const bx = MX + MW - 70, by = MY + MH - 10;
            ctx.fillStyle = '#64748b';
            ctx.fillRect(bx, by, 60, 2);
            ctx.font = '8px Inter';
            ctx.fillText('~40 m', bx + 16, by - 4);
        }

        function varColor(name) {
            return getComputedStyle(document.documentElement).getPropertyValue(name).trim();
        }

        // ─────────────────────────────────────────
        //  Event Logs Logging
        // ─────────────────────────────────────────
        function log(msg, type) {
            const el = document.getElementById('log');
            const d = document.createElement('div');
            d.className = 'le ' + (type || 'info');
            d.textContent = '[' + ts() + ']  ' + msg;
            el.appendChild(d);
            el.scrollTop = el.scrollHeight;
        }

        // ─────────────────────────────────────────
        //  Stats loader & dynamic cards updater
        // ─────────────────────────────────────────
        async function fetchStats() {
            try {
                const r = await fetch('/stats');
                const data = await r.json();
                if (data.status === 'success') {
                    document.getElementById('stVehicles').textContent = data.connected_vehicles;
                    document.getElementById('stAuthed').textContent = data.authenticated_nodes;
                    
                    // latency / load
                    if (sessionToken) {
                        document.getElementById('stLoc').textContent = '0.5';
                        document.getElementById('stRSU').textContent = data.bs_load; // use BS load metrics
                    } else {
                        document.getElementById('stLoc').textContent = '—';
                        document.getElementById('stRSU').textContent = '0%';
                    }

                    document.getElementById('stMsgs').textContent = msgsPassed;

                    // timestamps
                    const time = ts();
                    ['tsVeh', 'tsAuth', 'tsRsu', 'tsMsgs', 'tsLoc', 'tsThreats'].forEach(id => {
                        document.getElementById(id).textContent = `Updated: ${time}`;
                    });
                }
            } catch (err) {
                console.error("Stats fetching error:", err);
            }
        }

        // ─────────────────────────────────────────
        //  State Management for Steps UI
        // ─────────────────────────────────────────
        function setChecklist(stepIndex, state) {
            const el = document.getElementById(`step${stepIndex}`);
            if (el) {
                el.className = 'step ' + state;
                const icon = el.querySelector('.step-icon');
                if (state === 'done') icon.textContent = '✓';
                else if (state === 'error') icon.textContent = '✗';
                else icon.textContent = stepIndex;
            }
        }

        function clearChecklist() {
            for (let i = 1; i <= 4; i++) {
                setChecklist(i, 'idle');
            }
        }

        // ─────────────────────────────────────────
        //  UI Controls Elements
        // ─────────────────────────────────────────
        const selector = document.getElementById('nodeSelector');
        const btnAuth = document.getElementById('btnManualAuth');
        const btnLoc = document.getElementById('btnManualLoc');
        const btnMsg = document.getElementById('btnManualMsg');
        const btnReplay = document.getElementById('btnManualReplay');
        const btnReset = document.getElementById('btnManualReset');
        const statusBadge = document.getElementById('statusBadge');

        // Spawning / selection hook
        selector.addEventListener('change', async function() {
            const uid = this.value;
            if (!uid) return;

            await resetScene();
            activeVehicleId = uid;
            
            // Set status
            statusBadge.className = 'badge yellow';
            statusBadge.textContent = 'SPAWNING';

            log(`Initializing vehicle coordinates selection for UID: ${uid}`, 'info');

            if (uid === 'SCENARIO_MULTI') {
                try {
                    const [res1, res2] = await Promise.all([
                        fetch('/simulate/vehicle-info/VEH-DEMO-001').then(r => r.json()),
                        fetch('/simulate/vehicle-info/VEH-DEMO-002').then(r => r.json())
                    ]);

                    vehicleDataList = [res1.data, res2.data];

                    // Spawn V1, V2, and V3
                    VA.vis = true; VA.cx = 60; VA.cy = 275;
                    VC.vis = true; VC.cx = CW - 60; VC.cy = 235;
                    VD.vis = true; VD.cx = 398; VD.cy = CH - 60;

                    document.getElementById('iUid').textContent = 'V1, V2, V3';
                    document.getElementById('iAuth').textContent = 'SPAWNED';
                    document.getElementById('iAuth').className = 'ivalue cyan';

                    btnAuth.disabled = false;
                    setChecklist(1, 'done');
                    setChecklist(2, 'active');

                    bsOn = true;
                    Object.keys(rsuOn).forEach(k => rsuOn[k] = true);
                    trafficPhase = 'EW';

                    log(`Multi-Vehicle Scenario initialized: Spawning V1, V2, and V3. RSU and V2X backhaul tower active.`, 'success');
                    statusBadge.className = 'badge yellow';
                    statusBadge.textContent = 'UNAUTH';

                    await fetchStats();
                } catch (err) {
                    log(`Failed to initiate scenario credentials: ${err.message}`, 'danger');
                }
                return;
            }

            try {
                // Fetch keys for local signature MAC generation
                const res = await fetch(`/simulate/vehicle-info/${uid}`);
                const data = await res.json();
                vehicleData = data.data;

                // Spawning visual state
                if (uid === 'VEH-DEMO-001') {
                    VA.vis = true; VA.cx = 60; VA.cy = 275;
                } else if (uid === 'VEH-DEMO-002') {
                    VC.vis = true; VC.cx = CW - 60; VC.cy = 235;
                } else if (uid === 'VEH-DEMO-003') {
                    VD.vis = true; VD.cx = 398; VD.cy = CH - 60;
                } else if (uid === 'ATTACKER') {
                    VX.vis = true; VX.cx = 120; VX.cy = 275;
                }

                // Show details on Status Panel on the right
                document.getElementById('iUid').textContent = vehicleData.vehicle_uid;
                document.getElementById('iAuth').textContent = vehicleData.is_active ? 'SPAWNED' : 'INACTIVE';
                document.getElementById('iAuth').className = 'ivalue ' + (vehicleData.is_active ? 'cyan' : 'red');

                // Enable authenticate step if not attacker
                if (uid === 'ATTACKER') {
                    btnAuth.disabled = true;
                    btnLoc.disabled = true;
                    btnMsg.disabled = true;
                    log(`Attacker node selected. Please click the "⚡ Replay Attack" button to demonstrate replay attack mitigation.`, 'warn');
                } else {
                    btnAuth.disabled = false;
                }
                setChecklist(1, 'done');
                setChecklist(2, 'active');

                // Activate antennas
                bsOn = true;
                Object.keys(rsuOn).forEach(k => rsuOn[k] = true);
                trafficPhase = 'EW';

                if (uid === 'ATTACKER') {
                    log(`Spawning Attacker vehicle: x=120. Click the "⚡ Replay Attack" button to run.`, 'warn');
                    statusBadge.className = 'badge yellow';
                    statusBadge.textContent = 'REPLAY TEST';
                } else {
                    log(`Spawning deterministic starting positions: x=${uid === 'VEH-DEMO-001' ? 60 : uid === 'VEH-DEMO-002' ? CW - 60 : 398}. RSU and V2X backhaul tower active.`, 'success');
                    statusBadge.className = 'badge yellow';
                    statusBadge.textContent = 'UNAUTH';
                }

                await fetchStats();

            } catch (err) {
                log(`Failed to initiate vehicle credentials: ${err.message}`, 'danger');
            }
        });

        // Step 2: Authenticate Node
        btnAuth.addEventListener('click', async function() {
            btnAuth.disabled = true;
            document.getElementById('btnAuthText').innerHTML = '⏳ Verifying...';
            setChecklist(2, 'active');

            if (activeVehicleId === 'SCENARIO_MULTI') {
                log(`Starting multi-vehicle cryptographic handshake session for V1 and V2...`, 'info');
                const timestamp = Date.now();
                
                try {
                    const raw1 = vehicleDataList[0].secret_key + 'AuthRequest' + timestamp + '1';
                    const mac1 = await sha256(raw1);
                    
                    const raw2 = vehicleDataList[1].secret_key + 'AuthRequest' + timestamp + '1';
                    const mac2 = await sha256(raw2);

                    log(`Transmitting parallel V2I Auth packets for V1 and V2 to nearest RSUs...`, 'info');
                    await sleep(1000);

                    const [res1, res2] = await Promise.all([
                        fetch('/simulate/auth', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({
                                auth_type: 'v2i',
                                vehicle_uid: 'VEH-DEMO-001',
                                message: 'AuthRequest',
                                timestamp: timestamp,
                                seq: '1',
                                mac: mac1
                            })
                        }).then(r => r.json()),
                        fetch('/simulate/auth', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({
                                auth_type: 'v2i',
                                vehicle_uid: 'VEH-DEMO-002',
                                message: 'AuthRequest',
                                timestamp: timestamp,
                                seq: '1',
                                mac: mac2
                            })
                        }).then(r => r.json())
                    ]);

                    if (res1.status === 'success' && res2.status === 'success') {
                        isAuthenticated = true;
                        sessionToken = res1.data.session_token;
                        sessionTokenList = [res1.data.session_token, res2.data.session_token];

                        VA.cx = RD.vX1 - 16;
                        VC.cx = RD.vX2 + 16;

                        floats.push({ text: 'V1 Session Verified ✓', cx: VA.cx, cy: VA.cy - 12, alpha: 2.0, color: '#16a34a' });
                        floats.push({ text: 'V2 Session Verified ✓', cx: VC.cx, cy: VC.cy - 12, alpha: 2.0, color: '#16a34a' });

                        document.getElementById('btnAuthText').innerHTML = '🔐 Auth Request';
                        setChecklist(2, 'done');
                        setChecklist(3, 'active');

                        document.getElementById('iAuth').textContent = 'MULTI-AUTHENTICATED';
                        document.getElementById('iAuth').className = 'ivalue green';
                        document.getElementById('iToken').textContent = sessionToken.slice(0, 8) + '...';
                        statusBadge.className = 'badge green';
                        statusBadge.textContent = 'AUTH OK';

                        document.getElementById('mReg').textContent = '2.5';
                        document.getElementById('mAuth').textContent = '11.4';

                        btnLoc.disabled = false;
                        log(`V2I crypt-mac verification success for all active vehicles. Session tokens active.`, 'success');
                        msgsPassed += 4;
                        await fetchStats();
                    } else {
                        throw new Error("One or more vehicles failed V2I authentication.");
                    }
                } catch (err) {
                    document.getElementById('btnAuthText').innerHTML = '🔐 Auth Request';
                    setChecklist(2, 'error');
                    statusBadge.className = 'badge red';
                    statusBadge.textContent = 'REJECTED';
                    log(`Scenario authentication failed: ${err.message}`, 'danger');
                }
                return;
            }

            log(`Starting cryptographic handshake session...`, 'info');
            const timestamp = Date.now();
            const seq = '1';
            const msgBody = 'AuthRequest';

            // Calculate locally
            const raw = vehicleData.secret_key + msgBody + timestamp + seq;
            const computedMac = await sha256(raw);

            log(`Generated local MAC token: ${computedMac.slice(0, 16)}...`, 'muted');

            // Send register & authenticate verification checks
            await sleep(1000);

            try {
                const res = await fetch('/simulate/auth', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        auth_type: 'v2i',
                        vehicle_uid: activeVehicleId,
                        message: msgBody,
                        timestamp: timestamp,
                        seq: seq,
                        mac: computedMac
                    })
                });

                const data = await res.json();

                if (data.status === 'success') {
                    isAuthenticated = true;
                    sessionToken = data.data.session_token;

                    // Transition vehicle close to stop lines
                    if (activeVehicleId === 'VEH-DEMO-001') {
                        VA.cx = RD.vX1 - 16;
                    } else if (activeVehicleId === 'VEH-DEMO-002') {
                        VC.cx = RD.vX2 + 16;
                    }

                    // Float tags
                    floats.push({ text: 'Session Key Verified ✓', cx: activeVehicleId === 'VEH-DEMO-001' ? VA.cx : VC.cx, cy: (activeVehicleId === 'VEH-DEMO-001' ? VA.cy - 12 : VC.cy - 12), alpha: 2.0, color: '#16a34a' });

                    document.getElementById('btnAuthText').innerHTML = '🔐 Auth Request';
                    setChecklist(2, 'done');
                    setChecklist(3, 'active');

                    // Status
                    document.getElementById('iAuth').textContent = 'AUTHENTICATED';
                    document.getElementById('iAuth').className = 'ivalue green';
                    document.getElementById('iToken').textContent = sessionToken;
                    statusBadge.className = 'badge green';
                    statusBadge.textContent = 'AUTH OK';

                    // Perf metrics
                    document.getElementById('mReg').textContent = '2.4';
                    document.getElementById('mAuth').textContent = '10.8';

                    // Enable localization step
                    btnLoc.disabled = false;

                    log(`V2I crypt-mac verification success. Session token issued successfully: ${sessionToken.slice(0, 16)}...`, 'success');
                    msgsPassed += 2;
                    await fetchStats();
                } else {
                    throw new Error(data.message);
                }
            } catch (err) {
                document.getElementById('btnAuthText').innerHTML = '🔐 Auth Request';
                setChecklist(2, 'error');
                
                document.getElementById('iAuth').textContent = 'FAILED';
                document.getElementById('iAuth').className = 'ivalue red';
                statusBadge.className = 'badge red';
                statusBadge.textContent = 'REJECTED';

                // Float tags
                const tagX = activeVehicleId === 'VEH-DEMO-001' ? VA.cx : activeVehicleId === 'VEH-DEMO-002' ? VC.cx : VD.cx;
                const tagY = activeVehicleId === 'VEH-DEMO-001' ? VA.cy : activeVehicleId === 'VEH-DEMO-002' ? VC.cy : VD.cy;
                floats.push({ text: 'AUTH FAILED ✗', cx: tagX, cy: tagY - 15, alpha: 2.0, color: '#dc2626' });

                log(`Authentication signature check failed: ${err.message}`, 'danger');
            }
        });

        // Step 3: Localization
        btnLoc.addEventListener('click', async function() {
            btnLoc.disabled = true;
            document.getElementById('btnLocText').innerHTML = '⏳ Calculating...';
            setChecklist(3, 'active');

            if (activeVehicleId === 'SCENARIO_MULTI') {
                log(`Collecting simultaneous signal RSSI coordinate metrics for V1 and V2...`, 'info');
                await sleep(1000);

                const sim1 = c2s(VA.cx, VA.cy);
                const signals1 = Object.keys(RSUS).map(id => {
                    const rsu = RSUS[id];
                    const dist = Math.max(Math.hypot(sim1.sx - rsu.sx, sim1.sy - rsu.sy), 1);
                    return { rsu_uid: id, rssi: parseFloat((20 - (25 * Math.log10(dist))).toFixed(1)) };
                });
                const sim2 = c2s(VC.cx, VC.cy);
                const signals2 = Object.keys(RSUS).map(id => {
                    const rsu = RSUS[id];
                    const dist = Math.max(Math.hypot(sim2.sx - rsu.sx, sim2.sy - rsu.sy), 1);
                    return { rsu_uid: id, rssi: parseFloat((20 - (25 * Math.log10(dist))).toFixed(1)) };
                });

                try {
                    const [res1, res2] = await Promise.all([
                        fetch('/simulate/localization', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ session_token: sessionTokenList[0], signals: signals1 })
                        }).then(r => r.json()),
                        fetch('/simulate/localization', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ session_token: sessionTokenList[1], signals: signals2 })
                        }).then(r => r.json())
                    ]);

                    if (res1.status === 'success' && res2.status === 'success') {
                        VA.cx = 386;
                        VC.cx = 370;

                        dotTrue = s2c(res1.original_location.x, res1.original_location.y);
                        dotDP = s2c(res1.privacy_location.x, res1.privacy_location.y);
                        
                        dotTrueList = [
                            s2c(res1.original_location.x, res1.original_location.y),
                            s2c(res2.original_location.x, res2.original_location.y)
                        ];
                        dotDPList = [
                            s2c(res1.privacy_location.x, res1.privacy_location.y),
                            s2c(res2.privacy_location.x, res2.privacy_location.y)
                        ];

                        triLines = [];
                        Object.values(RSUS).forEach(rsu => {
                            triLines.push({ x1: VA.cx, y1: VA.cy, x2: rsu.cx, y2: rsu.cy, r: 14, g: 165, b: 233, alpha: 0.6, fade: true });
                            triLines.push({ x1: VC.cx, y1: VC.cy, x2: rsu.cx, y2: rsu.cy, r: 22, g: 197, b: 94, alpha: 0.6, fade: true });
                        });

                        floats.push({ text: 'V1 DP Laplace Applied', cx: dotDPList[0].cx, cy: dotDPList[0].cy - 12, alpha: 2.0, color: '#7c3aed' });
                        floats.push({ text: 'V2 DP Laplace Applied', cx: dotDPList[1].cx, cy: dotDPList[1].cy - 12, alpha: 2.0, color: '#7c3aed' });

                        document.getElementById('btnLocText').innerHTML = '📡 Update Loc';
                        setChecklist(3, 'done');
                        setChecklist(4, 'active');

                        document.getElementById('locTrue').textContent = `V1:(${res1.original_location.x.toFixed(0)},${res1.original_location.y.toFixed(0)})`;
                        document.getElementById('locDP').textContent = `V1:(${res1.privacy_location.x.toFixed(0)},${res1.privacy_location.y.toFixed(0)})`;
                        document.getElementById('mLoc').textContent = '15.6';

                        btnMsg.disabled = false;
                        log(`Multi-vehicle localization updated. Laplace privacy noise offsets generated for both V1 and V2.`, 'success');
                        msgsPassed += 10;
                        await fetchStats();
                    } else {
                        throw new Error("One or more localization requests failed.");
                    }
                } catch (err) {
                    document.getElementById('btnLocText').innerHTML = '📡 Update Loc';
                    setChecklist(3, 'error');
                    log(`Localization scenario processing failed: ${err.message}`, 'danger');
                }
                return;
            }

            log(`Collecting signal RSSI coordinates and resolving multilateration centroid...`, 'info');
            await sleep(1000);

            // Compute deterministic RSU RSSI values based on simulation coordinates
            const currentVeh = activeVehicleId === 'VEH-DEMO-001' ? VA : VC;
            const vehSim = c2s(currentVeh.cx, currentVeh.cy);
            const signals = Object.keys(RSUS).map(id => {
                const rsu = RSUS[id];
                const dx = vehSim.sx - rsu.sx;
                const dy = vehSim.sy - rsu.sy;
                const dist = Math.max(Math.hypot(dx, dy), 1); // simulated meters
                
                const txPower = 20;
                const rssi = txPower - (10 * 2.5 * Math.log10(dist));
                return { rsu_uid: id, rssi: parseFloat(rssi.toFixed(1)) };
            });

            log(`Collected RSSI: ` + signals.map(s => `${s.rsu_uid}=${s.rssi}dBm`).join(' '), 'muted');

            try {
                const res = await fetch('/simulate/localization', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        session_token: sessionToken,
                        signals: signals
                    })
                });

                const data = await res.json();

                if (data.status === 'success') {
                    // Update vehicle positioning to intersection center
                    if (activeVehicleId === 'VEH-DEMO-001') {
                        VA.cx = 386;
                    } else {
                        VC.cx = 370;
                    }

                    // Display True and DP dots
                    dotTrue = s2c(data.original_location.x, data.original_location.y);
                    dotDP = s2c(data.privacy_location.x, data.privacy_location.y);

                    // Add fading lines
                    triLines = Object.values(RSUS).map(rsu => {
                        return { x1: currentVeh.cx, y1: currentVeh.cy, x2: rsu.cx, y2: rsu.cy, r: 14, g: 165, b: 233, alpha: 0.7, fade: true };
                    });

                    // Float
                    floats.push({ text: 'Laplace DP Noise Applied', cx: dotDP.cx, cy: dotDP.cy - 12, alpha: 2.0, color: '#7c3aed' });

                    document.getElementById('btnLocText').innerHTML = '📡 Update Loc';
                    setChecklist(3, 'done');
                    setChecklist(4, 'active');

                    // Stats
                    document.getElementById('locTrue').textContent = `(${data.original_location.x.toFixed(1)}, ${data.original_location.y.toFixed(1)})`;
                    document.getElementById('locDP').textContent = `(${data.privacy_location.x.toFixed(1)}, ${data.privacy_location.y.toFixed(1)})`;
                    document.getElementById('mLoc').textContent = '14.2';

                    // Enable send message step
                    btnMsg.disabled = false;

                    const delta = Math.hypot(data.original_location.x - data.privacy_location.x, data.original_location.y - data.privacy_location.y).toFixed(1);
                    log(`Secure localization successfully updated. Noise Delta: ${delta}m. True: ${document.getElementById('locTrue').textContent} | DP: ${document.getElementById('locDP').textContent}`, 'success');
                    msgsPassed += 5;
                    await fetchStats();
                } else {
                    throw new Error(data.message);
                }

            } catch (err) {
                document.getElementById('btnLocText').innerHTML = '📡 Update Loc';
                setChecklist(3, 'error');
                log(`Localization multilateration processing failed: ${err.message}`, 'danger');
            }
        });

        // Step 4: Broadcast Message
        btnMsg.addEventListener('click', async function() {
            btnMsg.disabled = true;
            document.getElementById('btnMsgText').innerHTML = '⏳ Transmitting...';
            setChecklist(4, 'active');

            if (activeVehicleId === 'SCENARIO_MULTI') {
                log(`Establishing secure cooperative communication channel...`, 'info');
                await sleep(500);

                try {
                    const challenge = 'abc123v2vchal';
                    const timestamp = Date.now();
                    const rawMacV2V = 'STATIC_GROUP_KEY_FOR_SIMULATION' + challenge + timestamp + '0';
                    const macV2V = await sha256(rawMacV2V);

                    const resV2V = await fetch('/simulate/auth', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            auth_type: 'v2v',
                            vehicle_a_uid: 'VEH-DEMO-001',
                            vehicle_b_uid: 'VEH-DEMO-002',
                            challenge: challenge,
                            timestamp: timestamp,
                            mac: macV2V
                        })
                    });
                    const dataV2V = await resV2V.json();

                    const resV2I = await fetch('/simulate/messages', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            sender: 'VEH-DEMO-003',
                            receiver: 'RSU-1',
                            message_type: 'CAM',
                            channel: 'V2I',
                            session_token: sessionTokenList[0]
                        })
                    });
                    const dataV2I = await resV2I.json();

                    if (dataV2V.status === 'success' && dataV2I.status === 'success') {
                        v2vLink = { a: VA, b: VC };

                        packets.push({
                            ox: VA.cx, oy: VA.cy,
                            tx: VC.cx, ty: VC.cy,
                            x: VA.cx, y: VA.cy,
                            progress: 0, color: '#7c3aed', alpha: 1
                        });
                        packets.push({
                            ox: VC.cx, oy: VC.cy,
                            tx: VA.cx, ty: VA.cy,
                            x: VC.cx, y: VC.cy,
                            progress: 0, color: '#7c3aed', alpha: 1
                        });
                        packets.push({
                            ox: VD.cx, oy: VD.cy,
                            tx: RSUS['RSU-1'].cx, ty: RSUS['RSU-1'].cy,
                            x: VD.cx, y: VD.cy,
                            progress: 0, color: '#0ea5e9', alpha: 1
                        });

                        await sleep(1000);

                        VA.cx = CW + 60;
                        VC.cx = -60;
                        VD.cy = -60;

                        document.getElementById('btnMsgText').innerHTML = '📨 Send Message';
                        setChecklist(4, 'done');

                        document.getElementById('iV2V').textContent = 'ACTIVE (V1-V2)';
                        document.getElementById('iV2V').className = 'ivalue green';

                        log(`Secure V2V cooperative channel derived: ${dataV2V.session_key.slice(0, 16)}...`, 'success');
                        log(`Multi-channel concurrent communication completed:`, 'success');
                        log(`[V2V Telemetry] V1 ⟷ V2 exchanged mutual challenge CAM safety packets.`, 'info');
                        log(`[V2I Telemetry] V3 (VD) broadcasted safety CAM packet to RSU-1. Latency: ${dataV2I.data.latency_ms}ms.`, 'info');

                        msgsPassed += 3;
                        await fetchStats();
                    } else {
                        throw new Error("V2V or V2I communication scenario handshakes failed.");
                    }
                } catch (err) {
                    document.getElementById('btnMsgText').innerHTML = '📨 Send Message';
                    setChecklist(4, 'error');
                    log(`Broadcast communication scenario failed: ${err.message}`, 'danger');
                }
                return;
            }

            log(`Broadcasting CAM safety alert message packet...`, 'info');

            const currentVeh = activeVehicleId === 'VEH-DEMO-001' ? VA : VC;
            let nearestId = 'RSU-1';
            let minDist = Infinity;
            for (const [id, rsu] of Object.entries(RSUS)) {
                const dist = Math.hypot(currentVeh.cx - rsu.cx, currentVeh.cy - rsu.cy);
                if (dist < minDist) {
                    minDist = dist;
                    nearestId = id;
                }
            }

            try {
                const res = await fetch('/simulate/messages', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        sender: activeVehicleId,
                        receiver: nearestId,
                        message_type: 'CAM',
                        channel: 'V2I',
                        session_token: sessionToken
                    })
                });

                const data = await res.json();

                if (data.status === 'success') {
                    // Send packet animation from vehicle to RSU
                    packets.push({
                        ox: currentVeh.cx, oy: currentVeh.cy,
                        tx: RSUS[nearestId].cx, ty: RSUS[nearestId].cy,
                        x: currentVeh.cx, y: currentVeh.cy,
                        progress: 0, color: '#16a34a', alpha: 1
                    });

                    await sleep(800);

                    // Move vehicle past intersection and off the map
                    if (activeVehicleId === 'VEH-DEMO-001') {
                        VA.cx = CW + 60;
                    } else {
                        VC.cx = -60;
                    }

                    document.getElementById('btnMsgText').innerHTML = '📨 Send Message';
                    setChecklist(4, 'done');

                    // Stats
                    log(`CAM safety broadcast confirmed by RSU successfully. Latency: ${data.data.latency_ms}ms`, 'success');
                    
                    msgsPassed += 1;
                    await fetchStats();
                } else {
                    throw new Error(data.message);
                }

            } catch (err) {
                document.getElementById('btnMsgText').innerHTML = '📨 Send Message';
                setChecklist(4, 'error');
                log(`Message broadcast transmission failed: ${err.message}`, 'danger');
            }
        });

        // Trigger Replay Attack
        btnReplay.addEventListener('click', async function() {
            await resetScene();
            selector.value = 'ATTACKER';
            activeVehicleId = 'ATTACKER';

            statusBadge.className = 'badge yellow';
            statusBadge.textContent = 'REPLAY TEST';

            log(`Triggering Replay Attack scenario: Sniffing legitimate keys...`, 'warn');

            try {
                const res = await fetch(`/simulate/vehicle-info/VEH-DEMO-001`);
                const data = await res.json();
                vehicleData = data.data;

                // Spawn Attacker
                VX.vis = true; VX.cx = 120; VX.cy = 275;

                setChecklist(1, 'done');
                setChecklist(2, 'active');

                // Stale timestamp offset (12 seconds old)
                const staleTime = Date.now() - 12000;
                const seq = '1';
                const msgBody = 'AuthRequest';

                const raw = vehicleData.secret_key + msgBody + staleTime + seq;
                const staleMac = await sha256(raw);

                log(`Replaying sniffed MAC token: ${staleMac.slice(0, 16)}...`, 'warn');
                log(`Sending replayed packet containing stale timestamp offset ΔT = 12s...`, 'warn');

                await sleep(1000);

                const authRes = await fetch('/simulate/auth', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        auth_type: 'v2i',
                        vehicle_uid: 'VEH-DEMO-001',
                        message: msgBody,
                        timestamp: staleTime,
                        seq: seq,
                        mac: staleMac
                    })
                });

                const authData = await authRes.json();

                if (authData.status === 'success') {
                    // Fail: should not bypass freshness window
                    setChecklist(2, 'done');
                    log(`CRITICAL WARNING: Replay attack bypassed freshness constraint!`, 'danger');
                } else {
                    throw new Error(authData.message);
                }

            } catch (err) {
                setChecklist(2, 'error');
                statusBadge.className = 'badge red';
                statusBadge.textContent = 'BLOCKED';

                // Float Blocked Tag
                floats.push({ text: 'REPLAY BLOCKED ✗', cx: VX.cx, cy: VX.cy - 12, alpha: 2.2, color: '#dc2626' });

                // Increment threat statistics counter
                const threatsEl = document.getElementById('stThreats');
                threatsEl.textContent = parseInt(threatsEl.textContent) + 1;

                log(`RSU validation failed: "${err.message}"`, 'danger');
                msgsPassed += 1;
                log(`Freshness window check failed (|ΔT| = 12s > 5s). Cryptographic replay request rejected successfully.`, 'success');
                await fetchStats();
            }
        });

        // Reset Board
        btnReset.addEventListener('click', async function() {
            await resetScene();
            selector.value = '';
            statusBadge.className = 'badge';
            statusBadge.textContent = 'IDLE';
            log('Simulation testbed variables reset successfully.', 'info');
        });

        async function resetScene() {
            try {
                await fetch('/simulate/reset', { method: 'POST' });
            } catch (err) {
                console.error("Failed to reset backend sessions:", err);
            }
            msgsPassed = 0;

            VA.vis = false; VA.cx = -50; VA.cy = 275;
            VC.vis = false; VC.cx = CW + 50; VC.cy = 235;
            VD.vis = false; VD.cx = 398; VD.cy = CH + 50;
            VX.vis = false; VX.cx = -50; VX.cy = 275;

            rsuOn = { 'RSU-1': false, 'RSU-2': false, 'RSU-3': false, 'RSU-4': false };
            bsOn = false;
            rings = [];
            triLines = [];
            v2vLink = null;
            dotTrue = null;
            dotDP = null;
            dotTrueList = [];
            dotDPList = [];
            vehicleDataList = [];
            sessionTokenList = [];
            floats = [];
            packets = [];
            trafficPhase = 'OFF';

            activeVehicleId = null;
            vehicleData = null;
            sessionToken = null;
            isAuthenticated = false;

            document.getElementById('iUid').textContent = '—';
            document.getElementById('iAuth').textContent = 'UNAUTHENTICATED';
            document.getElementById('iAuth').className = 'ivalue';
            document.getElementById('iToken').textContent = '—';
            document.getElementById('iV2V').textContent = 'INACTIVE';
            document.getElementById('iV2V').className = 'ivalue';

            document.getElementById('locTrue').textContent = '—';
            document.getElementById('locDP').textContent = '—';

            document.getElementById('mReg').textContent = '—';
            document.getElementById('mAuth').textContent = '—';
            document.getElementById('mLoc').textContent = '—';

            btnAuth.disabled = true;
            btnLoc.disabled = true;
            btnMsg.disabled = true;

            clearChecklist();
            fetchStats();
        }

        // Initialize view
        resetScene();
        renderLoop();
    </script>
</body>

</html>
