
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
    //retrieve data
    var target = "";

    var query = window.location.search.substring(1);
    var parameters = query.split("&");

    //get envrionment features
    var count = 0;
    var eFeatures = [];
    for (i = 0; i < parameters.length; i++) {
        if (parameters[i].indexOf("eFeatures") !== -1) {
            //alert (parameters[i]);
            eFeatures[count] = parameters[i].replace("eFeatures%5B%5D=", "");
            count++;
        }
    }
    
    //get target suburb name
    //since gecoder is asynchronise function, do following step within its code body
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
                    dataManage(targetLoc, selectedChart, selectedDataSet, count);
                }
            }
        }
    });
}
function getData(selectedChart, selectedDataSet, count, yData)
{
    //alert(count);
    var element1 = {};
    var element2 = {};
    var element3 = {};
    var dataSet = {};
    var container = yData.split("#");

    for (i = 0; i < count; i++) {
        if (i == 0) {
            var temp = container[i].split("/");
            element1.x = [2012, 2013, 2014, 2015];
            element1.y = temp;
            element1.type = "line";
            dataSet.ds1 = element1;
        } else {
            if (i == 1) {
                var temp = container[i].split("/");
                element2.x = [2012, 2013, 2014, 2015];
                element2.y = temp;
                element2.type = "line";
                dataSet.ds2 = element2;
            } else {
                if (i == 2) {
                    var temp = container[i].split("/");
                    element3.x = [2012, 2013, 2014, 2015];
                    element3.y = temp;
                    element3.type = "line";
                    dataSet.ds3 = element3;
                }
            }
        }
    }

    var data = dataSet[selectedDataSet];
    data.type = selectedChart;
    if (selectedChart === "pie")
    {
        return [{values: data.y, lables: data.x, type: "pie"}];
    }
    return [data];
}

function dataManage(target, selectedChart, selectedDataSet, count) {
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("test").innerHTML = this.responseText;
            var yData = document.getElementById("test").innerHTML;
            var layout = {
                xaxis: {
                    title: 'Year',
                    showgrid: false,
                    zeroline: false
                },
                yaxis: {
                    title: 'Figure',
                    showline: false
                },
                margin: {t:0.5}
            };

            data = getData(selectedChart, selectedDataSet, count, yData);
            Plotly.newPlot(chart, data, layout);
        }
    };

    xhttp.open("GET", "connectDB.php?suburb=" + target, true);
    xhttp.send();
}