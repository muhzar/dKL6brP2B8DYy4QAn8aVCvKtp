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