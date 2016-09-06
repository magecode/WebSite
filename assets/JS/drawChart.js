var DBResponse = "";
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
    retrieveDB();
    alert(DBResponse);
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

function retrieveDB() {
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            DBResponse = this.responseText;
        }
    };

    xhttp.open("GET", "connectDB.php?suburb=" + "Malvern East", true);
    xhttp.send();
}