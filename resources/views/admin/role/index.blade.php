@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class=" col-md-offset-1 col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>角色列表</h4>
                            </div>
                            <div class="col-md-6">
                                @can('add_role')
                                    <a href="{{route('role.create')}}" class="btn btn-default pull-right">添加</a>
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
                                <th>用户认证</th>
                                <th>修改时间</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($role as $vo)
                                <tr>
                                    <td>{{$vo->id}}</td>
                                    <td>{{$vo->name}}</td>
                                    <td>{{$vo->guard_name}}</td>
                                    <td>{{$vo->updated_at}}</td>
                                    <td>{{$vo->created_at}}</td>
                                    <td>
                                        <div class="btn-group">
                                            @can('view_role')
                                                <a href="{{route('role.show',$vo->id)}}" class="btn btn-sm btn-success">查看</a>
                                            @endcan
                                            @can('edit_role')
                                                <a href="{{route('role.edit',$vo->id)}}" class="btn btn-sm btn-danger">修改</a>
                                            @endcan
                                            @can('delete_role')
                                                <a onclick="event.preventDefault();
                                                        document.getElementById('delete-{{$vo->id}}').submit();"
                                                   class="btn btn-sm btn-warning">删除
                                                </a>
                                            @endcan
                                        </div>
                                        <form id="delete-{{$vo->id}}" action="{{route('role.destroy',$vo->id)}}"
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
                            {{$role->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
