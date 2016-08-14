@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h1 class = "text-center brand-font">Register Account</h1>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
            {!! csrf_field() !!}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                
                <div class="col-md-4 col-md-offset-4">
                    <label for = "name">Name</label>

                    <input class = 'custom-input' type="text" name="name" value="{{ old('name') }}">

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong class = "error">{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                <div class="col-md-4 col-md-offset-4">
                    <label for = 'username'>Username</label>

                    <input class = 'custom-input' type="text" name="username" value="{{ old('username') }}">

                    @if ($errors->has('username'))
                        <span class="help-block">
                            <strong class = "error">{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <div class="col-md-4 col-md-offset-4">
                    <label for ="password">Password</label>
                    <input class = "custom-input" type="password" name="password">

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong class = "error">{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <div class="col-md-4 col-md-offset-4">
                    <label for = "password_confirmation">Confirm Password</label>
                    <input type="password" class="custom-input" name="password_confirmation">

                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong class = "error">{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">
                <div class="col-md-4 col-md-offset-4">
                    <label for="question">Secret Question</label>
                    <input type="text" class="custom-input" name="question" value="{{ old('question') }}" placeholder="Create your own question or phrase...">

                    @if ($errors->has('question'))
                        <span class="help-block">
                            <strong class ="error">{{ $errors->first('question') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
                <div class="col-md-4 col-md-offset-4">
                    <label for = "answer">Secret Answer</label>
                    <input type="text" class="custom-input" name="answer" value="{{ old('answer') }}">

                    @if ($errors->has('secretanswer'))
                        <span class="help-block">
                            <strong class = "error">{{ $errors->first('secretanswer') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-md-4 col-md-offset-4">
                    <button type="submit" class="btn-custom">
                        <i class="fa fa-btn fa-user"></i> Register
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
