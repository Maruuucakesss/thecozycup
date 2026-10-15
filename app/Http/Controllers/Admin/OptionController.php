<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index()
    {
        $rows = Option::orderBy('sort')->orderBy('id')->get();

        return view('admin.options', ['rows' => $rows, 'groups' => $rows->pluck('grp')->unique()]);
    }

    public function store(Request $r)
    {
        $d = $this->data($r);
        $d['sort'] = (Option::max('sort') ?? 0) + 1;
        $option = Option::create($d);
        AuditLog::record('option.created', 'Created add-on “' . $option->name . '” (' . $option->grp . ')', $option);

        return back()->with('msg', 'Add-on added.');
    }

    public function act(Request $r, Option $option)
    {
        if ($r->a === 'toggle') {
            $option->update(['active' => !$option->active]);
            AuditLog::record(
                $option->active ? 'option.enabled' : 'option.disabled',
                ($option->active ? 'Enabled' : 'Disabled') . ' add-on “' . $option->name . '”',
                $option
            );
            $msg = 'Availability updated.';
        } elseif ($r->a === 'delete') {
            AuditLog::record('option.deleted', 'Deleted add-on “' . $option->name . '”', $option);
            $option->delete();
            $msg = 'Add-on deleted.';
        } else {
            $d = $this->data($r);
            $before = $option->getOriginal();
            $option->update($d);
            AuditLog::record('option.updated', 'Updated add-on “' . $option->name . '” (' . AuditLog::diff($before, $d) . ')', $option);
            $msg = 'Add-on saved.';
        }

        return back()->with('msg', $msg);
    }

    private function data(Request $r): array
    {
        return $r->validate([
            'grp'       => 'required|max:40',
            'name'      => 'required|max:60',
            'price_add' => 'required|numeric|min:0',
            'is_multi'  => 'required|boolean',
        ]);
    }
}
