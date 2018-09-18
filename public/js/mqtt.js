function mqttConnect() {
    var mqttConfig = { 
        host: '43.251.98.16',
        // username: 'psuyddse', 
        // password: '0LFWtA334Zyy',
        currentTopic: 'api',
        ssl: false,
        port: 8083,
        clientId:'uid-' + Math.floor( Math.random() * 100 ) ,
        cleanSession: false,
        reconnectTimeout: 2000
    };

    client = new Paho.MQTT.Client(mqttConfig.host, Number(mqttConfig.port), mqttConfig.clientId);

    var options = {
        timeout: mqttConfig.reconnectTimeout,
        useSSL: mqttConfig.ssl,
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
  console.log("MQTT Connect");
  console.log("ready for receive, topic : " + topic);
  client.subscribe(topic);
  // initPoly();
}

// called when the client loses its connection
function onConnectionLost(responseObject) {
    if (responseObject.errorCode !== 0) {
        location.reload();
    }
}

// called when a message arrives
function onMessageArrived(message) {
    var data = message.payloadString;
    d = JSON.parse(data);
    // console.log("Message Arrives : " + JSON.stringify(d));
    if (d.cluster_code == clusterCode) {
        var pos = {
              lat: d.lat,
              lng: d.lng,
              name: d.username
              // name: 'tracking'
            };
        $('.geo').html('Posisi Security : <br>' + d.lat + ' ' + d.lng);
        addPositionGuard(pos, clusterCode);
        createPolygon(pos);
        if(!isLocationTrack(pos, guardTrack)) {
            $('.outoftrack').html('Perhatian Security Keluar dari jalur');
        } else {
            $('.outoftrack').html('');
        }
        
    }
        // map.setCenter(pos);   
}