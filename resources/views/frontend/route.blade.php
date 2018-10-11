@extends('frontend.templates.default')

@section('css')

@endsection

@section('js')
        
    <script>

      var poly;
      var map;
      var coo = [];
      var markers = [];
      var track = [];

      function initMap() {
        styles = [{"featureType":"all","elementType":"labels","stylers":[{"gamma":0.26},{"visibility":"off"}]},{"featureType":"administrative.province","elementType":"all","stylers":[{"visibility":"on"},{"lightness":-50}]},{"featureType":"administrative.province","elementType":"labels.text","stylers":[{"lightness":20}]},{"featureType":"administrative.province","elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"hue":"#ffffff"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"lightness":50},{"hue":"#ffffff"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"lightness":20}]},{"featureType":"road.arterial","elementType":"labels.text","stylers":[{"visibility":"on"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"visibility":"on"}]}];
        var coo = [-6.225947, 106.646944];
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 17,
          center: {lat: coo[0], lng: coo[1]}  ,
          styles: styles
        });
        poly = new google.maps.Polyline({
          strokeColor: '#000000',
          strokeOpacity: 1.0,
          strokeWeight: 3
        });
        poly.setMap(map);

        map.addListener('click', addLatLng);
      }

      function addLatLng(event) {
        console.log(event);
        var path = poly.getPath();
        var co =  event.latLng;
        coo.push([co.lat(), co.lng()]);
        // console.log(coo);
        path.push(event.latLng);

        // var marker = new google.maps.Marker({
        //   position: event.latLng,
        //   title: '#' + path.getLength(),
        //   map: map
        // });

        // markers.push(marker);
      }

        $('.save').on('click', function() {
            if ($('#cluster_code').val() =='') {
                alert('please input cluster code first')
                return false;
            }

            if ($('#track_code').val() =='') {
                alert('please input track code first')
                return false;
            }

            if ($('#track_name').val() =='') {
                alert('please input track name first')
                return false;
            }


            data = { 
                track_code: $('#track_code').val(),
                cluster_code: $('#cluster_code').val(), 
                data: coo,
                 _token: '{{ csrf_token()}}' 
             };
            $.ajax({
                type: "POST",
                url: 'track/save',
                data: data,
                success: function(e) {
                    console.log('success');
                    alert('success update route cluster');
                },
                dataType: 'json'
            });
        })

        $('.reset').on('click', function() {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            markers = [];
            coo = [];
            poly.setMap(null);
            poly = new google.maps.Polyline({
              strokeColor: '#000000',
              strokeOpacity: 1.0,
              strokeWeight: 3,
            });

            poly.setMap(map);
        })

        $('#cluster_code').on('change', function() {
            $.ajax({
                type: "GET",
                url: 'geo?cluster-code=' + $(this).val(),
                success: function(result) {
                    map.setCenter(result.geo); 
                    track = result.track;
                    var $select = $('#track_code');
                    $('#track_code option').remove();
                    $(result.track).each(function (index, o) {    
                        var $option = $("<option/>").attr("value", o.code).text(o.name);
                        $select.append($option);
                    });

                },
                dataType: 'json'
            });
        })

        $('.undo').on('click', function() {
            coo.pop();
            poly.getPath().removeAt(coo.length);
        });

        function setTrack(pathObj) {                    
            var flightPath = new google.maps.Polyline({
                path: pathObj,
                geodesic: true,
                strokeColor: '#e96648',
                strokeOpacity: .9,
                strokeWeight: 4
            });

            flightPath.setMap(map);
        }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB7R5r9_az0OxDsO_oWSVmijdWQYD1grg8&callback=initMap">
    </script>
@endsection

@section('content')
    <div class="route-page">
        <div id="map"></div>
        <div class="div-command">
            <label>Cluster Name</label>
            <select id="cluster_code">
                <option value="">==select==</option>
                @foreach($clusters as $cluster)
                    <option value="{{ $cluster->id }}">{{ $cluster->name }}</option>
                @endforeach
            </select><br>
            <label>Track ID</label>
             <select id="track_code">
             </select>
            <br>
            <div class="command-btn">
                <button class="undo">undo</button>
                <button class="reset">reset</button>
                <button class="save">save</button>
            </div>
        </div>
    </div>
@endsection