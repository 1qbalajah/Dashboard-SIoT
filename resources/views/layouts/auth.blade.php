<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Auth')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: "Plus Jakarta Sans", system-ui, sans-serif;
            background: #e9f3fb;
            color: #151617;
            line-height: 1.5;
            min-height: 100vh;
        }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            background: #fffefe;
            padding: 32px;
            border-radius: 8px;
            border: 1px solid #dfe7ee;
            box-shadow: 0 22px 70px rgba(21, 22, 23, 0.08);
            transition: all 0.3s ease;
        }
        .auth-card:hover {
            box-shadow: 0 28px 80px rgba(21, 22, 23, 0.1);
        }

        .auth-title {
            font-size: 28px;
            font-weight: 800;
            color: #151617;
            text-align: center;
            margin-bottom: 24px;
            letter-spacing: 0;
        }

        .form-group { margin-bottom: 16px; }
        .form-input {
            width: 100%;
            padding: 13px 14px;
            font-size: 14px;
            color: #151617;
            background-color: #f7fbff;
            border: 1px solid #dfe7ee;
            border-radius: 8px;
            outline: none;
            transition: all 0.2s ease;
        }
        .form-input::placeholder { color: #68727f; }
        
        .form-input:focus {
            border-color: #151617;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(21, 22, 23, 0.06);
        }
        .form-input:invalid:not(:placeholder-shown) {
            border-color: #ef4444;
        }

        .btn-primary {
            width: 100%;
            padding: 13px 16px;
            font-size: 14px;
            font-weight: 700;
            color: #ffffff;
            background: #151617;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 12px 22px rgba(21, 22, 23, 0.12);
        }
        .btn-primary:hover {
            background: #272727;
            box-shadow: 0 16px 26px rgba(21, 22, 23, 0.16);
            transform: translateY(-1px);
        }
        .btn-primary:active {
            transform: translateY(0);
        }

        .auth-footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #68727f;
        }
        .auth-link {
            color: #151617;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.2s;
        }
        .auth-link:hover { color: #2458ff; }

        .error-message {
            margin-top: 6px;
            font-size: 12px;
            color: #ef4444;
            display: flex;
            align-items: center;
            gap: 6px;
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
