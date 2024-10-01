<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Bloodcamps;
use Illuminate\Support\Str;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Validator;

class BloodcampsController extends Controller
{
    public function index(){
        $bloodcamps = Bloodcamps::paginate(10);
        return view('backend.bloodcamps.index',compact('bloodcamps'));
    }

    public function store(Request $request){
        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Assuming images are allowed with these extensions and a maximum size of 2MB
        ];
        $validator = Validator::make($request->all(), $rules);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $bloodcamps = new Bloodcamps;
        $bloodcamps->name = $request['name'];
        $bloodcamps->location = $request['location'];
        $bloodcamps->date = $request['date'];
        $bloodcamps->description = $request['description'];
        $bloodcamps->slug = Str::slug($request['name']);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // Get the original extension
            $randomFileName = Str::random(10); // Generate a random filename or however you choose
            $destinationPath = public_path('images'); // Define destination path
            $file->move($destinationPath, $randomFileName . '.' . $extension); // Move the file to destination
            $imagePath = 'images/' . $randomFileName . '.' . $extension; // This is the path you can store in your DB
            } else {
            $imagePath = null;
        }
        $bloodcamps->image = $imagePath;
        $bloodcamps->save();
        return redirect('/bloodcamps');
    }

    public function edit(Request $request, $id){
        $bloodcamps = Bloodcamps::find($id); // Replace ResourceModel with your actual model name
        return view('backend.bloodcamps.edit',compact('bloodcamps'));
    }

    public function update(Request $request, $id){
        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $bloodcamps = Bloodcamps::find($id);
        $bloodcamps->name = $request['name'];
        $bloodcamps->location = $request['location'];
        $bloodcamps->date = $request['date'];
        $bloodcamps->description = $request['description'];
        $bloodcamps->slug = Str::slug($request['name']);
        if ($request->hasFile('image') && $bloodcamps->image) {
            $oldFilePath = public_path($bloodcamps->image);
            if (File::exists($oldFilePath)) {
                File::delete($oldFilePath);
            }
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $randomFileName = Str::random(10);
                $destinationPath = public_path('images');
                $file->move($destinationPath, $randomFileName . '.' . $extension);
                $imagePath = 'images/' . $randomFileName . '.' . $extension; // This is the path you can store in your DB
                $bloodcamps->image = $imagePath;
            }
        }
        $bloodcamps->save();
        return redirect('/bloodcamps');
    }

    public function delete($id){
        $bloodcamps = Bloodcamps::find($id);
        if($bloodcamps->image){
            $oldFilePath = public_path($bloodcamps->image);
            if (File::exists($oldFilePath)) {
                File::delete($oldFilePath);
            }
        }
        $bloodcamps->delete();
        return redirect('/bloodcamps');
    }

    public function updateparticipants(Request $request){
        $bdcamps = Bloodcamps::find($request->bdcampsid);
        if ($request->has('participants') && !empty($request->participants)) {
            $participantsData = [];
            foreach ($request->participants as $participant) {
                $participantsData[] = [
                    'participantId' => $participant['participantId'],
                    'participantName' => $participant['participantName'],
                    'participantBg' => $participant['participantBg'],
                    'participantAddress' => $participant['participantAddress'],
                    'participantPhone' => $participant['participantPhone'],
                ];
            }
            $bdcamps->participants = $participantsData;
        } else {
            $bdcamps->participants = [];
        }
        $bdcamps->save();
        return redirect()->back();
    }

    public function pdfbdcamps(Request $request){
        $bdcamps = Bloodcamps::find($request->bdcampsid);
        $participantsData = $bdcamps->participants;
        $bdcamps_name = $bdcamps->name;
        $pdf = new Dompdf();
        $html = view('frontend.pdf.participants', compact('participantsData','bdcamps_name'))->render();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        // Output PDF for download
        return $pdf->stream('participants_data.pdf');
    }
}
