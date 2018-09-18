function addPositionGuard(pos, cluster) {
    var securityMarker = {
      url: '/skin/images/security.png',
    };
    
    if (typeof(guards[cluster]) != "undefined") guards[cluster].setMap(null);
    // markers.setMap(null);

    guards[cluster] = new google.maps.Marker({
        position: pos,
        map: map,
        title: '',
        icon: securityMarker
    });

    var contentString = '<div id="content">'+
    '<div id="siteNotice">'+
    '</div>'+
    '<h1 id="firstHeading" class="firstHeading">Guard Detail</h1>'+
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