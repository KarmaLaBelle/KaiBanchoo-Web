@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="side-body padding-top">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">Login</div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                                {!! csrf_field() !!}
                                <div class="form-group{{ $errors->has('email') ? ' has-error has-feedback' : '' }}">
                                    <div class="col-sm-10 col-sm-offset-1">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                            <input type="email" class="form-control" name="email" placeholder="E-Mail" value="{{ old('email') }}"{{ $errors->has('email') ? 'aria-describedby="emailErrorStatus"' : '' }}>
                                        </div>
                                        @if ($errors->has('email'))
                                            <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                                            <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                                            <span id="emailErrorStatus" class="sr-only">(error)</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error has-feedback' : '' }}">
                                    <div class="col-sm-10 col-sm-offset-1">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                            <input type="password" class="form-control" name="password" placeholder="Password"{{ $errors->has('password') ? 'aria-describedby="passwordErrorStatus"' : '' }}>
                                        </div>
                                        @if ($errors->has('password'))
                                            <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                                            <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                                            <span id="passwordErrorStatus" class="sr-only">(error)</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10 col-sm-offset-1">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember"> Remember me
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-default">Sign in</button>
                                        <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
