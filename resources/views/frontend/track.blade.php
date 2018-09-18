@extends('frontend.templates.default')

@section('css')

@endsection

@section('js')
        
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB7R5r9_az0OxDsO_oWSVmijdWQYD1grg8&callback=initMap"></script>
    <script type="text/javascript">
        var markers;
        var poly;
        var map;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 16,
                center: {lat: -6.175590504934915, lng: 106.82722392889707}  // Center the map on Chicago, USA.
            });

            setTrack();
            setCheckPoint();
        }

        function setTrack() {
            var flightPlanCoordinates = [
                @foreach($coordinates as $coor)
                    {lat: {{ $coor['latitude'] }}, lng: {{ $coor['longitude'] }} },
                @endforeach
            ];
            var flightPath = new google.maps.Polyline({
                path: flightPlanCoordinates,
                geodesic: true,
                strokeColor: '#FF0000',
                strokeOpacity: .9,
                strokeWeight: 3
            });

            flightPath.setMap(map);
        }

        function setCheckPoint() {
            @foreach($track_points as $track_point)
                addMarker({lat: {{ $track_point['latitude'] }}, lng: {{ $track_point['longitude'] }}, label: '{{ $track_point['checkpoint_code'] }}' });
            @endforeach
        }

        function addMarker(pos) {
            var imageMarker = {
                url: 'skin/images/check-point.png',
                size: new google.maps.Size(40,40),
                anchor: new google.maps.Point(20,20)
            }
            // if (typeof(markers) != "undefined") markers.setMap(null);
            markers = new google.maps.Marker({
                position: pos,
                label: {text: pos.label, color: "#0718f8"},
                map: map,
                title: '',
                icon: imageMarker
            });
        }

    </script>
@endsection

@section('content')
	<div id="map"></div>
@endsection
