<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Webuser;
use App\Models\Bloodcamps;
use App\Models\Bloodreq;
use App\Models\User;

class BackendController extends Controller
{
    public function dashboard(){
        $bloodreq = Bloodreq::count();
        $bdcamps = Bloodcamps::count();
        $webusers = Webuser::count();
        return view('backend.dashboard',compact('bloodreq','bdcamps','webusers'));
    }

    public function login(){
        return view('backend.login');
    }

    public function signin(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email', $email)->first();

        if ($user) {
            if (Hash::check($password, $user->password)) {
                Auth::login($user);
                return redirect()->intended('/dashboard');
            } else {
                return redirect()->back()->withErrors(['password' => 'Invalid Password'])->withInput();
            }
        } else {
            return redirect()->back()->withErrors(['email' => 'Invalid Email'])->withInput();
        }

    }

    public function logout(){
        Auth::logout();
        return redirect('/loginbackend');
    }
}
