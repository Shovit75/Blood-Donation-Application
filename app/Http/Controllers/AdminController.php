<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index(){
        $admins = User::all();
        return view('backend.admins.index',compact('admins'));
    }

    public function edit(Request $request, $id){
        $admins = User::find($id);
        return view('backend.admins.edit',compact('admins'));
    }

    public function update(Request $request, $id){
        $admins = User::find($id);
        $admins->name = $request['name'];
        $admins->email = $request['email'];
        $admins->password = bcrypt($request['password']);
        $admins->save();
        return redirect('/admin');
    }

    public function delete($id){
        $admins = User::find($id);
        $admins->delete();
        return redirect('/admin');
    }
}
