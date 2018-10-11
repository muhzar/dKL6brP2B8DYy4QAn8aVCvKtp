@extends('backend.templates.default')

@section('title')
    {{ $title }}
@endsection

@section('head')
@endsection

@section('js')

@endsection

@section('content')
	<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><small></small></h3>
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
                  <th>Guard Name</th>
                  <th>Cluster</th>
                  <th>Shift</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
                @if(isset($posts))
                    @foreach($posts as $post)
                      <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $post->getGuard->name }}</td>
                        <td>{{ $post->getCluster->name }}</td>
                        <td>{{ $post->getShift->name }}</td>
                        <td>{{ date('d F Y', strtotime($post->date)) }}</td>
                        <td><a href="{{ url('cms/history/map?guard_id=' . $post->getGuard->username . '&cluster_id=' . $post->getCluster->id . '&shift=' . $post->getShift->id . '&date=' .date('Y-m-d', strtotime($post->date))) }}" target="_blank">show track</a></td>
                      </tr>
                    @endforeach
                @endif
              </tbody>
              </table>
            </di>
            <div class="box-footer clearfix pull-right">
                @if(isset($posts))
                    {{ $posts->links() }}
                @endif 
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
@endsection