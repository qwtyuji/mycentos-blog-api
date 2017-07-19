@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class=" col-md-offset-1 col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>权限详细</h4>
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('permission.index')}}" class="btn btn-default pull-right">返回</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item">名称:{{$permission->name}}</li>
                            <li class="list-group-item">描述:{{$permission->cname}}</li>
                            <li class="list-group-item">分组:{{$permission->group}}</li>
                            <li class="list-group-item">认证guard:{{$permission->guard_name}}</li>
                            <li class="list-group-item">登录时间:{{$permission->updated_at}}</li>
                            <li class="list-group-item">注册时间:{{$permission->updated_at}}</li>
                        </ul>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
