<?php
    

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:roles-list|roles-create|roles-edit|roles-delete', ['only' => ['index','store']]);
         $this->middleware('permission:roles-create', ['only' => ['create','store']]);
         $this->middleware('permission:roles-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:roles-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request): View
    {
        try {
            $roles = Role::orderBy('id','DESC')->paginate(5);
            return view('roles.index',compact('roles'))
                ->with('i', ($request->input('page', 1) - 1) * 5);
        } catch (\Throwable $e) {
            Log::error('RoleController@index error: ' . $e->getMessage(), ['exception' => $e]);
            abort(500, 'Failed to load roles.');
        }
    }

    public function create(): View
    {
        try {
            $permission = Permission::get();
            return view('roles.add',compact('permission'));
        } catch (\Throwable $e) {
            Log::error('RoleController@create error: ' . $e->getMessage(), ['exception' => $e]);
            abort(500, 'Failed to load create role form.');
        }
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $this->validate($request, [
                'name' => 'required|unique:roles,name',
                'permission' => 'required',
            ]);

            $permissionsID = array_map(
                function($value) { return (int)$value; },
                $request->input('permission')
            );

            $role = Role::create(['name' => $request->input('name')]);
            $role->syncPermissions($permissionsID);

            return redirect()->route('roles.index')
                            ->with('success','Role created successfully');
        } catch (\Throwable $e) {
            Log::error('RoleController@store error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to create role.');
        }
    }

    public function show($id): View
    {
        try {
            $role = Role::find($id);
            $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
                ->where("role_has_permissions.role_id",$id)
                ->get();

            return view('roles.show',compact('role','rolePermissions'));
        } catch (\Throwable $e) {
            Log::error('RoleController@show error: ' . $e->getMessage(), ['exception' => $e]);
            abort(500, 'Failed to load role details.');
        }
    }

    public function edit($id): View
    {
        try {
            $role = Role::find($id);
            $permission = Permission::get();
            $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
                ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                ->all();

            return view('roles.edit',compact('role','permission','rolePermissions'));
        } catch (\Throwable $e) {
            Log::error('RoleController@edit error: ' . $e->getMessage(), ['exception' => $e]);
            abort(500, 'Failed to load role for editing.');
        }
    }

    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'permission' => 'required',
            ]);

            $role = Role::find($id);
            $role->name = $request->input('name');
            $role->save();

            $permissionsID = array_map(
                function($value) { return (int)$value; },
                $request->input('permission')
            );

            $role->syncPermissions($permissionsID);

            return redirect()->route('roles.index')
                            ->with('success','Role updated successfully');
        } catch (\Throwable $e) {
            Log::error('RoleController@update error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to update role.');
        }
    }

    public function destroy($id): RedirectResponse
    {
        try {
            DB::table("roles")->where('id',$id)->delete();
            return redirect()->route('roles.index')
                            ->with('success','Role deleted successfully');
        } catch (\Throwable $e) {
            Log::error('RoleController@destroy error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to delete role.');
        }
    }
}
