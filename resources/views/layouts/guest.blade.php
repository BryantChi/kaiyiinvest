<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>管理後台 · 楷懿國際投資</title>

    <link rel="icon" href="{{ asset('assets/img/logo/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&family=Noto+Sans+TC:wght@300;400;500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #0a0a0b;
            --panel: rgba(22, 22, 24, 0.72);
            --line: rgba(255, 255, 255, 0.08);
            --gold: #c9a86a;
            --gold-bright: #e4c98a;
            --text: #ececec;
            --muted: #8b8b90;
            --danger: #e0796f;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Noto Sans TC', system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding: 1.5rem;
            -webkit-font-smoothing: antialiased;
        }

        /* 背景：金色光暈 + 暗角 + 細格線 + 顆粒 */
        .bg-layer {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }
        .bg-glow {
            position: absolute;
            top: -20%;
            left: 50%;
            width: 900px;
            height: 900px;
            transform: translateX(-50%);
            background: radial-gradient(circle, rgba(201, 168, 106, 0.16) 0%, rgba(201, 168, 106, 0.04) 35%, transparent 70%);
            filter: blur(10px);
        }
        .bg-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(var(--line) 1px, transparent 1px),
                linear-gradient(90deg, var(--line) 1px, transparent 1px);
            background-size: 64px 64px;
            mask-image: radial-gradient(ellipse 70% 60% at 50% 35%, #000 30%, transparent 80%);
            -webkit-mask-image: radial-gradient(ellipse 70% 60% at 50% 35%, #000 30%, transparent 80%);
            opacity: 0.5;
        }
        .bg-vignette {
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 100% 100% at 50% 0%, transparent 40%, rgba(0,0,0,0.6) 100%);
        }
        .bg-grain {
            position: absolute;
            inset: 0;
            opacity: 0.035;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='3'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
        }

        .login-wrap {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 410px;
            animation: rise 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
        }
        @keyframes rise {
            from { opacity: 0; transform: translateY(18px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .brand {
            text-align: center;
            margin-bottom: 1.75rem;
            animation: fade 0.7s ease 0.1s both;
        }
        .brand-logo {
            width: 56px;
            height: 56px;
            object-fit: contain;
            margin-bottom: 0.9rem;
            filter: drop-shadow(0 4px 14px rgba(201,168,106,0.25));
        }
        .brand-mark {
            font-family: 'Cinzel', serif;
            font-size: 1.85rem;
            font-weight: 600;
            letter-spacing: 0.22em;
            color: var(--gold-bright);
            margin-left: 0.22em; /* 補償字距 */
        }
        .brand-sub {
            margin-top: 0.45rem;
            font-size: 0.8rem;
            letter-spacing: 0.32em;
            color: var(--muted);
        }

        .card {
            background: var(--panel);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 2rem 1.9rem 1.75rem;
            box-shadow: 0 30px 60px -20px rgba(0,0,0,0.7), inset 0 1px 0 rgba(255,255,255,0.04);
            position: relative;
            animation: fade 0.7s ease 0.2s both;
        }
        /* 卡片頂端金線 */
        .card::before {
            content: "";
            position: absolute;
            top: 0; left: 24px; right: 24px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            opacity: 0.7;
        }

        .card-title {
            font-size: 1.05rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }
        .card-desc {
            font-size: 0.82rem;
            color: var(--muted);
            margin-bottom: 1.6rem;
        }

        .alert {
            border-radius: 10px;
            padding: 0.7rem 0.9rem;
            font-size: 0.82rem;
            margin-bottom: 1.1rem;
            line-height: 1.6;
        }
        .alert-danger {
            background: rgba(224, 121, 111, 0.1);
            border: 1px solid rgba(224, 121, 111, 0.3);
            color: var(--danger);
        }
        .alert-success {
            background: rgba(120, 190, 140, 0.1);
            border: 1px solid rgba(120, 190, 140, 0.3);
            color: #8fcfa0;
        }
        .alert ul { margin: 0.25rem 0 0; padding-left: 1.1rem; }

        .field { margin-bottom: 1.1rem; }
        .field-label {
            display: block;
            font-size: 0.78rem;
            color: var(--muted);
            margin-bottom: 0.5rem;
            letter-spacing: 0.04em;
        }
        .input-shell {
            display: flex;
            align-items: center;
            background: rgba(0,0,0,0.35);
            border: 1px solid var(--line);
            border-radius: 10px;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .input-shell:focus-within {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201, 168, 106, 0.14);
            background: rgba(0,0,0,0.5);
        }
        .input-shell.has-error { border-color: rgba(224,121,111,0.6); }
        .input-shell svg {
            width: 18px; height: 18px;
            margin: 0 0.7rem;
            color: var(--muted);
            flex-shrink: 0;
        }
        .input-shell input {
            flex: 1;
            background: transparent;
            border: none;
            outline: none;
            color: var(--text);
            font-size: 0.92rem;
            font-family: inherit;
            padding: 0.78rem 0.9rem 0.78rem 0;
        }
        .input-shell input::placeholder { color: #5c5c61; }
        .field-error { color: var(--danger); font-size: 0.76rem; margin-top: 0.4rem; }

        .row-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        .check {
            display: flex;
            align-items: center;
            gap: 0.45rem;
            font-size: 0.82rem;
            color: var(--muted);
            cursor: pointer;
            user-select: none;
        }
        .check input {
            width: 15px; height: 15px;
            accent-color: var(--gold);
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            border: none;
            border-radius: 10px;
            padding: 0.85rem;
            font-family: inherit;
            font-size: 0.92rem;
            font-weight: 500;
            letter-spacing: 0.12em;
            color: #1a1408;
            background: linear-gradient(135deg, var(--gold-bright), var(--gold));
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.2s, filter 0.2s;
            box-shadow: 0 10px 24px -8px rgba(201, 168, 106, 0.5);
        }
        .btn-submit:hover { transform: translateY(-1px); filter: brightness(1.06); box-shadow: 0 14px 30px -8px rgba(201, 168, 106, 0.6); }
        .btn-submit:active { transform: translateY(0); }

        .foot {
            text-align: center;
            margin-top: 1.6rem;
            font-size: 0.72rem;
            letter-spacing: 0.1em;
            color: #5c5c61;
            animation: fade 0.7s ease 0.35s both;
        }

        @keyframes fade { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body>
    <div class="bg-layer">
        <div class="bg-grid"></div>
        <div class="bg-glow"></div>
        <div class="bg-vignette"></div>
        <div class="bg-grain"></div>
    </div>

    <div class="login-wrap">
        <div class="brand">
            <img src="{{ asset('assets/img/logo/logo.png') }}" alt="KAIYI" class="brand-logo">
            <div class="brand-mark">KAIYI</div>
            <div class="brand-sub">楷懿國際投資 · 管理後台</div>
        </div>

        @yield('content')

        <p class="foot">© {{ date('Y') }} 楷懿國際投資 Kaiyi International Investment</p>
    </div>
</body>
</html>
