function initMap(markers) {
    if (!markers || markers.length == 0)
        return;

    // The location
    const meanCoords = {lat:0, lng:0};
    for (marker of markers){
        meanCoords.lat += marker.lat;
        meanCoords.lng += marker.lng;
    }
    // The map, centered 
    var map = new google.maps.Map(
        document.getElementById('map'), {
            zoom: 2, 
            center: {
                lat: meanCoords.lat/markers.length, 
                lng: meanCoords.lng/markers.length
            }
        }
    );
    // The marker, positioned
    for(let mark of markers) {
        var marker = new google.maps.Marker({
            position: {lat: mark.lat, lng: mark.lng}, 
            map: map,
            origin: mark.photo
        });

        marker.addListener("click", function() {
            self.location.href  ='/photodetails/'+marker.origin;
        });
    }
}