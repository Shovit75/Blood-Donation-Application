<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\RequestBlood;
use App\Mail\DonorDetails;
use Illuminate\Http\Request;
use App\Models\Bloodreq;
use App\Models\Webuser;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Validator;

class BloodreqController extends Controller
{
    public function index(Request $request){
        $search = $request['search']??"";
        if($search!="")
        {
            $bloodreq = Bloodreq::where(function ($query) use ($search) {
                $query->where('patient_name', 'LIKE', "%$search%")
                    ->orWhere('hospital_name', 'LIKE', "%$search%")
                    ->orWhereHas('webuser', function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%$search%");
                    });
            })->paginate();
        } else {
            $bloodreq = Bloodreq::orderBy('created_at', 'desc')->paginate(10);
        }
        $webuser = Webuser::all();
        return view('backend.bloodreq.index',compact('bloodreq','webuser'));
    }

    public function store(Request $request){
        $rules = [
            'patient_name' => 'required|string|max:255',
            'blood_group' => 'required|string',
            'hospital_name' => 'required|string',
            'required_date' => 'required|date',
            'additional_details' => 'nullable|string|max:255',
            'webuser_id' => 'required|exists:webusers,id',
            'status' => 'required|boolean',
            'carousel' => 'required|boolean',
            'slug' => 'required|max:255',
        ];
        // Validate the request
        $validator = Validator::make($request->all(), $rules);
        // Check if the validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $compatibilityRules = [
            //can take from => can give to
            'O+' => ['O+', 'A+', 'B+', 'AB+'],
            'O-' => ['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'],
            'A+' => ['A+', 'AB+'],
            'A-' => ['A+', 'A-', 'AB+', 'AB-'],
            'B+' => ['B+', 'AB+'],
            'B-' => ['B-', 'AB-'],
            'AB+' => ['AB+'],
            'AB-' => ['AB+', 'AB-'],
        ];
        $bloodreq = new Bloodreq;
        $bloodreq->patient_name = $request['patient_name'];
        $bloodreq->blood_group = $request['blood_group'];
        $bloodreq->hospital_name = $request['hospital_name'];
        $bloodreq->required_date = $request['required_date'];
        $bloodreq->additional_details = $request['additional_details'];
        $bloodreq->webuser_id = $request['webuser_id'];
        $bloodreq->status = $request['status'];
        $bloodreq->carousel = $request['carousel'];
        $bloodreq->slug = Str::slug($request['slug']);
        if (array_key_exists($bloodreq->blood_group, $compatibilityRules)) {
            $bloodreq->blood_group_required = $compatibilityRules[$bloodreq->blood_group];
        } else {
            // Handle unexpected blood group value
            $bloodreq->blood_group_required = [];
        }
        $bloodreq->save();
        return redirect('/bloodreq')->with('message','Request created successfully');
    }

    public function edit(Request $request, $id){
        $bloodreq = Bloodreq::find($id);
        $webuser = Webuser::all();
        $selectedbloodgroup =  $bloodreq->blood_group;
        $selectedstatus = $bloodreq->status;
        $selectedcarousel = $bloodreq->carousel;
        $selectedhospital = $bloodreq->hospital_name;
        return view('backend.bloodreq.edit',compact('bloodreq','webuser','selectedbloodgroup','selectedstatus','selectedcarousel','selectedhospital'));
    }

    public function update(Request $request, $id){
        $rules = [
            'patient_name' => 'required|string|max:255',
            'blood_group' => 'required|string',
            'hospital_name' => 'required|string',
            'required_date' => 'required|date',
            'additional_details' => 'nullable|string|max:255',
            'webuser_id' => 'required|exists:webusers,id',
            'status' => 'required|boolean',
            'carousel' => 'required|boolean',
            'slug' => 'required|max:255',
        ];
        // Validate the request
        $validator = Validator::make($request->all(), $rules);
        // Check if the validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $compatibilityRules = [
            'O+' => ['O+', 'A+', 'B+', 'AB+'],
            'O-' => ['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'],
            'A+' => ['A+', 'AB+'],
            'A-' => ['A+', 'A-', 'AB+', 'AB-'],
            'B+' => ['B+', 'AB+'],
            'B-' => ['B-', 'AB-'],
            'AB+' => ['AB+'],
            'AB-' => ['AB+', 'AB-'],
        ];
        $bloodreq = Bloodreq::find($id);
        $bloodreq->patient_name = $request['patient_name'];
        $bloodreq->blood_group = $request['blood_group'];
        $bloodreq->hospital_name = $request['hospital_name'];
        $bloodreq->required_date = $request['required_date'];
        $bloodreq->additional_details = $request['additional_details'];
        $bloodreq->webuser_id = $request['webuser_id'];
        $bloodreq->status = $request['status'];
        $bloodreq->carousel = $request['carousel'];
        $bloodreq->slug = Str::slug($request['slug']);
        if (array_key_exists($bloodreq->blood_group, $compatibilityRules)) {
            $bloodreq->blood_group_required = $compatibilityRules[$bloodreq->blood_group];
        } else {
            // Handle unexpected blood group value
            $bloodreq->blood_group_required = [];
        }
        $bloodreq->save();
        return redirect('/bloodreq');
    }

    public function updateDonors(Request $request){
        $bloodreqId = $request['bdreqid'];
        $bloodreq = Bloodreq::findOrFail($bloodreqId);
        $donorsData = $request->input('donors');
        $donorsJson = json_encode($donorsData);
        $bloodreq->donors = $donorsJson;
        $bloodreq->save();
        return redirect('/bloodreq');
    }

    public function delete($id){
        $bloodreq = Bloodreq::find($id);
        $bloodreq->delete();
        return redirect('/bloodreq');
    }

    public function updateStatus(Request $request)
    {
        $bloodreq = Bloodreq::find($request->id);
        if ($bloodreq) {
            $bloodreq->status = $request->status;
            $bloodreq->save();
            if ($request->status == 1) {
                $auth_user = $bloodreq->webuser;
                Mail::to($auth_user->email)->send(new RequestBlood($auth_user));
            }
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Bloodreq not found'], 404);
    }

    public function updateCarousel(Request $request)
    {
        $bloodreq = Bloodreq::find($request->id);
        if ($bloodreq) {
            $bloodreq->carousel = $request->carousel;
            $bloodreq->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Bloodreq not found'], 404);
    }

    //Frontend

    public function addblood(Request $request){
        $rules = [
            'patient_name' => 'required|string|max:255',
            'blood_group' => 'required|string',
            'hospital_name' => 'required|string',
            'required_date' => 'required|date',
            'additional_details' => 'nullable|string|max:255',
            'webuser_id' => 'required|exists:webusers,id',
            'status' => 'required|boolean',
        ];
        // Validate the request
        $validator = Validator::make($request->all(), $rules);
        // Check if the validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $compatibilityRules = [
            'O+' => ['O+', 'A+', 'B+', 'AB+'],
            'O-' => ['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'],
            'A+' => ['A+', 'AB+'],
            'A-' => ['A+', 'A-', 'AB+', 'AB-'],
            'B+' => ['B+', 'AB+'],
            'B-' => ['B-', 'AB-'],
            'AB+' => ['AB+'],
            'AB-' => ['AB+', 'AB-'],
        ];
        $bloodreq = new Bloodreq;
        $bloodreq->patient_name = $request['patient_name'];
        $bloodreq->blood_group = $request['blood_group'];
        $bloodreq->hospital_name = $request['hospital_name'];
        $bloodreq->required_date = $request['required_date'];
        $bloodreq->additional_details = $request['additional_details'];
        $bloodreq->webuser_id = $request['webuser_id'];
        $bloodreq->status = $request['status'];
        $bloodreq->carousel = 0;
        $bloodreq->slug = Str::uuid();
        if (array_key_exists($bloodreq->blood_group, $compatibilityRules)) {
            $bloodreq->blood_group_required = $compatibilityRules[$bloodreq->blood_group];
        } else {
            // Handle unexpected blood group value
            $bloodreq->blood_group_required = [];
        }
        $bloodreq->save();
        return redirect('/activereq')->with('message', 'Admin will reach you & verify your request after which will be posted soon.');
    }

    public function senddonordetails(Request $request){
        $bloodreq = Bloodreq::find($request->bdreqid);
        $recruiter = $bloodreq->webuser->name; //name of the recruiter
        $bloodemail = $bloodreq->webuser->email; //email of the recruiter
        $donors = json_decode($bloodreq->donors, true) ?: [];
        $donor_id = Auth::guard('webuser')->user()->id;
        // Check if the donor's name already exists in the array
        foreach ($donors as $donor) {
            if ($donor['id'] === $donor_id) {
                return redirect()->back()->with('message', 'You have already helped this individual. Thank you for your assistance.');
            }
        }
        // If the donor's name doesn't exist, add the new donor information to the array
        $donor_name = Auth::guard('webuser')->user()->name;
        $donor_bg = Auth::guard('webuser')->user()->profile->blood_group;
        $donor_address = Auth::guard('webuser')->user()->profile->address;
        $donor_phone = Auth::guard('webuser')->user()->phone;
        $donors[] = [
            'id' => $donor_id,
            'name' => $donor_name,
            'blood_group' => $donor_bg,
            'address' => $donor_address,
            'phone' => $donor_phone
        ];
        // Encode the updated donor array to JSON
        $bloodreq->donors = json_encode($donors);
        // Save the changes
        $bloodreq->save();
        $auth_user = Auth::guard('webuser')->user();
        //send email to the recruiter notifying him/her of the donor available
        Mail::to($bloodemail)->send(new DonorDetails($recruiter));
        return redirect()->back()->with('message', 'Thank you for your help.');
    }

    public function downloadPdf(Request $request)
    {
        $bloodreq = Bloodreq::find($request->bdreqid);
        $donorsData = json_decode($bloodreq->donors, true);
        $bloodreq_patient_name = $bloodreq->patient_name;
        $pdf = new Dompdf();
        $html = view('frontend.pdf.donors', compact('donorsData','bloodreq_patient_name'))->render();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        // Output PDF for download
        return $pdf->stream('donors_data.pdf');
    }
}
