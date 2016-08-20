<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="assets/images/n-logo-dark-128x128-57.png" type="image/x-icon">
	<meta name="description" content="">

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic&amp;subset=latin">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,700,800,900">
	<link rel="stylesheet" href="assets/et-line-font-plugin/style.css">
	<link rel="stylesheet" href="assets/bootstrap-material-design-font/css/material.css">
	<link rel="stylesheet" href="assets/tether/tether.min.css">
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/socicon/css/socicon.min.css">
	<link rel="stylesheet" href="assets/animate.css/animate.min.css">
	<link rel="stylesheet" href="assets/dropdown/css/style.css">
	<link rel="stylesheet" href="assets/theme/css/style.css">
	<link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">
	
	
	<!--<script src="http://maps.googleapis.com/maps/api/js"></script>	-->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcvtV_71ZGFAUUcS9_u_D1ZFHi2BWLjao"></script>
	
	<script>
	
	
	//var locLatLng;

	
	
	function initialize() {
	var queryString = function(){
		var query = window.location.search.substring(1);
		query = query.replace("suburb=", "");
		query = query.replace("+", " ");
		
		return query;
	}();
	
	
		//alert(queryString);
		
		var targetLoc = queryString;
		//var targetLoc = "Melbourne";
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode({'address': targetLoc}, function(results, status) {
			if (status === google.maps.GeocoderStatus.OK) {
				var lat = results[0].geometry.location.lat();
				var lng = results[0].geometry.location.lng();
			  initMap(lat, lng, targetLoc);
			} else {
			  alert('Geocode was not successful for the following reason: ' + status);
			}
			
			//storeResult(result);
			
		});
	
	
		//alert(result.lat + ' ' + result.lng);
		//alert(locLatLng);
		
		
	}
	
	function initMap(lat, lng, targetLoc) {
		//var lat = document.getElementById('lat').innerHTML;
		//var lng = document.getElementById('lng').innerHTML;	
		//var myCenter=new google.maps.LatLng(-37.877106, 145.064891);
		var myCenter=new google.maps.LatLng(lat, lng);
		//alert(lat + lng);
		var mapProp = {
		center:myCenter,
		//center: resultsMap.center,
		clickableIcons: false,
		disableDoubleClickZoom: true,
		zoom:14,
		draggable: false,
		scrollwheel: false,
		clickable: false,
		mapTypeId:google.maps.MapTypeId.HYBRID
		};
		
		var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
	
		var marker=new google.maps.Marker({
			position:myCenter,
			animation: google.maps.Animation.BOUNCE,
			icon: 'assets/images/icons/happy.png'
		});
		
		var layer = new google.maps.FusionTablesLayer({
			query: {
			  select: 'geometry',
			  from: '1eP2GkW0yhBY7r9uZG_LKiV6E7iFqTZgG256sNg6Q'
			},
			styles: [{
			  polygonOptions: {
				strokeColor: '#000000' ,
				strokeOpacity: 0.8,
				strokeWeight: 2,
				fillColor: '#FFFFFF',
				fillOpacity: 0.5
				}
			},{
				where: "'Suburb Name' =" + "'" + targetLoc + "'",
				polygonOptions: {
					strokeColor: '#000000' ,
					strokeOpacity: 0.8,
					strokeWeight: 2,
					fillColor: '#008000',
					fillOpacity: 0.15
				}
			}]
		});
	  
		layer.setMap(map);
					
		
		marker.setMap(map);
		
		var infowindow = new google.maps.InfoWindow({
			content: '<div style="color:black">Lv. 5</div>'
		});

		infowindow.open(map,marker);
	}
	
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
                        <a href="home.html" class="navbar-logo"><img src="assets/images/neighborgood-dark-585x128-77-585x128-68.png"></a>
                        
                    </div>

                </div>
                <div class="mbr-table-cell">

                    <button class="navbar-toggler pull-xs-right hidden-md-up" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
                        <div class="hamburger-icon"></div>
                    </button>

                    <ul class="nav-dropdown collapse pull-xs-right nav navbar-nav navbar-toggleable-sm" id="exCollapsingNavbar"><li class="nav-item dropdown"><a class="nav-link link" href="home.html">HOME</a></li><li class="nav-item"><a class="nav-link link" href="suburb.html">SHARE</a></li><li class="nav-item"><a class="nav-link link" href="about.html">ABOUT</a></li></ul>
                    <button hidden="" class="navbar-toggler navbar-close" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
                        <div class="close-icon"></div>
                    </button>

                </div>
            </div>

        </div>
    </nav>

</section>


<section class="mbr-footer mbr-section mbr-section-md-padding mbr-parallax-background" id="contacts3-14" style="background-image: url(assets/images/jumbotron.jpg); padding-top: 120px; padding-bottom: 15%;">

    <div class="row">
    <div class="mbr-overlay" style="opacity: 0.8; background-color: rgb(60, 60, 60);"></div>
		
		<div id="googleMap" style="width:800px;height:600px;float:left;margin-right: 300px"></div>
		
		<div id="details" style="float:left">
		<?php 
			$servername = "118.139.0.100";
			$username = "ian";
			$password = "ian";
			$dbname = "envrionment";

			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn -> connect_error) {
				 die("Connection failed: " . $conn->connect_error);
			} 

			$sql = "SELECT * FROM CR";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				 // output data of each row
				 while($row = $result->fetch_assoc()) {
					 echo  "<br> id: ". $row["a"]. " - Name: ". $row["b"]. " <br>";
				 }
			} else {
				 echo "0 results";
			}

			$conn->close();
		?>
		</div>

		
</section>


<section>
	
</section>



<footer class="mbr-small-footer mbr-section mbr-section-nopadding" id="footer1-2" style="background-color: rgb(50, 50, 50); padding-top: 1.75rem; padding-bottom: 1.75rem;">
    
    <div class="container">
        <p class="text-xs-center">Copyright (c) 2016 Nirvana.</p>
    </div>
</footer>


  <script src="assets/web/assets/jquery/jquery.min.js"></script>
  <script src="assets/tether/tether.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/smooth-scroll/SmoothScroll.js"></script>
  <script src="assets/viewportChecker/jquery.viewportchecker.js"></script>
  <script src="assets/jarallax/jarallax.js"></script>
  <script src="assets/dropdown/js/script.min.js"></script>
  <script src="assets/touchSwipe/jquery.touchSwipe.min.js"></script>
  <script src="assets/theme/js/script.js"></script>
  <script src="assets/formoid/formoid.min.js"></script>
  
  
  <input name="animation" type="hidden">
  </body>
</html>