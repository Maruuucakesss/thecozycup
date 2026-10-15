<?php
namespace App\Http\Controllers;
use App\Models\{AuditLog, User};
use App\Support\StrongPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash};
class AuthController extends Controller
{
    public function login(Request $r)
    {
        $c = $r->validate(['email'=>'required|email','password'=>'required']);
        if (!Auth::attempt(['email'=>strtolower($c['email']),'password'=>$c['password']])) return back()->withInput($r->only('email'))->withErrors(['email'=>'Email or password is incorrect.']);
        $r->session()->regenerate();
        if (Auth::user()->isAdmin()) { AuditLog::record('account.login', 'Admin logged in: '.Auth::user()->email); }
        return Auth::user()->isAdmin() ? redirect()->intended(route('admin.orders')) : redirect()->intended(route('menu'));
    }
    public function register(Request $r)
    {
        $d = $r->validate(['name'=>'required|max:80','email'=>'required|email|max:120|unique:users,email','password'=>StrongPassword::rules(),'terms'=>'accepted']);
        $u = User::create(['name'=>$d['name'],'email'=>strtolower($d['email']),'password'=>Hash::make($d['password'])]);
        Auth::login($u); $r->session()->regenerate();
        return redirect()->route('menu')->with('msg','Welcome, '.$u->name.'!');
    }
    public function logout(Request $r)
    {
        if (Auth::user()?->isAdmin()) { AuditLog::record('account.logout', 'Admin logged out: '.Auth::user()->email); }
        Auth::logout(); $r->session()->invalidate(); $r->session()->regenerateToken();
        return redirect()->route('home');
    }
}
