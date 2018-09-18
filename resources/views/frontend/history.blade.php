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
            setCheckPoint();
        

            function setCheckPoint() {
                @foreach($track_points as $track_point)
                    @foreach($track_point as $coor)
                        addMarker({code: '{{ $coor['checkpoint_code'] }}', title: '{{ $coor['description'] }}', lat: {{ $coor['latitude'] }}, lng: {{ $coor['longitude'] }}, label: '{{ $coor['point_order'] }}' });
                    @endforeach
                @endforeach
            }

            var flightPlanCoordinates = [
              @foreach($points as $point)
                { lat: {{$point->latitude}}, lng: {{$point->longitude}} },
              @endforeach
            ];
            var flightPath = new google.maps.Polyline({
              path: flightPlanCoordinates,
              geodesic: true,
              strokeColor: '#FF0000',
              strokeOpacity: 1.0,
              strokeWeight: 2
            });

            flightPath.setMap(map);
            
        });
        
    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB7R5r9_az0OxDsO_oWSVmijdWQYD1grg8"></script>
    <script type="text/javascript" src="/js/dateNow.js"></script>
    <script type="text/javascript" src="/js/initMap.js"></script>
    <script type="text/javascript" src="/js/setTrack.js"></script>
    <script type="text/javascript" src="/js/cPolyline.js"></script>
    <script type="text/javascript" src="/js/addCheckpoint.js"></script>
        
@endsection

@section('content')
<div class="cluster-page">
    <div class="claster-name">{{ $clusterName }} <br></div>
    <div id="map"></div>
</div>
@endsection
