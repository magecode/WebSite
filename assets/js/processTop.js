window.onload = function () {
    //get range value
    var query = window.location.search.substring(1);
    var parameters = query.split("&");

    var prRange = 0;
    var popRange = 0;
    var crRange = 0;

    for (i = 1; i < parameters.length; i++) {
        var rangeValue = parameters[i].match(/\d+/)[0];
        if (rangeValue != 0) {
            if (parameters[i].match(/cr/g) != null) {
                crRange = rangeValue;
            }else if (parameters[i].match(/pop/g) != null) {
                popRange = rangeValue;
            } else if (parameters[i].match(/pr/g) != null) {
                prRange = rangeValue;
            }
        }
    }

    var sum = Number(crRange) + Number(popRange) + Number(prRange);
    var prWeight = prRange / sum;
    var popWeight = popRange / sum;
    var crWeight = crRange / sum;


    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("top5").innerHTML = this.responseText;
            }
    };

    xhttp.open("GET", "top5.php?prWeight=" + prWeight + "&popWeight=" + popWeight + "&crWeight=" + crWeight, true);
    xhttp.send();
}