function currentPatrolTrack(cluster) {
    $.ajax({
        method: "GET",
        dataType: "json",
        url: apihost + "/v1/get/progress-patrol?cluster_code=" + cluster + "&date=" + dateNow(),
    })
    .done(function( msg ) {
        // console.log(msg.data);

        var flightPath = new google.maps.Polyline({
          geodesic: true,
          strokeColor: '#ff0033',
          strokeOpacity: 1.0,
          strokeWeight: 5
        });
        flightPath.setMap(map);

        $.each( msg.data, function( key, value ) {
            var curPosition = new google.maps.LatLng(value.lat, value.lng);
            var path = flightPath.getPath();
            path.push(curPosition);
        })
    });
    
}