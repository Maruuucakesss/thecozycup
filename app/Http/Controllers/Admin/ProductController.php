<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $rows = Product::with('category')->orderBy('category_id')->orderBy('name')->get();

        return view('admin.products', compact('rows'));
    }

    public function create()
    {
        $product = new Product(['is_drink' => true, 'active' => true, 'category_id' => 1]);

        return view('admin.product_form', ['product' => $product, 'cats' => Category::all()]);
    }

    public function edit(Product $product)
    {
        return view('admin.product_form', ['product' => $product, 'cats' => Category::all()]);
    }

    public function store(Request $r)
    {
        return $this->save($r);
    }

    public function update(Request $r, Product $product)
    {
        return $this->save($r, $product);
    }

    public function toggle(Product $product)
    {
        $product->update(['active' => !$product->active]);
        AuditLog::record(
            $product->active ? 'product.enabled' : 'product.disabled',
            ($product->active ? 'Enabled' : 'Disabled') . ' product “' . $product->name . '”',
            $product
        );

        return back()->with('msg', 'Availability updated.');
    }

    public function destroy(Product $product)
    {
        AuditLog::record('product.deleted', 'Deleted product “' . $product->name . '”', $product);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return back()->with('msg', 'Product deleted.');
    }

    private function save(Request $r, ?Product $p = null)
    {
        $d = $r->validate([
            'name'        => 'required|max:100',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|max:255',
            'is_drink'    => 'required|boolean',
            'price'       => 'nullable|numeric|min:0',
            'price_cold'  => 'nullable|numeric|min:0',
            'price_hot'   => 'nullable|numeric|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);
        unset($d['image']);

        if ($d['is_drink']) {
            if (($d['price_cold'] ?? null) === null && ($d['price_hot'] ?? null) === null) {
                return back()->withInput()->withErrors(['price_cold' => 'Enter a cold or hot price (or both).']);
            }
            $d['price'] = 0;
        } else {
            if (($d['price'] ?? null) === null) {
                return back()->withInput()->withErrors(['price' => 'Enter a price.']);
            }
            $d['price_cold'] = $d['price_hot'] = null;
        }

        $d['featured'] = $r->boolean('featured');
        $d['active']   = $r->boolean('active');

        // Photo: upload a new one, or remove the current one.
        if ($r->hasFile('image')) {
            if ($p && $p->image) {
                Storage::disk('public')->delete($p->image);
            }
            $d['image'] = $r->file('image')->store('products', 'public');
        } elseif ($p && $p->image && $r->boolean('remove_image')) {
            Storage::disk('public')->delete($p->image);
            $d['image'] = null;
        }

        if ($p) {
            $before = $p->getOriginal();
            $p->update($d);
            AuditLog::record('product.updated', 'Updated product “' . $p->name . '” (' . AuditLog::diff($before, $d) . ')', $p);
        } else {
            $new = Product::create($d);
            AuditLog::record('product.created', 'Created product “' . $new->name . '”', $new);
        }

        return redirect()->route('admin.products')->with('msg', 'Product saved.');
    }
}
