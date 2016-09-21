// In the following example, markers appear when the user clicks on the map.
// The markers are stored in an array.
// The user can then click an option to hide, show or delete the markers.
var map;
var markers = [];
var searchBox;
function initMap() {
    var mapOptions = {
        center: new google.maps.LatLng(-37.813, 144.963),
        zoom: 13,
        zoomControl: false,
        streetViewControl: false,
        mapTypeControl: false,
        panControl: false
    };

    if (window.innerWidth > 728) {
        mapOptions.zoomControl = true;
        mapOptions.zoomControlOptions = {
            position: google.maps.ControlPosition.RIGHT_BOTTOM
        };

        mapOptions.streetViewControl = true;
        mapOptions.mapTypeControl = true;
        mapOptions.mapTypeControlOptions = {
            position: google.maps.ControlPosition.LEFT_BOTTOM
        };
    }

    map = new google.maps.Map(document.getElementById('map'),
            mapOptions
            );
    map.data.loadGeoJson('resources/js/data0.json', {}, function () {
        if (selectedSuburb) {
            var feature = map.data.getFeatureById(selectedSuburb);
            //selectSuburb(feature);
            map.setCenter(feature.getProperty('center'));
        }
    });
    map.data.setStyle({fillOpacity: 0.0, strokeWeight: 1.0});
    map.data.addListener('click', function (event) {
        selectSuburb(event.feature);
    });
    

}

// Adds a marker to the map and push to the array.
function addMarker(location) {
    var marker = new google.maps.Marker({
        position: location,
        map: map
    });
    markers.push(marker);
}

// Sets the map on all markers in the array.
function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
    setMapOnAll(null);
}

// Shows any markers currently in the array.
function showMarkers() {
    setMapOnAll(map);
}

// Deletes all markers in the array by removing references to them.
function deleteMarkers() {
    clearMarkers();
    markers = [];
}

function onPlaceChange() {
    var places = searchBox.getPlaces();
    address_components=places[0].address_components;
    var subrub=null;
    var postCode=null;
    for(j=0;j<address_components.length;j++)
    {
        if(address_components[j].types[0]=="locality")
        {
            subrub=address_components[j].long_name;
            
        }
        else if(address_components[j].types[0]=="postal_code")
        {
            postCode=address_components[j].long_name;
        }
    }
    if(subrub!=null && postCode!=null)
    {
        debugger;
        var feature = map.data.getFeatureById(subrub+"~VIC~"+postCode);
        selectSuburb(feature);
        
    }
    
    var i;
    var marker = null;
    for (i = 0, marker; marker = markers[i]; i++) {
        marker.setMap(null);
    }

    // For each place, get the icon, place name, and location.
    markers = [];
    var bounds = new google.maps.LatLngBounds();
    var place = null;
    for (i = 0, place; place = places[i]; i++) {
        var image = {
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25)
        };

        // Create a marker for each place.
        marker = new google.maps.Marker({
            map: map,
            icon: image,
            title: place.name,
            position: place.geometry.location
        });

        markers.push(marker);

        bounds.extend(place.geometry.location);
    }

    map.panTo(bounds.getCenter());
}

function selectSuburb(feature) {
    map.data.revertStyle();
    map.data.overrideStyle(feature, {fillOpacity: 0.4, fillColor: 'green'});
    var suburbId = feature.getId();
}