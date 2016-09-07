<html>
    <head>
        <title>NeigbourGood</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

        <script src="../js/jquery.min.js" type="text/javascript"></script>
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../js/plotly-latest.min.js" type="text/javascript"></script>
        <script src="../js/drawChart.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcvtV_71ZGFAUUcS9_u_D1ZFHi2BWLjao&libraries=places"></script>


        
        <!--<link href="../css/googleMap.css" rel="stylesheet" type="text/css"/>-->
        <!--
        <script src="assets/js/googleMap.js" type="text/javascript"></script>
        -->
        <script src="../js/initMap.js"></script>
        <style>
            body { padding-top: 70px;  
            }
            #navbarimagelogo{margin-top: -5px;}
            .container *
            {
                /*border: 1px black solid;*/
            }
            #map
            {
                height: 500px;
            }
            .panel-heading a:after {
                font-family:'Glyphicons Halflings';
                content:"\e114";
                float: right;
                color: grey;
            }
            .panel-heading a.collapsed:after {
                content:"\e080";
            }
            .scrollable
            {
                height: 500px;
                max-height: 500px;
                overflow-y:scroll; 
            }
            .list-group-horizontal .list-group-item {
                display: inline-block;
            }
            .list-group-horizontal .list-group-item {
                margin-bottom: 0;
                margin-left:-4px;
                margin-right: 0;
            }
            .list-group-horizontal .list-group-item:first-child {
                border-top-right-radius:0;
                border-bottom-left-radius:4px;
            }
            .list-group-horizontal .list-group-item:last-child {
                border-top-right-radius:4px;
                border-bottom-left-radius:0;
            }
            .sameWidht33Percent a
            {
                width: 33%;
            }
            .dataSetSelector
            {
                height: 300px;
            }
            .dataSetSelector a
            {
                text-align: center;
                line-height: 2.5;
                height: 20%;
                font-weight: bold;
            }
            .main-svg
            {
                background: none !important;
            }
        </style>
    </head>
    <body>
        <!--     top menu        -->
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <!--header-->
                <div class="navbar-header">
                    <a class="navbar-brand" href="../../home.html">
                        <img src="../img/logo.png" alt="logo" height="30" id="navbarimagelogo"/>
                    </a>
                </div>
                <!--items-->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-8"> 
                    <ul class="nav navbar-nav"> 
                        <li class="active">
                            <a href="../../home.html">Home</a>
                        </li> 
                        <li>
                            <a href="../../temp.html">About Us</a>
                        </li> 
                    </ul> 
                </div>
            </div>
        </nav> 
        <!--main section-->
        <div class="container">
            <!--first row-->
            <!--map|info-->
            <div class="row">
                <!--map col-->
                <div class="col-md-7">
                    <div id="googleMap"  style="width: 100%; height: 500px;"></div>
                </div>
                <!--info col-->
                <div class="col-md-5 scrollable">
                    <div class="panel-group" id="accordion">
                        <?php
                            if(!empty($_GET['eFeatures'])) {
                                foreach($_GET['eFeatures'] as $check) {
                                    $panelNames[] = $check;
                                }
                            }

                            $text = "";
                            foreach ($panelNames as $value){
                                if ($value == "CrimeRate"){
                                    $text =
                                        "<p>The figure of crimes in your chosen suburb</p><br>
                                         <p>You can take a look at the diagram in the bottom of this web page.<br>
                                            It shows the sum of below two crime categories:<br>
                                            1. Crimes against the person;<br>
                                            2. Property and deception offences</p><br>
                                        <p>Data Source: <a href='https://www.crimestatistics.vic.gov.au/'>Crime Statistic Agency Victoria</a></p><br>
                                        <p>We may lack of certain suburb's data, all missing data will be showed as 0.</p>";
                                }else{
                                     if($value == "PopulationDensity"){
                                         $text = "<p>It shows population per unit area. The higher the figure is, the more people is living in that suburb.</p><br>
                                        <p>You can take a look at the diagram in the bottom of this web Page.<br>
                                        It shows how many people is living per square meters in your target suburb.</p>
                                        <p>Data Source: <a href='http://www.abs.gov.au/'>Australia Bureau of Statistics</a></p><br>
                                        <p>We may lack of certain suburb's data, all missing data will be showed as 0.</p>";
                                     }else{
                                         if($value == "Price"){
                                             $text = "<p>It shows the average buying price for a property.<br>
                                            Since the real market is varying a lot, this information is just for reference.</p>
                                            <p>Data Source: <a href='http://www.delwp.vic.gov.au/'>Victoria Government Department of Environment, Land, Water & Planning</a></p><br>
                                            <p>We may lack of certain suburb's data, all missing data will be showed as 0.</p>";
                                         }
                                     }
                                 }
                                echo"
                                    <div class='panel panel-default' id='panel1'>
                                        <div class='panel-heading'>
                                            <h4 class='panel-title'>
                                            <a data-toggle='collapse' data-target='#collapseOne' href='#collapseOne'>
                                                ". $value . "
                                            </a>
                                            </h4>
                                    </div>
                                    <div id='collapseOne' class='panel-collapse collapse in'>
                                        <div class='panel-body'>".$text."</div>
                                        </div>
                                    </div>
                                    ";
                            }

                        ?>                          
                    </div>
                </div>

            </div>
            <br/>
            <!--row 2 charts-->

            <div class="row" style="clear: both">
                <!--data set selector col-->
                <div class="col-md-2 dataSetSelector"  id="dataSetSelector">
                    <div class="list-group">
                        <?php
                        //$eVar = $_GET['eFeatures'];

                        if(!empty($_GET['eFeatures'])) {
                            foreach($_GET['eFeatures'] as $check) {
                                $eArray[] = $check;
                            }
                        }

                       // print_r(array_values($eArray));

                        $count = 0;
                        foreach ($eArray as $value){
                            $count++;
                            echo"<a  class='list-group-item' id='ds".$count ."'>". $value ."</a>";
                        }
                        ?>
                    </div>
                </div>
                <!--chart col-->
                <div class="col-md-10">
                    <!--chart type row-->
                    <div class="row">
                        <div class="list-group list-group-horizontal sameWidht33Percent" id="chartTypeSelector">
                            <a  class="list-group-item active" id="line"> line chart</a>
                            <a  class="list-group-item" id="bar">bar chart</a>
                            <a  class="list-group-item" id="pie">pie chart</a>
                        </div>
                    </div>
                    <!--main chart row-->
                    <div class="row">
                        <div id="chart" style="width:100%;height:290px;"></div>
                    </div>
                </div>
            </div>  
            <div id="test" style="display:none;"></div>
            </body>
</html>
