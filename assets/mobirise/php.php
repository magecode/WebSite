<html lang="en">
    
    <title>DATA</title>
    <link rel="stylesheet" href="css/list-table.css" />
          <head>
		<meta charset="UTF-8">
		<title>Beach List</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>
	</head>
    <body>
        <header id="header">
				<h1><a href="index.html">Team Skylark</a></h1>
				<nav id="nav">
					<ul>
						<li><a href="index.html">Home</a></li>
						<li><a href="map.html">Map</a></li>
						<li><a href="list.html">List</a></li>
						<li><a href="#" class="button special">Sign Up</a></li>
					</ul>
				</nav>
			</header>
                               <section id="main" class="wrapper">
				<div class="container">
                                       <header class="major">
						<h2>Beach List</h2>
						<p>Here is a list about all the dog-friendly beaches in VIC</p>
					</header>
        <form>
        
        
<?php
$servername = "40.126.224.41";
$username = "will";
$password = "password";
$dbname = "beach";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "SELECT no, beach_name, address, longitude, latitude FROM beach";
$result = $conn->query($sql);
echo "<a href='temp.html'>sfdf</a>";

if ($result->num_rows > 0) {
    // output data of each row
     
    while($row = $result->fetch_assoc()) 
            {
        //echo "No: " . $row["no"]. "Beach Name: " . $row["beach_name"]. "  address: " . $row["address"]. " longitude :" . $row["longitude"]. " latitude :"  . $row["latitude"]."<br>";
            echo "<table> ";
          echo "<tr>";
          echo "<td>";
          echo "<a href = 'temp.php'> No: " . $row["no"]. "</a>";
          echo "</td>";
          echo "<td>";
          echo "Beach Name: " . $row["beach_name"];
          echo "</td>";
            echo "<td>";
          echo "Address: " . $row["address"];
          echo "</td>";
            echo "<td>";
          echo "Latitude: " . $row["latitude"];
          echo "</td>";
            echo "<td>";
          echo "Longitude: " . $row["longitude"];
          echo "</td>";
     
          echo "</tr>";
          echo "</table>";
           } 
} else {
    echo "0 results";
}
$conn->close();
?>
        </form>
  </div>
 </section>   
        <footer id="footer">
				<div class="container">
					<section class="links">
						<div class="row">
							<section class="3u 6u(medium) 12u$(small)">
								<h3>The copyright of data we used belongs </h3>
								<ul class="unstyled">
									<li><a href="www.google.com">Google Map</a></li>
									<li><a href="www.doggo.com">Doggo</a></li>
					                 	</ul>
							</section>
                                                </div>    
																										</div>
					</section>
					<div class="row">
						<div class="8u 12u$(medium)">
							<ul class="copyright">
								<li>&copy; Untitled. All rights reserved.</li>
								<li>Design: <a href="http://templated.co">TEMPLATED</a></li>
								<li>Images: <a href="http://unsplash.com">Unsplash</a></li>
							</ul>
						</div>
						<div class="4u$ 12u$(medium)">
							<ul class="icons">
								<li>
									<a class="icon rounded fa-facebook"><span class="label">Facebook</span></a>
								</li>
								<li>
									<a class="icon rounded fa-twitter"><span class="label">Twitter</span></a>
								</li>
								<li>
									<a class="icon rounded fa-google-plus"><span class="label">Google+</span></a>
								</li>
								<li>
									<a class="icon rounded fa-linkedin"><span class="label">LinkedIn</span></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</footer>

</body>
</html>

