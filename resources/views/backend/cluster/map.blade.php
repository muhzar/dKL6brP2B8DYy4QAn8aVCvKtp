@extends('backend.templates.default')

@section('css')

@endsection

@section('js')


    <script>

      var poly;
      var map;
      var coo = [];
      var markers = [];
      var markersLatLng = [];
      var track = [];

      function initMap() {
                $('.caption').hide();

        styles = [{"featureType":"all","elementType":"labels","stylers":[{"gamma":0.26},{"visibility":"off"}]},{"featureType":"administrative.province","elementType":"all","stylers":[{"visibility":"on"},{"lightness":-50}]},{"featureType":"administrative.province","elementType":"labels.text","stylers":[{"lightness":20}]},{"featureType":"administrative.province","elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"hue":"#ffffff"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"lightness":50},{"hue":"#ffffff"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"lightness":20}]},{"featureType":"road.arterial","elementType":"labels.text","stylers":[{"visibility":"on"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"visibility":"on"}]}];
        var coo = [-6.225947, 106.646944];
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 17,
          center: {lat: coo[0], lng: coo[1]}  ,
          styles: styles
        });

        map.addListener('click', addLatLng);
      }

      function addLatLng(event) {
        indexMarker = markers.length + 1;
        markers.push(new google.maps.Marker({
          position: event.latLng,
          map: map,
          label: indexMarker.toString()
        }));
        
        var latLng = {
            'lat': event.latLng.lat(),
            'lng':event.latLng.lng()
        }

        markersLatLng.push(latLng);

        if(markers.length > 0) {
            $('.caption').show();
        }

        $('#list-caption').append('<span class="markerIndex" style="margin-bottom: 5px; display: block">caption #' + (markers.length) + ' <input type="text" name="textcaption[]" style="width: 200px"><br></span> ');
        
      }

        $('.undo').on('click', function() {
            if(markers.length ==0) {
                $('.caption').hide();
                $('#list-caption').html('');
            } else {
                $('.markerIndex').last().remove();
                markers.pop().setMap(null);
                markersLatLng.pop();
            }
            

        });

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
            var i = 0;
            $('input[name="textcaption[]"]').each(function() { 
                markersLatLng[i].caption = $(this).val();
                i++;
            });


            data = { 
                track_code: $('#track_code').val(),
                cluster_code: $('#cluster_code').val(), 
                checkpoint: markersLatLng,
                _token: '{{ csrf_token()}}' 
             };

            $.ajax({
                type: "POST",
                url: '/clusters/checkpoint/save',
                data: { _token: '{{ csrf_token()}}', content: JSON.stringify(data)},
                success: function(e) {
                    console.log('success');
                    alert('success update checkpoint cluster');

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
            markersLatLng = [];
            $('#list-caption').html('');
        })

        $('#cluster_code').on('change', function() {
            $.ajax({
                type: "GET",
                url: '/geo?cluster-code=' + $(this).val(),
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
                    <option value="{{ $cluster->code }}">{{ $cluster->name }}</option>
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
        <div class="caption">
            <div id="list-caption"></div>
        </div>
    </div>
    <style type="text/css">
    .route-page #map{
        height: 650px;
        width: 100%;
        display: block;
        position: relative;
    }
    
    .route-page .div-command{
        padding: 6px 6px 4px;
        color: #337ab7;
        background-color: #fff;
        z-index: 2;
        position: absolute;
        display: inline-block;
        top: 116px;
        right: 71px;
        min-width: 250px;
        /* min-height: 300px; */
    }

    .caption {
        position: absolute;
        z-index: 2;
        display: inline-block;
        background-color: #fff;
        padding: 10px;
        right: 20px;
        top: 250px;
    }

    .route-page .command-btn {
        text-align: right;
    }

    .route-page label {
        width: 130px;
    }
</style>
@endsection