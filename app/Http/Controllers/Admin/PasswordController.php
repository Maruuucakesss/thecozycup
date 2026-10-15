<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Support\StrongPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class PasswordController extends Controller
{
    public function edit(){ return view('admin.password'); }
    public function update(Request $r)
    {
        $d = $r->validate(['old'=>'required|current_password','new'=>StrongPassword::rules()]);
        $r->user()->update(['password'=>Hash::make($d['new'])]);
        AuditLog::record('account.password_changed', 'Admin changed their password');
        return back()->with('msg','Password changed.');
    }
}
