<?php

namespace App\Http\Controllers;

use App\Coupon;
use Illuminate\Http\Request;
use App\Http\Requests\CouponFormRequest;
use Carbon\Carbon;
use App\Mail\CouponMailer;
use Mail;
use App\User;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $coupons = Coupon::all();
      return view('coupon.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponFormRequest $request)
    {
       Coupon::create([
         'coupon_name'     => strToUpper($request->coupon_name),
         'coupon_discount' => $request->coupon_discount,
         'valid_till'      => $request->valid_till,
         'created_at'      => Carbon::now(),
       ]);

       $coupon_name = $request->coupon_name;
       $users = User::where('role', 2)->get();

       foreach($users as $user)
       {
         Mail::to($user->email)->send(new CouponMailer($coupon_name));
       }
       return back()->withSuccess('Coupon Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
      return view('coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
       $coupon->coupon_name = strToUpper($request->coupon_name);
       $coupon->coupon_discount = $request->coupon_discount;
       $coupon->valid_till = $request->valid_till;
       $coupon->save();
       return redirect('coupon')->withSuccess('Coupon Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon, Request $request)
    {
      Coupon::findOrFail($request->id)->delete();
      return back()->withErrors('Coupon Deleeted');
    }
}
