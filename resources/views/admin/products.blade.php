@extends('layouts.admin')

@section('content')
    <div class="row" style="margin-top:0">
        <h1>Products</h1>
        <a class="btn" href="{{ route('admin.products.create') }}">Add product</a>
    </div>

    <div class="tscroll">
    <table>
        <tr><th>Name</th><th>Category</th><th>Price</th><th>Status</th><th></th></tr>
        @foreach($rows as $p)
            <tr class="{{ $p->active ? '' : 'off' }}">
                <td>
                    <div class="pname">
                        @if($p->image_url)
                            <img class="mini" src="{{ $p->image_url }}" alt="">
                        @else
                            <span class="mini"></span>
                        @endif
                        <span>{{ $p->name }} @if($p->featured)<span class="tag">Featured</span>@endif</span>
                    </div>
                </td>
                <td>{{ $p->category->name }}</td>
                <td>{{ $p->price_label }}</td>
                <td><span class="tag {{ $p->active ? '' : 'off' }}">{{ $p->active ? 'Available' : 'Hidden' }}</span></td>
                <td>
                    <div class="acts">
                        <form method="post" action="{{ route('admin.products.toggle', $p) }}">
                            @csrf @method('PATCH')
                            <button class="btn ghost sm">{{ $p->active ? 'Disable' : 'Enable' }}</button>
                        </form>
                        <a class="btn ghost sm" href="{{ route('admin.products.edit', $p) }}">Edit</a>
                        <form method="post" action="{{ route('admin.products.destroy', $p) }}" onsubmit="return confirm('Delete this product permanently?')">
                            @csrf @method('DELETE')
                            <button class="btn danger sm">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
    </div>
@endsection
