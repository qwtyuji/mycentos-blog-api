@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>编辑角色</h4>
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('role.index')}}" class="btn btn-default pull-right">返回</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('role.update',$role->id) }}">
                            {{ csrf_field() }}
                            {{method_field('PUT')}}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">名称</label>
                                
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ $role->name }}" required autofocus>
                                    
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div  class="col-md-4"><h4>权限</h4></div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <hr>
                                    @foreach($permission as $vo)
                                        @php
                                            $checked =$role->hasPermissionTo($vo->name) ? "checked":"";
                                        @endphp
                                        <div class="col-sm-3">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]" {{$checked}} value="{{$vo->name}}">
                                                    {{$vo->cname}}({{$vo->name}})
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        保存
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
