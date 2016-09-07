
$(document).ready(function () {
    //initMap();
    
    var selectedChart = "line";
    var selectedDataSet = "ds1";

    var chart = document.getElementById('chart');
    drawChart(selectedChart, selectedDataSet, chart);
    $("#chartTypeSelector a").click(function () {
        selectedChart = $(this).attr("id");
        if (!$(this).hasClass("active"))
        {
            $("#chartTypeSelector a").removeClass("active");
            $(this).addClass("active");
            drawChart(selectedChart, selectedDataSet, chart);
        }
    });
    $("#dataSetSelector a").click(function () {
        selectedDataSet = $(this).attr("id");
        if (!$(this).hasClass("active"))
        {
            $("#dataSetSelector a").removeClass("active");
            $(this).addClass("active");
            drawChart(selectedChart, selectedDataSet, chart);
        }
    });
});

function drawChart(selectedChart, selectedDataSet, chart)
{
    data = getData(selectedChart, selectedDataSet);
    Plotly.newPlot(chart, data,
            {margin: {t: 0}});

}
function getData(selectedChart, selectedDataSet)
{
    //var target = "MELBOURNE";
    var target1 = document.getElementById("ds1").innerHTML;
    var query = window.location.search.substring(1);
    var parameters = query.split("&");

    var count = 0;
    var eFeatures = [];
    for (i = 0; i < parameters.length; i++) {
        if (parameters[i].indexOf("eFeatures") !== -1) {
            //alert (parameters[i]);
            eFeatures[count] = parameters[i].replace("eFeatures%5B%5D=", "");
            count++;
        }
    }
    var target = getSuburbName(parameters, callback);
    alert(target);
    //retrieveDB(target);
    //alert(DBResponse);
    var test = [5, 5, 6, 4, 9];
    //var hardCodedData = {ds1: {x: [1, 2, 3], y: [4, 5, 6],type: "line" }, ds2: {x: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], y: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], type: "line"}, ds3: {x: [8, 9, 6, 3, 4], y: [8, 6, 3, 7, 8], type: "line"}};
    var hardCodedData = { ds1: { x: [2012, 2013, 2014, 2015, 2016], y: test, type: "line" }, ds2: { x: [2012, 2013, 2014, 2015, 2016], y: [2, 3, 4, 5, 6], type: "line" } };
    var data = hardCodedData[selectedDataSet];
    data.type = selectedChart;
    if (selectedChart === "pie")
    {
        return [{values: data.y, lables: data.x, type: "pie"}];
    }
    return [data];
}

function retrieveDB(target) {
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("test").innerHTML = this.responseText;
            //DBResponse = this.responseText;
        }
    };

    xhttp.open("GET", "connectDB.php?suburb=" + target, true);
    xhttp.send();
}

function getSuburbName(parameters, callback) {
    var loc = "";
    loc = parameters[0].replace("suburb=", "").replace("+", " ");
			
    //retrieve geographic parameters from google api
    var targetLoc = loc.replace(/%2C/g, ",").replace(/\+/g, " ");

    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({ 'address': targetLoc }, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            //get suburb name 
            var loc_info = results[0].address_components;
            var flag_hasSuburb = false;
            for (i = 0; i < loc_info.length; i++) {
                if (loc_info[i].types.indexOf('locality') !== -1) {
                    targetLoc = loc_info[i].long_name;
                    alert(targetLoc);
                    callback(targetLoc);
                }
            }
        }
    });
}