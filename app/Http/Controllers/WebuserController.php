<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Webuser;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Session;


class WebuserController extends Controller
{

    //Backend

    public function index(Request $request){
        $search = $request['search'] ?? "";
        if($search != "")
        {
            $webuser = Webuser::where('name','LIKE',"%$search%")->paginate();
        }
        else{
            $webuser = Webuser::orderBy('created_at', 'desc')->paginate(10);
        }
        $roles = Roles::all();
        return view('backend.webusers.index',compact('webuser','roles'));
    }

    public function store(Request $request){
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|ends_with:gmail.com|max:255|unique:webusers',
            'password' => ['required', 'string', 'min:8'],
            'phone' => 'required|string|digits:10|numeric',
        ];
        $messages = [
            'email.ends_with' => 'Enter a valid email address.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $webuser = new Webuser;
        $webuser->name = $request['name'];
        $webuser->email = $request['email'];
        $webuser->phone = $request['phone'];
        $webuser->password = bcrypt($request['password']);
        $webuser->save();
        $role = Roles::where('name', 'authenticated_user')->first();
        if ($role) {
            $webuser->roles()->attach($role->id);
        }
        return redirect('/webuser')->with('message','Webuser Created Successfully');
    }

    public function edit(Request $request, $id){
        $webuser = Webuser::find($id);
        $roles = Roles::all();
        $selectedRoles = $webuser->roles->pluck('id')->toArray();
        return view('backend.webusers.edit',compact('webuser','roles','selectedRoles'));
    }

    public function update(Request $request, $id){
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|ends_with:gmail.com|max:255',
            'phone' => 'required|string|digits:10|numeric',
        ];
        $messages = [
            'email.ends_with' => 'Enter a valid email address.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $webuser = Webuser::find($id);
        $webuser->name = $request['name'];
        $webuser->email = $request['email'];
        $webuser->phone = $request['phone'];
        $webuser->save();
        $roles = $request->input('assign');
        $webuser->roles()->sync($roles);
        return redirect('/webuser')->with('message','Profile updated successfully');
    }

    public function updatewebuserdetails(Request $request){
        $rules = [
            'blood_group' => 'required|string',
            'address' => 'required|string|max:255',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $id = $request['id'];
        $webuser = WebUser::find($id);
        $profile = $webuser->profile;
        $profile->blood_group= $request['blood_group'];
        $profile->address= $request['address'];
        $profile->save();
        return redirect()->back()->with('message','Profile section changed successfully');
    }

    public function resetpasswordbackend(Request $request){
        $validator = Validator::make($request->all(), [
        'password' => ['required', 'string', 'min:8'],
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $webuserid = $request['id'];
        $webuser = Webuser::find($webuserid);
        $webuser -> password = bcrypt($request['password']);
        $webuser->save();
        return redirect()->back()->with('message', 'Password has been reset successfully');
    }

    public function delete($id){
        $webuser = Webuser::find($id);
        $webuser->delete();
        return redirect('/webuser');
    }

    //Frontend

    public function login(){
        return view('frontend.auth.login');
    }

    public function logout(Request $request){
        Auth::guard('webuser')->logout();
        return redirect('/');
    }

    public function signin(Request $request){
        // Validate the request
        $request->validate([
            'email' => 'required|email|exists:webusers,email',
            'password' => 'required',
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Please provide a valid email address.',
            'password.required' => 'Password is required.',
            'email.exists' => "The email doesn't exist.",
        ]);
        $email = $request->input('email');
        $password = $request->input('password');
        $webuser = Webuser::where('email', $email)->first();
        if ($webuser) {
            // Verify the password
            if (Hash::check($password, $webuser->password)) {
                // Password matches, so authenticate the webuser
                Auth::guard('webuser')->login($webuser);
                return redirect()->intended('/')->with('message', "Welcome to Sikkim's very own Blood Donation Application");
            } else {
                // Password does not match
                return redirect()->back()->with('message', 'Password does not match.')->withInput($request->only('email'));
            }
        } else {
            // webuser with the provided email does not exist
            return redirect()->back()->with('message', 'Email does not exist.')->withInput($request->only('email'));
        }
        return view('frontend.auth.login');
    }

    public function phonesignin(Request $request){
        $request->validate([
            'mobile' => 'required|regex:/^[0-9]{10}$/|exists:webusers,phone',
        ], [
            'mobile.required' => 'phone number is required.',
            'mobile.phone' => 'Please provide a valid contact number.',
            'mobile.exists' => "The contact doesn't exist.",
        ]);
        $code = $request->input('code');
        $storedCode = session('verification_code');
        if ($code == $storedCode) {
            $phone = $request->input('mobile');
            $webuser = Webuser::where('phone', $phone)->first();
            if($webuser){
                Session::forget('verification_code');
                Auth::guard('webuser')->login($webuser);
                return redirect()->intended('/')->with('message', "Welcome to Sikkim's very own Blood Donation Application");
            }
        } else {
            Session::forget('verification_code');
            return redirect()->back()->with('message', 'Invalid Verification Code. Try Again.');
        }
    }

    public function sendotp(Request $request){
        $rules = [
            'mobile' => 'required|digits:10|regex:/^[789]\d{9}$/|exists:webusers,phone'
        ];
        $messages = [
            'mobile.regex' => 'The phone number must start with 7, 8, or 9 and be exactly 10 digits long.',
            'mobile.exists' => 'The phone number does not exist in our records.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation Failed.'
            ]);
        }
        $check = $request['mobile'];
        $phoneverify = "+91".$request['mobile'];
        if($check){
            $sid = getenv("TWILIO_SID");
            $token = getenv("TWILIO_TOKEN");
            $sender = getenv("TWILIO_PHONE");
            $random = rand(1000,9999);
            session(['verification_code' => $random]);
            $twilio = new Client($sid, $token);
            $message = $twilio->messages
            ->create($phoneverify, // to
                array(
                "from" => $sender,
                "body" => "Your Verification Code is: $random"
                )
            );
            return response()->json(['message' => 'Message sent successfully.']);
        }
    }

    public function sendsms(Request $request){
        $rules = [
            'phone' => 'required|digits:10|regex:/^[789]\d{9}$/|unique:webusers,phone'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed.'
            ]);
        }
        $check = $request['phone'];
        $phoneverify = "+91".$request['phone'];
        if($check){
            $sid = getenv("TWILIO_SID");
            $token = getenv("TWILIO_TOKEN");
            $sender = getenv("TWILIO_PHONE");
            $random = rand(1000,9999);
            session(['verification_code' => $random]);
            $twilio = new Client($sid, $token);
            $message = $twilio->messages
            ->create($phoneverify, // to
                array(
                "from" => $sender,
                "body" => "Your Verification Code is: $random"
                )
            );
            return response()->json(['message' => 'Message sent successfully.']);
        }
    }

    public function signup(Request $request){
        $custom = [
            'email.ends_with' => 'Enter a valid email address.',
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|ends_with:gmail.com|max:255|unique:webusers',
            'password' => ['required', 'string', 'min:8'],
            'phone' => 'required|string|digits:10|numeric',
        ],$custom);
        if ($validator->fails()) {
            return redirect()->route('frontend.webuserlogin')->withErrors($validator)->withInput();
        }
        $code = $request->input('code');
        $storedCode = session('verification_code');
        if ($code == $storedCode) {
            Session::forget('verification_code');
            $webuser = new Webuser;
            $webuser->name = $request['name'];
            $webuser->email = $request['email'];
            $webuser->phone = $request['phone'];
            $webuser->password = bcrypt($request['password']);
            $webuser->save();
            $roles = Roles::where('name', 'authenticated_user')->firstOrFail();
            $webuser->roles()->attach($roles);
            Auth::guard('webuser')->login($webuser);
            return redirect('/')->with('message', 'Welcome to our blood donation application.');
        }
        Session::forget('verification_code');
        return redirect()->back()->with('message', 'Invalid Verification Code');
    }

}
