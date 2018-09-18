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
          <h3 class="box-title">Edit new {{ getCurrentController() }}</h3>
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

        <form role="form" method="POST" action="{{ route('guard.update', $post->id) }}" enctype="multipart/form-data">
            {{ method_field('PUT') }}
            @include('backend.guard.form')
          <div class="box-footer text-center">
            <button type="button" onclick="window.location.href='{{ URL::previous() }}'" class="btn btn-primary">Back</button> 
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
    </div>
@endsection