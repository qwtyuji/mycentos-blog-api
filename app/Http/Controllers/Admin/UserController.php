<?php

namespace App\Http\Controllers\Admin;

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends AuthController
{
    protected $user;

    /**
     * UserController constructor.
     * @param $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user =$this->user->orderBy('id','desc')->paginate();
        $role = Role::all();
        return view('admin.user.index',compact('user','role'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Role::all();
        $permission = Permission::orderBy('group','desc')->get();
        return view('admin.user.add',compact('role','permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule =[
            'name'=>'required|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password'=>'required|min:6|confirmed:repassword',
            'roles' => 'required|min:1'
        ];
        $message = [
            'name.required'=>'用户名不能为空',
            'name.min'=>'用户名太短',
            'name.max'=>'用户名太长',
            'email.required'=>'email必须',
            'email.string'=>'不是有效的字符',
            'email.email'=>'不是有效的Email地址',
            'email.max'=>'Email地址超过最大产能过度',
            'email.unique'=>'邮箱已注册',
            'password.required'=>'密码必须',
            'password.min'=>'密码不能少于6位',
            'password.confirmed'=>'两次输入密码不一样',
            'roles.required'=>'用户组必须',
            'roles.min'=>'用户组至少一个'
        ];
        $this->validate($request,$rule,$message);
        if ( $user = User::create($request->except('roles', 'permissions')) ) {
            $this->syncPermissions($request, $user);
        }

        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->user->find($id);
        $permission = Permission::orderBy('group','desc')->get();
        return view('admin.user.show',compact('user','permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user->find($id);
        $role = Role::all();
        $permission = Permission::orderBy('group','desc')->get();
        return view('admin.user.edit',compact('user','role','permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $this->user->find($id);
        $data = $request->all();
        $rule =[
            'name'=>'required|min:3|max:255',
            'email' => ['required','string','email','max:255',Rule::unique('users')->ignore($user->id)]
        ];
        $message = [
            'name.required'=>'用户名不能为空',
            'name.min'=>'用户名太短',
            'name.max'=>'用户名太长',
            'email.required'=>'email必须',
            'email.string'=>'不是有效的字符',
            'email.email'=>'不是有效的Email地址',
            'email.max'=>'Email地址超过最大产能过度',
            'email.unique'=>'邮箱已注册',
        ];
        if (!is_null($data['password'])){
            $rulePassword =[
                'password'=>'min:6|confirmed:repassword'
            ];
            $messagePassword = [
                'password.min'=>'密码不能少于6位',
                'password.confirmed'=>'两次输入密码不一样',
            ];
            $rule = array_merge($rule,$rulePassword);
            $message = array_merge($message,$messagePassword);
        }
        $this->validate($request,$rule,$message);
        // Get the user
        $user = User::findOrFail($id);
        // Update user
        $user->fill($request->except('roles', 'permissions', 'password'));
        // check for password change
        if($request->get('password')) {
            $user->password = bcrypt($request->get('password'));
        }
        // Handle the user roles
        $this->syncPermissions($request, $user);
        $user->save();
         return redirect()->route('user.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->user->find($id);
        $user->delete();
        return redirect()->route('user.index');
    }
    private function syncPermissions(Request $request, $user)
    {
        // Get the submitted roles
        $roles = $request->get('roles', []);
        $permissions = $request->get('permissions', []);

        // Get the roles
        $roles = Role::find($roles);

        // check for current role changes
        if( ! $user->hasAllRoles( $roles ) ) {
            // reset all direct permissions for user
            $user->permissions()->sync([]);
        } else {
            // handle permissions
            $user->syncPermissions($permissions);
        }

        $user->syncRoles($roles);

        return $user;
    }
}
