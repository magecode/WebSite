<!doctype html>
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><html lang="en" class="no-js"> <![endif]-->
<html lang="en">

<head>
    <!-- Clear Cache-->
    <meta http-equiv="Cache-control" content="no-cache" />

    <!-- Basic -->
    <title>Neighbourgood | Target Locaion</title>

    <!-- Define Charset -->
    <meta charset="utf-8" />

    <!-- Responsive Metatag -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Page Description and Author -->
    <meta name="description" content="Sulfur - Responsive HTML5 Template" />
    <meta name="author" content="Shahriyar Ahmed" />

    <!-- Bootstrap CSS  -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" type="text/css" />

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css" type="text/css" />

    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="../css/owl.carousel.css" type="text/css" />
    <link rel="stylesheet" href="../css/owl.theme.css" type="text/css" />
    <link rel="stylesheet" href="../css/owl.transitions.css" type="text/css" />

    <!-- Css3 Transitions Styles  -->
    <link rel="stylesheet" type="text/css" href="../css/animate.css" />

    <!-- Lightbox CSS -->
    <link rel="stylesheet" type="text/css" href="../css/lightbox.css" />

    <!-- Sulfur CSS Styles  -->
    <link rel="stylesheet" type="text/css" href="../css/style.css" />

    <!-- Responsive CSS Style -->
    <link rel="stylesheet" type="text/css" href="../css/responsive.css" />
    <script src="../js/modernizrr.js"></script>


    <script src="../js/jquery.min.js" type="text/javascript"></script>
    <script src="../js/plotly-latest.min.js" type="text/javascript"></script>
    <script src="../js/drawChart.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcvtV_71ZGFAUUcS9_u_D1ZFHi2BWLjao&libraries=places"></script>
    <script src="../js/processTop.js" type="text/javascript"></script>
    <script src="../js/initMap.js"></script>
    <script src="../js/retrieveDetails.js" type="text/javascript"></script>



    <!-- Sulfur JS File -->
    <script src="../js/jquery-2.1.3.min.js"></script>
    <script src="../js/jquery-migrate-1.2.1.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/jquery.appear.js"></script>
    <script src="../js/jquery.fitvids.js"></script>
    <script src="../js/jquery.nicescroll.min.js"></script>
    <script src="../js/lightbox.min.js"></script>
    <script src="../js/count-to.js"></script>
    <script src="../js/styleswitcher.js"></script>

    <script src="../js/map.js"></script>
    <script src="../js/script.js"></script>
    <script>
        function refreshPage(id) {
            var suburb = document.getElementById("top" + id).innerHTML;
            
            var query = window.location.search.substring(1);
            //alert(query);
            var parameters = query.split("&");
            parameters[0] = "suburb=" + suburb + "%2C+Victoria%2C+Australia";
            var address = parameters[0];
            for (i = 1; i <= parameters.length - 1; i++) {
                address = address + "&" + parameters[i];
            }
            //alert(address);
            //parameters[0] = "";
            window.open("http://118.139.17.41/asset/php/result.php?" + address, "_self");
        }
        
    </script>
    

</head>
<body>

    <header class="clearfix">

        <!-- Clear Cache-->
        <meta http-equiv="Cache-control" content="no-cache" />

        <!-- Start Top Bar -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="top-bar">
                        <div class="row">

                            <div class="col-md-6">
                                <!-- Start Contact Info -->
                                <ul class="contact-details">
                                    <li>
                                        <i class="fa fa-phone"></i>+12 345 678 000
                                    </li>
                                    <li>
                                        <i class="fa fa-envelope-o"></i>support@neighbourgood.com
                                    </li>
                                </ul>
                                <!-- End Contact Info -->
                            </div><!-- .col-md-6 -->

                        </div>


                    </div>
                </div>

            </div><!-- .row -->
        </div><!-- .container -->
        <!-- End Top Bar -->

        <!-- Start  Logo & Naviagtion  -->
        <div class="navbar navbar-default navbar-top">
            <div class="container">
                <div class="navbar-header">
                    <!-- Stat Toggle Nav Link For Mobiles -->
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- End Toggle Nav Link For Mobiles -->
                    <a class="navbar-brand" href="index.html">Neighbourgood</a>
                </div>
                <div class="navbar-collapse collapse">

                    <!-- Start Navigation List -->
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="../../index.html">Home</a>
                        </li>
                        <li>
                            <a>Your Target Location</a>
                        </li>
                        <li>
                            <a href="../../about.html">About</a>
                        </li>
                        <li>
                            <a href="../../contact.html">Contact</a>
                        </li>
                    </ul>
                    <!-- End Navigation List -->
                </div>
            </div>
        </div>
        <!-- End Header Logo & Naviagtion -->

    </header>


    <!-- Start Header Section -->
    <div class="page-header">
        <div class="overlay">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 id="suburbName"></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Section -->




    <!-- Start Service Section -->
    <section id="resultMap" style="width: 100%; height: 500px;">

        <div class="container"></div>
    </section>
    <!-- Start Service Section -->


    <!-- Start Abstract Section -->
    <section class="fun-facts">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title text-center wow fadeInDown" data-wow-duration="2s" data-wow-delay="50ms">
                    <h2 style="color:#ffffff;">Infomation Abstract (Based on 2015 reports)</h2>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <?php
                $ranges = explode('&', $_SERVER['REQUEST_URI']);
                unset($ranges[0]);
                $features = [];
                $flag = false;
                foreach($ranges as $value){
                    $int = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
                    if($int !== "0" && $int != null){
                        $flag = true;
                        if(strpos($value, "cr") !== false){
                            $features[] = "CrimeRate";
                        }else if(strpos($value, "pop") !== false){
                            $features[] = "PopulationDensity";
                        }else if(strpos($value, "pr") !== false){
                            $features[] = "Price";
                        }
                    }
                }

                if($flag == true){
                    echo "
                        <div class='col-xs-12 col-sm-3 col-md-3 wow fadeInLeft'>
                            <div class='counter-item' style='height: 400px;'>
                                <i class='fa fa-cloud-upload'></i>
                                <h3>Top 5 recommend Suburbs</h3>
                                <p>(Based on the given weight of featrues)</p>
                                <div align='left' style='font-size:20px'> <a id = 'top1' onclick='refreshPage(". 1 .")'></a></div><br>
                                <div align='left' style='font-size:20px'> <a id = 'top2' onclick='refreshPage(". 2 .")'></a></div><br>
                                <div align='left' style='font-size:20px'> <a id = 'top3' onclick='refreshPage(". 3 .")'></a></div><br>
                                <div align='left' style='font-size:20px'> <a id = 'top4' onclick='refreshPage(". 4 .")'></a></div><br>
                                <div align='left' style='font-size:20px'> <a id = 'top5' onclick='refreshPage(". 5 .")'></a></div>
                            </div>
                        </div>";
                }else{
                    echo"
                        <h3 align='center' style='color:white;'>SORRY, SINCE YOU RATE ALL ENVIRONMENT FEATURES as 0, WE HAVE NO DATA TO SHOW HERE.</h3>
                    ";
                }

                $text = "";
                foreach ($features as $value){
                    if ($value == "CrimeRate"){
                        echo "
                        <div class='col-xs-12 col-sm-3 col-md-3 wow fadeInUp'>
                            <div class='counter-item' style='height: 400px;'>
                                <i class='fa fa-code'></i>
                                <h3>". $value ."</h3>
                                <p><br></p>
                                <p id='crDetail' align='left' style='font-size:20px'></p>
                            </div>
                        </div>";
                    }else{
                        if($value == "PopulationDensity"){
                            echo "
                        <div class='col-xs-12 col-sm-3 col-md-3 wow fadeInUp' data-wow-duration='2s' data-wow-delay='300ms'>
                            <div class='counter-item' style='height: 400px;'>
                                <i class='fa fa-male'></i>
                                <h3>". $value ."</h3>
                                <p><br></p>
                                <p id='popDetail' align='left' style='font-size:20px'></p>
                            </div>
                        </div>";
                        }else{
                            if($value == "Price"){
                                echo "
                                <div class='col-xs-12 col-sm-3 col-md-3 wow fadeInUp' data-wow-duration='2s' data-wow-delay='300ms'>
                                    <div class='counter-item' style='height: 400px;'>
                                        <i class='fa fa-diamond'></i>
                                        <h3>". $value ."</h3>
                                        <p><br></p>
                                        <p id='prDetail' align='left' style='font-size:20px'></p>
                                    </div>
                                </div>";
                            }
                        }
                    }
                }
                ?>
    </section>
    <!-- End Abstract Section -->

    <!-- Start Diagram Section -->
    <section id="pricing-section" class="pricing-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title text-center wow fadeInDown" data-wow-duration="2s" data-wow-delay="50ms">
                        <h2>Data Analyze (2012-2015)</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="row" style="clear: both">
                    <?php
                            $ranges = explode('&', $_SERVER['REQUEST_URI']);
                            unset($ranges[0]);
                            $features = [];
                            foreach($ranges as $value){
                                $int = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
                                //echo $int;
                                if($int !== "0"){
                                    if(strpos($value, "cr") !== false){
                                        $features[] = "CrimeRate";
                                    }else if(strpos($value, "pop") !== false){
                                        $features[] = "PopulationDensity";
                                    }else if(strpos($value, "pr") !== false){
                                        $features[] = "Price";
                                    }
                                }
                            }
                            if(sizeof($features) !== 0){
                                echo"
                                <!--data set selector col-->
                                <div class='col-md-2 dataSetSelector' id='dataSetSelector'>
                                    <div class='list-group'>";
                                $count = 0;
                                foreach ($features as $value){
                                    $count++;
                                    //echo "<script type='text/javascript'>alert('$count');</script>";
                                    if($count == 1){
                                        echo"<a  class='list-group-item active' id='ds1'><p style='font-size:20px';><center>". $value ."</center></p></a>";
                                    }else{
                                        echo"<a  class='list-group-item' id='ds".$count ."'><p style='font-size:20px';><center>". $value ."</center></p></a>";
                                    }
                                }
                                echo"</div></div>
                                    <!--chart col-->
                                    <div class='col-md-10'>
                                            <div id='chart' style='width:100%;height:400px;'></div>
                                    </div>
                                    ";
                            }else{
                                echo"<h3 align='center'>Sorry, since you rate all environment features as 0, we have no data to show here.</h3>";
                            }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <!-- End Diagram Section -->

    <!-- Start Copyright Section -->
    <div id="copyright-section" class="copyright-section">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="copyright">
                        Copyright © 2016. All Rights Reserved by
                        <a href="http://www.neighbourgood.tk">Neighbourgood</a>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="copyright-menu pull-right">
                        <ul>
                            <li>
                                <a href="../../index.html" class="active">Home</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!--/.row -->
        </div><!-- /.container -->
    </div>
    <!-- End Copyright Section -->



        <!--row 2 charts-->

        <div id="test" style="display:none;"></div>
</body>
</html>
