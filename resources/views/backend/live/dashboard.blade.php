@extends('backend.templates.default')

@section('title')
    {{ $title }}
@endsection

@section('head')
@endsection

@section('js')

<script type="text/javascript">
    var id = 0;
    setInterval(function(){getData()}, 1000);
    function getData() {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "http://43.251.98.16:82/v1/route/live",
            // url: "http://local.apialamsutera.mbp/v1/route/live",
            success: function( response ) { 
                if (response.data.id != id) {
                    $('.live').prepend('<div style="display: block">' + 
                        '<span style="display: inline-block;width: 100px;max-width: 100px;">' + response.data.cluster_id + '</span>' + 
                        '<span style="display: inline-block;width: 100px;max-width: 100px;">' + response.data.latitude +'</span>' + 
                        '<span style="display: inline-block;width: 100px;max-width: 100px;">' + response.data.longitude + '</span>' +
                        '<span style="display: inline-block;width: 100px;max-width: 100px;">' + response.data.accuracy + '</span>' +
                        '<span style="display: inline-block;width: 60px;max-width: 60px;">' + response.data.speed + '</span>' +
                        '<span style="display: inline-block;width: 220px;max-width: 220px;">' + response.data.created_at + '</span>' + '</div>');
                    id = response.data.id;
                }
            },
            error: function( error ){
                alert( error );
            }

        });
    }
</script>
@endsection

@section('content')
    <div class="box box-primary">
    	<div class="box-header with-border">
        	<h3 class="box-title">Streaming Data Entry</h3>
      	</div>
        <div class="headers" style="text-align:left; margin: 10px; ">
            <span style="display: inline-block;width: 100px;max-width: 100px; font-weight: bold;">Cluster Code</span>
            <span style="display: inline-block;width: 100px;max-width: 100px; font-weight: bold;">Latitude</span>
            <span style="display: inline-block;width: 100px;max-width: 100px; font-weight: bold;">Longitude</span>
            <span style="display: inline-block;width: 100px;max-width: 100px; font-weight: bold;">Accuracy</span>
            <span style="display: inline-block;width: 60px;max-width: 60px; font-weight: bold;">Speed</span>
            <span style="display: inline-block;width: 220px;max-width: 220px; font-weight: bold;">Date</span>
        </div>
        <div class="live" style="text-align:left;margin: 10px; max-height: 500px; overflow: scroll;"></div>
    </div>
@endsection