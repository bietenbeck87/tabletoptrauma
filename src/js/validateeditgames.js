function validateForm() {
    var BoolT=false;
    var alertM = "";
    var name = document.forms["addeditform"]["name"].value;
    var minp = document.forms["addeditform"]["min_p"].value;
    var maxp = document.forms["addeditform"]["max_p"].value;
    var mint = document.forms["addeditform"]["min_t"].value;
    var maxt = document.forms["addeditform"]["max_t"].value;
    var url = document.forms["addeditform"]["url"].value;
    var img = document.forms["addeditform"]["img"].value;

    if (name == "") {
        alertM +="-Name muss ausgefüllt werden!\n";
        BoolT = true;
    }
    if (minp == "") {
        alertM +="-Mindest-Spieleranzahl muss ausgefüllt werden!\n";
        BoolT = true;
    }
    if (maxp == "") {
        alertM +="-Maximal-Spieleranzahl muss ausgefüllt werden!\n";
        BoolT = true;
    }
    if (mint == "") {
        alertM +="-Mindest-Spielzeit muss ausgefüllt werden!\n";
        BoolT = true;
    }
    if (maxt == "") {
        alertM +="-Maximal-Spielzeit muss ausgefüllt werden!\n";
        BoolT = true;
    }
    if (url == "") {
        alertM +="-URL muss ausgefüllt werden!\n";
        BoolT = true;
    }
    if (img == "") {
        alertM +="-Bild-URL muss ausgefüllt werden!\n";
        BoolT = true;
    }

    if(!isNumeric(minp) || !isNumeric(maxp) || !isNumeric(mint) || !isNumeric(maxt)){
        alertM +="-Zahlenfelder prüfen!\n";
        BoolT = true;
    }

    if(BoolT){
        alert(alertM);
        return false;
    }
}

function isNumeric(n) {
  return !isNaN(parseInt(n)) && isFinite(n);
}