@extends('backend.templates.default')

@section('title')
    {{ $title }}
@endsection

@section('head')
@endsection

@section('js')
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
          <h3 class="box-title">Change Password {{ getCurrentController() }}</h3>
        </div>
        @if (count($errors) > 0)
            <div class="box-body">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form role="form" method="POST" action="{{ '/cms/user/password/change' }}" enctype="multipart/form-data">
            {{ csrf_field() }}              
            <div class="box-body">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Current Password</label>
                        <input name="current-password" value="" class="form-control"  type="password">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">New Password</label>
                        <input name="password" value="" class="form-control"  type="password">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">New Password Confirmation</label>
                        <input name="password_confirmation" value="" class="form-control"  type="password">
                    </div>
                </div>
                
            </div>
            <div class="box-footer text-center">
                <button type="button" onclick="window.location.href='{{ URL::previous() }}'" class="btn btn-primary">Back</button> 
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection