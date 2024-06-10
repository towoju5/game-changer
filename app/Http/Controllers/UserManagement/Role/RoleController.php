<?php

namespace App\Http\Controllers\UserManagement\Role;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'under-review']);
    }

    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('dashboard.user-management.role.list', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('dashboard.user-management.role.add', compact('permissions'));
    }

    public function store(Request $request)
    {
        //Performing Validations
        $validator = \Validator::make($request->all(), [
            'name' => ['required', 'unique:roles,name'],
        ]);

        if($validator->fails()){
            return redirect()->back()->with('warning', 'Role already exists please try again with another name!');
        }

        //Creating Role
        $role = Role::create([
            'name' => $request->name,
            'description' => $request->description,
            'guard_name' => 'web'
        ]);

        $role->syncPermissions($request->permissions);

        return redirect('role/list')->with('success', 'Role Added Successfully!');
    }

    public function edit($id)
    {
        $role = Role::with('permissions')->find(decrypt($id));
        $permissions = Permission::all();

        return view('dashboard.user-management.role.edit', compact('role','permissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::find(decrypt($id));

        //Performing Validations
        $validator = \Validator::make($request->all(), [
            'name' => ['required', 'unique:roles,name,'.$role->id.',id']
        ]);

        if($validator->fails()){
            return redirect()->back()->with('warning', 'Role already exists please try again with another name!');
        }

        //Updating Role
        $role->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        $role->syncPermissions($request->permissions);

        return redirect('role/list')->with('success', 'Role Updated Successfully!');
    }

    public function destroy($id)
    {
        $role = Role::find(decrypt($id));

        //Checking if role is assigned to any user
        if (User::role($role->name)->first() != null) {
            return redirect()->back()->with('warning','This role has been assigned to one or more users. Please change the roles before attempting to delete it.');
        }

        $role->delete();
        return redirect('role/list')->with('success', 'Role Deleted Successfully!');
    }
}