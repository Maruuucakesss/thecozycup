<?php
namespace App\Http\Controllers;
use App\Models\{Option, Product};
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
class CartController extends Controller
{
    public function index(Request $r)
    {
        if ($r->user()->purgeUnavailableCart()) session()->now('msg','Some items were removed because they are no longer available.');
        return view('cart', ['items'=>$r->user()->cartItems()->with('product')->get()]);
    }
    public function add(Request $r)
    {
        $r->validate(['product_id'=>'required|exists:products,id','qty'=>'required|integer|min:1|max:10','temp'=>'nullable|in:cold,hot']);
        $p = Product::available()->findOrFail($r->product_id);
        if ($p->is_drink) { $t = $r->temp === 'hot' ? 'hot' : 'cold'; $base = $p->{'price_'.$t}; $names = [$t==='hot' ? 'Hot 12 oz' : 'Cold 16 oz']; }
        else { $base = $p->price; $names = []; }
        if (is_null($base)) return back()->with('msg','That serving is not available.');
        $price = (float)$base;
        if ($p->is_drink) {
            $ids = array_map('intval', Arr::flatten((array)$r->input('opt', [])));
            if ($ids) {
                $o = Option::whereIn('id',$ids)->where('active',true)->orderBy('sort')->orderBy('id')->get();
                $price += (float)$o->sum('price_add'); $names = array_merge($names, $o->pluck('name')->all());
            }
        }
        $r->user()->cartItems()->create(['product_id'=>$p->id,'qty'=>$r->qty,'options_text'=>implode(', ',$names),'unit_price'=>$price]);
        return redirect()->route('menu')->with('msg', $p->name.' added to cart');
    }
    public function update(Request $r, $id)
    {
        $item = $r->user()->cartItems()->findOrFail($id); $q = (int)$r->qty;
        $q < 1 ? $item->delete() : $item->update(['qty'=>min($q,10)]);
        return redirect()->route('cart');
    }
    public function remove(Request $r, $id){ $r->user()->cartItems()->findOrFail($id)->delete(); return redirect()->route('cart'); }
}
