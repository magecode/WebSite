//validate user input suburb name and checkbox
function validateForm(theForm) {
    var x = document.forms["input"]["suburb"].value;
    var y = theForm.eFeature.checked;

    if (x == null || x == "") {
        alert("suburb input must be filled out");
        return false;
    } else {
        if (y == null || y == "") {
            alert("checkbox must have at least one checked feature");
            return false;
        }
    }
}
