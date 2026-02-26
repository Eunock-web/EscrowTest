<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PixelVault — Créer un compte</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap"
        rel="stylesheet" />
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            background: #09090f;
            color: #e2e8f0;
            font-family: 'DM Sans', sans-serif;
            cursor: none;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3 {
            font-family: 'Syne', sans-serif;
        }

        /* Cursor */
        #cur {
            width: 10px;
            height: 10px;
            background: #7c3aed;
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            transform: translate(-50%, -50%);
            transition: .15s width, .15s height;
            mix-blend-mode: screen;
        }

        #ring {
            width: 32px;
            height: 32px;
            border: 1px solid rgba(124, 58, 237, .4);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 9998;
            transform: translate(-50%, -50%);
        }

        /* Grad text */
        .g {
            background: linear-gradient(135deg, #a78bfa, #22d3ee);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .g2 {
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Noise overlay */
        body::after {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='4'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 998;
            opacity: .5;
        }

        /* Grid background */
        .grid-bg {
            background-image: linear-gradient(rgba(124, 58, 237, .04) 1px, transparent 1px), linear-gradient(90deg, rgba(124, 58, 237, .04) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0
            }

            100% {
                background-position: 200% 0
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(18px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes stepSlide {
            from {
                opacity: 0;
                transform: translateX(28px)
            }

            to {
                opacity: 1;
                transform: translateX(0)
            }
        }

        @keyframes spin {
            to {
                transform: rotate(360deg)
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: .6
            }

            50% {
                transform: scale(1.04);
                opacity: 1
            }
        }

        @keyframes tagPop {
            from {
                transform: scale(0);
                opacity: 0
            }

            60% {
                transform: scale(1.1)
            }

            to {
                transform: scale(1);
                opacity: 1
            }
        }

        @keyframes scalePop {
            0% {
                transform: scale(0) rotate(-6deg);
                opacity: 0
            }

            60% {
                transform: scale(1.1)
            }

            100% {
                transform: scale(1);
                opacity: 1
            }
        }

        @keyframes checkDraw {
            0% {
                stroke-dashoffset: 60;
                opacity: 0
            }

            40% {
                opacity: 1
            }

            100% {
                stroke-dashoffset: 0
            }
        }

        @keyframes confetti {
            0% {
                transform: translateY(0) rotate(0);
                opacity: 1
            }

            100% {
                transform: translateY(-100px) rotate(720deg);
                opacity: 0
            }
        }

        @keyframes strengthGrow {
            from {
                width: 0
            }

            to {
                width: 100%
            }
        }

        /* Nav */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            background: rgba(9, 9, 15, .8);
            border-bottom: 1px solid rgba(255, 255, 255, .05);
        }

        /* Step indicator */
        .step-track {
            display: flex;
            align-items: center;
            gap: 0;
        }

        .step-dot {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 1.5px solid #1e1e2e;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 12px;
            color: #64748b;
            transition: all .4s cubic-bezier(.4, 0, .2, 1);
            flex-shrink: 0;
        }

        .step-dot.active {
            background: #7c3aed;
            border-color: #7c3aed;
            color: #fff;
            box-shadow: 0 0 0 4px rgba(124, 58, 237, .18);
        }

        .step-dot.done {
            background: rgba(16, 185, 129, .12);
            border-color: rgba(16, 185, 129, .4);
            color: #34d399;
        }

        .step-line {
            flex: 1;
            height: 1px;
            background: #1e1e2e;
            transition: background .5s;
        }

        .step-line.done {
            background: rgba(124, 58, 237, .4);
        }

        .step-label {
            font-size: 11px;
            color: #64748b;
            margin-top: 4px;
            text-align: center;
            transition: color .3s;
        }

        .step-label.active {
            color: #e2e8f0;
        }

        .step-label.done {
            color: #34d399;
        }

        /* Card */
        .card {
            background: rgba(17, 17, 24, .9);
            border: 1px solid #1e1e2e;
            border-radius: 24px;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 50% 0%, rgba(124, 58, 237, .07), transparent 60%);
            pointer-events: none;
        }

        /* Input */
        .iw {
            position: relative;
            background: rgba(255, 255, 255, .03);
            border: 1.5px solid #1e1e2e;
            border-radius: 13px;
            transition: border-color .2s, box-shadow .2s;
        }

        .iw:focus-within {
            border-color: rgba(124, 58, 237, .6);
            box-shadow: 0 0 0 3px rgba(124, 58, 237, .08);
        }

        .iw.v {
            border-color: rgba(16, 185, 129, .4);
        }

        .iw.e {
            border-color: rgba(239, 68, 68, .45);
        }

        .ii {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #2e2e48;
            pointer-events: none;
            transition: color .2s;
        }

        .iw:focus-within .ii {
            color: #a78bfa;
        }

        input.fi,
        textarea.fi {
            background: transparent;
            border: none;
            outline: none;
            color: #e2e8f0;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            width: 100%;
            padding: 14px 14px 14px 44px;
        }

        input.fi::placeholder,
        textarea.fi::placeholder {
            color: #2a2a3e;
        }

        .eyebtn {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #3f3f5a;
            cursor: pointer;
            transition: color .2s;
            background: none;
            border: none;
        }

        .eyebtn:hover {
            color: #a78bfa;
        }

        /* Buttons */
        .btn {
            background: linear-gradient(135deg, #7c3aed, #5b21b6);
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            color: #fff;
        }

        .btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(100deg, transparent 40%, rgba(255, 255, 255, .17) 50%, transparent 60%);
            background-size: 200% 100%;
            animation: shimmer 2.5s infinite;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 26px rgba(124, 58, 237, .5);
        }

        .btn:disabled {
            opacity: .35;
            pointer-events: none;
        }

        .btn-outline {
            background: transparent;
            border: 1.5px solid rgba(124, 58, 237, .3);
            cursor: pointer;
            transition: all .2s;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            color: #94a3b8;
        }

        .btn-outline:hover {
            border-color: rgba(124, 58, 237, .6);
            background: rgba(124, 58, 237, .08);
            color: #e2e8f0;
        }

        /* Social buttons */
        .btn-soc {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            background: rgba(255, 255, 255, .04);
            border: 1.5px solid #1e1e2e;
            border-radius: 13px;
            padding: 12px;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 500;
            color: #e2e8f0;
            transition: all .2s;
        }

        .btn-soc:hover {
            border-color: rgba(124, 58, 237, .4);
            background: rgba(124, 58, 237, .07);
            transform: translateY(-1px);
        }

        /* Divider */
        .or {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #2a2a3e;
            font-size: 11px;
        }

        .or::before,
        .or::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #1e1e2e;
        }

        /* Checkbox */
        .chk {
            width: 17px;
            height: 17px;
            border-radius: 5px;
            border: 1.5px solid #2a2a3e;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .2s;
            flex-shrink: 0;
        }

        .chk.on {
            background: #7c3aed;
            border-color: #7c3aed;
        }

        /* Strength bars */
        .sbar {
            height: 3px;
            border-radius: 2px;
            background: rgba(255, 255, 255, .07);
            flex: 1;
            overflow: hidden;
            position: relative;
        }

        .sbar-fill {
            height: 100%;
            border-radius: 2px;
            width: 0;
            transition: width .4s, background .4s;
        }

        /* Tag */
        .tag {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(124, 58, 237, .14);
            border: 1px solid rgba(124, 58, 237, .3);
            border-radius: 7px;
            padding: 3px 10px;
            color: #a78bfa;
            font-size: 12px;
            font-weight: 500;
            animation: tagPop .2s ease both;
        }

        .tag-x {
            color: #7c3aed;
            cursor: pointer;
            font-size: 13px;
            line-height: 1;
            transition: color .15s;
        }

        .tag-x:hover {
            color: #f87171;
        }

        /* Avatar options */
        .av {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            cursor: pointer;
            transition: all .25s;
            border: 2.5px solid transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 17px;
            color: #fff;
            position: relative;
        }

        .av.sel {
            border-color: #7c3aed;
            box-shadow: 0 0 0 4px rgba(124, 58, 237, .2);
        }

        .av.sel::after {
            content: '✓';
            position: absolute;
            bottom: -3px;
            right: -3px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #7c3aed;
            border: 2px solid #09090f;
            font-size: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Plan cards */
        .plan {
            border: 1.5px solid #1e1e2e;
            border-radius: 16px;
            padding: 16px;
            cursor: pointer;
            transition: all .2s;
            position: relative;
            overflow: hidden;
        }

        .plan:hover {
            border-color: rgba(124, 58, 237, .35);
            background: rgba(124, 58, 237, .04);
        }

        .plan.sel {
            border-color: #7c3aed;
            background: rgba(124, 58, 237, .09);
            box-shadow: 0 0 0 3px rgba(124, 58, 237, .1);
        }

        .plan-radio {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 1.5px solid #3f3f5a;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
            flex-shrink: 0;
        }

        .plan.sel .plan-radio {
            border-color: #7c3aed;
            background: #7c3aed;
        }

        .plan.sel .plan-radio::after {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #fff;
        }

        /* Spec pill */
        .spec {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            padding: 7px 14px;
            border-radius: 100px;
            border: 1.5px solid #1e1e2e;
            color: #64748b;
            cursor: pointer;
            transition: all .2s;
        }

        .spec:hover {
            border-color: rgba(124, 58, 237, .4);
            color: #a78bfa;
        }

        .spec.on {
            border-color: rgba(124, 58, 237, .5);
            background: rgba(124, 58, 237, .1);
            color: #a78bfa;
        }

        /* Success */
        .suc-ring {
            width: 84px;
            height: 84px;
            border-radius: 50%;
            background: rgba(16, 185, 129, .1);
            border: 2px solid rgba(16, 185, 129, .35);
            display: flex;
            align-items: center;
            justify-content: center;
            animation: scalePop .6s cubic-bezier(.34, 1.56, .64, 1) both;
        }

        .chk-svg {
            animation: checkDraw .6s .25s ease both;
            stroke-dasharray: 60;
            stroke-dashoffset: 60;
        }

        .confetti-p {
            position: absolute;
            animation: confetti 1.2s ease forwards;
        }

        .spinner {
            width: 17px;
            height: 17px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, .2);
            border-top-color: #fff;
            animation: spin .6s linear infinite;
        }

        ::-webkit-scrollbar {
            width: 4px
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(124, 58, 237, .3);
            border-radius: 2px
        }
    </style>
</head>

<body class="grid-bg">
    <div id="cur"></div>
    <div id="ring"></div>

    <!-- Fixed background orbs -->
    <div style="position:fixed;inset:0;pointer-events:none;overflow:hidden;z-index:0;">
        <div class="orb" style="width:500px;height:300px;background:rgba(124,58,237,.1);top:-120px;right:-140px;">
        </div>
        <div class="orb" style="width:350px;height:350px;background:rgba(6,182,212,.07);bottom:-100px;left:-80px;">
        </div>
    </div>

    <!-- Nav -->
    <nav>
        <div
            style="max-width:900px;margin:0 auto;padding:0 24px;height:60px;display:flex;align-items:center;justify-content:space-between;">
            <a href="index.html" style="display:flex;align-items:center;gap:9px;text-decoration:none;">
                <div
                    style="width:32px;height:32px;border-radius:9px;background:linear-gradient(135deg,#7c3aed,#06b6d4);display:flex;align-items:center;justify-content:center;">
                    <svg width="16" height="16" fill="#fff" viewBox="0 0 20 20">
                        <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                    </svg>
                </div>
                <span style="font-family:'Syne',sans-serif;font-weight:800;font-size:17px;color:#fff;">Pixel<span
                        class="g">Vault</span></span>
            </a>

            <!-- Step indicator (desktop) -->
            <div id="stepNav" class="step-track" style="width:340px;">
                <div style="display:flex;flex-direction:column;align-items:center;">
                    <div class="step-dot active" id="sd1">1</div>
                    <div class="step-label active" id="sl1">Compte</div>
                </div>
                <div class="step-line" id="sline1" style="margin-bottom:16px;"></div>
                <div style="display:flex;flex-direction:column;align-items:center;">
                    <div class="step-dot" id="sd2">2</div>
                    <div class="step-label" id="sl2">Profil</div>
                </div>
                <div class="step-line" id="sline2" style="margin-bottom:16px;"></div>
                <div style="display:flex;flex-direction:column;align-items:center;">
                    <div class="step-dot" id="sd3">3</div>
                    <div class="step-label" id="sl3">Plan</div>
                </div>
            </div>

            <a href="login" style="font-size:13px;color:#64748b;text-decoration:none;">Déjà un compte →</a>
        </div>
    </nav>

    <!-- Main -->
    <div
        style="position:relative;z-index:1;min-height:100vh;display:flex;flex-direction:column;align-items:center;padding:84px 16px 40px;">

        <!-- ══════ STEP 1 — Compte ══════ -->
        <div id="step1" style="width:100%;max-width:480px;animation:fadeUp .5s ease both;">
            <div style="text-align:center;margin-bottom:28px;">
                <h1 style="font-size:2.2rem;font-weight:800;color:#fff;margin-bottom:6px;">Créer votre compte <span
                        class="g">gratuit</span></h1>
                <p style="color:#64748b;font-size:14px;">Rejoignez 12 000+ créatifs sur PixelVault</p>
            </div>

            <div class="card" style="padding:32px;">
                <!-- Social -->
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:6px;">
                    <button class="btn-soc"
                        onclick="this.style.opacity='.5';this.style.pointerEvents='none';setTimeout(()=>location.href='#',1600)">
                        <svg width="17" height="17" viewBox="0 0 24 24">
                            <path fill="#4285f4"
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="#34a853"
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="#fbbc05"
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                            <path fill="#ea4335"
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                        Google
                    </button>
                    <button class="btn-soc"
                        onclick="this.style.opacity='.5';this.style.pointerEvents='none';setTimeout(()=>location.href='#',1600)">
                        <svg width="17" height="17" fill="#e2e8f0" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
                        </svg>
                        GitHub
                    </button>
                </div>
                <div class="or" style="margin:18px 0;">ou avec votre email</div>

                @if (session('success'))
                    <div style="background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.3);border-radius:12px;padding:12px;margin-bottom:18px;color:#34d399;font-size:13px;display:flex;align-items:center;gap:10px;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);border-radius:12px;padding:12px;margin-bottom:18px;color:#f87171;font-size:13px;display:flex;align-items:center;gap:10px;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ session('error') }}
                    </div>
                @endif


                <div style="display:flex;flex-direction:column;gap:12px;">
                    <form action="{{ url('auth/register') }}" method="post" id="regForm" class="flex flex-col gap-8">
                        @csrf
                        <input type="hidden" name="avatar" id="hidden_avatar" value="{{ old('avatar', 'av1') }}">
                        <input type="hidden" name="specialite" id="hidden_specialite" value="{{ old('specialite', '') }}">
                        <input type="hidden" name="plan" id="hidden_plan" value="{{ old('plan', 'gratuit') }}">
                        <!-- Names -->
                                <input class="fi @error('firstname') border-red-500 @enderror" type="text" id="fn" name="firstname"
                                    placeholder="Prénom" oninput="vField(this,'wFn',2);chk1()"
                                    autocomplete="given-name" value="{{ old('firstname') }}" />
                            </div>
                            @error('firstname') <span style="color:#f87171;font-size:10px;margin-top:2px;">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <div class="iw @error('lastname') e @enderror" id="wLn">
                                <div class="ii"><svg width="15" height="15" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg></div>
                                <input class="fi" type="text" id="ln" name="lastname"
                                    placeholder="Nom" oninput="vField(this,'wLn',2);chk1()"
                                    autocomplete="family-name" value="{{ old('lastname') }}" />
                            </div>
                            @error('lastname') <span style="color:#f87171;font-size:10px;margin-top:2px;">{{ $message }}</span> @enderror
                        </div>
                    </div>

                        <div>
                            <div class="iw @error('email') e @enderror" id="wEm">
                                <div class="ii"><svg width="15" height="15" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg></div>
                                <input class="fi" type="email" id="em" placeholder="vous@email.com"
                                    oninput="vEmail();chk1()" autocomplete="email" name="email" value="{{ old('email') }}" />
                            </div>
                            @error('email') <span style="color:#f87171;font-size:10px;margin-top:2px;">{{ $message }}</span> @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <div class="iw @error('password') e @enderror" id="wPw">
                                <div class="ii"><svg width="15" height="15" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg></div>
                                <input class="fi" type="password" id="pw" placeholder="Mot de passe"
                                    style="padding-right:46px;" oninput="checkStr();chk1()"
                                    autocomplete="new-password" name="password" />
                                <button class="eyebtn" onclick="togglePw('pw')" type="button"><svg width="15"
                                        height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg></button>
                            </div>
                            @error('password') <span style="color:#f87171;font-size:10px;margin-top:2px;">{{ $message }}</span> @enderror
                        </div>

                            <!-- Strength -->
                            <div style="display:flex;gap:4px;margin:8px 0 3px;">
                                <div class="sbar">
                                    <div class="sbar-fill" id="sb1"></div>
                                </div>
                                <div class="sbar">
                                    <div class="sbar-fill" id="sb2"></div>
                                </div>
                                <div class="sbar">
                                    <div class="sbar-fill" id="sb3"></div>
                                </div>
                                <div class="sbar">
                                    <div class="sbar-fill" id="sb4"></div>
                                </div>
                            </div>
                            <div style="font-size:11px;color:#64748b;" id="strLabel">Min. 8 caractères, 1 majuscule,
                                1 chiffre</div>
                        </div>
                        <!-- Confirm -->
                        <div class="iw" id="wCo">
                            <div class="ii"><svg width="15" height="15" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg></div>
                            <input class="fi" type="password" id="co"
                                placeholder="Confirmer le mot de passe" style="padding-right:46px;"
                                oninput="checkConfirm();chk1()" autocomplete="new-password"
                                name="password_confirmation" />
                            <button class="eyebtn" onclick="togglePw('co')" type="button"><svg width="15"
                                    height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg></button>
                        </div>
                        <div id="errConf" style="font-size:11px;color:#f87171;display:none;padding-left:2px;">Les
                            mots de passe ne correspondent pas.</div>

                        <!-- CGU -->
                        <label style="display:flex;align-items:flex-start;gap:10px;cursor:pointer;"
                            onclick="toggleCgu()">
                            <div class="chk" id="cguBox" style="margin-top:1px;"></div>
                            <span style="font-size:13px;color:#64748b;line-height:1.5;">J'accepte les <a
                                    href="tarifs.html" style="color:#a78bfa;text-decoration:underline;"
                                    onclick="event.stopPropagation()">CGU</a> et la <a href="#"
                                    style="color:#a78bfa;text-decoration:underline;"
                                    onclick="event.stopPropagation()">Politique de confidentialité</a></span>
                        </label>
                </div>

                <button class="btn" id="btn1" onclick="goStep(2)" disabled
                    style="width:100%;padding:14px;border-radius:13px;font-size:14px;margin-top:20px;display:flex;align-items:center;justify-content:center;gap:8px;">
                    Continuer → Personnaliser le profil
                </button>
            </div>

            <p style="text-align:center;margin-top:18px;color:#64748b;font-size:13px;">
                Déjà un compte ? <a href="/login" style="color:#a78bfa;font-weight:600;text-decoration:none;">Se
                    connecter →</a>
            </p>
        </div>

        <!-- ══════ STEP 2 — Profil ══════ -->
        <div id="step2" style="display:none;width:100%;max-width:520px;">
            <div style="text-align:center;margin-bottom:24px;">
                <h1 style="font-size:2rem;font-weight:800;color:#fff;margin-bottom:6px;">Votre <span
                        class="g">profil</span></h1>
                <p style="color:#64748b;font-size:14px;">Donnez une identité à votre espace créatif</p>
            </div>

            <div class="card" style="padding:32px;">
                <!-- Avatar grid -->
                <div style="margin-bottom:24px;">
                    <div
                        style="font-size:11px;font-weight:600;color:#94a3b8;letter-spacing:.08em;text-transform:uppercase;margin-bottom:12px;">
                        Choisissez votre avatar</div>
                    <div style="display:flex;gap:12px;flex-wrap:wrap;">
                        <div class="av sel" id="av0" onclick="pickAv(0)"
                            style="background:linear-gradient(135deg,#7c3aed,#06b6d4);">PV</div>
                        <div class="av" id="av1" onclick="pickAv(1)"
                            style="background:linear-gradient(135deg,#f59e0b,#ef4444);">🌅</div>
                        <div class="av" id="av2" onclick="pickAv(2)"
                            style="background:linear-gradient(135deg,#06b6d4,#3b82f6);">🌊</div>
                        <div class="av" id="av3" onclick="pickAv(3)"
                            style="background:linear-gradient(135deg,#10b981,#059669);">🌿</div>
                        <div class="av" id="av4" onclick="pickAv(4)"
                            style="background:linear-gradient(135deg,#ec4899,#8b5cf6);">✨</div>
                        <div class="av" id="av5" onclick="pickAv(5)"
                            style="background:linear-gradient(135deg,#f97316,#eab308);">🔥</div>
                    </div>
                </div>

                <div style="display:flex;flex-direction:column;gap:14px;">
                    <!-- Username -->
                    <div>
                        <div class="iw @error('pseudo') e @enderror" id="wUn">
                            <div class="ii" style="font-size:14px;left:14px;font-weight:500;">@</div>
                            <input class="fi" type="text" id="uname" placeholder="votre_pseudo"
                                oninput="chkUname()" style="padding-left:38px;" autocomplete="username"
                                name="pseudo" value="{{ old('pseudo') }}" />
                        </div>
                        @error('pseudo') <span style="color:#f87171;font-size:10px;margin-top:2px;">{{ $message }}</span> @enderror
                        <div style="font-size:11px;color:#7c3aed;margin-top:4px;padding-left:2px;" id="urlPreview">
                            pixelvault.io/@vous</div>
                    </div>


                    <!-- Bio -->
                    <div>
                        <div class="iw @error('description') e @enderror" style="border-radius:13px;">
                            <textarea class="fi" id="bio" placeholder="Décrivez votre activité créative..."
                                style="padding-left:14px;resize:none;min-height:80px;padding-top:12px;" oninput="cntBio()" maxlength="160"
                                name="description">{{ old('description') }}</textarea>
                            <div style="text-align:right;font-size:10px;color:#64748b;padding:4px 12px 8px;"
                                id="bioCnt">0/160</div>
                        </div>
                        @error('description') <span style="color:#f87171;font-size:10px;margin-top:2px;">{{ $message }}</span> @enderror
                    </div>


                    <!-- Specialties -->
                    <div>
                        <div
                            style="font-size:11px;font-weight:600;color:#94a3b8;letter-spacing:.08em;text-transform:uppercase;margin-bottom:10px;">
                            Spécialité (max. 3)</div>
                        <div style="display:flex;flex-wrap:wrap;gap:8px;" id="specs">
                            <button class="spec" onclick="toggleSpec(this)">🎨 UI Design</button>
                            <button class="spec" onclick="toggleSpec(this)">💻 Dev</button>
                            <button class="spec" onclick="toggleSpec(this)">🖼 Illustration</button>
                            <button class="spec" onclick="toggleSpec(this)">🎬 Motion</button>
                            <button class="spec" onclick="toggleSpec(this)">🎵 Audio</button>
                            <button class="spec" onclick="toggleSpec(this)">📚 Formation</button>
                            <button class="spec" onclick="toggleSpec(this)">🔮 3D</button>
                            <button class="spec" onclick="toggleSpec(this)">📱 Mobile</button>
                        </div>
                    </div>
                </div>

                <div style="display:flex;gap:10px;margin-top:24px;">
                    <button class="btn-outline" onclick="goStep(1)"
                        style="flex:1;padding:13px;border-radius:13px;font-size:13px;">← Retour</button>
                    <button class="btn" onclick="goStep(3)"
                        style="flex:2;padding:14px;border-radius:13px;font-size:14px;">Choisir mon plan →</button>
                </div>
            </div>
        </div>

        <!-- ══════ STEP 3 — Plan ══════ -->
        <div id="step3" style="display:none;width:100%;max-width:500px;">
            <div style="text-align:center;margin-bottom:24px;">
                <h1 style="font-size:2rem;font-weight:800;color:#fff;margin-bottom:6px;">Votre <span
                        class="g">plan</span></h1>
                <p style="color:#64748b;font-size:14px;">Modifiable à tout moment. Sans engagement.</p>
            </div>

            <div class="card" style="padding:28px;">
                <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:20px;">
                    <!-- Starter -->
                    <div class="plan sel" id="pl-starter" onclick="pickPlan('starter')">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div class="plan-radio"></div>
                            <div
                                style="width:36px;height:36px;border-radius:10px;background:rgba(100,116,139,.15);border:1px solid rgba(100,116,139,.2);display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;">
                                😊</div>
                            <div style="flex:1;">
                                <div style="font-family:'Syne',sans-serif;font-weight:700;color:#fff;font-size:14px;">
                                    Starter</div>
                                <div style="font-size:12px;color:#64748b;margin-top:1px;">50 produits · 5
                                    téléchargements/mois</div>
                            </div>
                            <div style="font-family:'Syne',sans-serif;font-weight:800;color:#fff;font-size:15px;">
                                Gratuit</div>
                        </div>
                    </div>

                    <!-- Pro -->
                    <div class="plan" id="pl-pro" onclick="pickPlan('pro')"
                        style="border-color:rgba(124,58,237,.2);">
                        <div
                            style="position:absolute;top:-1px;right:16px;background:linear-gradient(135deg,#7c3aed,#06b6d4);color:#fff;font-size:9px;font-weight:700;font-family:'Syne',sans-serif;padding:3px 10px;border-radius:0 0 10px 10px;letter-spacing:.06em;">
                            POPULAIRE</div>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div class="plan-radio"></div>
                            <div
                                style="width:36px;height:36px;border-radius:10px;background:rgba(124,58,237,.2);border:1px solid rgba(124,58,237,.3);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <svg width="18" height="18" fill="none" stroke="#a78bfa"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div style="flex:1;">
                                <div style="font-family:'Syne',sans-serif;font-weight:700;color:#fff;font-size:14px;">
                                    Pro <span
                                        style="font-size:11px;color:#34d399;font-family:'DM Sans',sans-serif;font-weight:500;">14j
                                        gratuit</span></div>
                                <div style="font-size:12px;color:#64748b;margin-top:1px;">Illimité · Licence
                                    commerciale · Support 24/7</div>
                            </div>
                            <div style="text-align:right;flex-shrink:0;">
                                <div style="font-family:'Syne',sans-serif;font-weight:800;color:#fff;font-size:15px;">
                                    19€<span
                                        style="font-size:11px;color:#64748b;font-family:'DM Sans',sans-serif;">/mois</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Creator -->
                    <div class="plan" id="pl-creator" onclick="pickPlan('creator')">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div class="plan-radio"></div>
                            <div
                                style="width:36px;height:36px;border-radius:10px;background:rgba(245,158,11,.15);border:1px solid rgba(245,158,11,.25);display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;">
                                ⭐</div>
                            <div style="flex:1;">
                                <div style="font-family:'Syne',sans-serif;font-weight:700;color:#fff;font-size:14px;">
                                    Créateur</div>
                                <div style="font-size:12px;color:#64748b;margin-top:1px;">Vendre · 70% commission ·
                                    Analytics</div>
                            </div>
                            <div style="text-align:right;flex-shrink:0;">
                                <div style="font-family:'Syne',sans-serif;font-weight:800;color:#fff;font-size:15px;">
                                    49€<span
                                        style="font-size:11px;color:#64748b;font-family:'DM Sans',sans-serif;">/mois</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Newsletter opt-in -->
                <label style="display:flex;align-items:flex-start;gap:10px;cursor:pointer;margin-bottom:20px;"
                    onclick="toggleNl()">
                    <div class="chk on" id="nlChk" style="margin-top:1px;"><svg width="9" height="9"
                            viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 13l4 4L19 7" />
                        </svg></div>
                    <span style="font-size:13px;color:#64748b;line-height:1.5;">Recevoir les nouveaux produits et
                        offres exclusives par email</span>
                </label>

                <div style="display:flex;gap:10px;">
                    <button class="btn-outline" onclick="goStep(2)"
                        style="flex:1;padding:13px;border-radius:13px;font-size:13px;">← Retour</button>
                    <button class="btn" id="finalBtn" onclick="finalCreate()"
                        style="flex:2;padding:14px;border-radius:13px;font-size:14px;display:flex;align-items:center;justify-content:center;gap:8px;">
                        <span id="finalTxt">Créer mon compte</span>
                        <div class="spinner" id="finalSpin" style="display:none;"></div>
                    </button>
                </div>

                <p style="text-align:center;font-size:11px;color:#3f3f5a;margin-top:14px;">En créant votre compte, vous
                    acceptez nos CGU.</p>
            </div>

            </form>
        </div>

        <!-- ══════ SUCCESS ══════ -->
        <div id="stepOK" style="display:none;width:100%;max-width:440px;text-align:center;padding-top:20px;">
            <div style="position:relative;display:inline-block;margin-bottom:24px;">
                <div id="confettiBox" style="position:absolute;inset:0;pointer-events:none;overflow:visible;"></div>
                <div class="suc-ring" style="margin:0 auto;">
                    <svg width="38" height="38" viewBox="0 0 40 40" fill="none">
                        <path class="chk-svg" d="M10 20 L17 27 L30 13" stroke="#34d399" stroke-width="3.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
            <h2 style="font-size:2.4rem;font-weight:800;color:#fff;margin-bottom:8px;">Bienvenue sur <span
                    class="g">PixelVault</span> !</h2>
            <p style="color:#94a3b8;margin-bottom:6px;" id="okName">Votre compte est prêt.</p>
            <p style="color:#64748b;font-size:13px;margin-bottom:32px;">Confirmez votre email pour débloquer toutes les
                fonctionnalités.</p>
            <a href="/explorer" class="btn"
                style="display:inline-flex;align-items:center;gap:8px;padding:14px 32px;border-radius:13px;font-size:14px;text-decoration:none;">
                Explorer PixelVault →
            </a>
        </div>

    </div>

    <script>
        /* Cursor */
        const cur = document.getElementById('cur'),
            ring = document.getElementById('ring');
        let mx = 0,
            my = 0,
            rx = 0,
            ry = 0;
        document.addEventListener('mousemove', e => {
            mx = e.clientX;
            my = e.clientY;
            cur.style.left = mx + 'px';
            cur.style.top = my + 'px';
        });
        (function loop() {
            rx += (mx - rx) * .1;
            ry += (my - ry) * .1;
            ring.style.left = rx + 'px';
            ring.style.top = ry + 'px';
            requestAnimationFrame(loop);
        })();

        function rc() {
            document.querySelectorAll('a,button,input,textarea,label,.av,.plan,.spec').forEach(el => {
                el.addEventListener('mouseenter', () => {
                    cur.style.width = '18px';
                    cur.style.height = '18px';
                    ring.style.width = '46px';
                    ring.style.height = '46px';
                });
                el.addEventListener('mouseleave', () => {
                    cur.style.width = '10px';
                    cur.style.height = '10px';
                    ring.style.width = '32px';
                    ring.style.height = '32px';
                });
            });
        }
        rc();

        /* State */
        let cgu = false,
            nl = true,
            curStep = 1,
            selPlan = '{{ old('plan', 'starter') }}' === 'gratuit' ? 'starter' : '{{ old('plan', 'starter') }}',
            selAv = parseInt('{{ old('avatar', 'av1') }}'.replace('av','')) - 1,
            specCnt = {{ old('specialite') ? 1 : 0 }};

        // Auto-navigate to correct step if errors exist
        @if($errors->hasAny(['pseudo', 'description', 'specialite']))
            window.addEventListener('DOMContentLoaded', () => goStep(2));
        @elseif($errors->has('plan'))
            window.addEventListener('DOMContentLoaded', () => goStep(3));
        @endif

        // Initialize UI with old values
        window.addEventListener('DOMContentLoaded', () => {
            pickAv(selAv);
            pickPlan(selPlan);
            
            // Re-apply specialite if exists
            const oldSpec = '{{ old('specialite') }}';
            if(oldSpec) {
                document.querySelectorAll('.spec').forEach(btn => {
                    if(specMap[btn.textContent.trim()] === oldSpec) {
                        btn.classList.add('on');
                    }
                });
            }
        });

        /* Helpers */
        function vField(inp, wid, min) {
            const w = document.getElementById(wid);
            const ok = inp.value.trim().length >= min;
            w.className = 'iw' + (inp.value ? ok ? ' v' : ' e' : '');
        }

        function vEmail() {
            const v = document.getElementById('em').value;
            const w = document.getElementById('wEm');
            const ok = /.+@.+\..+/.test(v);
            w.className = 'iw' + (v ? ok ? ' v' : ' e' : '');
        }

        function checkStr() {
            const p = document.getElementById('pw').value;
            const s = [1, 2, 3, 4].map(i => document.getElementById('sb' + i));
            const lbl = document.getElementById('strLabel');
            let sc = 0;
            if (p.length >= 8) sc++;
            if (/[A-Z]/.test(p)) sc++;
            if (/[0-9]/.test(p)) sc++;
            if (/[^A-Za-z0-9]/.test(p)) sc++;
            const cols = ['#ef4444', '#f97316', '#eab308', '#10b981'];
            const lbls = ['Très faible', 'Faible', 'Bon', 'Fort 💪'];
            s.forEach((b, i) => {
                b.style.width = i < sc ? '100%' : '0';
                b.style.background = i < sc ? cols[sc - 1] : 'transparent';
                b.style.transition = 'width .4s ' + (i * .06) + 's,background .3s';
            });
            if (p) {
                lbl.textContent = lbls[sc - 1] || 'Trop court';
                lbl.style.color = sc >= 3 ? '#34d399' : '#94a3b8';
            } else {
                lbl.textContent = 'Min. 8 caractères, 1 majuscule, 1 chiffre';
                lbl.style.color = '#64748b';
            }
            document.getElementById('wPw').className = 'iw' + (p ? sc >= 2 ? ' v' : ' e' : '');
        }

        function checkConfirm() {
            const p = document.getElementById('pw').value,
                c = document.getElementById('co').value;
            const w = document.getElementById('wCo'),
                e = document.getElementById('errConf');
            if (!c) {
                w.className = 'iw';
                e.style.display = 'none';
                return;
            }
            const ok = p === c;
            w.className = 'iw' + (ok ? ' v' : ' e');
            e.style.display = ok ? 'none' : 'block';
        }

        function chk1() {
            const fn = document.getElementById('fn').value.trim(),
                ln = document.getElementById('ln').value.trim(),
                em = document.getElementById('em').value,
                pw = document.getElementById('pw').value,
                co = document.getElementById('co').value;
            const ok = fn.length >= 2 && ln.length >= 2 && /.+@.+\..+/.test(em) && pw.length >= 8 && pw === co && cgu;
            const b = document.getElementById('btn1');
            b.disabled = !ok;
            b.style.opacity = ok ? '1' : '.35';
        }

        function toggleCgu() {
            cgu = !cgu;
            const b = document.getElementById('cguBox');
            b.classList.toggle('on', cgu);
            b.innerHTML = cgu ?
                '<svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>' :
                '';
            chk1();
        }

        function toggleNl() {
            nl = !nl;
            const b = document.getElementById('nlChk');
            b.classList.toggle('on', nl);
            b.innerHTML = nl ?
                '<svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>' :
                '';
        }

        function togglePw(id) {
            const i = document.getElementById(id);
            i.type = i.type === 'password' ? 'text' : 'password';
        }

        function pickAv(n) {
            selAv = n;
            document.querySelectorAll('.av').forEach((a, i) => a.classList.toggle('sel', i === n));
            document.getElementById('hidden_avatar').value = 'av' + (n + 1);
        }

        const specMap = {
            '🎨 UI Design': 'uidesign',
            '💻 Dev': 'dev',
            '🖼 Illustration': 'illustration',
            '🎬 Motion': 'motion',
            '🎵 Audio': 'audio',
            '📚 Formation': 'formation',
            '🔮 3D': '3D',
            '📱 Mobile': 'mobile'
        };

        function toggleSpec(btn) {
            if (!btn.classList.contains('on') && specCnt >= 3) return;
            btn.classList.toggle('on');
            specCnt += btn.classList.contains('on') ? 1 : -1;

            const selected = [];
            document.querySelectorAll('.spec.on').forEach(el => {
                const val = specMap[el.textContent.trim()];
                if (val) selected.push(val);
            });
            // Since migration is enum, we only take the first one
            document.getElementById('hidden_specialite').value = selected.length > 0 ? selected[0] : '';
        }

        function chkUname() {
            const v = document.getElementById('uname').value;
            const p = document.getElementById('urlPreview');
            const w = document.getElementById('wUn');
            if (v) {
                p.textContent = 'pixelvault.io/@' + v;
                p.style.color = v.length >= 3 ? '#7c3aed' : '#f87171';
                w.className = 'iw' + (v.length >= 3 ? ' v' : ' e');
            } else {
                p.textContent = 'pixelvault.io/@vous';
                p.style.color = '#64748b';
                w.className = 'iw';
            }
        }

        function cntBio() {
            const v = document.getElementById('bio').value;
            document.getElementById('bioCnt').textContent = v.length + '/160';
            document.getElementById('bioCnt').style.color = v.length > 140 ? '#f97316' : '#64748b';
        }

        function pickPlan(p) {
            const planMap = {
                'starter': 'gratuit',
                'pro': 'pro',
                'creator': 'createur'
            };
            selPlan = p;
            document.getElementById('hidden_plan').value = planMap[p] || p;
            ['starter', 'pro', 'creator'].forEach(n => {
                const el = document.getElementById('pl-' + n);
                el.classList.toggle('sel', n === p);
            });
        }

        /* Step navigation */
        function goStep(n) {
            const steps = ['step1', 'step2', 'step3', 'stepOK'];
            steps.forEach(s => {
                const el = document.getElementById(s);
                if (el) {
                    el.style.display = 'none';
                }
            });
            const target = document.getElementById('step' + n);
            if (target) {
                target.style.display = 'block';
                target.style.animation = 'none';
                target.offsetHeight;
                target.style.animation = 'stepSlide .4s ease both';
            }
            curStep = n;
            updateDots(n);
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            rc();
        }

        function updateDots(n) {
            [1, 2, 3].forEach(i => {
                const d = document.getElementById('sd' + i),
                    l = document.getElementById('sl' + i);
                if (i < n) {
                    d.className = 'step-dot done';
                    d.innerHTML =
                        '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>';
                    l.className = 'step-label done';
                } else if (i === n) {
                    d.className = 'step-dot active';
                    d.textContent = i;
                    l.className = 'step-label active';
                } else {
                    d.className = 'step-dot';
                    d.textContent = i;
                    l.className = 'step-label';
                }
            });
            document.getElementById('sline1').className = 'step-line' + (n > 1 ? ' done' : '');
            document.getElementById('sline2').className = 'step-line' + (n > 2 ? ' done' : '');
        }

        function finalCreate() {
            const btn = document.getElementById('finalBtn'),
                tx = document.getElementById('finalTxt'),
                sp = document.getElementById('finalSpin');
            btn.disabled = true;
            tx.style.opacity = '0';
            sp.style.display = 'block';

            // Submit the form
            document.getElementById('regForm').submit();
        }

        function confettiLaunch() {
            const c = document.getElementById('confettiBox');
            const colors = ['#a78bfa', '#22d3ee', '#f59e0b', '#34d399', '#f87171'];
            for (let i = 0; i < 22; i++) {
                const d = document.createElement('div');
                d.className = 'confetti-p';
                d.style.cssText =
                    `width:${6+Math.random()*7}px;height:${6+Math.random()*7}px;border-radius:${Math.random()>.5?'50%':'3px'};background:${colors[~~(Math.random()*colors.length)]};left:${Math.random()*100}%;top:${30+Math.random()*50}%;animation-delay:${Math.random()*.4}s;animation-duration:${.8+Math.random()*.5}s;`;
                c.appendChild(d);
                setTimeout(() => d.remove(), 2e3);
            }
        }

        document.getElementById('btn1').style.opacity = '.35';
    </script>
</body>

</html>
