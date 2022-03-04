<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->data['currentMenu1'] = 'settings';
        $this->data['currentMenu2'] = 'auth';
        $this->data['currentMenu3'] = 'permissions';
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

        $query = Permission::orderBy($column, $dir);

        if ($search) {
            $query->where(function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('guard_name', 'like', '%' . $search . '%');
            });
        }

        $permissions = $query->paginate($length);

        $this->data['length'] = (int)$length;
        $this->data['column'] = $column;
        $this->data['dir'] = $dir;
        $this->data['search'] = $search;
        $this->data['permissions'] = $permissions;

        Inertia::setRootView('layouts.dashboard');
        return Inertia::render('Permission/Index', $this->data);
    }

    public function create()
    {
        Inertia::setRootView('layouts.dashboard');
        return Inertia::render('Permission/Create', $this->data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100|unique:permissions,name',
            'guardName' => 'required|max:100',
        ]);

        $permission = new Permission;
        $permission->name = $request->name;
        $permission->guard_name = $request->guardName;

        if ($permission->save()) {
            session()->flash('message', 'Add data successfully.');
            return redirect('/permissions');
        }
    }

    public function edit($id)
    {
        $this->data['permission'] = Permission::findOrFail($id);
        Inertia::setRootView('layouts.dashboard');

        return Inertia::render('Permission/Edit', $this->data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100|unique:permissions,name,'.$id,
            'guardName' => 'required|max:100',
        ]);

        $permission = Permission::findOrFail($id);
        $permission->name = $request->name;
        $permission->guard_name = $request->guardName;

        if ($permission->update()) {
            session()->flash('message', 'Update data successfully.');
            return redirect('/permissions');
        }
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        if ($permission->delete()) {
            session()->flash('message', 'Delete data successfully.');
            return redirect('/permissions');
        }
    }
}
