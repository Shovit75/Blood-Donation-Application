<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permissions;

class PermissionsController extends Controller
{
    public function index(){
        $permissions = Permissions::all();
        return view('backend.permissions.index',compact('permissions'));
    }

    public function store(Request $request){
        $permissions = new Permissions;
        $permissions->name = $request['name'];
        $permissions->guard_name = $request['guardname'];
        $permissions->save();
        return redirect('/permissions');
    }

    public function edit(Request $request, $id){
        $permissions = Permissions::find($id); // Replace ResourceModel with your actual model name
        return view('backend.permissions.edit',compact('permissions'));
    }

    public function update(Request $request, $id){
        $permissions = Permissions::find($id);
        $permissions->name = $request['name'];
        $permissions->guard_name = $request['guardname'];
        $permissions->save();
        return redirect('/permissions');
    }

    public function delete($id){
        $permissions = Permissions::find($id);
        $permissions->delete();
        return redirect('/permissions');
    }
}
