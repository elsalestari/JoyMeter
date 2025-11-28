<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard JoyMeter</title>
    <style>
        :root {
            --yummy-yellow: #fede4a;
            --yummy-yellow-dark: #f4c128;
        }
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #ffffff;
            color: #5c4204;
            min-height: 100vh;
        }
        nav {
            background: #ffffff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 18px 36px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav span {
            font-size: 14px;
            display: block;
        }
        .logout-btn {
            background: linear-gradient(90deg, var(--yummy-yellow), var(--yummy-yellow-dark));
            border: none;
            color: #5c4204;
            padding: 10px 18px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
        }
        main {
            padding: 40px 36px;
            display: flex;
            justify-content: center;
        }
        .card {
            background: #ffffff;
            border-radius: 18px;
            padding: 28px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.08);
            max-width: 640px;
        }
        h1 {
            margin-top: 0;
            color: #92400e;
        }
    </style>
</head>
<body>
    <nav>
        <div>
            <strong>JoyMeter</strong>
            <span>Masuk sebagai {{ auth()->user()->role }}</span>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Keluar</button>
        </form>
    </nav>

    <main>
        <div class="card">
            <h1>Halo, {{ auth()->user()->name }}!</h1>
            <p>Anda berhasil masuk menggunakan akun {{ auth()->user()->role }}. Lanjutkan pekerjaan Anda di JoyMeter dengan aman.</p>
        </div>
    </main>
</body>
</html>

