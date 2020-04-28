<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Auth;
use Carbon\Carbon;
use App\User;

class GithubController extends Controller
{
  /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        // $user = Socialite::driver('github')->user();
        $user = Socialite::driver('github')->user();

        // if(User::where('email', $user->getEmail())->exists())
        // {
        //   echo 'ase';
        // }
        // else
        // {
        //   echo 'nai';
        // }

     // if(Auth::attempt(['email' => $user->getEmail(), 'password' => 'abc@1234']))
     // {
     //   return redirect('/home/customer');
     // }
     // else
     // {
     //   User::insert([
     //     'name'         =>$user->getNickname(),
     //     'email'        =>$user->getEmail(),
     //     'password'     =>bcrypt('abc@1234'),
     //     'role'         => 2,
     //     'created_at'   =>Carbon::now()
     //   ]);
     // }
 }
}
