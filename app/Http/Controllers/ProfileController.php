<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Webuser;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Bloodreq;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function profile(){
        return view('frontend.webuser.profile');
    }

    // For authenticated webuser
    public function updateprofiledetails(Request $request){
        $authenticated_user = Auth::guard('webuser')->user()->id;
        $custom = [
            'email.ends_with' => 'Enter a valid email address.',
        ];
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|ends_with:gmail.com|unique:webusers,email,' . $authenticated_user,
            'phone' => 'required|string|digits:10|numeric',
        ], $custom);
        // If validation fails, redirect back with error messages
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $webuser = Webuser::find($authenticated_user);
        $webuser->name = $request['name'];
        $webuser->email = $request['email'];
        $webuser->phone = $request['phone'];
        $webuser->save();
        return redirect()->back()->with('message', 'Profile Updated Successfully');
    }

    //For donor webuser
    public function profileinsert(Request $request){
        $rules = [
            'address' => 'required|string|max:255',
            'blood_group' => 'required|string',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $profile = new Profile;
        $profile -> webuser_id = Auth::guard('webuser')->user()->id;
        $profile -> address = $request['address'];
        $profile -> blood_group = $request['blood_group'];
        $profile -> save();
        $authenticated_user = Auth::guard('webuser')->user()->id;
        $webuser = Webuser::find($authenticated_user);
        $roles = Roles::where('name','donor')->firstOrFail();
        $webuser->roles()->sync($roles);
        return redirect()->back()->with('message', 'Profile Updated Successfully');
    }

    public function updatedonordetails(Request $request){
        $val_id = Auth::guard('webuser')->user()->id;
        $custom = [
            'email.ends_with' => 'Enter a valid email address.',
        ];
        $rules = [
            'address' => 'required|string|max:255',
            'phone' => 'required|string|digits:10|numeric',
            'blood_group' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email|ends_with:gmail.com|unique:webusers,email,' . $val_id,
        ];
        $validator = Validator::make($request->all(), $rules, $custom);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $id = Auth::guard('webuser')->user()->profile->id;
        $profile = Profile::find($id);
        $profile -> webuser_id = $val_id;
        $profile -> address = $request['address'];
        $profile -> blood_group = $request['blood_group'];
        $profile -> save();
        $donor_user = Auth::guard('webuser')->user()->id;
        $webuser = Webuser::find($donor_user);
        $webuser->name = $request['name'];
        $webuser->email = $request['email'];
        $webuser->phone = $request['phone'];
        $webuser->save();
        return redirect()->back()->with('message', 'Profile Updated Successfully');
    }

    public function resetpassword(Request $request){
        $custom = [
            'password.regex' => 'The password field should contain a capital letter and a symbol.',
        ];
        $validator = Validator::make($request->all(), [
        'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*[\W_]).+$/'],
        ], $custom);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $webuserid = Auth::guard('webuser')->user()->id;
        $webuser = Webuser::find($webuserid);
        $webuser -> password = bcrypt($request['password']);
        $webuser->save();
        return redirect()->back()->with('message', 'Password has been reset successfully');
    }

    public function seedonorspdf(Request $request){
        $webuser = Auth::guard('webuser')->user()->id;
        $webusername = Auth::guard('webuser')->user()->name;
        // Find Bloodreq records where the donors column contains the webuser ID
        $bloodreqIds = DB::select("SELECT id FROM bloodreqs WHERE JSON_CONTAINS(donors, :webuserId)", ['webuserId' => json_encode(["id" => $webuser])]);
        $bloodreqsArray = array_column($bloodreqIds, 'id');
        $bloodreqs = Bloodreq::whereIn('id', $bloodreqsArray)->get(['patient_name', 'blood_group', 'hospital_name', 'required_date']);
        $bloodencoded = json_decode($bloodreqs);
        $pdf = new Dompdf();
        $html = view('frontend.pdf.donatedto', compact('bloodencoded','webusername'))->render();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        return $pdf->stream('donated_to.pdf');
    }

    public function seerequestspdf(Request $request){
        $webuser = Auth::guard('webuser')->user()->id;
        $webusername = Auth::guard('webuser')->user()->name;
        $bloodreqIds = DB::select("SELECT id FROM bloodreqs WHERE webuser_id = :webuserId", ['webuserId' => $webuser]);
        $bloodreqsArray = array_column($bloodreqIds, 'id');
        $bloodreqs = Bloodreq::whereIn('id', $bloodreqsArray)->get(['patient_name', 'blood_group', 'hospital_name', 'required_date', 'donors' ]);
        $bloodencoded = json_decode($bloodreqs);
        $pdf = new Dompdf();
        $html = view('frontend.pdf.seerequests', compact('bloodencoded','webusername'))->render();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        return $pdf->stream('see_requested.pdf');
    }

}
