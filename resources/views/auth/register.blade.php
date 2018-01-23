@extends('layouts.app')
@section('content')
    <style>
        @media (min-width: 768px){

            .form-horizontal .control-label {
                text-align: left;

            }
        }
        .warehouse{
            color:#a94442;
        }
        .help-block{
            color:red;
        }
    </style>
    <div class="wrapper-login">
        <div class="panel-body">

            <div class="container-logins">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <label for="last_name" class="col-md-4 control-label">Last Name</label>

                        <div class="col-md-8">
                            <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <label for="first_name" class="col-md-4 control-label">First Name</label>

                        <div class="col-md-8">
                            <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required>

                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="warehouse_select" class="col-md-4 control-label">Branch</label>

                        <div class="col-md-8">
                            <select id="warehouse_select"  class="form-control" name="warehouse_select" required>
                                <option selected disabled>Select Branch</option>
                                @foreach(\App\Branches::get() as $key => $val)
                                    <option value="{{ $val->id }}">{{ $val->name }}</option>

                                @endforeach
                            </select>

                            @if ($errors->has('warehouse_select'))
                                <span class="help-block">
                                        <strong class="warehouse">{{ $errors->first('warehouse_select') }}</strong>
                                    </span>
                            @endif

                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                        <div class="col-md-8">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Password</label>

                        <div class="col-md-8">
                            <input id="password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                        <div class="col-md-8">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-5">
                            <button type="submit" class="form-control btn btn-primary" style="margin-top: 5px">
                                Register
                            </button>
                        </div>
                        <div class="col-md-5 ">

                                <a href="{{ url('login') }}" style="position: relative;top:12px;color:red;font-weight: 700">I already have an account</a>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
