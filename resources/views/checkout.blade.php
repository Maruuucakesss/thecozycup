@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
    @php
        $subtotal = $items->sum(fn($i) => $i->unit_price * $i->qty);
        $fee = \App\Models\Setting::deliveryFee();
        $type = old('order_type', 'pickup');
    @endphp

    <section class="wrap two">
        <div>
            <h1>Checkout</h1>

            <form method="post" action="{{ route('checkout.place') }}" class="box">
                @csrf

                @if($errors->any())
                    <p class="err">{{ $errors->first() }}</p>
                @endif

                <div class="seg" role="radiogroup" aria-label="How do you want your order?">
                    <label>
                        <input type="radio" name="order_type" value="pickup" @checked($type === 'pickup')>
                        <span class="segbox">Pickup <small>Free · collect in store</small></span>
                    </label>
                    <label>
                        <input type="radio" name="order_type" value="delivery" @checked($type === 'delivery')>
                        <span class="segbox">Delivery <small>+{{ peso($fee) }} · to your address</small></span>
                    </label>
                </div>

                <label id="addrBox" hidden>Delivery address
                    <textarea id="address" name="address" rows="2" maxlength="255"
                              placeholder="House/Unit no., Street, Barangay, Landmark">{{ old('address') }}</textarea>
                </label>

                <label>Name for the order
                    <input name="name" required value="{{ old('name', auth()->user()->name) }}">
                </label>
                <label>Phone
                    <input name="phone" required value="{{ old('phone') }}">
                </label>
                <label>When do you want it?
                    <select name="pickup">
                        @foreach(['ASAP', 'In 15 minutes', 'In 30 minutes', 'In 1 hour'] as $t)
                            <option @selected(old('pickup') == $t)>{{ $t }}</option>
                        @endforeach
                    </select>
                </label>
                <label>Note (optional)
                    <textarea name="note" rows="2" maxlength="255">{{ old('note') }}</textarea>
                </label>
                <button class="btn block">Place order</button>
            </form>
        </div>

        <div>
            <h2>Summary</h2>
            <table>
                @foreach($items as $i)
                    <tr>
                        <td>{{ $i->qty }} × {{ $i->product->name }}<small>{{ $i->options_text }}</small></td>
                        <td class="num">{{ peso($i->unit_price * $i->qty) }}</td>
                    </tr>
                @endforeach
                <tr><td>Subtotal</td><td class="num">{{ peso($subtotal) }}</td></tr>
                <tr id="feeRow" data-fee="{{ $fee }}" hidden><td>Delivery fee</td><td class="num">{{ peso($fee) }}</td></tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td class="num"><strong id="grand" data-sub="{{ $subtotal }}">{{ peso($subtotal) }}</strong></td>
                </tr>
            </table>
        </div>
    </section>

    <script>
        (function () {
            var radios = document.querySelectorAll('input[name=order_type]');
            var addrBox = document.getElementById('addrBox');
            var addr = document.getElementById('address');
            var feeRow = document.getElementById('feeRow');
            var grand = document.getElementById('grand');
            var sub = parseFloat(grand.dataset.sub);
            var fee = parseFloat(feeRow.dataset.fee);

            function peso(n) {
                var whole = n % 1 === 0;
                return '₱' + n.toLocaleString('en-PH', {
                    minimumFractionDigits: whole ? 0 : 2,
                    maximumFractionDigits: whole ? 0 : 2
                });
            }

            function sync() {
                var delivery = document.querySelector('input[name=order_type]:checked').value === 'delivery';
                addrBox.hidden = !delivery;
                addr.required = delivery;
                feeRow.hidden = !delivery;
                grand.textContent = peso(sub + (delivery ? fee : 0));
            }

            radios.forEach(function (r) { r.addEventListener('change', sync); });
            sync();
        })();
    </script>
@endsection
