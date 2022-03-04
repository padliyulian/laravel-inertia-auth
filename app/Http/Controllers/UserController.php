<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->data['currentMenu1'] = 'settings';
        $this->data['currentMenu2'] = 'auth';
        $this->data['currentMenu3'] = 'users';
    }

    public function index(Request $request)
    {
        if ($request->has('length') && $request->input('length') != '') {
            $length = $request->input('length');
        } else {
            $length = 10;
        }

        if ($request->has('column') && $request->input('column') != '') {
            $column = $request->input('column');
        } else {
            $column = 'id';
        }

        if ($request->has('dir') && $request->input('dir') != '') {
            $dir = $request->input('dir');
        } else {
            $dir = 'desc';
        }

        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
        } else {
            $search = '';
        }

        $query = User::with('roles')->orderBy($column, $dir);

        if ($search) {
            $query->where(function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $users = $query->paginate($length);

        $this->data['length'] = (int)$length;
        $this->data['column'] = $column;
        $this->data['dir'] = $dir;
        $this->data['search'] = $search;
        $this->data['users'] = $users;

        Inertia::setRootView('layouts.dashboard');
        return Inertia::render('User/Index', $this->data);
    }

    public function create()
    {
        $this->data['roles'] =  Role::select('id','name')->get();
        Inertia::setRootView('layouts.dashboard');

        return Inertia::render('User/Create', $this->data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|confirmed|min:8|max:100',
            'address' => 'required|max:500',
            'phone' => 'required|max:20',
            'role' => 'required',
            'status' => 'required',
            'photo' => 'nullable|image|max:1024|image|mimes:jpeg,png,jpg',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->status = $request->status;
        $user->password = bcrypt($request->password);

        if ($request->photo) {
            $filename = uniqid();
            $fileExt = $request->photo->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$fileExt;
            $request->photo->storePubliclyAs('/public/images', $fileNameToStore);

            $user->photo = $fileNameToStore;
        }

        if ($user->save()) {
            $user->assignRole($request->role);
            session()->flash('message', 'Add data successfully.');
            return redirect('/users');
        }
    }

    public function edit($id)
    {
        $this->data['user'] = User::with('roles')->findOrFail($id);
        $this->data['roles'] =  Role::select('id','name')->get();
        Inertia::setRootView('layouts.dashboard');

        return Inertia::render('User/Edit', $this->data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|max:100|unique:users,email,'.$id,
            'password' => 'nullable|confirmed|min:8|max:100',
            'address' => 'required|max:500',
            'phone' => 'required|max:20',
            'role' => 'required',
            'status' => 'required',
            'photo' => 'nullable|image|max:1024|image|mimes:jpeg,png,jpg',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->status = $request->status;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        if ($request->photo) {
            if ($user->photo != null) {
                Storage::delete('/public/images/'.$user->photo);
            }

            $filename = uniqid();
            $fileExt = $request->photo->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$fileExt;
            $request->photo->storePubliclyAs('/public/images', $fileNameToStore);

            $user->photo = $fileNameToStore;
        }

        if ($user->update()) {
            $user->syncRoles($request->role);
            session()->flash('message', 'Update data successfully.');
            return redirect('/users');
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->delete()) {
            if ($user->photo != null) {
                Storage::delete('/public/images/'.$user->photo);
            }
            session()->flash('message', 'Delete data successfully.');
            return redirect('/users');
        }
    }
}
