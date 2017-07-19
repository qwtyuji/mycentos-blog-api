@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class=" col-md-offset-1 col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>权限列表</h4>
                            </div>
                            <div class="col-md-6">
                                @can('add_permission')
                                    <a href="{{route('permission.create')}}" class="btn btn-default pull-right">添加</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered table-hover table-responsive">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>名称</th>
                                <th>描述</th>
                                <th>分组</th>
                                <th>认证guard</th>
                                <th>登录时间</th>
                                <th>注册时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($permission as $vo)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$vo->name}}</td>
                                    <td>{{$vo->cname}}</td>
                                    <td>{{$vo->group}}</td>
                                    <td>{{$vo->guard_name}}</td>
                                    <td>{{$vo->updated_at}}</td>
                                    <td>{{$vo->created_at}}</td>
                                    <td>
                                        <div class="btn-group">
                                            @can('view_permission')
                                                <a href="{{route('permission.show',$vo->id)}}" class="btn btn-sm btn-success">查看</a>
                                            @endcan
                                            @can('edit_permission')
                                                <a href="{{route('permission.edit',$vo->id)}}" class="btn btn-sm btn-danger">修改</a>
                                            @endcan
                                            @can('delete_permission')
                                                <a onclick="event.preventDefault();
                                                        document.getElementById('delete-{{$vo->id}}').submit();"
                                                   class="btn btn-sm btn-warning">删除
                                                </a>
                                            @endcan
                                        </div>
                                        <form id="delete-{{$vo->id}}" action="{{route('permission.destroy',$vo->id)}}"
                                              method="post" class="form-horizontal"
                                              style="display: inline-block;margin: 0;padding: 0;">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                                    
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pull-right">
                            {{$permission->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
