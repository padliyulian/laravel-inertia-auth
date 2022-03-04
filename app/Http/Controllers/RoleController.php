<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Inertia\Inertia;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
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

        $query = Role::orderBy($column, $dir);

        if ($search) {
            $query->where(function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('guard_name', 'like', '%' . $search . '%');
            });
        }

        $roles = $query->paginate($length);

        Inertia::setRootView('layouts.dashboard');
        return Inertia::render('Role/Index', [
            'length' => (int)$length,
            'column' => $column,
            'dir' => $dir,
            'search' => $search,
            'roles' => $roles
        ]);
    }

    public function create()
    {
        Inertia::setRootView('layouts.dashboard');
        return Inertia::render('Role/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100|unique:roles,name',
            'guardName' => 'required|max:100',
        ]);

        $role = new Role;
        $role->name = $request->name;
        $role->guard_name = $request->guardName;

        if ($role->save()) {
            session()->flash('message', 'Add data successfully.');
            return redirect('/roles');
        }
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        Inertia::setRootView('layouts.dashboard');

        return Inertia::render('Role/Edit', [
            'role' => $role
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100|unique:roles,name,'.$id,
            'guardName' => 'required|max:100',
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->guard_name = $request->guardName;

        if ($role->update()) {
            session()->flash('message', 'Update data successfully.');
            return redirect('/roles');
        }
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        if ($role->delete()) {
            session()->flash('message', 'Delete data successfully.');
            return redirect('/roles');
        }
    }

    public function getPermission($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::select('id','name')->get();
        Inertia::setRootView('layouts.dashboard');

        return Inertia::render('Role/Permission', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    public function updatePermission(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        if ($role->name === 'admin') {
            $role->syncPermissions(Permission::all());
        } else {
            $role->syncPermissions($request->permissions);
        }

        session()->flash('message', 'Update permission successfully.');
        return redirect('/roles');
    }
}
