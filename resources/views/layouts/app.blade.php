<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Azure Metrics Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        /* ===== AZURE METRICS DESIGN SYSTEM ===== */
        :root {
            /* Colors - Surface & Background */
            --surface: #f3faff;
            --surface-container: #dbf1fe;
            --surface-container-low: #e6f6ff;
            --surface-container-high: #d5ecf8;
            --surface-bright: #ffffff;
            --on-surface: #071e27;
            --on-surface-variant: #434652;

            /* Colors - Primary */
            --primary: #003178;
            --primary-container: #0d47a1;
            --on-primary: #ffffff;
            --on-primary-container: #a1bbff;
            --primary-fixed: #d9e2ff;
            --primary-fixed-dim: #b0c6ff;

            /* Colors - Secondary & Accent */
            --secondary: #006874;
            --secondary-container: #5ce9fe;
            --on-secondary: #ffffff;

            /* Colors - Status */
            --error: #ba1a1a;
            --error-container: #ffdad6;
            --on-error: #ffffff;
            --success: #2e7d32;
            --success-container: #c8e6c9;

            /* Borders & Outline */
            --outline: #737783;
            --outline-variant: #c3c6d4;

            /* Typography - Poppins + JetBrains Mono */
            --font-main: 'Poppins', system-ui, -apple-system, sans-serif;
            --font-mono: 'JetBrains Mono', monospace;

            /* Spacing - Base 8px scale */
            --space-1: 8px;
            --space-2: 16px;
            --space-3: 24px;
            --space-4: 32px;
            --space-5: 40px;

            /* Rounded */
            --radius-sm: 0.25rem;
            --radius-md: 0.5rem;
            --radius-lg: 1rem;
            --radius-xl: 1.5rem;

            /* Elevation Shadows */
            --shadow-level1: 0 4px 20px rgba(13, 71, 161, 0.04);
            --shadow-level2: 0 12px 32px rgba(13, 71, 161, 0.12);
            --shadow-hover: 0 8px 24px rgba(13, 71, 161, 0.08);
        }

        /* ===== RESET & BASE ===== */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            height: 100%;
            overflow: hidden;
            /* ✅ Mencegah scroll ganda di level root */
        }

        body {
            font-family: var(--font-main);
            background-color: var(--surface);
            color: var(--on-surface);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* ===== LAYOUT GRID - UPDATED FOR FIXED SIDEBAR ===== */
        .dashboard-layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            min-height: 100vh;
            height: 100vh;
            /* ✅ Kunci: Batasi tinggi layout ke viewport */
            overflow: hidden;
            /* ✅ Cegah scroll ganda pada body */
        }

        /* ===== MAIN CONTENT - SCROLLABLE INDEPENDENT ===== */
        .main-content {
            padding: var(--space-4);
            background-color: var(--surface);

            /* ✅ FIX: Content area bisa discroll sendiri */
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;

            /* ✅ Smooth scroll untuk content */
            scroll-behavior: smooth;
        }

        /* ✅ Custom scrollbar untuk main content */
        .main-content::-webkit-scrollbar {
            width: 8px;
        }

        .main-content::-webkit-scrollbar-track {
            background: var(--surface);
        }

        .main-content::-webkit-scrollbar-thumb {
            background: var(--outline-variant);
            border-radius: 4px;
        }

        .main-content::-webkit-scrollbar-thumb:hover {
            background: var(--outline);
        }

        /* ===== TYPOGRAPHY ===== */
        .headline-xl {
            font-family: var(--font-main);
            font-size: 40px;
            font-weight: 700;
            line-height: 48px;
            letter-spacing: -0.02em;
            color: var(--on-surface);
        }

        .headline-lg {
            font-family: var(--font-main);
            font-size: 32px;
            font-weight: 600;
            line-height: 40px;
            letter-spacing: -0.01em;
        }

        .headline-md {
            font-family: var(--font-main);
            font-size: 24px;
            font-weight: 600;
            line-height: 32px;
        }

        .headline-sm {
            font-family: var(--font-main);
            font-size: 20px;
            font-weight: 600;
            line-height: 28px;
        }

        .body-lg {
            font-family: var(--font-main);
            font-size: 18px;
            font-weight: 400;
            line-height: 28px;
        }

        .body-md {
            font-family: var(--font-main);
            font-size: 16px;
            font-weight: 400;
            line-height: 24px;
            color: var(--on-surface-variant);
        }

        .body-sm {
            font-family: var(--font-main);
            font-size: 14px;
            font-weight: 400;
            line-height: 20px;
        }

        .label-md {
            font-family: var(--font-mono);
            font-size: 14px;
            font-weight: 500;
            line-height: 16px;
            letter-spacing: 0.05em;
            color: var(--on-surface-variant);
            text-transform: uppercase;
        }

        .label-sm {
            font-family: var(--font-mono);
            font-size: 12px;
            font-weight: 500;
            line-height: 14px;
            letter-spacing: 0.05em;
            color: var(--on-surface-variant);
            text-transform: uppercase;
        }

        .data-value {
            font-family: var(--font-mono);
            font-size: 32px;
            font-weight: 600;
            color: var(--primary);
            letter-spacing: -0.02em;
        }

        /* ===== CONTENT HEADER ===== */
        .content-header {
            margin-bottom: var(--space-4);
            padding-bottom: var(--space-3);
            border-bottom: 1px solid var(--outline-variant);
        }

        .greeting-text {
            font-family: var(--font-main);
            font-size: 28px;
            font-weight: 600;
            color: var(--primary);
        }

        .greeting-subtitle {
            font-family: var(--font-main);
            color: var(--on-surface-variant);
            margin-top: 4px;
        }

        .section {
            margin-bottom: var(--space-4);
        }

        .section-title {
            font-family: var(--font-main);
            font-size: 20px;
            font-weight: 600;
            color: var(--on-surface);
            margin-bottom: var(--space-2);
        }

        /* ===== KPI CARDS ===== */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: var(--space-3);
            margin-bottom: var(--space-4);
        }

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
            border-color: var(--primary-fixed-dim);
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
            font-family: var(--font-main);
            font-size: 14px;
            font-weight: 500;
            color: var(--on-surface-variant);
        }

        .card-value {
            font-family: var(--font-mono);
            font-size: 36px;
            font-weight: 600;
            color: var(--primary);
            line-height: 1.2;
        }

        .card-trend {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-top: var(--space-2);
            font-family: var(--font-mono);
            font-size: 12px;
            font-weight: 500;
        }

        .trend-up {
            color: var(--success);
        }

        .trend-down {
            color: var(--error);
        }

        /* ===== BUTTONS ===== */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: var(--primary);
            color: var(--on-primary);
            border: none;
            border-radius: var(--radius-md);
            font-family: var(--font-main);
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-level1);
        }

        .btn-primary:hover {
            background: var(--primary-container);
            box-shadow: var(--shadow-hover);
            transform: translateY(-1px);
        }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--outline-variant);
            border-radius: var(--radius-md);
            font-family: var(--font-main);
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-ghost:hover {
            background: var(--primary-fixed);
            border-color: var(--primary);
        }

        .btn-danger {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            background: var(--error-container);
            color: var(--error);
            border: 1px solid var(--error);
            border-radius: var(--radius-sm);
            font-family: var(--font-main);
            font-size: 12px;
            font-weight: 500;
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
            padding: 6px 12px;
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #f59e0b;
            border-radius: var(--radius-sm);
            font-family: var(--font-main);
            font-size: 12px;
            font-weight: 500;
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
            font-family: var(--font-main);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-success {
            background: var(--success-container);
            color: var(--success);
            border: 1px solid var(--success);
        }

        .alert-error {
            background: var(--error-container);
            color: var(--error);
            border: 1px solid var(--error);
        }

        /* ===== DATA TABLE ===== */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-family: var(--font-main);
        }

        .table-header {
            padding: 12px var(--space-3);
            text-align: left;
            font-family: var(--font-mono);
            font-size: 12px;
            font-weight: 500;
            color: var(--on-surface-variant);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--outline-variant);
            background: var(--surface-container-low);
        }

        .table-cell {
            padding: 14px var(--space-3);
            border-bottom: 1px solid var(--outline-variant);
            color: var(--on-surface);
        }

        .data-table tbody tr:hover {
            background: var(--surface-container-low);
        }

        .data-table tbody tr:last-child .table-cell {
            border-bottom: none;
        }

        .table-empty {
            padding: 0;
        }

        /* ===== SIDEBAR - FIXED POSITION ===== */
        .sidebar {
            background: linear-gradient(180deg, var(--primary-container) 0%, var(--primary) 100%);
            color: var(--on-primary);
            padding: var(--space-4) var(--space-3);
            display: flex;
            flex-direction: column;

            /* ✅ FIX: Sidebar tetap di posisi, scroll independen jika konten panjang */
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;

            /* ✅ Smooth scroll untuk sidebar */
            scroll-behavior: smooth;

            /* ✅ Pastikan sidebar di layer atas */
            z-index: 10;
        }

        /* ✅ Custom scrollbar untuk sidebar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            padding-bottom: var(--space-4);
            margin-bottom: var(--space-4);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-logo-img {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-md);
            background: var(--surface-bright);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-weight: 700;
            font-family: var(--font-main);
        }

        .sidebar-logo-text {
            font-family: var(--font-main);
            font-size: 18px;
            font-weight: 700;
            color: var(--on-primary);
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
            gap: var(--space-2);
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius-md);
            color: var(--on-primary);
            text-decoration: none;
            font-family: var(--font-main);
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            opacity: 0.9;
            border-left: 3px solid transparent;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            opacity: 1;
            transform: translateX(4px);
        }

        .nav-link.active {
            border-left: 3px solid var(--secondary-container);
            padding-left: calc(var(--space-3) - 3px);
            font-weight: 600;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            opacity: 0.9;
        }

        .nav-login {
            margin-top: auto;
            padding-top: var(--space-3);
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .login-btn {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            width: 100%;
            padding: var(--space-2) var(--space-3);
            background: var(--surface-bright);
            color: var(--primary);
            border-radius: var(--radius-md);
            text-decoration: none;
            font-family: var(--font-main);
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .login-btn:hover {
            background: var(--secondary-container);
            color: var(--on-secondary);
            transform: translateY(-2px);
            box-shadow: var(--shadow-level1);
        }

        .logout-form {
            margin-top: var(--space-2);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            width: 100%;
            padding: var(--space-2) var(--space-3);
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: var(--on-primary);
            border-radius: var(--radius-md);
            font-family: var(--font-main);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: left;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
        }

        /* ===== UTILITIES ===== */
        .d-flex {
            display: flex;
        }

        .d-inline {
            display: inline;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .align-items-center {
            align-items: center;
        }

        .gap-2 {
            gap: 8px;
        }

        .gap-3 {
            gap: 12px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .mb-4 {
            margin-bottom: var(--space-4);
        }

        .mb-3 {
            margin-bottom: var(--space-3);
        }

        .mb-2 {
            margin-bottom: var(--space-2);
        }

        .mt-2 {
            margin-top: var(--space-2);
        }

        .mt-4 {
            margin-top: var(--space-4);
        }

        .px-3 {
            padding-left: var(--space-3);
            padding-right: var(--space-3);
        }

        .py-2 {
            padding-top: var(--space-2);
            padding-bottom: var(--space-2);
        }

        .overflow-x-auto {
            overflow-x: auto;
        }

        /* ===== FORM COMPONENTS ===== */
        .form-group {
            margin-bottom: var(--space-3);
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .form-label {
            display: block;
            font-family: var(--font-mono);
            font-size: 12px;
            font-weight: 500;
            line-height: 16px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--on-surface-variant);
            margin-bottom: var(--space-1);
        }

        .form-label.required::after {
            content: " *";
            color: var(--error);
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 10px 14px;
            font-family: var(--font-main);
            font-size: 16px;
            line-height: 24px;
            color: var(--on-surface);
            background: var(--surface-container-low);
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
            border-color: var(--secondary-container);
            box-shadow: 0 0 0 3px rgba(92, 233, 254, 0.2);
        }

        .form-input.is-invalid,
        .form-select.is-invalid,
        .form-textarea.is-invalid {
            border-color: var(--error);
            background: var(--error-container);
        }

        .form-input.is-invalid:focus,
        .form-select.is-invalid:focus,
        .form-textarea.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(186, 26, 26, 0.15);
        }

        .form-error {
            margin-top: 6px;
            font-family: var(--font-main);
            font-size: 12px;
            line-height: 16px;
            color: var(--error);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .form-error::before {
            content: "•";
            font-size: 18px;
            line-height: 1;
            font-weight: 600;
        }

        .form-text {
            margin-top: 6px;
            font-family: var(--font-main);
            font-size: 12px;
            line-height: 16px;
            color: var(--on-surface-variant);
        }

        .form-textarea {
            min-height: 100px;
            resize: vertical;
            line-height: 1.5;
        }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23737783' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px;
            padding-right: 36px;
            cursor: pointer;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            margin-bottom: var(--space-2);
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            border: 1px solid var(--outline-variant);
            border-radius: var(--radius-sm);
            background: var(--surface-container-low);
            cursor: pointer;
            accent-color: var(--primary);
        }

        .form-check-label {
            font-family: var(--font-main);
            font-size: 14px;
            color: var(--on-surface);
            cursor: pointer;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--space-3);
        }

        .form-actions {
            display: flex;
            gap: var(--space-2);
            padding-top: var(--space-3);
            border-top: 1px solid var(--outline-variant);
            margin-top: var(--space-3);
        }

        .form-input:read-only,
        .form-input:disabled,
        .form-select:disabled,
        .form-textarea:disabled {
            background: var(--surface-container);
            color: var(--on-surface-variant);
            cursor: not-allowed;
            opacity: 0.7;
        }

        .form-input:read-only:focus,
        .form-input:disabled:focus {
            box-shadow: none;
            border-color: var(--outline-variant);
        }

        /* ===== IOT CONTROL PANEL ===== */

        .iot-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: var(--space-3);
            margin-bottom: var(--space-4);
        }

        .iot-card {
            position: relative;
            overflow: hidden;
            background: linear-gradient(180deg,
                    rgba(255, 255, 255, 0.95) 0%,
                    rgba(230, 246, 255, 0.95) 100%);
            border: 1px solid var(--outline-variant);
            border-radius: var(--radius-xl);
            padding: var(--space-3);
            box-shadow: var(--shadow-level1);
            transition: all .25s ease;
            min-height: 220px;
        }

        .iot-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-level2);
            border-color: var(--primary-fixed-dim);
        }

        .iot-card::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at top right,
                    rgba(92, 233, 254, .18),
                    transparent 40%);
            pointer-events: none;
        }

        .iot-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: var(--space-3);
        }

        .iot-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            color: var(--on-surface);
            font-size: 16px;
        }

        .iot-status {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-family: var(--font-mono);
            text-transform: uppercase;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
        }

        .status-online .status-dot {
            background: #22c55e;
            box-shadow: 0 0 10px #22c55e;
        }

        .status-offline .status-dot {
            background: #94a3b8;
        }

        .status-online {
            color: #22c55e;
        }

        .status-offline {
            color: #94a3b8;
        }

        /* ===== SENSOR VALUE ===== */

        .sensor-value {
            font-size: 48px;
            font-weight: 700;
            line-height: 1;
            color: var(--primary);
            font-family: var(--font-mono);
            margin-bottom: 10px;
        }

        .sensor-unit {
            font-size: 16px;
            opacity: .7;
        }

        .sensor-info {
            font-size: 14px;
            color: var(--on-surface-variant);
            line-height: 1.6;
        }

        .servo-value {
            font-size: 42px;
            font-family: var(--font-mono);
            font-weight: 700;
            color: var(--primary);
            margin-bottom: var(--space-2);
        }

        .servo-slider {
            width: 100%;
            appearance: none;
            height: 10px;
            border-radius: 999px;
            background: linear-gradient(90deg,
                    var(--primary-fixed-dim),
                    var(--secondary-container));
            outline: none;
        }

        .servo-slider::-webkit-slider-thumb {
            appearance: none;
            width: 22px;
            height: 22px;
            border-radius: 999px;
            background: var(--primary);
            cursor: pointer;
            border: 3px solid white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, .2);
        }

        .servo-labels {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 12px;
            font-family: var(--font-mono);
            color: var(--on-surface-variant);
        }

        /* ===== LCD FORM ===== */

        .lcd-form {
            display: flex;
            flex-direction: column;
            gap: var(--space-2);
            margin-top: var(--space-2);
        }

        .lcd-input {
            width: 100%;
            border: 1px solid var(--outline-variant);
            border-radius: var(--radius-md);
            background: var(--surface-bright);
            padding: 12px;
            font-family: var(--font-mono);
            outline: none;
            transition: .2s ease;
        }

        .lcd-input:focus {
            border-color: var(--secondary-container);
            box-shadow: 0 0 0 3px rgba(92, 233, 254, .2);
        }

        .lcd-preview {
            background: #071e27;
            color: #5ce9fe;
            font-family: var(--font-mono);
            padding: 14px;
            border-radius: var(--radius-md);
            font-size: 14px;
            min-height: 60px;
            display: flex;
            align-items: center;
            border: 1px solid rgba(92, 233, 254, .25);
            box-shadow:
                inset 0 0 10px rgba(92, 233, 254, .12),
                0 0 12px rgba(92, 233, 254, .08);
        }

        /* ===== DEVICE TABLE WRAPPER ===== */

        .device-monitor {
            background: var(--surface-bright);
            border-radius: var(--radius-xl);
            border: 1px solid var(--outline-variant);
            overflow: hidden;
            box-shadow: var(--shadow-level1);
            margin-bottom: var(--space-4);
        }

        .device-monitor-header {
            padding: var(--space-3);
            border-bottom: 1px solid var(--outline-variant);
            background: linear-gradient(90deg,
                    var(--surface-container-low),
                    transparent);
        }

        .device-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-family: var(--font-mono);
            font-weight: 600;
        }

        .device-status-online {
            background: rgba(34, 197, 94, .12);
            color: #16a34a;
        }

        .device-status-offline {
            background: rgba(148, 163, 184, .15);
            color: #64748b;
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
            border-radius: 999px;
            background: #22c55e;
            animation: pulse-live 1.5s infinite;
        }

        /* ===== RESPONSIVE - UPDATED ===== */
        @media (max-width: 1024px) {
            .dashboard-layout {
                grid-template-columns: 1fr;
                height: auto;
                /* ✅ Reset height untuk mobile */
                overflow: visible;
            }

            .sidebar {
                position: relative;
                min-height: auto;
                height: auto;
                overflow: visible;
            }

            .main-content {
                height: auto;
                overflow: visible;
            }

            .sidebar::-webkit-scrollbar,
            .main-content::-webkit-scrollbar {
                display: none;
            }

            .iot-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .content-header>.d-flex {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 12px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .kpi-grid {
                grid-template-columns: 1fr;
            }

            .iot-grid {
                grid-template-columns: 1fr;
            }

            .sensor-value,
            .servo-value {
                font-size: 36px;
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
            @yield('content')
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
