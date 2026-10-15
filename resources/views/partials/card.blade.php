<a class="card" href="{{ route('product', $p) }}">
    @if($p->image_url)
        <img class="thumb" src="{{ $p->image_url }}" alt="{{ $p->name }}" loading="lazy">
    @else
        <div class="thumb ph"><span class="mug" aria-hidden="true"></span></div>
    @endif
    <div class="info">
        <h3>{{ $p->name }}</h3>
        <p>{{ $p->description }}</p>
        <span class="price">{{ $p->price_label }}</span>
    </div>
</a>
