<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;
use App\Models\Permissions;

class RolesController extends Controller
{
    public function index(){
        $permissions = Permissions::all();
        $roles = Roles::all();
        return view('backend.roles.index',compact('roles','permissions'));
    }

    public function store(Request $request){
        $roles = new Roles;
        $roles->name = $request['name'];
        $roles->guard_name = $request['guardname'];
        $roles->save();

        $permissionIds = $request->input('assign');
        $roles->permissions()->attach($permissionIds);
        return redirect('/roles');
    }

    public function edit(Request $request, $id){
        $roles = Roles::find($id); // Replace ResourceModel with your actual model name
        $permissions = Permissions::all();
        $selectedPermissions = $roles->permissions->pluck('id')->toArray();
        return view('backend.roles.edit',compact('roles','permissions','selectedPermissions'));
    }

    public function update(Request $request, $id){
        $roles = Roles::find($id);
        $roles->name = $request['name'];
        $roles->guard_name = $request['guardname'];
        $roles->save();

        $permissionIds = $request->input('assign');
        $roles->permissions()->sync($permissionIds);
        return redirect('/roles');
    }

    public function delete($id){
        $roles = Roles::find($id);
        $roles->delete();
        return redirect('/roles');
    }
}
