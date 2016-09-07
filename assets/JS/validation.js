//validate user input suburb name and checkbox
var checkFlag = false;


function validateForm(theForm) {
    var input = document.forms["input"]["suburb"].value;
    
    if (input == null || input == "") {
        alert("suburb input must be filled out");
        return false;
    } else {
        var checkCR = document.getElementById("CrimeRate");
        var checkPD = document.getElementById("PopulationDensity");
        var checkPR = document.getElementById("Price");
        if (checkCR.checked || checkPD.checked || checkPR.checked) {
            checkFlag = true;
        }
        if (checkFlag == false) {
            alert("please choose at least one environment feature");
            return false;
        }
    }

    
   
    

}
