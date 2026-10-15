@extends('layouts.app')
@section('title', 'My orders')

@section('content')
    <section class="wrap mid">
        <h1>My orders</h1>

        @forelse($orders as $o)
            <div class="order">
                <div class="row" style="margin-top:0">
                    <strong>Order #{{ $o->id }}</strong>
                    <span class="badge">{{ $o->status_label }}</span>
                </div>
                <p class="muted" style="margin:.2rem 0 0">
                    {{ $o->created_at->format('M j, Y g:i A') }} ·
                    {{ $o->is_delivery ? 'Delivery' : 'Pickup' }} · {{ $o->pickup_time }}
                </p>

                <div class="notice {{ $o->needs_attention ? 'alert' : '' }}">
                    {{ $o->customer_message }}
                    @if($o->needs_attention && $o->reminded_at)
                        <small>Updated {{ $o->reminded_at->diffForHumans() }}</small>
                    @endif
                </div>

                @if($o->is_delivery)
                    <p class="muted" style="margin:0 0 .4rem"><strong>Deliver to:</strong> {{ $o->delivery_address }}</p>
                @endif

                @foreach($o->items as $r)
                    <div class="row" style="margin:.2rem 0">
                        <span>{{ $r->qty }} × {{ $r->product_name }} @if($r->options_text)<small class="muted">({{ $r->options_text }})</small>@endif</span>
                        <span>{{ peso($r->unit_price * $r->qty) }}</span>
                    </div>
                @endforeach

                @if($o->is_delivery)
                    <div class="row" style="margin:.2rem 0"><span class="muted">Delivery fee</span><span>{{ peso($o->delivery_fee) }}</span></div>
                @endif
                <div class="row"><strong>Total</strong><strong>{{ peso($o->total) }}</strong></div>
            </div>
        @empty
            <p class="muted">No orders yet.</p>
            <a class="btn" href="{{ route('menu') }}">Browse the menu</a>
        @endforelse
    </section>

    @if($orders->contains(fn($o) => in_array($o->status, ['pending', 'accepted', 'on_the_way', 'ready'])))
        <script>
            // Keep order updates fresh while something is still in progress.
            setTimeout(function () { location.reload(); }, 30000);
        </script>
    @endif
@endsection
