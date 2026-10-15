@extends('layouts.app')
@section('title', 'Your cart')

@section('content')
    <section class="wrap mid">
        <h1>Your cart</h1>

        @if($items->isEmpty())
            <p class="muted">Your cart is empty.</p>
            <a class="btn" href="{{ route('menu') }}">Browse the menu</a>
        @else
            <table class="cart">
                <tr>
                    <th>Item</th><th>Qty</th><th class="num">Price</th><th class="num">Subtotal</th><th></th>
                </tr>
                @foreach($items as $i)
                    <tr>
                        <td>{{ $i->product->name }}<small>{{ $i->options_text }}</small></td>
                        <td>
                            <form method="post" action="{{ route('cart.update', $i->id) }}" class="qty">
                                @csrf @method('PATCH')
                                <input type="number" name="qty" value="{{ $i->qty }}" min="0" max="10" aria-label="Quantity">
                                <button class="link">Update</button>
                            </form>
                        </td>
                        <td class="num">{{ peso($i->unit_price) }}</td>
                        <td class="num">{{ peso($i->unit_price * $i->qty) }}</td>
                        <td>
                            <form method="post" action="{{ route('cart.remove', $i->id) }}">
                                @csrf @method('DELETE')
                                <button class="link">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>

            <div class="total">
                <a class="btn ghost" href="{{ route('menu') }}">Add more</a>
                <span>Total <strong>{{ peso($items->sum(fn($i) => $i->unit_price * $i->qty)) }}</strong></span>
                <a class="btn" href="{{ route('checkout') }}">Checkout</a>
            </div>
        @endif
    </section>
@endsection
