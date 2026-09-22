<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#faf9fd">
    <title>404 · Page not found · Illuna</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('assets/portal.css') }}">
    <style>
        .error-main {
            flex:1;
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            width:min(720px,calc(100% - 40px));
            margin:24px auto 64px;
            text-align:center;
        }
        .error-art {
            display:flex;
            align-items:center;
            justify-content:center;
            gap:clamp(6px,2vw,20px);
            margin-bottom:26px;
            font-size:clamp(100px,22vw,190px);
            line-height:1;
            font-weight:650;
            letter-spacing:-.07em;
            color:#dcd3ee;
        }
        .error-orbit {
            position:relative;
            display:grid;
            place-items:center;
            width:clamp(100px,22vw,190px);
            aspect-ratio:1;
            border:1px dashed #b5a1d5;
            border-radius:50%;
            background:radial-gradient(circle,#ebe1fc 0%,#f4edfc 55%,transparent 72%);
        }
        .error-orbit::after {
            content:"";
            position:absolute;
            width:12%;
            aspect-ratio:1;
            top:10%;
            right:7%;
            border:4px solid var(--bg);
            border-radius:50%;
            background:#28c6c2;
        }
        .error-mark {
            width:45%;
            height:auto;
            color:var(--purple);
            transform:rotate(-12deg);
        }
        .error-main h1 {
            max-width:620px;
            margin:18px 0;
            font-size:clamp(2.15rem,5vw,3.75rem);
        }
        .error-copy {
            max-width:430px;
            font-size:1rem;
        }
        .error-copy + .error-copy {
            margin-top:12px;
        }
        .error-actions {
            display:flex;
            justify-content:center;
            flex-wrap:wrap;
            gap:12px;
            margin-top:30px;
        }
        @media(max-width:400px) {
            .error-actions {
                width:100%;
                flex-direction:column;
            }
            .error-actions .button {
                width:100%;
            }
        }
    </style>
</head>
<body class="auth-body">
    <a class="skip-link" href="#main">Skip to content</a>
    <header class="auth-header">
        <x-brand />
        <a class="quiet-link" href="{{ route('home') }}">Back to website <span aria-hidden="true">↗</span></a>
    </header>
    <main id="main" class="error-main">
        <div class="error-art" aria-hidden="true">
            <span>4</span>
            <span class="error-orbit">
                <svg class="error-mark" viewBox="0 0 60 68" fill="none">
                    <path d="M10 50V28M30 58V10M50 42V20" stroke="currentColor" stroke-width="10" stroke-linecap="round"/>
                </svg>
            </span>
            <span>4</span>
        </div>
        <span class="eyebrow">404 · PAGE NOT FOUND</span>
        <h1>This page went exploring.</h1>
        <p class="error-copy">We can personalise almost everything.<br>Apparently, this page wanted to be somewhere else.</p>
        <p class="error-copy">The link may be outdated, or the address may have a typo. Let's get you back.</p>
        <nav class="error-actions" aria-label="Find your way back">
            <a class="button primary" href="{{ route('home') }}">Back to home <span aria-hidden="true">↗</span></a>
            <a class="button" href="{{ route('dashboard') }}">Go to dashboard <span aria-hidden="true">→</span></a>
        </nav>
    </main>
    <footer class="auth-footer">© {{ date('Y') }} Illuna <span>Software, more personal.</span></footer>
</body>
</html>
