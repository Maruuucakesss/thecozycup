@extends('layouts.app')
@section('title', 'Quality drinks, affordable prices')

@section('content')
    <div class="hero">
        <div class="wrap">
            <h1>Good drinks. Small prices.</h1>
            <div>
                <p>The Cozy Cup serves quality coffee, matcha and pastries without the high price. Order ahead and pick up in store.</p>
                <a class="btn light" href="{{ route('menu') }}">Browse the menu</a>
            </div>
        </div>
    </div>

    <section class="wrap">
        <div class="sectionhead">
            <h2>Customer favorites</h2>
            <a class="btn ghost sm" href="{{ route('menu') }}">See full menu</a>
        </div>
        <div class="grid">
            @foreach($featured as $p)
                @include('partials.card', ['p' => $p])
            @endforeach
        </div>
    </section>

    <section class="band">
        <div class="wrap two">
            <div>
                <h2>A cozy place for everyone</h2>
                <p>Enjoy your favorite drinks while relaxing and spending time with friends and family. Good taste, quality service and a cozy experience in every cup.</p>
                <a class="btn" href="{{ route('about') }}">About The Cozy Cup</a>
            </div>
            <ol class="steps">
                <li>Create a free account.</li>
                <li>Pick a drink, then choose cold or hot, sugar level and extras.</li>
                <li>Choose pickup or delivery and place your order.</li>
            </ol>
        </div>
    </section>
@endsection
