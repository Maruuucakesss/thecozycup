<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function index(Request $r)
    {
        $group = $r->query('g');
        $q = AuditLog::with('user')->latest('id');

        if (in_array($group, ['order', 'product', 'option', 'settings', 'account'], true)) {
            $q->where('action', 'like', $group . '.%');
        }

        return view('admin.audit', [
            'logs'  => $q->simplePaginate(25)->withQueryString(),
            'group' => $group,
        ]);
    }
}
