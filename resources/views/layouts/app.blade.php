@php
    $showTerms = !request()->routeIs('terms', 'privacy');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('shop.name')) | {{ config('shop.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,600;12..96,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/favicon.png') }}">
    @if($showTerms)
        <script>
            // Terms pop-up: shown on every new visit (new tab or reopened site),
            // but not on refresh or when moving between pages in the same tab.
            try {
                if (sessionStorage.getItem('tcc_terms') === '1') {
                    document.documentElement.classList.add('terms-ok');
                }
            } catch (e) {}
        </script>
    @endif
</head>
<body @class(['gate' => $showTerms])>
    <header>
        <div class="in">
            <a class="logo" href="{{ route('home') }}">
                <img src="{{ asset('assets/logo-mark.png') }}" alt="">
                <span>{{ config('shop.name') }}</span>
            </a>
            <button class="burger" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="nav">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
            <nav id="nav">
                <a href="{{ route('home') }}" @if(request()->routeIs('home')) aria-current="page" @endif>Home</a>
                <a href="{{ route('menu') }}" @if(request()->routeIs('menu', 'product')) aria-current="page" @endif>Menu</a>
                <a href="{{ route('about') }}" @if(request()->routeIs('about')) aria-current="page" @endif>About us</a>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.orders') }}">Admin</a>
                    @endif
                    <a href="{{ route('orders') }}">My orders
                        @if(auth()->user()->orders()->whereIn('status', ['on_the_way', 'ready'])->exists())
                            <span class="dot" title="Update on your order"></span>
                        @endif
                    </a>
                    <form method="post" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button class="navbtn">Log out</button>
                    </form>
                    <a class="pill" href="{{ route('cart') }}">Cart ({{ (int) auth()->user()->cartItems()->sum('qty') }})</a>
                @else
                    <a href="{{ route('login') }}">Log in</a>
                    <a class="pill" href="{{ route('register') }}">Sign up</a>
                @endauth
            </nav>
        </div>
    </header>

    @if(session('msg'))
        <div class="toast" role="status">{{ session('msg') }}</div>
    @endif

    <main>@yield('content')</main>

    <footer>
        <div class="in">
            <div>
                <strong>{{ config('shop.name') }} ({{ config('shop.short') }})</strong><br>
                {{ config('shop.address') }}<br>
                @foreach(config('shop.hours') as $days => $time){{ $days }} {{ $time }}@if(!$loop->last) · @endif @endforeach
            </div>
            <div class="flinks">
                <a class="fbtn" href="{{ route('terms') }}">Terms &amp; Conditions</a>
                <a class="fbtn" href="{{ route('privacy') }}">Privacy Policy</a>
            </div>
        </div>
    </footer>
    @if($showTerms)
        @include('partials.terms-modal')
    @endif

    <script>
        // Mobile menu toggle
        var burger = document.querySelector('.burger');
        var nav = document.getElementById('nav');
        burger.addEventListener('click', function () {
            var open = nav.classList.toggle('open');
            burger.setAttribute('aria-expanded', open);
        });
    </script>
</body>
</html>
