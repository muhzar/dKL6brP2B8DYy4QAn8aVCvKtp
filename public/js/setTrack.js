function setTrack(coordinates) {
    trackCoordinates = [];
    coordinates.forEach((coordinate) => {
        trackCoordinates.push({ lat: parseFloat(coordinate.latitude), lng: parseFloat(coordinate.longitude)});
    });
    
    guardTrack = new google.maps.Polyline({
        path: trackCoordinates,
        geodesic: true,
        strokeColor: '#ffff66',
        strokeOpacity: .5,
        strokeWeight: 7
    });

    guardTrack.setMap(map);
}