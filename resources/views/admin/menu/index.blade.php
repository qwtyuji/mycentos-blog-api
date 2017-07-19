@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class=" col-md-offset-1 col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>栏目列表</h4>
                            </div>
                            <div class="col-md-6">
                                @can('add_menu')
                                    <a href="{{route('menu.create')}}" class="btn btn-default pull-right">添加</a>
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
                                <th>链接</th>
                                <th>导航显示</th>
                                <th>是否启用</th>
                                <th>修改时间</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($menu as $vo)
                                <tr>
                                    <td>{{$vo->id}}</td>
                                    <td>{{$vo->name}}</td>
                                    <td>{{$vo->url}}</td>
                                    <td>{{config('hupo.shownav')[$vo->shownav]}}</td>
                                    <td>{{config('hupo.status')[$vo->status]}}</td>
                                    <td>{{$vo->updated_at}}</td>
                                    <td>{{$vo->created_at}}</td>
                                    <td>
                                        <div class="btn-group">
                                            @can('view_menu')
                                                <a href="{{route('menu.show',$vo->id)}}" class="btn btn-sm btn-success">查看</a>
                                            @endcan
                                            @can('edit_menu')
                                                <a href="{{route('menu.edit',$vo->id)}}" class="btn btn-sm btn-danger">修改</a>
                                            @endcan
                                            @can('delete_menu')
                                                <a onclick="event.preventDefault();
                                                        document.getElementById('delete-{{$vo->id}}').submit();"
                                                   class="btn btn-sm btn-warning">删除
                                                </a>
                                            @endcan
                                        </div>
                                        <form id="delete-{{$vo->id}}" action="{{route('menu.destroy',$vo->id)}}"
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
                            {{$menu->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
