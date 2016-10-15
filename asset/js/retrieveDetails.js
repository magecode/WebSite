//retreive figurs from DB and process
function retrieveDetail() {
    var query = window.location.search.substring(1);
    var parameters = query.split("&");

    var prFlag = 0;
    var popFlag = 0;
    var crFlag = 0;

    var suburbName = document.getElementById("suburbName").innerHTML.split(",")[0];

    for (i = 1; i < parameters.length; i++) {
        if (parameters[i].match(/\d+/) != null) {
            var rangeValue = parameters[i].match(/\d+/)[0];
            if (rangeValue != 0) {
                if (parameters[i].match(/cr/g) != null) {
                    crFlag = 1;
                } else if (parameters[i].match(/pop/g) != null) {
                    popFlag = 1;
                } else if (parameters[i].match(/pr/g) != null) {
                    prFlag = 1;
                }
            }
        }
    }

    //using AJAX to connect to DB
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var temp = this.responseText;
            var details = [];
            details = temp.split("&");
            for (i = 0; i <= details.length - 1; i++) {
                if (details[i].match(/cr/g) != null) {
                    var crimes = details[i].split(",");
                    var rate = lvToWord(crimes[2], "crime");
                    var text = "<table><tr><td>Figure:</td><td>" + crimes[1] + " reports</td></tr>"
                                + "<tr><td>Level:</td><td>" + rate + "</td></tr></table>";
                    document.getElementById("crDetail").innerHTML = text;
                    drawStars("crStars", crimes[2]);
                } else if (details[i].match(/pop/g) != null) {
                    var populations = details[i].split(",");
                    var rate = lvToWord(populations[4], "population");
                    var text = "<table><tr><td>Figure:</td><td>" + populations[1] + "</td></tr>"
                                + "<tr><td>Geo Area:</td><td>" + populations[2] + " km<sup>2</sup></td></tr>"
                                + "<tr><td>Density:</td><td>" + populations[3] + " ppl/" + "km<sup>2</sup></td></tr>"
                                + "<tr><td>Level:</td><td>" + rate + "</td></tr></table>";
                    document.getElementById("popDetail").innerHTML = text;
                    drawStars("popStars", populations[4]);
                } else if (details[i].match(/pr/g) != null) {
                    var prices = details[i].split(",");
                    var rate = lvToWord(prices[2], "price");
                    var text = "<table><tr><td>Average:</td><td>$" + prices[1] + "</td></tr>"
                                + "<tr><td>Level:</td><td>" + rate + "</td></tr></table>";
                    document.getElementById("prDetail").innerHTML = text;
                    drawStars("prStars", prices[2]);
                }
            }

            //give empty result a meaningful output
            validateResult();
        }
    };

    xhttp.open("GET", "details.php?prFlag=" + prFlag + "&popFlag=" + popFlag + "&crFlag=" + crFlag + "&suburb=" + suburbName, true);
    xhttp.send();
}

function validateResult() {
    if (document.getElementById("crDetail").innerHTML == "") {
        var text = "Sorry, no data can be retrieved.";
        document.getElementById("crDetail").innerHTML = text;
    }

    if (document.getElementById("popDetail").innerHTML == "") {
        var text = "Sorry, no data can be retrieved.";
        document.getElementById("popDetail").innerHTML = text;
    }

    if (document.getElementById("prDetail").innerHTML == "") {
        var text = "Sorry, no data can be retrieved.";
        document.getElementById("prDetail").innerHTML = text;
    }
}

function lvToWord(lv, feature) {
    var text = "";
    if (feature == "crime") {
        text1 = "High";
        text2 = "Elevated";
        text3 = "Guarded";
        text4 = "Very safe";
    } else if (feature == "price") {
        text1 = "Expensive";
        text2 = "Acceptable";
        text3 = "Moderate";
        text4 = "Cheap";
    } else if (feature == "population") {
        text4 = "Few people";
        text3 = "Moderate";
        text2 = "Crowded";
        text1 = "Populated";
    }

    switch(lv){
        case "1":
            text = text1;
            break;
        case "2":
            text = text2;
            break;
        case "3":
            text = text3;
            break;
        case "4":
            text = text4;
            break;
        default:
            break;
    }

    return text;
}

function drawStars(element, level) {
    var stars = "";
    switch (level) {
        case "1":
            stars = "<span class='active'><i class='fa fa-star-o'></i></span><span><i class='fa fa-star-o'></i></span><span><i class='fa fa-star-o'></i></span><span><i class='fa fa-star-o'></i></span>";
            break;
        case "2":
            stars = "<span class='active'><i class='fa fa-star-o'></i></span><span class='active'><i class='fa fa-star-o'></i></span><span><i class='fa fa-star-o'></i></span><span><i class='fa fa-star-o'></i></span>";
            break;
        case "3":
            stars = "<span class='active'><i class='fa fa-star-o'></i></span><span class='active'><i class='fa fa-star-o'></i></span><span class='active'><i class='fa fa-star-o'></i></span><span><i class='fa fa-star-o'></i></span>";;
            break;
        case "4":
            stars = "<span class='active'><i class='fa fa-star-o'></i></span><span class='active'><i class='fa fa-star-o'></i></span><span class='active'><i class='fa fa-star-o'></i></span><span class='active'><i class='fa fa-star-o'></i></span>";;
            break;
        default:
            break;
    }

    document.getElementById(element).innerHTML = stars;
}
