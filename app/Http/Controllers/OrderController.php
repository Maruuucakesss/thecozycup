<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class OrderController extends Controller
{
    public function index(Request $r){ return view('orders', ['orders'=>$r->user()->orders()->with('items')->latest('id')->get()]); }
}
