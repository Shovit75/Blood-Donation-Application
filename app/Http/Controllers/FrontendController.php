<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Bloodreq;
use App\Models\Bloodcamps;
use Illuminate\Support\Facades\Auth;
use App\Models\Webuser;
use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{
    public function index(){
        if (Auth::guard('webuser')->check()) {
            // For donor user
            if (Auth::guard('webuser')->user()->hasRole('donor')) {
                $user = Auth::guard('webuser')->user();
                $donorBloodType = $user->profile->blood_group;
                $bloodreq = Bloodreq::where('status', 1)
                ->where('carousel', 1)
                ->WhereJsonContains('blood_group_required', $donorBloodType)
                ->oldest('required_date')
                ->get();
                foreach ($bloodreq as $req) {
                    // Extract the blood group from the request
                    $bloodGroupRequired = $req->blood_group_required;
                    // Do something with the blood group
                    foreach ($bloodGroupRequired as $requiredBloodGroup) {
                        // Check if the authenticated user can donate to this blood group
                        if ($requiredBloodGroup == $donorBloodType) {
                            return view('frontend.index', compact('bloodreq'));
                        }
                    }
                }
                return view('frontend.index', compact('bloodreq'));
            }
            //For authenticated user
            else {
                $bloodreq = Bloodreq::where('status', 1)
                ->where('carousel', 1)
                ->oldest('required_date')
                ->get();
                return view('frontend.index', compact('bloodreq'));
            }
        }
        //For public user
        else {
            $bloodreq = Bloodreq::where('status', 1)
            ->where('carousel', 1)
            ->oldest('required_date')
            ->get();
            return view('frontend.index', compact('bloodreq'));
        }
    }

    public function about(){
        return view('frontend.about');
    }

    public function activereq(){
        if (Auth::guard('webuser')->check()) {
            // For donor user
            if (Auth::guard('webuser')->user()->hasRole('donor')) {
                $user = Auth::guard('webuser')->user();
                $donorBloodType = $user->profile->blood_group;
                $bloodreq = Bloodreq::where('status', 1)
                ->WhereJsonContains('blood_group_required', $donorBloodType)
                ->oldest('required_date')
                ->paginate(8); //No of requests shown
                foreach ($bloodreq as $req) {
                    // Extract the blood group from the request
                    $bloodGroupRequired = $req->blood_group_required;
                    // Do something with the blood group
                    foreach ($bloodGroupRequired as $requiredBloodGroup) {
                        // Check if the authenticated user can donate to this blood group
                        if ($requiredBloodGroup == $donorBloodType) {
                            return view('frontend.activereq', compact('bloodreq'));
                        }
                    }
                }
                return view('frontend.activereq',compact('bloodreq'));
            }
            //For auth user
            $bloodreq = Bloodreq::where('status', 1)->oldest('required_date')->paginate(8);
            return view('frontend.activereq',compact('bloodreq'));
        }
        //For public user
        $bloodreq = Bloodreq::where('status', 1)->oldest('required_date')->paginate(8);
        return view('frontend.activereq',compact('bloodreq'));
    }

    public function bdcamps(){
        $bdcamps = Bloodcamps::all();
        return view('frontend.bdcamps',compact('bdcamps'));
    }

    //For Active Requirements Slug
    public function activereqslug(Request $request, $slug){
        $bloodreq = Bloodreq::where('slug', $slug)->first();
        // dd($bloodreq);
        return view('frontend.slugs.reqslug',compact('bloodreq'));
    }

    //For BD Camps Slug
    public function bdcampslug(Request $request, $slug){
        $bdcamps = Bloodcamps::where('slug', $slug)->first();
        return view('frontend.slugs.bdcampslug',compact('bdcamps'));
    }

    //Participate in bdcamps as a donor
    public function participate(Request $request){
        $bdcamps = Bloodcamps::find($request->id);
        $participants = $bdcamps->participants ?: [];
        $participantName = Auth::guard('webuser')->user()->name;
        $participantId = Auth::guard('webuser')->user()->id;
        $participantBg = Auth::guard('webuser')->user()->profile->blood_group;
        $participantAddress = Auth::guard('webuser')->user()->profile->address;
        $participantPhone = Auth::guard('webuser')->user()->phone;
         // Check if the participant with the same ID already exists
        foreach ($participants as $participant) {
            if ($participant['participantId'] == $participantId) {
                return redirect()->back()->with('message', 'You have already enrolled for this blood camp.');
            }
        }
        $participants[] = [
            'participantId' => $participantId,
            'participantName' => $participantName,
            'participantBg' => $participantBg,
            'participantAddress' => $participantAddress,
            'participantPhone' => $participantPhone,
        ];
        $bdcamps->participants = $participants;
        $bdcamps->save();
        return redirect()->back()->with('message', 'You have successfully participated for the blood camp.');
    }

    public function redirectback(){
        return redirect('/');
    }

    public function search(Request $request){
        $search = $request['search'] ?? "";
        if (Auth::guard('webuser')->check()) {
            // For donor user
            if (Auth::guard('webuser')->user()->hasRole('donor')) {
                $user = Auth::guard('webuser')->user();
                $donorBloodType = $user->profile->blood_group;
                if($search != ""){
                    $bloodreq = Bloodreq::where('status', 1)
                    ->where(function ($query) use ($search) {
                        $query->where('patient_name', 'LIKE', "%$search%")
                            ->orWhere('hospital_name', 'LIKE', "%$search%");
                            // ->orWhereHas('webuser', function ($query) use ($search) {
                            //     $query->where('name', 'LIKE', "%$search%");
                            // });
                    })
                    ->WhereJsonContains('blood_group_required', $donorBloodType)
                    ->oldest('required_date')
                    ->get(); //No of requests shown
                }else{
                   return redirect()->back();
                }
                foreach ($bloodreq as $req) {
                    // Extract the blood group from the request
                    $bloodGroupRequired = $req->blood_group_required;
                    // Do something with the blood group
                    foreach ($bloodGroupRequired as $requiredBloodGroup) {
                        // Check if the authenticated user can donate to this blood group
                        if ($requiredBloodGroup == $donorBloodType) {
                            return view('frontend.search', compact('bloodreq'));
                        }
                    }
                }
                return view('frontend.search',compact('bloodreq'));
            }
            //For auth user
            if($search != ""){
                $bloodreq = Bloodreq::where('status', 1)
                ->where(function ($query) use ($search) {
                    $query->where('patient_name', 'LIKE', "%$search%")
                        ->orWhere('hospital_name', 'LIKE', "%$search%");
                        // ->orWhereHas('webuser', function ($query) use ($search) {
                        //     $query->where('name', 'LIKE', "%$search%");
                        // });
                })
                ->oldest('required_date')->get();
            } else {
                return redirect()->back();
            }
            return view('frontend.search',compact('bloodreq'));
        }
        //For public user
        if($search != ""){
            $bloodreq = Bloodreq::where('status', 1)
            ->where(function ($query) use ($search) {
                $query->where('patient_name', 'LIKE', "%$search%")
                    ->orWhere('hospital_name', 'LIKE', "%$search%");
                    // ->orWhereHas('webuser', function ($query) use ($search) {
                    //     $query->where('name', 'LIKE', "%$search%");
                    // });
            })
            ->oldest('required_date')->get();
        } else {
            return redirect()->back();
        }
        return view('frontend.search',compact('bloodreq'));
    }

    public function forgotpass(Request $request){
        $email = [
            'email.ends_with' => 'Enter a valid email address.',
            'email.exists' => "The email doesn't exist.",
        ];
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|ends_with:gmail.com|max:255|exists:webusers,email',
        ],$email);
        // If validation fails,
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $mail = $request['email'];
        $webuser = Webuser::where('email', $mail)->first();
        if ($webuser && $webuser->email == $mail) {
            Mail::to($webuser->email)->send(new ForgotPassword($webuser));
            return redirect()->back()->with('message','Mail has been sent to your email to reset password.');
        }
        return redirect()->back()->with('message',"Email doesn't exist.");
    }

    public function resetpassforgot(){
        return view('emails.resetpassforgot');
    }

    public function resetpassforgotstore(Request $request){
        $custom = [
            'email.ends_with' => 'Enter a valid email address.',
        ];
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|ends_with:gmail.com|max:255|exists:webusers,email',
            'password' => ['required', 'string', 'min:8'],
        ],$custom);
        // If validation fails,
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $email = $request['email'];
        $password = $request['password'];
        $user = Webuser::where('email', $email)->first();
        if ($user) {
            // User found, update the password
            $user->password = bcrypt($password);
            $user->save();
            return redirect()->route('frontend.webuserlogin')->with('message', 'Password reset successful.');
        } else {
            // No user found with that email, redirect or return response
            return back()->withErrors(['email' => 'No account found with that email address.'])->withInput();
        }
    }
}
