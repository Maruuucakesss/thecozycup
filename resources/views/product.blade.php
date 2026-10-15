@extends('layouts.app')
@section('title', $product->name)

@section('content')
    <section class="wrap">
        <a class="btn ghost sm" href="{{ route('menu') }}">← Back to menu</a>

        <div class="product">
            <div class="pimg">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                @else
                    <div class="ph"><span class="mug" aria-hidden="true"></span></div>
                @endif
            </div>

            <div class="pinfo">
                <h1>{{ $product->name }}</h1>
                <p class="price">{{ $product->price_label }}</p>
                <p class="muted">{{ $product->description }}</p>

                @guest
                    <p>Please log in to order this item.</p>
                    <div class="acts">
                        <a class="btn" href="{{ route('login') }}">Log in to order</a>
                        <a class="btn ghost" href="{{ route('register') }}">Create account</a>
                    </div>
                @else
                    <form method="post" action="{{ route('cart.add') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        @if($product->is_drink)
                            <fieldset>
                                <legend>Serving</legend>
                                @php $first = true; @endphp
                                @foreach(['cold' => 'Cold 16 oz', 'hot' => 'Hot 12 oz'] as $k => $label)
                                    @if(!is_null($product->{'price_' . $k}))
                                        <label class="opt">
                                            <span><input type="radio" name="temp" value="{{ $k }}" @checked($first)> {{ $label }}</span>
                                            <span class="muted">{{ peso($product->{'price_' . $k}) }}</span>
                                        </label>
                                        @php $first = false; @endphp
                                    @endif
                                @endforeach
                            </fieldset>

                            @foreach($groups as $g => $opts)
                                @php $multi = $opts->first()->is_multi; @endphp
                                <fieldset>
                                    <legend>{{ $g }}</legend>
                                    @foreach($opts as $o)
                                        <label class="opt">
                                            <span>
                                                <input type="{{ $multi ? 'checkbox' : 'radio' }}"
                                                       name="opt[{{ $g }}]{{ $multi ? '[]' : '' }}"
                                                       value="{{ $o->id }}"
                                                       @checked(!$multi && $loop->first)>
                                                {{ $o->name }}
                                            </span>
                                            <span class="muted">{{ $o->price_add > 0 ? '+' . peso($o->price_add) : '' }}</span>
                                        </label>
                                    @endforeach
                                </fieldset>
                            @endforeach
                        @endif

                        <label>Quantity
                            <input type="number" name="qty" value="1" min="1" max="10">
                        </label>
                        <button class="btn block">Add to cart</button>
                    </form>
                @endguest
            </div>
        </div>
    </section>
@endsection
