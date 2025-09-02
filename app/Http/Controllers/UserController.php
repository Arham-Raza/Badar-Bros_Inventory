<?php
    

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:users-list|users-create|users-edit|users-delete', ['only' => ['index','store']]);
         $this->middleware('permission:users-create', ['only' => ['create','store']]);
         $this->middleware('permission:users-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:users-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request): View
    {
        try {
            $data = User::latest()->paginate(10);
            $totalUsers = User::count();
            $activeUsers = User::where('status', 1)->count();
            $inactiveUsers = User::where('status', 0)->count();
            $newUsers = User::whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->count();

            return view('users.index', compact(
                'data',
                'totalUsers',
                'activeUsers',
                'inactiveUsers',
                'newUsers'
            ))->with('i', ($request->input('page', 1) - 1) * 10);
        } catch (\Throwable $e) {
            Log::error('UserController@index error: ' . $e->getMessage(), ['exception' => $e]);
            abort(500, 'Failed to load users.');
        }
    }

    public function create(): View
    {
        try {
            $roles = Role::pluck('name','name')->all();
            return view('users.add',compact('roles'));
        } catch (\Throwable $e) {
            Log::error('UserController@create error: ' . $e->getMessage(), ['exception' => $e]);
            abort(500, 'Failed to load create user form.');
        }
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|same:confirm-password',
                'roles' => 'required'
            ]);

            $input = $request->all();
            $input['password'] = Hash::make($input['password']);

            $user = User::create($input);
            $user->assignRole($request->input('roles'));

            return redirect()->route('users.index')
                            ->with('success','User created successfully');
        } catch (\Throwable $e) {
            Log::error('UserController@store error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to create user.');
        }
    }

    public function show($id): View
    {
        try {
            $user = User::find($id);
            return view('users.show',compact('user'));
        } catch (\Throwable $e) {
            Log::error('UserController@show error: ' . $e->getMessage(), ['exception' => $e]);
            abort(500, 'Failed to load user details.');
        }
    }

    public function edit($id): View
    {
        try {
            $user = User::find($id);
            $roles = Role::pluck('name','name')->all();
            $userRole = $user->roles->pluck('name','name')->all();
            return view('users.edit',compact('user','roles','userRole'));
        } catch (\Throwable $e) {
            Log::error('UserController@edit error: ' . $e->getMessage(), ['exception' => $e]);
            abort(500, 'Failed to load user for editing.');
        }
    }

    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$id,
                'password' => 'same:confirm-password',
                'roles' => 'required'
            ]);

            $input = $request->all();
            if(!empty($input['password'])){ 
                $input['password'] = Hash::make($input['password']);
            }else{
                $input = Arr::except($input,array('password'));    
            }

            $user = User::find($id);
            $user->update($input);
            DB::table('model_has_roles')->where('model_id',$id)->delete();

            $user->assignRole($request->input('roles'));

            return redirect()->route('users.index')
                            ->with('success','User updated successfully');
        } catch (\Throwable $e) {
            Log::error('UserController@update error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to update user.');
        }
    }

    public function destroy($id): RedirectResponse
    {
        try {
            User::find($id)->delete();
            return redirect()->route('users.index')
                            ->with('success','User deleted successfully');
        } catch (\Throwable $e) {
            Log::error('UserController@destroy error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to delete user.');
        }
    }
}
