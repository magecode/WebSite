function autoComplete() {
    var input = /** @type {!HTMLInputElement} */(
      document.getElementById('input'));

    var autocomplete = new google.maps.places.Autocomplete(input);

}