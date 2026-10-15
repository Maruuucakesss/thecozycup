<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /** action => allowed current statuses, new status, audit action, wording */
    private const MOVES = [
        'accept'   => ['from' => ['pending'],                             'to' => 'accepted',   'log' => 'order.accepted',   'text' => 'Accepted'],
        'decline'  => ['from' => ['pending', 'accepted'],                 'to' => 'cancelled',  'log' => 'order.declined',   'text' => 'Declined'],
        'ontheway' => ['from' => ['accepted'],                            'to' => 'on_the_way', 'log' => 'order.on_the_way', 'text' => 'Marked on the way'],
        'ready'    => ['from' => ['accepted'],                            'to' => 'ready',      'log' => 'order.ready',      'text' => 'Marked ready for pickup'],
        'finish'   => ['from' => ['accepted', 'on_the_way', 'ready'],     'to' => 'completed',  'log' => 'order.finished',   'text' => 'Finished'],
    ];

    public function index(Request $r)
    {
        $tabs = [
            'active'    => ['Active', ['pending', 'accepted', 'on_the_way', 'ready']],
            'pending'   => ['Pending', ['pending']],
            'completed' => ['Completed', ['completed']],
            'cancelled' => ['Cancelled', ['cancelled']],
            'all'       => ['All', null],
        ];
        $tab = array_key_exists($r->query('s'), $tabs) ? $r->query('s') : 'active';

        $q = Order::with(['items', 'user'])->latest('id');
        if ($tabs[$tab][1]) {
            $q->whereIn('status', $tabs[$tab][1]);
        }

        return view('admin.orders', [
            'orders'  => $q->take(100)->get(),
            'tabs'    => $tabs,
            'tab'     => $tab,
            'pending' => Order::where('status', 'pending')->count(),
        ]);
    }

    public function act(Request $r, Order $order, string $action)
    {
        $who = "order #{$order->id} ({$order->contact_name})";

        if ($action === 'remind') {
            if (!$order->needs_attention) {
                return back()->with('msg', 'Only orders that are on the way or ready can be reminded.');
            }
            $order->update(['reminded_at' => now()]);
            AuditLog::record('order.reminded', "Reminded customer about $who", $order);

            return back()->with('msg', 'Customer reminded.');
        }

        $move = self::MOVES[$action] ?? abort(404);

        if (!in_array($order->status, $move['from'], true)) {
            return back()->with('msg', 'That order can no longer be changed this way.');
        }
        if ($action === 'ontheway' && !$order->is_delivery) {
            return back()->with('msg', 'Only delivery orders can be marked on the way.');
        }
        if ($action === 'ready' && $order->is_delivery) {
            return back()->with('msg', 'Only pickup orders can be marked ready for pickup.');
        }

        $old = $order->status;
        $order->update([
            'status'      => $move['to'],
            'reminded_at' => in_array($move['to'], ['on_the_way', 'ready'], true) ? now() : $order->reminded_at,
        ]);
        AuditLog::record($move['log'], "{$move['text']} $who ($old → {$move['to']})", $order);

        return back()->with('msg', "Order #{$order->id}: {$order->status_label}.");
    }
}
