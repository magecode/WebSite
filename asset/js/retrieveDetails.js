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
                    var text = "Crime Figure: " + crimes[1] + "<br>"
                                + "Level: " + rate;
                    document.getElementById("crDetail").innerHTML = text;
                    drawStars("crStars", crimes[2]);
                } else if (details[i].match(/pop/g) != null) {
                    var populations = details[i].split(",");
                    var rate = lvToWord(populations[4], "population");
                    var text = "Population Figure: " + populations[1] + "<br>"
                                + "Geographic Area: " + populations[2] + "<br>"
                                + "Population Density: " + populations[3] + "<br>"
                                + "Level: " + rate;
                    document.getElementById("popDetail").innerHTML = text;
                    drawStars("popStars", populations[4]);
                } else if (details[i].match(/pr/g) != null) {
                    var prices = details[i].split(",");
                    var rate = lvToWord(prices[2], "price");
                    var text = "Average House Price: $" + prices[1] + "<br>"
                                + "Level: " + rate;
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
        text1 = "high";
        text2 = "elevated";
        text3 = "guarded";
        text4 = "very safe";
    } else if (feature == "price") {
        text1 = "expensive";
        text2 = "acceptable";
        text3 = "moderate";
        text4 = "cheap";
    } else if (feature == "population") {
        text1 = "very few people";
        text2 = "moderate";
        text3 = "crowded";
        text4 = "populated";
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
