<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ChangePassword;
use Hash;
use Auth;
use App\User;
use App\Mail\ChangePasswordMailer;
use Illuminate\Support\Facades\Mail;


class ProfileController extends Controller
{
   public function __construct()
   {
     $this->middleware('auth');
     $this->middleware('verified');
     $this->middleware('password.confirm');
   }

   function profile_edit()
   {
    return view('profile.changepassword');
   }

   function change_pass(ChangePassword $request)
   {
     $db_password = Auth::user()->password;
     $old_password = $request->old_password;

     if(Hash::check($old_password, $db_password))
     {
      if($old_password == $request->password)
      {
        return back()->withErrors('Old and new password cannot be same');
      }
      else
      {
        User::findOrFail(Auth::id())->update([
          'password' => Hash::make($request->password),
        ]);

        Mail::to(Auth::user()->email)->send(new ChangePasswordMailer());
        return back()->withSuccess('Password Changed Successfully');
      }
     }
     else
     {
        return back()->withErrors('Old Password is incorrect');
     }

   }
}
