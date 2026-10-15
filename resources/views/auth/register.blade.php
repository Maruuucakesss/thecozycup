@extends('layouts.app')
@section('title', 'Sign up')

@section('content')
    <div class="authwrap">
        <div class="authsplit">
            @include('auth._side', ['title' => 'Join The Cozy Cup.', 'text' => 'Create a free account and start ordering in under a minute.'])

            <form method="post" action="{{ route('register') }}" class="authform">
                @csrf
                <img class="authlogo" src="{{ asset('assets/logo.png') }}" alt="{{ config('shop.name') }}">
                <h1>Create account</h1>

                @if($errors->any())
                    <p class="err">{{ $errors->first() }}</p>
                @endif

                <label>Name
                    <input name="name" required autofocus value="{{ old('name') }}">
                </label>
                <label>Email
                    <input type="email" name="email" required value="{{ old('email') }}">
                </label>
                @include('partials.password-field', ['name' => 'password', 'label' => 'Password', 'autocomplete' => 'new-password', 'rules' => true])
                <label class="opt">
                    <span>
                        <input type="checkbox" name="terms">
                        <span>I agree to the <a href="{{ route('terms') }}" target="_blank">Terms</a> and <a href="{{ route('privacy') }}" target="_blank">Privacy Policy</a></span>
                    </span>
                </label>
                <button class="btn block">Sign up</button>

                <div class="or">Already have an account?</div>
                <a class="btn ghost block" href="{{ route('login') }}">Log in</a>
            </form>
        </div>
    </div>
@endsection
