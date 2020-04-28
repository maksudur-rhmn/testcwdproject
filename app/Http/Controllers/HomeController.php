<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('checkRole');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        User::all()->except(Auth::id());
        $logged = Auth::id();
        $users = User::where('id', '!=', $logged)->orderBy('id', 'desc')->get();
        $total_users = User::count();
        return view('home', compact('users', 'total_users'));
    }
}
