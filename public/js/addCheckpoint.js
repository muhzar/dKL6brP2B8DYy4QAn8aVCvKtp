function addMarker(pos) {
    var imageMarker = {
        url: '/skin/images/check-point.png',
        size: new google.maps.Size(30,30),
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
    '<h1 id="firstHeading" class="firstHeading"></h1>'+
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

    function fromLatLngToPoint(latLng, map) {
        var topRight = map.getProjection().fromLatLngToPoint(map.getBounds().getNorthEast());
        var bottomLeft = map.getProjection().fromLatLngToPoint(map.getBounds().getSouthWest());
        var scale = Math.pow(2, map.getZoom());
        var worldPoint = map.getProjection().fromLatLngToPoint(latLng);
        return new google.maps.Point((worldPoint.x - bottomLeft.x) * scale, (worldPoint.y - topRight.y) * scale);
    }
}