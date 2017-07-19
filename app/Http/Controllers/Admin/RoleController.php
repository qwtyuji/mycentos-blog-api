<?php

namespace App\Http\Controllers\Admin;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends AuthController
{
    protected $role;
    protected $permission;

    /**
     * RoleController constructor.
     * @param $role
     */
    public function __construct(Role $role,Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = $this->role->orderBy('id', 'desc')->paginate();
        return view('admin.role.index', compact('role'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = $this->permission->get();

        return view('admin.role.add',compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = [
            'name' => 'required|unique:roles',
        ];
        $message = [
            'name.required' => '名称不能为空',
            'name.unique' => '角色已经存在!不可重复添加',
        ];
        $this->validate($request, $rule, $message);
        $role = $this->role->create($request->only('name'));
        $permissions = $request->get('permissions', []);
        $role->syncPermissions($permissions);
        return redirect()->route('role.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $permission = $this->permission->get();
        return view('admin.role.show', compact('role','permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permission = $this->permission->get();
        return view('admin.role.edit', compact('role','permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $rule = [
            'name' => [
                'required',
                Rule::unique('roles')->ignore($role->id)
            ]
        ];
        $messages = [
            'name.required' => '名称不能为空',
            'name.unique' => '名称不能重复',
        ];
        $this->validate($request, $rule, $messages);
        $role->update($request->only('name'));
        $permissions = $request->get('permissions', []);
        $role->syncPermissions($permissions);
        return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('role.index');
    }
}
