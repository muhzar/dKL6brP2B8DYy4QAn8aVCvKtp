@extends('backend.templates.default')

@section('title')
    {{ $title }}
@endsection

@section('head')
@endsection

@section('js')

    <script type="text/javascript">
        $('.add-point').on('click', function(e) {
            $('.tbl-route tr:last').after('<tr> \
                                        <td><input type="text" name="order[]" value=""></td>\
                                        <td><input type="text" name="checkpoint_code[]" value=""></td>\
                                        <td><input type="text" name="lat[]" value=""></td>\
                                        <td><input type="text" name="long[]" value=""></td>\
                                        <td><input type="text" name="description[]" value=""></td>\
                                        <td><input type="text" name="beacon[]" value=""></td>\
                                        <td><a href="" class="delete">delete</td>\
                                    </tr>');
            e.preventDefault();
        })

        $("tr td .delete").on("click", function(e){
            $(this).parent().parent().remove();
            e.preventDefault();
        })
        
    </script>
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

        <form role="form" method="POST" action="{{ route('track.update', $post->id) }}" enctype="multipart/form-data">
            {{ method_field('PUT') }}
            @include('backend.track.form')
          <div class="box-footer text-center">
            <button type="button" onclick="window.location.href='{{ URL::previous() }}'" class="btn btn-primary">Back</button> 
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
    </div>
@endsection
