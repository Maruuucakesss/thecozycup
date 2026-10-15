<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | {{ config('shop.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,600;12..96,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/favicon.png') }}">
</head>
<body class="admin">
    <header>
        <div class="in">
            <a class="logo" href="{{ route('admin.orders') }}">
                <img src="{{ asset('assets/logo-mark-light.png') }}" alt="">
                <span>TCC</span>
            </a>
            <button class="burger" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="nav">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
            <nav id="nav">
                <a href="{{ route('admin.orders') }}" @if(request()->routeIs('admin.orders')) aria-current="page" @endif>Orders
                    @php $pendingCount = \App\Models\Order::where('status', 'pending')->count(); @endphp
                    @if($pendingCount)<span class="count">{{ $pendingCount }}</span>@endif
                </a>
                <a href="{{ route('admin.products') }}" @if(request()->routeIs('admin.products*')) aria-current="page" @endif>Products</a>
                <a href="{{ route('admin.options') }}" @if(request()->routeIs('admin.options*')) aria-current="page" @endif>Add-ons</a>
                <a href="{{ route('admin.settings') }}" @if(request()->routeIs('admin.settings*')) aria-current="page" @endif>Settings</a>
                <a href="{{ route('admin.audit') }}" @if(request()->routeIs('admin.audit')) aria-current="page" @endif>Audit log</a>
                <a href="{{ route('admin.password') }}" @if(request()->routeIs('admin.password*')) aria-current="page" @endif>Password</a>
                <a href="{{ route('home') }}">View site</a>
                <form method="post" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="navbtn">Log out</button>
                </form>
            </nav>
        </div>
    </header>

    @if(session('msg'))
        <div class="toast" role="status">{{ session('msg') }}</div>
    @endif

    <main>
        <div class="wrap">
            @if($errors->any())
                <p class="err">{{ $errors->first() }}</p>
            @endif
            @yield('content')
        </div>
    </main>
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
