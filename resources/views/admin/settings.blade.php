@extends('layouts.admin')

@section('content')
    <h1>Settings</h1>
    <p class="muted">Customers see this fee at checkout when they choose delivery.</p>

    <form method="post" action="{{ route('admin.settings.update') }}" class="box">
        @csrf @method('PUT')

        <label>Delivery fee (₱)
            <input type="number" name="delivery_fee" step="0.01" min="0" max="5000" required
                   value="{{ old('delivery_fee', $fee) }}">
        </label>

        <p class="muted" style="margin:0">
            Pickup is always free. Changing the fee only affects new orders; orders already placed keep the fee they were placed with.
        </p>

        <button class="btn">Save settings</button>
    </form>
@endsection
