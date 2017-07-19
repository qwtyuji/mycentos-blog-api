@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class=" col-md-offset-1 col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>用户列表</h4>
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('user.index')}}" class="btn btn-default pull-right">返回</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item">名称:{{$user->name}}</li>
                            <li class="list-group-item">Email:{{$user->email}}</li>
                            <li class="list-group-item">登录时间:{{$user->updated_at}}</li>
                            <li class="list-group-item">注册时间:{{$user->updated_at}}</li>
                        </ul>
                        <div>
                            <h4>用户权限</h4>
                        </div>
                        <hr>
    
                        <div class="col-md-12">
                            @foreach($permission as $v)
                                @php
                                    $checked = $user->hasPermissionTo($v->name)?"checked":"";
                                @endphp
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permissions[]" value="{{$v->name}}" {{$checked}}>
                                            {{$v->cname}}({{$v->name}})
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
