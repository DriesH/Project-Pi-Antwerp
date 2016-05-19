/**
*Variabele bevat de map data van de Google Maps API
*
*@var map
*
*Variabele bevat het DOM element waar de map in wordt gerenderd
*
*@var mapElement
*/
var map;
var marker;
var mapElement = document.getElementById('map');

/**
*Google map api initialiseren
*
*@method initMap
*/
window.initMap = function() {
    if(mapElement != null){
        map = new google.maps.Map(mapElement, {
                center: {lat: 51.202257, lng: 4.419694},
                zoom: 10
            });
        marker = new google.maps.Marker({
                    position: {lat: 51.202257, lng: 4.419694},
                    map: map,
                    title: 'Klik hier Joren',
                });

        map.addListener('center_changed', function() {
            // 3 seconds after the center of the map has changed, pan back to the
            // marker.
            window.setTimeout(function() {
              map.panTo(marker.getPosition());
            }, 3000);
        });
    }
};
