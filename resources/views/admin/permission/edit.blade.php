@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>编辑权限</h4>
                        </div>
                        <div class="col-md-6">
                            <a href="{{route('permission.index')}}" class="btn btn-default pull-right">返回</a>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" permission="form" method="POST" action="{{route('permission.update',$permission->id)}}">
                        {{ csrf_field() }}
                        {{method_field('PUT')}}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">名称</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $permission->name }}" autofocus
                                       placeholder="规则:操作_模块 如:view_roles/add_roles/edit_roles/delete_roles">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('cname') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">描述:</label>
        
                            <div class="col-md-6">
                                <input id="cname" type="text" class="form-control" name="cname" value="{{ $permission->cname }}" autofocus
                                       placeholder="如:角色列表">
            
                                @if ($errors->has('cname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('group') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">分组</label>
        
                            <div class="col-md-6">
                                <input id="group" type="text" class="form-control" name="group" value="{{ $permission->group }}" autofocus
                                       placeholder="如:权限管理(实现角色勾选权限时可按分组全选)">
            
                                @if ($errors->has('group'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('group') }}</strong>
                                    </span>
                                @endif
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
