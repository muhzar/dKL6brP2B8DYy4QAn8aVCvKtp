@extends('backend.templates.default')

@section('title')
    {{ $title }}
@endsection

@section('head')
@endsection

@section('js')
  <script>
    $(document).ready(function(){
      $('.form-delete').submit(function(e){
        //sadsad
        e.preventDefault();
      });
      $(".alert").alert();
      $('.search-btn').click(function(){
        window.location.href = "?keyword=" + $('.search-input').val(); 
      })
      $('.clear-btn').click(function(){
        window.location.href = "?"; 
      })
    })
  </script>

@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"> </h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 230px;">
                  @if($keyword != '')
                    <div class="input-group-btn">
                      <button type="submit" class="btn btn-default clear-btn" style="margin-right: 2px">clear filter</button>
                    </div>
                  @endif
                  <input type="text" name="table_search" value="{{ $keyword }}" class="form-control pull-right search-input" placeholder="Search">
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default search-btn"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
            @if(session('message'))
            <!-- sucess - danger - warning - info -->
              <div class="box-body">
                <div class="alert alert-{{ session('type') }} alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4><i class="icon fa fa-check"></i> Information!</h4>
                  {{ session('message') }}
                </div>
              </div>
            @endif
              <table class="table table-hover">
                <tbody>
                <tr>
                  <th>No.</th>
                  <th>User Id</th>
                  <th>Command</th>
                  <th>Description</th>
                  <th>Created By</th>
                  <th>Created At</th>
                </tr>

                @foreach($posts as $post)
                  <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $post->user_id }}</td>
                    <td>{{ status($post->command) }}</td>
                    <td>{{ status($post->description) }}</td>
                    <td>{{ $post->created_by }}</td>
                    <td>{{ $post->created_at }}</td>
                  </tr>
                @endforeach
              </tbody>
              </table>
            </di>
            <div class="box-footer clearfix pull-right">
              {{ $posts->links() }}
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
@endsection