@extends('layouts.admin')
@section('content')
<h1>Add-ons</h1><p class="muted">Add-ons appear on drinks. Options with the same group are shown together. Use the same "Pick one / Pick many" setting for every option in a group. Disabled add-ons are hidden from customers.</p>
<datalist id="g">@foreach($groups as $g)<option value="{{ $g }}">@endforeach</datalist>
<form method="post" action="{{ route('admin.options.store') }}" class="order wide">@csrf<strong>New add-on</strong><div class="rowform" style="margin-top:.6rem">
<input name="grp" list="g" required placeholder="Group"><input name="name" required placeholder="Name"><input name="price_add" type="number" step="0.01" min="0" value="0"><select name="is_multi"><option value="0">Pick one</option><option value="1">Pick many</option></select><button class="btn sm">Add</button></div></form>
@foreach($rows as $o)<form method="post" action="{{ route('admin.options.act',$o) }}" class="order wide" style="{{ $o->active?'':'opacity:.6' }}">@csrf
<div class="rowform"><input name="grp" list="g" required value="{{ $o->grp }}"><input name="name" required value="{{ $o->name }}"><input name="price_add" type="number" step="0.01" min="0" value="{{ $o->price_add }}">
<select name="is_multi"><option value="0">Pick one</option><option value="1" @selected($o->is_multi)>Pick many</option></select>
<div class="acts"><button class="btn sm" name="a" value="save">Save</button><button class="btn ghost sm" name="a" value="toggle">{{ $o->active?'Disable':'Enable' }}</button>
<button class="btn danger sm" name="a" value="delete" onclick="return confirm('Delete this add-on?')">Delete</button></div></div></form>@endforeach
@endsection
