@extends('layouts.app')
@section('title', 'About us')

@section('content')
    <section class="pagehero tex dots">
        <div class="wrap">
            <span class="eyebrow">About us</span>
            <h1>Quality drinks,<br>cozy moments.</h1>
            <p>TCC – The Cozy Cup is a beverage business that aims to provide quality drinks at affordable prices.</p>
        </div>
    </section>

    <section class="wrap two">
        <div>
            <h2>Who we are</h2>
            <p>We offer delicious and refreshing beverages that you can enjoy without spending too much.</p>
            <p>We focus on good taste, quality service, and a cozy experience for every customer.</p>
        </div>
        <div class="quote tex dark">
            “A place where people enjoy their favorite drinks while relaxing and spending time with friends and family.”
            <span>Our goal</span>
        </div>
    </section>

    <section class="wrap" style="padding-top:0">
        <h2>What we stand for</h2>
        <div class="values">
            <article class="value">
                <div class="ico">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 9h11v5a4 4 0 0 1-4 4H9a4 4 0 0 1-4-4V9z"/><path d="M16 11h1.5a2 2 0 0 1 0 4H16"/><path d="M8 3.5v2M12 3.5v2"/></svg>
                </div>
                <h3>Good taste</h3>
                <p>Every drink is made to be delicious and refreshing.</p>
            </article>
            <article class="value">
                <div class="ico">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20s-7-4.5-7-10a4 4 0 0 1 7-2.5A4 4 0 0 1 19 10c0 5.5-7 10-7 10z"/></svg>
                </div>
                <h3>Quality service</h3>
                <p>Friendly, careful service from order to pickup.</p>
            </article>
            <article class="value">
                <div class="ico">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 11l8-7 8 7v9H4z"/><path d="M10 20v-6h4v6"/></svg>
                </div>
                <h3>A cozy experience</h3>
                <p>A comfortable place to slow down and enjoy time together.</p>
            </article>
        </div>
    </section>

    <section class="band tex">
        <div class="wrap two" style="align-items:center">
            <div>
                <h2>Visit us</h2>
                <p style="margin:0 0 .5rem">{{ config('shop.address') }}</p>
                @foreach(config('shop.hours') as $days => $time)
                    <p style="margin:0"><strong>{{ $days }}</strong> · {{ $time }}</p>
                @endforeach
            </div>
            <div class="acts">
                <a class="btn" href="{{ route('menu') }}">See the menu</a>
                @guest
                    <a class="btn ghost" href="{{ route('register') }}">Create an account</a>
                @endguest
            </div>
        </div>
    </section>
@endsection
