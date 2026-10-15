@extends('layouts.app')
@section('title', 'Menu')

@section('content')
    <section class="wrap">
        <h1>Menu</h1>
        <div class="hintbar">
            <p class="muted" style="margin:0">Drinks come in Cold 16 oz or Hot 12 oz. Tap an item to see details.</p>
            @guest
                <a class="btn sm" href="{{ route('login') }}">Log in to order</a>
            @endguest
        </div>

        <div class="tabs">
            <a href="{{ route('menu') }}" class="{{ $slug ? '' : 'on' }}">All</a>
            @foreach($cats as $c)
                <a href="{{ route('menu', ['cat' => $c->slug]) }}" class="{{ $slug == $c->slug ? 'on' : '' }}">{{ $c->name }}</a>
            @endforeach
        </div>

        <div class="grid">
            @forelse($items as $p)
                @include('partials.card', ['p' => $p])
            @empty
                <p class="muted">Nothing available here right now.</p>
            @endforelse
        </div>
    </section>
@endsection
