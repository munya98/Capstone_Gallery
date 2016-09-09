@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h1 class = "text-center brand-font">Member Log In</h1>
        @if (Session::has('account-status'))
            <span class="help-block">
                <strong class = "error">{{ Session::get('account-status') }}</strong>
            </span>
        @endif
        @if (Session::has('password-update'))
            <span class="help-block">
                <strong class = "success">{{ Session::get('password-update') }}</strong>
            </span>
        @endif
        <form role="form" method="POST" action="{{ url('/login') }}">
            {!! csrf_field() !!}

            <div class = "row">
                <div class = "col-md-4 col-md-offset-4">
                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                    <label for = "username">Username</label>
                        <input class = "custom-input" type="text" name="username" value="{{ old('username') }}">

                        @if ($errors->has('username'))
                            <span class="help-block">
                                <strong class = "error">{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                </div>
            </div>
            </div>

            <div class = "row">
                <div class = "col-md-4 col-md-offset-4">
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for = "password">Password</label>
                        <input class = "custom-input" type="password" name="password">
                        @if (Session::has('status'))
                            <span class="help-block">
                                <strong class = "error">{{ Session::get('status') }}</strong>
                            </span>
                        @endif
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong class = "error">{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                </div>
            </div>
            </div>
            <div class="form-group">
                <div class="col-md-4 col-md-offset-4">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember"> Remember Me
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-4 col-md-offset-4">
                    <button type="submit" class="btn-custom">
                        <i class="fa fa-btn fa-sign-in"></i> Login
                    </button>
                </div>
            </div>
            <div>
                <div class = "col-md-4 col-md-offset-4"><br>
                    <!-- <a href="{{ url('/password/reset') }}">Forgot Your Password?</a> -->
                     <a href="{{ url('user/password/reset') }}">Forgot Your Password?</a>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection
