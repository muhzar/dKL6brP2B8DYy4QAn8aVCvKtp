@extends('backend.templates.default')

@section('title')
    {{ $title }}
@endsection

@section('head')
@endsection

@section('js')
    <script src="{{ asset('backend/plugins/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('backend/plugins/ckeditor/config.js') }}"></script>
    <script>
      $(function () {
        CKEDITOR.replaceAll( 'editor-class', {
            filebrowserBrowseUrl: '/browser/browse.php',
            filebrowserUploadUrl: '/uploader/upload.php'
        });
      });
      function getSlug(text) 
    {
        x = text.split(' ').slice(0, 2).join('');   
        return x.toUpperCase();

    }
    $(document).ready(function(){
        $('.name').keyup(
            function() 
            {
                $('.code').val(getSlug($(this).val()));
            }
        );
    })
    </script>
@endsection

@section('content')
    <div class="box box-primary">
    	<div class="box-header with-border">
        	<h3 class="box-title">Add new {{ getCurrentController() }}</h3>
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

      	<form role="form" method="POST" action="{{ route('cluster.store') }}" enctype="multipart/form-data">	
        	   @include('backend.cluster.form')
        	<div class="box-footer text-center">
            <button type="button" onclick="window.location.href='{{ URL::previous() }}'" class="btn btn-primary">Back</button> 
          	<button type="submit" class="btn btn-primary">Submit</button>
        	</div>
      	</form>
    </div>
@endsection