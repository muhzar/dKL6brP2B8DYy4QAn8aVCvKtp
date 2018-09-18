@extends('frontend.templates.default')

@section('css')

@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB7R5r9_az0OxDsO_oWSVmijdWQYD1grg8"></script>
    <script type="text/javascript">
        var client;
        var map;
        var pos;
        var lastPos;
        var topic = "v1/api/cluster";
        var markers = [];
        var guards = [];


        $('.btn-connect').on('click', function(){
            mqttConnect();
        })
        
        $('.btn-send').on('click', function(){
            setPoly();
        })

        function mqttConnect() {
            var mqttConfig= { 
                hostname: 'm10.cloudmqtt.com',
                port: '34384',
                clientId: 'id-01-' + Math.floor(Math.random() * 6),
                username: 'psuyddse',
                password: '0LFWtA334Zyy',
                reconnectTimeout: 2000,
                ssl: true
            };

            client = new Paho.MQTT.Client(mqttConfig.hostname, Number(mqttConfig.port), mqttConfig.clientId);

            var options = {
                timeout: mqttConfig.reconnectTimeout,
                useSSL: mqttConfig.ssl,
                userName: mqttConfig.username,
                password: mqttConfig.password,
                onSuccess: onConnect,
                onFailure:onConnectionLost
            };

            // set callback handlers
            client.onConnectionLost = onConnectionLost;
            client.onMessageArrived = onMessageArrived;

            // connect the client
            client.connect(options);

        }
        // called when the client connects
        function onConnect() {
          // Once a connection has been made, make a subscription and send a message.
          console.log("onConnect");
          mqttMon();
          // initPoly();
        }

        function mqttMon() {
          console.log("ready for receive, topic : " + topic);
          client.subscribe(topic);
        }

        // called when the client loses its connection
        function onConnectionLost(responseObject) {
            if (responseObject.errorCode !== 0) {
                location.reload();
                console.log("onConnectionLost:" + JSON.stringify(responseObject));
            }
        }

        function mqttSend() {
          message = new Paho.MQTT.Message("Hello");
          message.destinationName = "World";
          client.send(message);
        }

        // called when a message arrives
        function onMessageArrived(message) {
            var data = message.payloadString;
            d = JSON.parse(data);
                if (d.cluster_code != '') {
                    var pos = {
                          lat: d.lat,
                          lng: d.lng,
                          name: d.username,
                          date: d.date,
                          accuracy: d.acc
                        };

                    if (typeof(lastPos) != "undefined") {
                        if (checkTrack(lastPos.lat, lastPos.lng, pos.lat, pos.lng) > 10) {
                            // console.log("set guard position: " + JSON.stringify(d));
                            addPositionGuard(pos, d.cluster_code);
                        }
                        // console.log('distance from last location: ' + checkTrack(lastPos.lat, lastPos.lng, pos.lat, pos.lng));
                        // console.log("set guard position: " + JSON.stringify(d));

                    }else {
                        addPositionGuard(pos, d.cluster_code);
                    }
                    lastPos = pos;
                
                    // if (typeof(lastPos) != "undefined") console.log('last lat ' + lastPos.lat);
                    // console.log('last lat ' + lastPos.lat);
                    // lastPos = pos;
                    
                }
                    // map.setCenter(pos);   
            }

        function addPositionGuard(pos, cluster) {
            postData(pos, cluster);
            var imageMarker = {
              url: '{{ asset('skin/images/security.png') }}',
              // size: new google.maps.Size(20, 32),
              // origin: new google.maps.Point(0, 0),
              // anchor: new google.maps.Point(0, 32)
            };

            if (typeof(guards[cluster]) != "undefined") guards[cluster].setMap(null);
            // markers.setMap(null);

            guards[cluster] = new google.maps.Marker({
                position: pos,
                map: map,
                title: '',
                icon: imageMarker
            });

            var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<h1 id="firstHeading" class="firstHeading">Info</h1>'+
            '<div id="bodyContent">'+
            '<p><b>Guard Name : ' + pos.name + '<br>'+
            'Current Position : ' + pos.lat + ', ' + pos.lng + '</p>'+
            '</div>'+
            '</div>';

            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            guards[cluster].addListener('click', function() {
                if (infowindow) {
                    infowindow.close();
                }
                infowindow.open(map, guards[cluster]);
            });
        }

        $(document).ready(function() {
            initMap();
            mqttConnect();
        });

        function initMap() {
            styles = [{"featureType":"all","elementType":"labels","stylers":[{"gamma":0.26},{"visibility":"off"}]},{"featureType":"administrative.province","elementType":"all","stylers":[{"visibility":"on"},{"lightness":-50}]},{"featureType":"administrative.province","elementType":"labels.text","stylers":[{"lightness":20}]},{"featureType":"administrative.province","elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"hue":"#ffffff"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"lightness":50},{"hue":"#ffffff"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"lightness":20}]},{"featureType":"road.arterial","elementType":"labels.text","stylers":[{"visibility":"on"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"visibility":"on"}]}];
            //set map init
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: {   lat: -6.257536, 
                            lng: 106.657560
                        },
                styles: styles
            });
            
        }

        function checkTrack(lat1, long1, lat2, long2) {
            errorMargin = 10;
            var earthRadiusKm = 6371;

            var dLat = degreesToRadians(lat2-lat1);
            var dLon = degreesToRadians(long2-long1);

            lat1 = degreesToRadians(lat1);
            lat2 = degreesToRadians(lat2);

            var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                    Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2); 
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
            var distance =  earthRadiusKm * c * 1000;
            return distance;
        }

        function degreesToRadians(degrees) {
          return degrees * Math.PI / 180;
        }

        function addMarker(pos) {
            var imageMarker = {
                url: '{{ asset('skin/images/check-point.png') }}',
                size: new google.maps.Size(40,40),
                anchor: new google.maps.Point(20,20)
            }
            // if (typeof(markers) != "undefined") markers.setMap(null);
            markers[pos.code] = new google.maps.Marker({
                position: pos,
                label: {text: pos.label, color: "#00a9ba"},
                map: map,
                title: pos.title,
                icon: imageMarker
            });

            var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<h1 id="firstHeading" class="firstHeading">Detail</h1>'+
            '<div id="bodyContent">'+
            '<p><b>' + pos.title + '</b><br>'+
            '<br>(' + pos.lat + ', ' + pos.lng + ')</p>'+
            '</div>'+
            '</div>';

            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            markers[pos.code].addListener('click', function() {
                if (infowindow) {
                    infowindow.close();
                }
                infowindow.open(map, markers[pos.code]);
            });

            // google.maps.event.addListener(markers, 'mouseover', function () {
            //     var point = fromLatLngToPoint(markers.getPosition(), map);
            //     $('#marker-tooltip').html(markers.tooltipContent + '<br>Pixel coordinates: ' + point.x + ', ' + point.y).css({
            //         'left': point.x,
            //             'top': point.y
            //     }).show();
            // });

            function fromLatLngToPoint(latLng, map) {
                var topRight = map.getProjection().fromLatLngToPoint(map.getBounds().getNorthEast());
                var bottomLeft = map.getProjection().fromLatLngToPoint(map.getBounds().getSouthWest());
                var scale = Math.pow(2, map.getZoom());
                var worldPoint = map.getProjection().fromLatLngToPoint(latLng);
                return new google.maps.Point((worldPoint.x - bottomLeft.x) * scale, (worldPoint.y - topRight.y) * scale);
            }
        }

        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
        }

        /* Set the width of the side navigation to 0 */
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }

        $('#cluster').on('change', function() {
            location.href = '/cluster/' + $(this).val();
        });

        function postData(data, cluster) {
            $.ajax({
              method: "POST",
              url: "http://209.97.168.161/v1/route/collect",
              data: {
                        cluster_id  : cluster,
                        longitude : data.lng,
                        latitude : data.lat,
                        speed : '0',
                        accuracy : data.accuracy,
                        unique_key : data.name,
                        device_date: data.date
                    }
            })
              .done(function( msg ) {
                // alert( "Data Saved: " + msg );
              });
        }

        function checkPatroli(data, cluster) {
            $.ajax({
              method: "GET",
              url: "http://209.97.168.161/v1/check/not-patrol-yet",
            })
              .done(function( msg ) {
                console.log( "Data Saved: " + JSON.stringify(msg) );
              });
        }

        checkPatroli();
    </script>
        
@endsection

@section('content')
    <!-- <span class="menu" onclick="openNav()"><img src="{{ asset('skin/images/menu.png') }}"></span> -->
    <div class="claster-name"><span><a href="/" style="color: #fff;font-size: 14px;">Home</a></span>All</div>
    <div id="map">
    </div>
@endsection
