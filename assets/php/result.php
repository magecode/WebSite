<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="../images/n-logo-dark-128x128-57.png" type="image/x-icon">
	<meta name="description" content="">

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic&amp;subset=latin">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,700,800,900">
	<link rel="stylesheet" href="../et-line-font-plugin/style.css">
	<link rel="stylesheet" href="../bootstrap-material-design-font/css/material.css">
	<link rel="stylesheet" href="../tether/tether.min.css">
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../socicon/css/socicon.min.css">
	<link rel="stylesheet" href="../animate.css/animate.min.css">
	<link rel="stylesheet" href="../dropdown/css/style.css">
	<link rel="stylesheet" href="../theme/css/style.css">
	<link rel="stylesheet" href="../mobirise/css/mbr-additional.css" type="text/css">
	
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcvtV_71ZGFAUUcS9_u_D1ZFHi2BWLjao"></script>
	
	<script>	
    	//this function is used for receive data pass from home.html and get geographical parameters of target suburb
    	function initialize() {
    		var loc = "";
    		var eFeature = "";
    		var rate = "";

    		var query = window.location.search.substring(1);
    		var parameters = query.split("&");

    		//filter and initialise parameters
    		loc = parameters[0].replace("suburb=", "").replace("+", " ");
    		//loc = loc.split('%2C')[0].replace("+", " ");
    		
			
			//retrieve geographic parameters from google api
			var targetLoc = loc;
			var tempArray = targetLoc.split(" ");
			
    	    //make input first letter upper case
            /*
			if (tempArray.length == 1)
				targetLoc = capitalizeFirstLetter(targetLoc);
			else{
				var temp = "";
				for (var i = 0; i < tempArray.length; i++){
					tempArray[i] = capitalizeFirstLetter(tempArray[i]);
					
				}
				
				for (var i = 0; i < tempArray.length; i++){
					temp += tempArray[i] + " ";
				}
				targetLoc = temp.trim();
			}*/

			var geocoder = new google.maps.Geocoder();
			geocoder.geocode({'address': loc}, function(results, status) {
				if (status === google.maps.GeocoderStatus.OK) {
					var lat = results[0].geometry.location.lat();
					var lng = results[0].geometry.location.lng();

					//get suburb name 
					var loc_info = results[0].address_components;
					var flag_hasSuburb = false;
					for (i = 0; i < loc_info.length; i++) {
					    if (loc_info[i].types.indexOf('locality') !== -1) {
					        targetLoc = loc_info[i].long_name;
					        flag_hasSuburb = true;
					    }
					}

				    //show alert info when cannot find suburb
					if (flag_hasSuburb == false) {
					    alert("Sorry, we cannot locate to a suitable suburb.");
					}

					var strictBounds = new google.maps.LatLngBounds(
                            new google.maps.LatLng(-38.310532, 144.081150),
                            new google.maps.LatLng(-37.417193, 146.157566)
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
					            document.getElementById("googleMap").innerhtml = "Geocode was not successful for the following reason:";
					        }
					    });
					} else {
					    alert("Please only input location within Melbourne.");
					}
				} else {
				    alert("Please check your input, it should be either a suburb name or a post code.");
				  //document.getElementById("googleMap").innerhtml = "Geocode was not successful for the following reason:";
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
			draggable: false,
			scrollwheel: false,
			clickable: false,
			mapTypeId:google.maps.MapTypeId.HYBRID
			};
		
			//locate drawing position
			var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
	
			//initialise icon based on different environment level
            /*
			var face = "../images/icons/happy.png";
			var eLv = "Lv2";
            */
			
    	    //this part is left for implement later
            /*
			var eFigure = document.getElementById("eFigure").innerHTML;
			if (eFigure > 5000) {
			    eLv = "Lv1";
				face = "../images/icons/sad.png";
			}else{
			    if (eFigure < 2000) {
			        eLv = "Lv3";;
			        face = "../images/icons/happy.png";
			    } else {
			        eLv = "Lv2";
					face = "../images/icons/middle.png"
				}
			}
            */
			
			/*var marker=new google.maps.Marker({
				position:myCenter,
				animation: google.maps.Animation.BOUNCE,
				icon: face
			});*/
		
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
				},{
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
					
			//draw marker
			marker.setMap(map);
		
    	    //initialise infowindow for marker
			var infowindow = new google.maps.InfoWindow({
			    content: '<div style="color:black">' + eLv + '</div>'
			});
            

			//draw infowindow
			infowindow.open(map,marker);
		}
	
	
		function capitalizeFirstLetter(string) {
			return string.charAt(0).toUpperCase() + string.slice(1);
		}
		
		//run function when load current page
		google.maps.event.addDomListener(window, 'load', initialize);
	</script>

  
</head>

<body>
<section id="menu-26">
    <nav class="navbar navbar-dropdown bg-color transparent navbar-fixed-top">
        <div class="container">
            <div class="mbr-table">
                <div class="mbr-table-cell">
					<div class="navbar-brand">
						<a href="../../home.html" class="navbar-logo">
							<img src="../images/neighborgood-dark-585x128-77-585x128-68.png" />
						</a>
						<button class="navbar-toggler pull-xs-right hidden-md-up" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
							<div class="hamburger-icon"></div>
						</button>
						<ul class="nav-dropdown collapse pull-xs-right nav navbar-nav navbar-toggleable-sm" id="exCollapsingNavbar">
							<li class="nav-item dropdown">
								<a class="nav-link link" href="../../home.html">HOME</a>
							</li>
							<li class="nav-item">
								<a class="nav-link link" href="../../suburb.html">SHARE</a>
							</li>
							<li class="nav-item">
								<a class="nav-link link" href="../../temp.html">ABOUT</a>
							</li>
						</ul>
						<button hidden="" class="navbar-toggler navbar-close" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
							<div class="close-icon"></div>
						</button>	
					</div>
                </div>
            </div>
        </div>
    </nav>
</section>

<section class="mbr-footer mbr-section mbr-section-md-padding mbr-parallax-background" id="contacts3-14" style="background-image: url(../images/jumbotron.jpg); padding-top: 120px; padding-bottom: 15%;">
	<div class="row">
    <div class="mbr-overlay" style="opacity: 0.5; background-color: rgb(60, 60, 60);"></div>		
	<div id="googleMap" style="width:800px;height:600px;float:left;margin-right: 150px">
    </div>		
        <div id="details" style="float:left; color:#FFFFFF;">
            <h3>Below is the report crime happend in 2005:</h3>
            <!--connect to DB and retrieve data-->
            <p id="eFigure" style="color:#FFFFFF;">
                
                <?php
                /*
                //read DB deatail from file
                $db_temp = file_get_contents("../info/dbInfo.txt");
                $db_info = explode(";",$db_temp);
                $servername = $db_info[0];
                $username = $db_info[1];
                $password = $db_info[2];
                $dbname = $db_info[3];



			    //Using GET
			    $var_value = $_GET['suburb'];
			    if ($var_value == ""){
				    $var_value = "Melbourne";
			    }

			    // Create connection
			    $conn = new mysqli($servername, $username, $password, $dbname);
			    // Check connection
			    if ($conn -> connect_error) {
				     die("Connection failed: " . $conn->connect_error);
			    }


			    //generate crime report
			    $sql = "SELECT * FROM melbmap where suburb = UPPER('$var_value')";
			    $result = $conn->query($sql);

			    if ($result->num_rows > 0) {
				     //output data of each row
				     while($row = $result->fetch_assoc()) {
					     $postcode = $row["postcode"];
                         $sql = "SELECT * FROM crimemap where postcode = '$postcode' and year = 2015";
                         $result = $conn->query($sql);
                         if ($result->num_rows > 0) {
                             // output data of each row
                             while($row = $result->fetch_assoc()) {
                                 $crReport = $row["report"];
                                 echo  $crReport;
                             }
                         } else {
                             echo "0";
                         }
				     }
			    } else {
				     echo "0";
			    }

			    $conn->close();*/
                ?>
            </p>
        </div>		
</section>

<section>
	
</section>

<footer class="mbr-small-footer mbr-section mbr-section-nopadding" id="footer1-2" style="background-color: rgb(50, 50, 50); padding-top: 1.75rem; padding-bottom: 1.75rem;">
    
    <div class="container">
        <p class="text-xs-center">Copyright (c) 2016 Nirvana.</p>
    </div>
</footer>

  <script src="../web/assets/jquery/jquery.min.js"></script>
  <script src="../tether/tether.min.js"></script>
  <script src="../bootstrap/js/bootstrap.min.js"></script>
  <script src="../smooth-scroll/SmoothScroll.js"></script>
  <script src="../viewportChecker/jquery.viewportchecker.js"></script>
  <script src="../jarallax/jarallax.js"></script>
  <script src="../dropdown/js/script.min.js"></script>
  <script src="../touchSwipe/jquery.touchSwipe.min.js"></script>
  <script src="../theme/js/script.js"></script>
  <script src="../formoid/formoid.min.js"></script>
  
  
  <input name="animation" type="hidden">
  </body>
</html>