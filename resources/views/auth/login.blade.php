@extends('backend.templates.login')
@section('content')
 <div class="login-box-body">
      <p class="login-box-msg">Please Sign in to continue...</p>

      <form action="{{ route('login') }}" method="post" role="form">
        {{ csrf_field() }}
        @if ($errors->has('email') || $errors->has('password') )
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
            {{ $errors->first('email') }}
          </div>
        @endif
        <div class="form-group has-feedback">
          <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input id="password" type="password" class="form-control" name="password" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <a href="{{ route('password.request') }}">I forgot my password</a><br>

    </div>
@endsection

