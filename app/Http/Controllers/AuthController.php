<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //register user
    public function signup(Request $request) {
        //dd($request->username); //die and dump - useful for debugging
        //validate
        $fields = $request->validate([
            'username' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email', 'unique:users'],
            'password' => ['required', 'min:3', 'confirmed']
        ]);
        
        //register
        $user = User::create($fields);

        //login
        Auth::login($user);

        //trigger the verify email
        event(new Registered($user));

        //redirect new user to homepage once logged in
        return redirect()->route('dashboard');
    }

    //verify email notice
    public function verifyNotice(){
        return view('auth.verify-email');
    }

    //email verification handler
    public function verifyEmail (EmailVerificationRequest $request){
        $request->fulfill();

        return redirect()->route('dashboard');
    }

    //resending verification email
    public function verifyHandler (Request $request) {
        $request->user()->sendEmailVerificationNotification();
     
        return back()->with('message', 'Verification link sent!');
    }

    //login user
    public function login(Request $request) {
        //validate
        $fields = $request->validate([
            'email' => ['required', 'max:255', 'email'],
            'password' => ['required']
        ]);

        //try to login the user
        if(Auth::attempt($fields, $request->remember)) {
            return redirect()->intended('dashboard');
        } else{
            return back()->withErrors([
                'failed' => 'Wrong credentials.'
            ]);
        }
    }

    //logout user
    public function logout(Request $request) {
        Auth::logout();

        //invalidate the session of the user
        $request->session()->invalidate();

        //regenerate CSRF Token
        $request->session()->regenerateToken();

        //redirect to home
        return redirect('/');
    }
}
