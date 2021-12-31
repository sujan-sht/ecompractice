<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function githubRedirect(){
        // dd('hello');
        return Socialite::driver('github')->redirect();
    }
    public function callback(){
        $githubUser = Socialite::driver('github')->stateless()->user();
        // dd($githubUser->getId());
        $user = User::where('email',$githubUser->email)->first();
        // dd($user);
        if (! $user) {
            $user = User::create([
                'name' => $githubUser->nickname,
                'email' => $githubUser->email,
                'github_id' => $githubUser->getId(),
                'auth_type' => 'github',
            ]);
        }
        else if($user->email && $user->github_id){
            // dd('hello');
            // dd($user);
            Auth::login($user);
            return view('admin.dashboard')->with('status','Successfully logged in');
        }
        else{
            return redirect()->route('login')->with('error','Github id or Email already exists');

        } 
        Auth::login($user);

        return redirect('/dashboard');
    }
}
