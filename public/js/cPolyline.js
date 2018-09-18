//create polygon
function createPolygon(latLng) {
    var curPosition = new google.maps.LatLng(latLng.lat, latLng.lng);
    var path = poly.getPath();
    path.push(curPosition);
    // console.log('cPolyline ' + JSON.stringify(curPosition));
}