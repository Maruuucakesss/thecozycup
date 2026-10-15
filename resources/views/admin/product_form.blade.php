@extends('layouts.admin')

@section('content')
    <a class="btn ghost sm" href="{{ route('admin.products') }}">← Back to products</a>
    <h1 style="margin-top:.5rem">{{ $product->exists ? 'Edit product' : 'Add product' }}</h1>

    <form method="post" enctype="multipart/form-data" class="box"
          action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}">
        @csrf
        @if($product->exists) @method('PUT') @endif

        <label>Name
            <input name="name" required value="{{ old('name', $product->name) }}">
        </label>

        <label>Category
            <select name="category_id">
                @foreach($cats as $c)
                    <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id) == $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
        </label>

        <label>Description
            <input name="description" maxlength="255" value="{{ old('description', $product->description) }}">
        </label>

        <label>Photo (JPG, PNG or WebP, up to 3 MB)
            <input type="file" name="image" accept="image/jpeg,image/png,image/webp">
        </label>
        @if($product->image_url)
            <div class="pname">
                <img class="mini" src="{{ $product->image_url }}" alt="">
                <label class="opt" style="width:auto">
                    <span><input type="checkbox" name="remove_image" value="1"> Remove current photo</span>
                </label>
            </div>
        @endif

        @php $drink = (int) old('is_drink', $product->is_drink); @endphp
        <label>Type
            <select name="is_drink" id="t">
                <option value="1" @selected($drink == 1)>Drink (cold 16 oz / hot 12 oz, with add-ons)</option>
                <option value="0" @selected($drink == 0)>Food (single price)</option>
            </select>
        </label>

        <div id="d" style="display:grid;gap:.9rem">
            <label>Cold 16 oz price (₱)
                <input name="price_cold" type="number" step="0.01" min="0" value="{{ old('price_cold', $product->price_cold) }}">
            </label>
            <label>Hot 12 oz price (₱)
                <input name="price_hot" type="number" step="0.01" min="0" value="{{ old('price_hot', $product->price_hot) }}">
            </label>
            <p class="muted" style="margin:0">Leave one blank if the drink is only served cold or only hot.</p>
        </div>

        <div id="f">
            <label>Price (₱)
                <input name="price" type="number" step="0.01" min="0" value="{{ old('price', $product->is_drink ? '' : $product->price) }}">
            </label>
        </div>

        <label class="opt">
            <span><input type="checkbox" name="featured" value="1" @checked(old('featured', $product->featured))> Show on home page (featured)</span>
        </label>
        <label class="opt">
            <span><input type="checkbox" name="active" value="1" @checked(old('active', $product->active))> Available to customers</span>
        </label>

        <button class="btn">Save product</button>
    </form>

    <script>
        var t = document.getElementById('t');
        function show() {
            var drink = t.value === '1';
            document.getElementById('d').style.display = drink ? 'grid' : 'none';
            document.getElementById('f').style.display = drink ? 'none' : 'block';
        }
        t.onchange = show;
        show();
    </script>
@endsection
