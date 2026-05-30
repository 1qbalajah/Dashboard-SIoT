<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Auth')</title>
    <style>
        /* 1. Reset & Base */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            line-height: 1.5;
        }

        /* 2. Layout Wrapper (pengganti class flex Tailwind) */
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        /* 3. Card Login (Minimalis Dashboard Style) */
        .auth-card {
            width: 100%;
            max-width: 400px;
            background: #ffffff;
            padding: 2rem;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            /* Shadow biru halus di pinggir */
            box-shadow: 
                0 4px 6px -1px rgba(59, 130, 246, 0.08),
                0 2px 4px -2px rgba(59, 130, 246, 0.05);
            transition: all 0.3s ease;
        }
        .auth-card:hover {
            box-shadow: 
                0 10px 15px -3px rgba(59, 130, 246, 0.12),
                0 4px 6px -4px rgba(59, 130, 246, 0.08);
        }

        /* 4. Typography */
        .auth-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            text-align: center;
            margin-bottom: 1.5rem;
            letter-spacing: -0.025em;
        }

        /* 5. Form Input */
        .form-group { margin-bottom: 1rem; }
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            color: #475569;
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 0.5rem;
            outline: none;
            transition: all 0.2s ease;
        }
        .form-input::placeholder { color: #94a3b8; }
        
        /* Focus: Shadow biru minimalis di pinggir border */
        .form-input:focus {
            border-color: #3b82f6;
            background-color: #ffffff;
            box-shadow: 
                0 0 0 3px rgba(59, 130, 246, 0.15),
                0 2px 4px rgba(59, 130, 246, 0.1);
        }
        /* Validasi client-side: border merah hanya muncul setelah user interact */
        .form-input:invalid:not(:placeholder-shown) {
            border-color: #ef4444;
        }

        /* 6. Button */
        .btn-primary {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #ffffff;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.25);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            box-shadow: 0 6px 8px -1px rgba(59, 130, 246, 0.35);
            transform: translateY(-1px);
        }
        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px -1px rgba(59, 130, 246, 0.25);
        }

        /* 7. Footer & Links */
        .auth-footer {
            margin-top: 1.25rem;
            text-align: center;
            font-size: 0.875rem;
            color: #64748b;
        }
        .auth-link {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .auth-link:hover { color: #1d4ed8; text-decoration: underline; }

        /* 8. Error Message */
        .error-message {
            margin-top: 0.4rem;
            font-size: 0.75rem;
            color: #ef4444;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }
        .error-dot {
            display: inline-block;
            width: 5px;
            height: 5px;
            background-color: #ef4444;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        @yield('content')
    </div>
</body>
</html>