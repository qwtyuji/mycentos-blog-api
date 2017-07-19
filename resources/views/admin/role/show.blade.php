@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                <h4><strong style="color: red;">{{$role->name}}</strong>的权限</h4>
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('role.index')}}" class="btn btn-default pull-right">返回</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                            <div class="form-group">
                                @foreach($permission as $vo)
                                    <div class="col-sm-3">
                                        <div class="checkbox">
                                            <label>
                                                @php
                                                    $checked = $role->hasPermissionTo($vo->name)?"checked":"";
                                                @endphp
                                                <input type="checkbox" name="permissions[]" {{$checked}} value="{{$vo->name}}">
                                                {{$vo->cname}}({{$vo->name}})
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
