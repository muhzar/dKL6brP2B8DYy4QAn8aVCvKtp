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
        var topic = "v1/panic-button/alert";
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
                onSuccess: mqttMon,
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
          // mqttMon();
          // initPoly();
        }

        function mqttMon() {
          console.log("ready for receive, topic : " + topic);
          client.subscribe(topic);
        }

        // called when the client loses its connection
        function onConnectionLost(responseObject) {
          if (responseObject.errorCode !== 0) {
            mqttConnect();
            console.log("onConnectionLost:"+responseObject.errorMessage);
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
            console.log("onMessageArrived:"+data);

            var pos = {
                    username: d.user.username,
                    address: d.user.address,
                    audio: d.user.audio,
                    lat: d.coordinate.lat,
                    lng: d.coordinate.lng
                };

            // if (typeof(lastPos) != "undefined") checkTrack(lastPos.lat, lastPos.lng, pos.lat, pos.lng);
            // if (typeof(lastPos) != "undefined") console.log('last lat ' + lastPos.lat);
            // console.log('last lat ' + lastPos.lat);
            // lastPos = pos;
            addPositionAlert(pos, d.user.username);
            map.setCenter(pos);
        }

        function addPositionAlert(pos, name) {
            var imageMarker = {
              url: '{{ asset('skin/images/alert-ani.gif') }}',
              // size: new google.maps.Size(20, 32),
              // origin: new google.maps.Point(0, 0),
              // anchor: new google.maps.Point(0, 32)
            };
            if (typeof(guards[name]) != "undefined") guards[name].setMap(null);
            // markers.setMap(null);
            guards[name] = new google.maps.Marker({
                position: pos,
                map: map,
                title: '',
                icon: imageMarker
            });

            map.setZoom(16);

            var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            ''+
            '<div id="bodyContent">'+
            '<p><b>User Name : ' + pos.username + '<br>'+
            'Resident : ' + pos.address +'</p>'+
            '<button onclick="stopSound(\'alert-'+pos.username+'\')">Silence</button>'+
            '<button onclick="removeMarker(\''+pos.username+'\')">Solve</button>'+
            '<button onclick="soundPlay(\'sound-'+pos.username+'\')"">Play Audio</button>'+
            '</div>'+
            '</div>';

            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            sendAlertSound(pos.username);
            createAudio(pos.username, pos.audio);

            guards[name].addListener('click', function() {
                if (infowindow) {
                    infowindow.close();
                }
                infowindow.open(map, guards[name]);
            });

            guards[name].addListener('dblclick', function() {
                map.setCenter(pos);
                map.setZoom(18);
            });
        }

        $(document).ready(function() {
            initMap();
            mqttConnect();
        });

        function initMap() {
            styles = [{"featureType":"all","elementType":"labels","stylers":[{"gamma":0.26},{"visibility":"off"}]},{"featureType":"administrative.province","elementType":"all","stylers":[{"visibility":"on"},{"lightness":-50}]},{"featureType":"administrative.province","elementType":"labels.text","stylers":[{"lightness":20}]},{"featureType":"administrative.province","elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"hue":"#ffffff"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"lightness":50},{"hue":"#ffffff"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"lightness":20}]},{"featureType":"road.arterial","elementType":"labels.text","stylers":[{"visibility":"on"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"visibility":"on"}]}];

            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: {lat: -6.256492, lng: 106.660154}, 
                styles: styles
            });
            

            setCheckPoint();
        }

        function setCheckPoint() {
            @foreach($clusters as $cluster)
                addMarker({code: '{{ $cluster['code'] }}', lat: {{ $cluster['latitude'] }}, lng: {{ $cluster['longitude'] }}, label: '{{ $cluster['name'] }}' });
            @endforeach
        }

        function addMarker(pos) {

            var imageMarker = {
                url: '{{ asset('skin/images/here-blank.png') }}',
                size: new google.maps.Size(40,40),
                anchor: new google.maps.Point(20,20)
            }
            if (typeof(markers[pos.code]) != "undefined") markers[pos.code].setMap(null);
            markers[pos.code] = new google.maps.Marker({
                position: pos,
                label: {text: pos.label, color: "#ffa500"},
                map: map,
                title: pos.code,
                icon: imageMarker
            });

            // markers[pos.code].addListener('click', function() {
            //   map.setCenter(markers[pos.code].getPosition());
            //   map.setZoom(17);
            // });

            markers[pos.code].addListener('click', function() {
              location.href = '/cluster/' + pos.code;
            });

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

        function soundPlay(which)
        {
            var audio = document.getElementById(which);
            var promise = audio.play();
            if (promise !== undefined) {
              promise.then(_ => {
                // Autoplay started!
              }).catch(error => {
                // Autoplay was prevented.
                // Show a "Play" button so that user can start playback.
              });
            }
        }

        function stopSound(which) {
            console.log(which);
            var audio = document.getElementById(which);
            var promise = audio.pause();
            if (promise !== undefined) {
              promise.then(_ => {
                // Autoplay started!
              }).catch(error => {
                // Autoplay was prevented.
                // Show a "Play" button so that user can start playback.
              });
            }
        }

        var sendAlertSound = function(name){
            if($("#alert-" + name).length == 0) {
                var $div = $('audio[id="alert"]');
                var $klon = $div.clone().attr('id', 'alert-' + name);
                $klon.appendTo('body');
                soundPlay('alert-' + name);
            } else {
                soundPlay('alert-' + name);
            }
        };

        var createAudio = function(name, audio){
            if($("#sound-" + name).length == 0) {
                var $div = $('audio[id="sound"]');
                var $klon = $div.clone().attr('id', 'sound-' + name);
                $klon.attr('src', 'http://139.59.226.254/uploads/' + audio);
                $klon.appendTo('body');
            }
        };


        var removeMarker = function(marker) {
            stopSound('alert-'+marker)
            $('#alert-' +marker).remove();
            $('#sound-' +marker).remove();
            guards[marker].setMap(null);
        }
    </script>
        
@endsection

@section('content')
    <!-- <span class="menu" onclick="openNav()"><img src="{{ asset('skin/images/menu.png') }}"></span> -->
    <div class="claster-name"><span  onclick="openNav()"><img src="{{ asset('logo.png') }}" width="100" class="logo"></span>{{ $clusterName }}</div>
    <div id="map"></div>
    <audio style="display: none;" id="alert" preload src="{{ asset('skin/alert.wav')}}"  loop="infinite"></audio>
    <audio style="display: none;" id="sound" preload src="{{ asset('skin/alert.wav')}}"></audio>
@endsection
