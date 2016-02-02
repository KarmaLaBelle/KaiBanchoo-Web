@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row vertical-align">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Avatar</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/dashboard/avatar') }}" enctype="multipart/form-data">
                            {!! csrf_field() !!}

                            <div class="form-group{{ $errors->has('avatarError') ? ' has-error' : '' }}">
                                <div class="col-md-8 col-md-offset-2">
                                    <label>Current Avatar</label>
                                    <br/>
                                    <img src="{!! $avatar !!}">
                                    <br/><br/>
                                    <label>Upload New Avatar</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" name="avatar">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-btn fa-sign-in"></i>Upload
                                            </button>
                                        </span>
                                    </div>
                                    @if ($errors->has('avatar'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('avatar') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
