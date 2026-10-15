<?php
namespace App\Http\Controllers;
use App\Models\{Category, Option, Product};
use Illuminate\Http\Request;
class ShopController extends Controller
{
    public function home(){ return view('home', ['featured'=>Product::available()->where('featured',true)->take(4)->get()]); }
    public function menu(Request $r)
    {
        $q = Product::available()->orderBy('category_id')->orderBy('id');
        if ($r->cat) $q->whereHas('category', fn($c) => $c->where('slug', $r->cat));
        return view('menu', ['cats'=>Category::all(), 'items'=>$q->get(), 'slug'=>$r->cat]);
    }
    public function product(Product $product)
    {
        abort_unless($product->active, 404);
        $groups = $product->is_drink ? Option::where('active',true)->orderBy('sort')->orderBy('id')->get()->groupBy('grp') : collect();
        return view('product', compact('product','groups'));
    }
}
