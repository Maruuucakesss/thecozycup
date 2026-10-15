<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    private function items(Request $r)
    {
        $r->user()->purgeUnavailableCart();

        return $r->user()->cartItems()->with('product')->get();
    }

    public function show(Request $r)
    {
        $items = $this->items($r);

        return $items->isEmpty() ? redirect()->route('cart') : view('checkout', compact('items'));
    }

    public function place(Request $r)
    {
        $d = $r->validate([
            'name'       => 'required|max:80',
            'phone'      => ['required', 'regex:/^[0-9+\- ]{7,20}$/'],
            'order_type' => 'required|in:pickup,delivery',
            'address'    => 'required_if:order_type,delivery|nullable|max:255',
            'pickup'     => 'required|in:ASAP,In 15 minutes,In 30 minutes,In 1 hour',
            'note'       => 'nullable|max:255',
        ], [
            'phone.regex'           => 'Enter a valid phone number.',
            'address.required_if'   => 'Please enter your delivery address.',
        ]);

        $items = $this->items($r);
        if ($items->isEmpty()) {
            return redirect()->route('cart');
        }

        $delivery = $d['order_type'] === 'delivery';
        $fee      = $delivery ? Setting::deliveryFee() : 0;
        $subtotal = $items->sum(fn($i) => $i->unit_price * $i->qty);

        $order = DB::transaction(function () use ($r, $d, $items, $delivery, $fee, $subtotal) {
            $o = $r->user()->orders()->create([
                'total'            => $subtotal + $fee,
                'contact_name'     => $d['name'],
                'phone'            => $d['phone'],
                'order_type'       => $d['order_type'],
                'delivery_address' => $delivery ? $d['address'] : null,
                'delivery_fee'     => $fee,
                'pickup_time'      => $d['pickup'],
                'note'             => $d['note'] ?? null,
            ]);

            foreach ($items as $i) {
                $o->items()->create([
                    'product_name' => $i->product->name,
                    'options_text' => $i->options_text,
                    'qty'          => $i->qty,
                    'unit_price'   => $i->unit_price,
                ]);
            }
            $r->user()->cartItems()->delete();

            return $o;
        });

        AuditLog::record('order.placed', "New {$order->order_type} order #{$order->id} from {$order->contact_name} (" . peso($order->total) . ')', $order);

        return redirect()->route('orders')->with('msg', 'Order #' . $order->id . " placed. We'll update you here once it's accepted.");
    }
}
