@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>栏目详细</h4>
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('menu.index')}}" class="btn btn-default pull-right">返回</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item">名称:{{$menu->name}}</li>
                            <li class="list-group-item">URL:{{$menu->url}}</li>
                            <li class="list-group-item">导航显示:{{config('hupo.shownav')[$menu->shownav]}}</li>
                            <li class="list-group-item">状态:{{config('hupo.status')[$menu->status]}}</li>
                            <li class="list-group-item">更新时间:{{$menu->updated_at}}</li>
                            <li class="list-group-item">添加时间:{{$menu->created_at}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
