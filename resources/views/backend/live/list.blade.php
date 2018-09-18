@extends('backend.templates.default')

@section('title')
    {{ $title }}
@endsection

@section('head')
    <link href="{{ asset('backend/css/jquery-ui.min.css') }}" rel="stylesheet">
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('backend/js/jquery-ui.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $(".btn-delete").on("click", function() {
                var submitId = $(this);
                $( "#dialog-confirm" ).dialog({
                    resizable: false,
                    height: "auto",
                    width: 400,
                    modal: true,
                    buttons: {
                      "Yes": function() {
                        $(submitId).parent().submit();
                        $( this ).dialog( "close" );
                      },
                      No: function(e) {
                        $( this ).dialog( "close" );
                      }
                    }
                });

            });

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
    <div id="dialog-confirm" title="Basic dialog">
        <p>Are your sure want delete this record ?</p>
    </div>
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><small><a class="btn btn-default" href="{{ url('cms/' . strtolower(getCurrentController()) . '/create') }}">add new</a></small></h3>

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
                  <th>User Name</th>
                  <th>User ID</th>
                  <th>Created By</th>
                  <th>Created At</th>
                  <th colspan="2" class="text-center">Action</th>
                </tr>

                @foreach($users as $user)
                  <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ formatedDate($user->created_at) }}
                    <td width="100"><form class="form-delete" method="POST" action="{{ route('guard.destroy', $user->id)  }}">{{ csrf_field() }} {{ method_field('DELETE') }}<button type="button" class="btn-delete btn btn-sm btn-block btn-danger" style="width: 80px">Delete</button></form></td>
                    <td width="100"><form class="form-update" method="GET" action="{{ route('guard.edit', $user->id)  }}"><button type="submit" class="btn btn-sm btn-block btn-warning" style="width: 80px">Edit</button></form></td>
                  </tr>
                @endforeach
              </tbody>
              </table>
            </di>
            <div class="box-footer clearfix pull-right">
              {{ $users->links() }}
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
@endsection