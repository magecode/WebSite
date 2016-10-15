var map;
var infowindow;
var facilities = [];

//this function is used for receive data pass from home.html and get geographical parameters of target suburb
function initialize() {
    var loc = "";
    var eFeature = "";
    var rate = "";

    var query = window.location.search.substring(1);
    var parameters = query.split("&");

    //filter and initialise parameters
    loc = parameters[0].replace("suburb=", "").replace("+", " ");
    if (loc == "") {
        loc = "Melbourne";
    }
    //get facilities parameters
    var count = 0;
    for (i = 0; i < parameters.length; i++) {
        if (parameters[i].indexOf("facilities") !== -1) {
            //alert (parameters[i]);
            facilities[count] = parameters[i].replace("facilities=", "");
            count++;
        }
    }
			
    //retrieve geographic parameters from google api
    var targetLoc = loc.replace(/%2C/g, ",").replace(/\+/g, " ");
    var isNum = /^\d+$/.test(targetLoc);
    if (isNum == true) {
        targetLoc = "Victoria, " + targetLoc ;
    }

    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({ 'address': targetLoc }, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            var lat = results[0].geometry.location.lat();
            var lng = results[0].geometry.location.lng();
                
            //get suburb name 
            var loc_info = results[0].address_components;
            var flag_hasSuburb = false;
            for (i = 0; i < loc_info.length; i++) {
                if (loc_info[i].types.indexOf('locality') !== -1) {
                    targetLoc = loc_info[i].long_name;
                    document.getElementById("suburbName").innerHTML = targetLoc + ", Victoria, Australia";
                    retrieveDetail();
                    flag_hasSuburb = true;
                }
            }

            //show alert info when cannot find suburb
            if (flag_hasSuburb == false) {
                alert("Sorry, we cannot locate to a suitable suburb.");
                window.open("../../index.html", "_self");
            }

            //retrieve fusiontable suburbs list
            var fusionTableList = "";

            var file = "../info/suburbs.txt";
            var rawFile = new XMLHttpRequest();
            rawFile.open("GET", file, false);
            rawFile.onreadystatechange = function () {
                if (rawFile.readyState === 4) {
                    if (rawFile.status === 200 || rawFile.status == 0) {
                        var allText = rawFile.responseText;
                        fusionTableList = allText;
                    }
                }
            }
            rawFile.send(null);

            var arrayFusionList = fusionTableList.match(/[^\r\n]+/g);

            //validate if input is within fusiontable suburbs list
            var fusiontableFlage = false;
            for (var i = 0; i <= arrayFusionList.length-1; i++) {
                //var matchResult = arrayFusionList[i].match(new RegExp(targetLoc, "i"));
                if (arrayFusionList[i].toUpperCase() == targetLoc.toUpperCase()) {
                    fusiontableFlage = true;
                }
            }

            if (fusiontableFlage != true) {
                alert("Sorry, we have problem with drawing suburbs boundary. Please choose suburbs from search pull-down list.");
                window.open("../../index.html", "_self");
            }


            var strictBounds = new google.maps.LatLngBounds(
                    new google.maps.LatLng(-38.404306, 143.989873),
                    new google.maps.LatLng(-37.324942, 146.032990)
                );
            var targetCenter = new google.maps.LatLng(lat, lng);
            if (strictBounds.contains(targetCenter)) {
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({ 'address': targetLoc + ', Victoria, Australia' }, function (results, status) {
                    if (status === google.maps.GeocoderStatus.OK) {
                        var lat = results[0].geometry.location.lat();
                        var lng = results[0].geometry.location.lng();
                        initMap(lat,lng,targetLoc);
                    } else {
                        document.getElementById("resultMap").innerhtml = "Geocode was not successful for the following reason:";
                    }
                });
            } else {
                alert("Please only input location within Melbourne.");
                window.open("../../index.html", "_self");
            }
        } else {
            alert("Please check your input, it should be either a suburb name or a post code (in English).");
            window.open("../../index.html", "_self");
        }			
    });
		
}
	
//this function is used for drawing a result map
function initMap(lat,lng,targetLoc) {
    //locate the map center to target suburb's center
    var myCenter=new google.maps.LatLng(lat, lng);
    var mapProp = {
        center:myCenter,
        clickableIcons: false,
        disableDoubleClickZoom: true,
        zoom:14,
        draggable: true,
        scrollwheel: false,
        clickable: false,
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };
		
    //locate drawing position
    map = new google.maps.Map(document.getElementById("resultMap"), mapProp);
    if (facilities.length !== 0) {
        infowindow = new google.maps.InfoWindow({
            content: '<div style="color:black">' + '</div>'
        });
        var service = new google.maps.places.PlacesService(map);
        service.nearbySearch({
            location: { lat: lat, lng: lng },
            radius: 1800,
            types: facilities
        }, callback);
    }
			

    //drawing suburbs boundaries in victoria and highlight target suburb
    var layer = new google.maps.FusionTablesLayer({
        suppressInfoWindows: true,
        query: {
            select: 'geometry',
            from: '1eP2GkW0yhBY7r9uZG_LKiV6E7iFqTZgG256sNg6Q'
        },
        styles: [{
            polygonOptions: {
                strokeColor: '#000000' ,
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#000000',
                fillOpacity: 0.4
            }
        }, {
            where: "'Suburb Name' =" + "'" + targetLoc + "'",
            polygonOptions: {
                strokeColor: '#000000' ,
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#000000',
                fillOpacity: 0.1
            }
        }]
    });

    //draw map
    layer.setMap(map);
}
	
function callback(results, status) {
    if (status === google.maps.places.PlacesServiceStatus.OK) {
        for (var i = 0; i < results.length; i++) {
            createMarker(results[i]);
        }
    }
}

//create facilities icon on result map
function createMarker(place) {
    var icons = {
        school: {
            icon: '../images/marker/school.png'
        },
        park: {
            icon: '../images/marker/park.png'
        },
        hospital: {
            icon: '../images/marker/hospital.png'
        }
    };

    var placeLoc = place.geometry.location;
    var marker = new google.maps.Marker({
        map: map,
        icon: icons[place.types[0]].icon,
        position: place.geometry.location
    });

    google.maps.event.addListener(marker, 'click', function () {
        infowindow.setContent(place.name);
        infowindow.open(map, this);
    });
}
	
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

		
//run function when load current page
google.maps.event.addDomListener(window, 'load', initialize)