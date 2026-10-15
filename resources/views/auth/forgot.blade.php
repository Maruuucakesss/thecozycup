@extends('layouts.app')
@section('title', 'Forgot password')

@section('content')
    <div class="authwrap">
        <div class="authsplit">
            @include('auth._side', [
                'title' => 'Forgot your password?',
                'text'  => 'Enter your email and choose a new password.',
                'perks' => false,
            ])

            <form method="post" action="{{ route('password.change') }}" class="authform">
                @csrf
                <img class="authlogo" src="{{ asset('assets/logo.png') }}" alt="{{ config('shop.name') }}">
                <h1>Forgot password</h1>

                @if($errors->any())
                    <p class="err">{{ $errors->first() }}</p>
                @endif

                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required autofocus autocomplete="email" value="{{ old('email') }}">
                </div>

                @include('partials.password-field', ['name' => 'password', 'label' => 'New password', 'autocomplete' => 'new-password', 'rules' => true])
                @include('partials.password-field', ['name' => 'password_confirmation', 'label' => 'Confirm new password', 'autocomplete' => 'new-password'])

                <button class="btn block">Change password</button>

                <div class="or">Remembered it?</div>
                <a class="btn ghost block" href="{{ route('login') }}">Back to log in</a>
            </form>
        </div>
    </div>
@endsection
