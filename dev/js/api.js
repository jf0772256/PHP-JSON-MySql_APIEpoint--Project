
// read the local json file.

$.getJSON("files/api/test_api.json", function(json) {
    console.log(json); // this will show the info it in firebug console
    for (var i = 0; i < json.length; i++) {
      document.getElementById('demo').innerHTML += json[i].categoryName + "<br />";
    }
});

$.getJSON("files/api/products.json", function(json) {
    console.log(json); // this will show the info it in firebug console
    document.getElementById('demo').innerHTML += "<br />";
    for (var i = 0; i < json.length; i++) {
      document.getElementById('demo').innerHTML += json[i].productName + "<br />";
    }
});
