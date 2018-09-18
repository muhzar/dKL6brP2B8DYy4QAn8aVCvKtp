@extends('frontend.templates.default')

@section('css')

@endsection

@section('js')
    
    <script type="text/javascript">
        var client;
        var map;
        var pos;
        var lastPos;
        var topic = "v1/api/cluster";
        var markers = [];
        var guards = [];
        var clusterCode = '{{ $cluster->code }}';
        var guardTrack;
        var poly;
        var apihost = 'http://43.251.98.16:82';

        $(document).ready(function() {
            initMap({{$cluster->latitude}}, {{$cluster->longitude}});
            mqttConnect();
            setTrack({!!$coors!!});
            setCheckPoint();
            currentPatrolTrack(clusterCode);
        

            function setCheckPoint() {
                @foreach($track_points as $track_point)
                    @foreach($track_point as $coor)
                        addMarker({code: '{{ $coor['checkpoint_code'] }}', title: '{{ $coor['description'] }}', lat: {{ $coor['latitude'] }}, lng: {{ $coor['longitude'] }}, label: '{{ $coor['point_order'] }}' });
                    @endforeach
                @endforeach
            }
        });
        
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB7R5r9_az0OxDsO_oWSVmijdWQYD1grg8"></script>
    <script type="text/javascript" src="/js/cTrack.js"></script>
    <script type="text/javascript" src="/js/dateNow.js"></script>
    <script type="text/javascript" src="/js/initMap.js"></script>
    <script type="text/javascript" src="/js/setTrack.js"></script>
    <script type="text/javascript" src="/js/addGuard.js"></script>
    <script type="text/javascript" src="/js/cPolyline.js"></script>
    <script type="text/javascript" src="/js/mqtt.js"></script>
    <script type="text/javascript" src="/js/inTrack.js"></script>
    <script type="text/javascript" src="/js/cPatrol.js"></script>
    <script type="text/javascript" src="/js/addCheckpoint.js"></script>
    <script type="text/javascript" src="/js/currentTrack.js"></script>
        
@endsection

@section('content')
<div class="cluster-page">
    <div class="claster-name"><span><a href="/" style="color: #fff;font-size: 14px;">Home</a></span>{{ $clusterName }}</div>
    <div id="map"></div>
    <div class="div-command">
        <label>INFO</label>
        
        <div class="outoftrack"></div>
        <div class="geo"></div>
        <div class="patrolstatus"></div>
        <div class="patrolstatuslist"></div>

    </div>
</div>
@endsection
