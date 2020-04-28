<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
   function __construct()
   {
     $this->middleware('auth');
     $this->middleware('verified');
   }

   function index()
   {
     return view('customer_dashboard.index');
   }
}
