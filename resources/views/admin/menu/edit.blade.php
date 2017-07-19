@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>编辑栏目</h4>
                        </div>
                        <div class="col-md-6">
                            <a href="{{route('menu.index')}}" class="btn btn-default pull-right">返回</a>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" permission="form" method="POST" action="{{ route('menu.update',$menu->id) }}">
                        {{ csrf_field() }}
                        {{method_field('PUT')}}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">名称</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $menu->name }}" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">URL</label>
        
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="url" value="{{ $menu->url }}" required autofocus>
                                @if ($errors->has('url'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('url') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">导航显示</label>
                            <div class="col-md-1">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="shownav" id="shownav" value="T" @if($menu->shownav == "T") checked @endif>
                                        是
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="shownav" id="shownav" value="F" @if($menu->shownav == "F") checked @endif>
                                        否
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">是否启用</label>
                            <div class="col-md-1">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="status" id="status" value="T" @if($menu->status == "T") checked @endif>
                                        启用
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="status" id="status" value="F" @if($menu->status == "F") checked @endif>
                                        禁用
                                    </label>
                                </div>
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
