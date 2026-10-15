@extends('layouts.admin')

@section('content')
    <h1>Change password</h1>

    <form method="post" action="{{ route('admin.password.update') }}" class="box">
        @csrf @method('PUT')

        @include('partials.password-field', ['name' => 'old', 'label' => 'Current password', 'autocomplete' => 'current-password'])
        @include('partials.password-field', ['name' => 'new', 'label' => 'New password', 'autocomplete' => 'new-password', 'rules' => true])

        <button class="btn">Save password</button>
    </form>
@endsection
