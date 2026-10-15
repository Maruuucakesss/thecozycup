<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function edit()
    {
        return view('admin.settings', ['fee' => Setting::deliveryFee()]);
    }

    public function update(Request $r)
    {
        $d = $r->validate(['delivery_fee' => 'required|numeric|min:0|max:5000']);

        $old = Setting::deliveryFee();
        $new = round((float) $d['delivery_fee'], 2);

        Setting::put('delivery_fee', $new);

        if (abs($old - $new) > 0.001) {
            AuditLog::record('settings.updated', 'Changed delivery fee: ' . peso($old) . ' → ' . peso($new));
        }

        return back()->with('msg', 'Settings saved.');
    }
}
