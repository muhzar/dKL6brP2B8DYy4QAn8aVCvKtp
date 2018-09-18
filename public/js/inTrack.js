function isLocationTrack(pos, trackCoordinates) {
    var myPosition = new google.maps.LatLng(pos.lat, pos.lng);
    if (google.maps.geometry.poly.isLocationOnEdge(myPosition, trackCoordinates, 0.00030)) {
        return true;
    } else {
        return false;
    }
}