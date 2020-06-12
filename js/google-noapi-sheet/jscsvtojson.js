$.get("https://docs.google.com/spreadsheets/d/e/2PACX-1vThwMLOfv4kM8jcSvKligWK8nz21Edfmn0IUncBXayhjySkl-BYY_FoOS4M_mozgOka2Vu_Nw1AKCK6/pub?gid=0&single=true&output=csv", function (data) {

    var data = JSON.parse(csvJSON(data));

    $(data).each(function (k, v) {
        console.log(v);
    })

})
//var csv is the CSV file with headers
function csvJSON(csv){

var lines=csv.split("\n");

var result = [];

var headers=lines[0].split(",");

for(var i=1;i<lines.length;i++){

var obj = {};
var currentline=lines[i].split(",");

for(var j=0;j<headers.length;j++){
obj[headers[j]] = currentline[j];
}

result.push(obj);

}

//return result; //JavaScript object
return JSON.stringify(result); //JSON
}