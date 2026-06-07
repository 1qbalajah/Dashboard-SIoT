<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Azure Metrics Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ===== AZURE METRICS DESIGN SYSTEM ===== */
        :root {
            /* Colors - Surface & Background */
            --surface: #eef2f6;
            --surface-container: #f8fafc;
            --surface-container-low: #f8fafc;
            --surface-container-high: #e2e8f0;
            --surface-bright: #ffffff;
            --on-surface: #0f172a;
            --on-surface-variant: #64748b;

            /* Colors - Primary */
            --primary: #0f172a;
            --primary-container: #1e293b;
            --on-primary: #ffffff;
            --on-primary-container: #e2e8f0;
            --primary-fixed: #e2e8f0;
            --primary-fixed-dim: #cbd5e1;

            /* Colors - Secondary & Accent */
            --secondary: #0f172a;
            --secondary-container: #f1f5f9;
            --on-secondary: #0f172a;

            /* Colors - Status */
            --error: #ef4444;
            --error-container: #fee2e2;
            --on-error: #ffffff;
            --success: #22c55e;
            --success-container: #dcfce7;

            /* Borders & Outline */
            --outline: #94a3b8;
            --outline-variant: #e2e8f0;

            /* Typography */
            --font-main: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --font-mono: 'JetBrains Mono', monospace;

            /* Spacing */
            --space-1: 8px;
            --space-2: 16px;
            --space-3: 24px;
            --space-4: 32px;
            --space-5: 40px;

            /* Rounded */
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 20px;
            --radius-xl: 24px;

            /* Pastel Colors for Sensor Cards */
            --temp-bg: #fff5f0;
            --temp-border: #ffe4d6;
            --temp-text: #c2410c;
            
            --humidity-bg: #f0f7ff;
            --humidity-border: #dbeafe;
            --humidity-text: #1d4ed8;

            --servo-bg: #f0fdf4;
            --servo-border: #dcfce7;
            --servo-text: #15803d;

            --lcd-bg: #0f111a;
            --lcd-text: #ffffff;
            --lcd-border: #1e293b;

            /* Shadows */
            --shadow-level1: 0 4px 20px rgba(15, 23, 42, 0.015);
            --shadow-level2: 0 12px 30px rgba(15, 23, 42, 0.04);
            --shadow-hover: 0 8px 24px rgba(15, 23, 42, 0.03);
        }

        /* ===== RESET & BASE ===== */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            height: 100%;
            overflow: hidden;
        }

        body {
            font-family: var(--font-main);
            background-color: var(--surface);
            color: var(--on-surface);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        /* ===== LAYOUT GRID ===== */
        .dashboard-layout {
            display: grid;
            grid-template-columns: 260px 1fr;
            min-height: 100vh;
            height: 100vh;
            overflow: hidden;
            background-color: var(--surface);
        }

        /* ===== MAIN CONTENT - WRAPPED IN PALE BLUE FRAME ===== */
        .main-content {
            padding: 24px;
            background-color: var(--surface);
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* ===== CONTENT CANVAS - WHITE ROUNDED CONTAINER ===== */
        .content-canvas {
            background-color: var(--surface-bright);
            border-radius: 32px;
            padding: 40px;
            flex: 1;
            overflow-y: auto;
            box-shadow: 0 4px 30px rgba(15, 23, 42, 0.015);
            display: flex;
            flex-direction: column;
            scroll-behavior: smooth;
        }

        /* Custom scrollbar untuk content canvas */
        .content-canvas::-webkit-scrollbar {
            width: 8px;
        }
        .content-canvas::-webkit-scrollbar-track {
            background: transparent;
        }
        .content-canvas::-webkit-scrollbar-thumb {
            background: var(--outline-variant);
            border-radius: 4px;
        }
        .content-canvas::-webkit-scrollbar-thumb:hover {
            background: var(--outline);
        }

        /* ===== TYPOGRAPHY ===== */
        .headline-xl {
            font-size: 32px;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -0.03em;
            color: var(--on-surface);
        }

        .headline-lg {
            font-size: 26px;
            font-weight: 700;
            line-height: 1.3;
            letter-spacing: -0.02em;
        }

        .headline-md {
            font-size: 22px;
            font-weight: 700;
            line-height: 1.3;
            letter-spacing: -0.02em;
        }

        .headline-sm {
            font-size: 18px;
            font-weight: 600;
            line-height: 1.4;
        }

        .body-lg {
            font-size: 16px;
            font-weight: 400;
            line-height: 1.6;
        }

        .body-md {
            font-size: 14px;
            font-weight: 400;
            line-height: 1.5;
            color: var(--on-surface-variant);
        }

        .body-sm {
            font-size: 13px;
            font-weight: 400;
            line-height: 1.5;
            color: var(--on-surface-variant);
        }

        .label-md {
            font-family: var(--font-main);
            font-size: 13px;
            font-weight: 600;
            letter-spacing: -0.01em;
            color: var(--on-surface);
        }

        .label-sm {
            font-family: var(--font-main);
            font-size: 11px;
            font-weight: 600;
            color: var(--on-surface-variant);
        }

        .data-value {
            font-family: var(--font-mono);
            font-size: 28px;
            font-weight: 700;
            color: var(--primary);
        }

        /* ===== CONTENT HEADER ===== */
        .content-header {
            margin-bottom: var(--space-4);
            padding-bottom: var(--space-3);
            border-bottom: 1px solid var(--outline-variant);
        }

        .greeting-text {
            font-size: 28px;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -0.03em;
        }

        .greeting-subtitle {
            font-size: 14px;
            color: var(--on-surface-variant);
            margin-top: 4px;
            font-weight: 500;
        }

        .section {
            margin-bottom: var(--space-4);
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--on-surface);
            margin-bottom: var(--space-3);
            letter-spacing: -0.02em;
        }

        /* ===== CARDS ===== */
        .card {
            background: var(--surface-bright);
            border-radius: var(--radius-lg);
            border: 1px solid var(--outline-variant);
            box-shadow: var(--shadow-level1);
            padding: var(--space-3);
            transition: all 0.2s ease;
        }

        .card:hover {
            box-shadow: var(--shadow-hover);
            border-color: var(--outline);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            margin-bottom: var(--space-2);
        }

        .card-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-md);
            background: var(--primary-fixed);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
        }

        .card-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--on-surface-variant);
        }

        .card-value {
            font-family: var(--font-mono);
            font-size: 32px;
            font-weight: 700;
            color: var(--primary);
            line-height: 1.2;
        }

        .card-trend {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-top: var(--space-2);
            font-size: 12px;
            font-weight: 600;
        }

        .trend-up { color: var(--success); }
        .trend-down { color: var(--error); }

        /* ===== BUTTONS ===== */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: var(--primary);
            color: var(--on-primary);
            border: none;
            border-radius: var(--radius-md);
            font-family: var(--font-main);
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
        }

        .btn-primary:hover {
            background: var(--primary-container);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.12);
        }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--outline-variant);
            border-radius: var(--radius-md);
            font-family: var(--font-main);
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-ghost:hover {
            background: var(--secondary-container);
            border-color: var(--primary);
        }

        .btn-danger {
            display: inline-flex;
            align-items: center;
            padding: 8px 14px;
            background: var(--error-container);
            color: var(--error);
            border: 1px solid transparent;
            border-radius: var(--radius-sm);
            font-family: var(--font-main);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-danger:hover {
            background: var(--error);
            color: var(--on-error);
        }

        .btn-warning {
            display: inline-flex;
            align-items: center;
            padding: 8px 14px;
            background: #fffbeb;
            color: #b45309;
            border: 1px solid transparent;
            border-radius: var(--radius-sm);
            font-family: var(--font-main);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-warning:hover {
            background: #f59e0b;
            color: #ffffff;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        .action-buttons {
            display: inline-flex;
            gap: 8px;
            justify-content: flex-end;
        }

        /* ===== ALERT ===== */
        .alert {
            border-radius: var(--radius-md);
            padding: var(--space-2) var(--space-3);
            margin-bottom: var(--space-3);
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-success {
            background: var(--success-container);
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: var(--error-container);
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* ===== DATA TABLE ===== */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-family: var(--font-main);
        }

        .table-header {
            padding: 16px 20px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            color: var(--on-surface-variant);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--outline-variant);
            background: #f8fafc;
        }

        .table-cell {
            padding: 16px 20px;
            border-bottom: 1px solid var(--outline-variant);
            color: var(--on-surface);
            font-size: 14px;
        }

        .data-table tbody tr:hover {
            background: #f8fafc;
        }

        .data-table tbody tr:last-child .table-cell {
            border-bottom: none;
        }

        .table-empty {
            padding: 40px;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            background-color: #0c0e12;
            color: #94a3b8;
            padding: 32px 24px;
            display: flex;
            flex-direction: column;
            height: 100vh;
            z-index: 10;
            border-right: 1px solid #1e293b;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 24px;
            margin-bottom: 24px;
            border-bottom: 1px solid #1e293b;
        }

        .sidebar-logo-img {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: #fcf6e8;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0f172a;
            font-weight: 800;
            font-family: var(--font-main);
            font-size: 16px;
            box-shadow: 0 4px 12px rgba(252, 246, 232, 0.15);
        }

        .sidebar-logo-text {
            font-family: var(--font-main);
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.02em;
        }

        .nav-list {
            list-style: none;
            flex: 1;
        }

        .nav-item {
            margin-bottom: var(--space-1);
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            color: #94a3b8;
            text-decoration: none;
            font-family: var(--font-main);
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.04);
            transform: translateX(4px);
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.06);
            color: #ffffff;
            font-weight: 600;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
        }

        .nav-login {
            margin-top: auto;
            padding-top: var(--space-3);
            border-top: 1px solid #1e293b;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            padding: 12px 16px;
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #94a3b8;
            border-radius: 12px;
            font-family: var(--font-main);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: left;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.04);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.2);
        }

        /* ===== UTILITIES ===== */
        .d-flex { display: flex; }
        .d-inline { display: inline; }
        .justify-content-between { justify-content: space-between; }
        .align-items-center { align-items: center; }
        .gap-2 { gap: 8px; }
        .gap-3 { gap: 12px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .mb-4 { margin-bottom: var(--space-4); }
        .mb-3 { margin-bottom: var(--space-3); }
        .mb-2 { margin-bottom: var(--space-2); }
        .mt-2 { margin-top: var(--space-2); }
        .mt-4 { margin-top: var(--space-4); }
        .px-3 { padding-left: var(--space-3); padding-right: var(--space-3); }
        .py-2 { padding-top: var(--space-2); padding-bottom: var(--space-2); }
        .overflow-x-auto { overflow-x: auto; }

        /* ===== FORM COMPONENTS ===== */
        .form-group {
            margin-bottom: var(--space-3);
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--on-surface-variant);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .form-label.required::after {
            content: " *";
            color: var(--error);
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 12px 16px;
            font-family: var(--font-main);
            font-size: 14px;
            color: var(--on-surface);
            background: #f8fafc;
            border: 1px solid var(--outline-variant);
            border-radius: var(--radius-md);
            outline: none;
            transition: all 0.2s ease;
        }

        .form-input::placeholder,
        .form-textarea::placeholder {
            color: var(--outline);
            opacity: 0.7;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            background: var(--surface-bright);
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.06);
        }

        .form-input.is-invalid,
        .form-select.is-invalid,
        .form-textarea.is-invalid {
            border-color: var(--error);
            background: #fef2f2;
        }

        .form-error {
            margin-top: 6px;
            font-size: 12px;
            color: var(--error);
            display: flex;
            align-items: center;
            gap: 4px;
            font-weight: 500;
        }

        .form-actions {
            display: flex;
            gap: var(--space-2);
            padding-top: var(--space-3);
            border-top: 1px solid var(--outline-variant);
            margin-top: var(--space-3);
        }

        /* ===== IOT GRID & CARDS (PREMIUM PASTEL GRAPHICS) ===== */
        .iot-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-bottom: var(--space-4);
        }

        .iot-card {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            padding: 28px;
            transition: all .25s ease;
            min-height: 220px;
            border: 1px solid transparent;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.01);
        }

        .iot-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.03);
        }

        .iot-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: var(--space-2);
        }

        .iot-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            font-size: 15px;
            letter-spacing: -0.01em;
        }

        .iot-status {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .status-online { color: #16a34a; }
        .status-offline { color: #64748b; }

        .status-online .status-dot {
            background: #22c55e;
            box-shadow: 0 0 8px #22c55e;
        }
        .status-offline .status-dot {
            background: #94a3b8;
        }

        /* CARD INDIVIDUAL COLOR SCHEMES */
        .card-temp {
            background-color: var(--temp-bg);
            border-color: var(--temp-border);
            color: var(--temp-text);
        }
        .card-temp .sensor-value { color: var(--temp-text); }
        .card-temp .iot-title { color: var(--temp-text); }
        
        .card-humidity {
            background-color: var(--humidity-bg);
            border-color: var(--humidity-border);
            color: var(--humidity-text);
        }
        .card-humidity .sensor-value { color: var(--humidity-text); }
        .card-humidity .iot-title { color: var(--humidity-text); }

        .card-servo {
            background-color: var(--servo-bg);
            border-color: var(--servo-border);
            color: var(--servo-text);
        }
        .card-servo .sensor-value { color: var(--servo-text); }
        .card-servo .iot-title { color: var(--servo-text); }

        /* LCD message is the dark accent card (matches dark card in reference UI) */
        .card-lcd {
            background-color: var(--lcd-bg);
            border-color: var(--lcd-border);
            color: var(--lcd-text);
            box-shadow: 0 8px 30px rgba(15, 17, 26, 0.1);
        }
        .card-lcd .iot-title { color: var(--lcd-text); }
        .card-lcd .lcd-input {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }
        .card-lcd .lcd-input:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #5ce9fe;
            box-shadow: 0 0 0 3px rgba(92, 233, 254, 0.2);
        }
        .card-lcd .btn-primary {
            background: #ffffff;
            color: #0f111a;
        }
        .card-lcd .btn-primary:hover {
            background: #f1f5f9;
        }

        .sensor-value {
            font-size: 44px;
            font-weight: 800;
            line-height: 1;
            font-family: var(--font-mono);
            letter-spacing: -0.04em;
            margin: var(--space-2) 0;
        }

        .sensor-unit {
            font-size: 16px;
            font-weight: 600;
            opacity: .7;
            margin-left: 2px;
        }

        .sensor-info {
            font-size: 12px;
            line-height: 1.5;
            opacity: 0.8;
            font-weight: 500;
        }

        .servo-angle-display {
            font-size: 32px;
            font-weight: 800;
            font-family: var(--font-mono);
        }

        .servo-slider {
            width: 100%;
            appearance: none;
            height: 6px;
            border-radius: 999px;
            background: rgba(21, 128, 61, 0.15);
            outline: none;
        }
        .servo-slider::-webkit-slider-thumb {
            appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #15803d;
            cursor: pointer;
            border: 2px solid #ffffff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        /* ===== DEVICE MONITOR BOX ===== */
        .device-monitor {
            background: var(--surface-bright);
            border-radius: 24px;
            border: 1px solid var(--outline-variant);
            overflow: hidden;
            box-shadow: var(--shadow-level1);
            margin-bottom: var(--space-4);
        }

        .device-monitor-header {
            padding: 24px 28px;
            border-bottom: 1px solid var(--outline-variant);
            background: #f8fafc;
        }

        .device-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-family: var(--font-main);
            font-weight: 700;
            text-transform: uppercase;
        }

        .device-status-online {
            background: var(--success-container);
            color: #166534;
        }

        .device-status-offline {
            background: #f1f5f9;
            color: #475569;
        }

        /* ===== LIVE PULSE EFFECT ===== */
        .live-pulse {
            position: relative;
        }

        .live-pulse::after {
            content: "";
            position: absolute;
            top: 50%;
            right: -6px;
            transform: translateY(-50%);
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #22c55e;
            animation: pulse-live 1.5s infinite;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .dashboard-layout {
                grid-template-columns: 1fr;
                height: auto;
                overflow: visible;
            }

            .sidebar {
                position: relative;
                min-height: auto;
                height: auto;
                overflow: visible;
                padding: 24px;
            }

            .main-content {
                height: auto;
                overflow: visible;
                padding: 16px;
            }

            .content-canvas {
                border-radius: 20px;
                padding: 24px;
            }

            .iot-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .iot-grid {
                grid-template-columns: 1fr;
            }
        }

        @keyframes pulse-live {
            0% {
                transform: translateY(-50%) scale(1);
                opacity: 1;
            }
            100% {
                transform: translateY(-50%) scale(2.5);
                opacity: 0;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="dashboard-layout">
        @include('components.sidebar')
        <main class="main-content">
            <div class="content-canvas">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                const matchPath = link.getAttribute('data-match');
                if (matchPath && currentPath.startsWith(matchPath)) {
                    link.classList.add('active');
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
