<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login JoyMeter</title>
    <style>
        :root {
            --yummy-yellow: #fede4a;
            --yummy-yellow-dark: #f4c128;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
        }
        .card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border-radius: 18px;
            padding: 32px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        }
        h1 {
            text-align: center;
            color: #5c4204;
            margin-bottom: 24px;
        }
        label {
            display: block;
            font-size: 14px;
            color: #92400e;
            margin-bottom: 6px;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            border: 1px solid var(--yummy-yellow);
            border-radius: 10px;
            padding: 12px;
            font-size: 14px;
            background: #fff;
        }
        input:focus {
            outline: 2px solid var(--yummy-yellow-dark);
            border-color: transparent;
        }
        .remember {
            display: flex;
            align-items: center;
            font-size: 13px;
            color: #7c5c0f;
            margin-bottom: 16px;
        }
        .remember span {
            margin-left: 8px;
        }
        button {
            width: 100%;
            border: none;
            border-radius: 12px;
            padding: 12px;
            background: linear-gradient(90deg, var(--yummy-yellow), var(--yummy-yellow-dark));
            color: #5c4204;
            font-weight: bold;
            font-size: 15px;
            cursor: pointer;
        }
        button:hover {
            opacity: 0.95;
        }
        .hint {
            text-align: center;
            margin-top: 18px;
            font-size: 12px;
            color: #8c6b15;
        }
        .errors {
            background: #fff8d6;
            border: 1px solid var(--yummy-yellow);
            color: #7c5c0f;
            padding: 10px 14px;
            border-radius: 10px;
            margin-bottom: 16px;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Masuk JoyMeter</h1>

        @if ($errors->any())
            <div class="errors">
                <ul style="margin:0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}">
            @csrf
            <div style="margin-bottom:16px;">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div style="margin-bottom:16px;">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
            </div>

            <label class="remember">
                <input type="checkbox" name="remember">
                <span>Ingat saya</span>
            </label>

            <button type="submit">Masuk</button>
        </form>

        <p class="hint">Gunakan akun staff/admin dari seeder. Hubungi admin jika lupa.</p>
    </div>
</body>
</html>

