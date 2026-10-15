@extends('layouts.app')
@section('title', 'Log in')

@section('content')
    <div class="authwrap">
        <div class="authsplit">
            @include('auth._side', ['title' => 'Welcome back.', 'text' => 'Log in to order your favorites and follow your pickups.'])

            <form method="post" action="{{ route('login') }}" class="authform">
                @csrf
                <img class="authlogo" src="{{ asset('assets/logo.png') }}" alt="{{ config('shop.name') }}">
                <h1>Log in</h1>

                @if($errors->any())
                    <p class="err">{{ $errors->first() }}</p>
                @endif

                <label>Email
                    <input type="email" name="email" required autofocus value="{{ old('email') }}">
                </label>
                @include('partials.password-field', ['name' => 'password', 'label' => 'Password', 'autocomplete' => 'current-password'])
                <a class="forgot" href="{{ route('password.request') }}">Forgot password?</a>
                <button class="btn block">Log in</button>

                <div class="or">New here?</div>
                <a class="btn ghost block" href="{{ route('register') }}">Create an account</a>
            </form>
        </div>
    </div>
@endsection
