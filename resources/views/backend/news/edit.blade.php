@extends('backend.templates.default')

@section('title')
    {{ $title }}
@endsection

@section('head')
    <link href="{{ asset('backend/css/datepicker.css') }}" rel="stylesheet">
    <style type="text/css">
        label.myLabel input[type="file"] {
            position: fixed;
            top: -1000px;
        }

        /***** Example custom styling *****/
        .myLabel, .delete-custom-field {
            border: 1px solid #cecece;
            border-radius: 4px;
            padding: 2px 5px;
            margin: 2px;
            background: #fff;
            display: inline-block;
            width: 24px;
            text-align: center;
        }
        .myLabel:hover {
            background: #fff;
        }
        .myLabel:active {
            background: #CCF;
        }
        .myLabel :invalid + span {
            color: #A44;
        }
        .myLabel :valid + span {
            color: #4A4;
        }
    </style>
@endsection

@section('js')
    
    <script>
        function uploader() {
            $('.custom-img').fileupload({
                url: '{{ url('cms/uploads/images')}}',
                type: 'POST',
                dataType: 'json',
                done: function (e, data) {
                    $.each(data.result.files, function (index, file) {
                        imageURL = '/{{ config('app.folder_upload_images') }}/' + file.url;
                    });
                    $(this).parents().parents().children('#exampleInputPassword1').val(imageURL);
                }
            });
        };
    </script>
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
        return text.toString().toLowerCase().trim()
            .replace(/\s+/g, '-')           // Replace spaces with -
            .replace(/&/g, '-')         // Replace & with 'and'
            .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
            .replace(/\-\-+/g, '-');   

    }
    $(document).ready(function(){
        $('.title').keyup(
            function() 
            {
                $('.slug').val(getSlug($(this).val()));
            }
        );

        $('.btn-add-custom-field').click(function(e){
                $('.custom-fields').append('<div class="custom-field col-md-12"style="padding-bottom:10px;"><div class="col-md-6"><div class="form-group"><div class="col-md-6"><input name="custom-field-name[]"value=""type="text"class="form-control"id="exampleInputPassword1"placeholder="Custom field name" required></div><div class="col-md-6"><input name="custom-field-value[]"value=""type="text"class="form-control"id="exampleInputPassword1"placeholder="Custom field value" required><label class="myLabel"><input id="fileupload" type="file" name="images[]" class="custom-img"><span class="fa fa-download" aria-hidden="true"></span></label><a href="#" class="delete-custom-field"><span class="fa fa-trash" aria-hidden="true"></span></a></div></div></div></div>');
                setDelete();       
                uploader();      
                e.preventDefault();
                return false;
        });

        function setDelete() {
            $('.delete-custom-field').click(function(e) {
                $(this).parent().parent().parent().parent().remove();
                e.preventDefault();
                return false;
            })
        }

        setDelete();
    });
    
    $("#datetimepicker input").datepicker({ dateFormat: 'yy-mm-dd', autoclose: true });
    
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

        <form role="form" method="POST" action="{{ route('news.update', $post->id) }}" enctype="multipart/form-data">
            {{ method_field('PUT') }}
            @include('backend.news.form')
          <div class="box-footer text-center">
            <button type="button" onclick="window.location.href='{{ URL::previous() }}'" class="btn btn-primary">Back</button> 
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
    </div>
@endsection