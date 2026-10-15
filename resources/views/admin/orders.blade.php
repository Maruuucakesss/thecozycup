@extends('layouts.admin')

@section('content')
    <h1>Orders</h1>

    <div class="tabs">
        @foreach($tabs as $key => [$label])
            <a href="{{ route('admin.orders', ['s' => $key]) }}" class="{{ $tab === $key ? 'on' : '' }}">
                {{ $label }}@if($key === 'pending' && $pending) ({{ $pending }})@endif
            </a>
        @endforeach
    </div>

    @if($orders->isEmpty())
        <p class="muted">No orders here.</p>
    @endif

    @foreach($orders as $o)
        <div class="order">
            <div class="row" style="margin-top:0">
                <strong>Order #{{ $o->id }} · {{ $o->contact_name }} · {{ $o->phone }}</strong>
                <span class="badge">{{ $o->status_label }}</span>
            </div>
            <p class="muted" style="margin:.2rem 0 .5rem">
                {{ $o->created_at->format('M j, Y g:i A') }} ·
                <span class="tag">{{ $o->is_delivery ? 'Delivery' : 'Pickup' }}</span> ·
                Wants it: {{ $o->pickup_time }} · {{ $o->user->email }}
                @if($o->note) · Note: {{ $o->note }} @endif
            </p>

            @if($o->is_delivery)
                <p style="margin:0 0 .5rem"><strong>Deliver to:</strong> {{ $o->delivery_address }}</p>
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

            {{-- action buttons depend on where the order is --}}
            <div class="acts" style="margin-top:.8rem">
                @if($o->status === 'pending')
                    <form method="post" action="{{ route('admin.orders.act', [$o, 'accept']) }}">@csrf
                        <button class="btn sm">Accept order</button>
                    </form>
                    <form method="post" action="{{ route('admin.orders.act', [$o, 'decline']) }}" onsubmit="return confirm('Decline this order?')">@csrf
                        <button class="btn ghost sm">Decline</button>
                    </form>

                @elseif($o->status === 'accepted')
                    @if($o->is_delivery)
                        <form method="post" action="{{ route('admin.orders.act', [$o, 'ontheway']) }}">@csrf
                            <button class="btn sm">Mark on the way</button>
                        </form>
                    @else
                        <form method="post" action="{{ route('admin.orders.act', [$o, 'ready']) }}">@csrf
                            <button class="btn sm">Ready for pickup</button>
                        </form>
                    @endif
                    <form method="post" action="{{ route('admin.orders.act', [$o, 'finish']) }}">@csrf
                        <button class="btn ghost sm">Finished</button>
                    </form>
                    <form method="post" action="{{ route('admin.orders.act', [$o, 'decline']) }}" onsubmit="return confirm('Cancel this order?')">@csrf
                        <button class="btn danger sm">Cancel</button>
                    </form>

                @elseif($o->needs_attention)
                    <form method="post" action="{{ route('admin.orders.act', [$o, 'finish']) }}">@csrf
                        <button class="btn sm">Finished</button>
                    </form>
                    <form method="post" action="{{ route('admin.orders.act', [$o, 'remind']) }}">@csrf
                        <button class="btn ghost sm">Remind customer</button>
                    </form>
                    @if($o->reminded_at)
                        <span class="muted">Customer notified {{ $o->reminded_at->diffForHumans() }}</span>
                    @endif
                @endif
            </div>
        </div>
    @endforeach
@endsection
