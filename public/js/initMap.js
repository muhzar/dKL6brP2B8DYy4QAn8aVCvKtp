function initMap(ilat, ilng) {

    // Init MAP
    styles = [{"featureType":"all","elementType":"labels","stylers":[{"gamma":0.26},{"visibility":"off"}]},{"featureType":"administrative.province","elementType":"all","stylers":[{"visibility":"on"},{"lightness":-50}]},{"featureType":"administrative.province","elementType":"labels.text","stylers":[{"lightness":20}]},{"featureType":"administrative.province","elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"hue":"#ffffff"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"lightness":50},{"hue":"#ffffff"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"lightness":20}]},{"featureType":"road.arterial","elementType":"labels.text","stylers":[{"visibility":"on"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"visibility":"on"}]}];
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 17,
        center: {   lat: ilat, 
                    lng: ilng 
                },
        styles: styles
    });


    // console.log('lat:' + ilat + ' lng: ' + ilng);


    //Init Polyline utk tracing guard
    poly = new google.maps.Polyline({
          strokeColor: '#ff0033',
          strokeOpacity: 1.0,
          strokeWeight: 5
    });
    poly.setMap(map);
    
}