function validateForm() {
    var BoolT = false;
    var alertM = "";
    var date = document.forms["dateForm"]["date"].value;
    var time = document.forms["dateForm"]["time"].value;
    var who = document.forms["dateForm"]["who"].value;
    var place = document.forms["dateForm"]["place"].value;
    var games = document.forms["dateForm"]["games[]"].value;

    if (date == "") {
        alertM += "-Datum muss ausgefüllt werden!\n";
        BoolT = true;
    }
    else {
        if (!date.match(/^[0-9]{4}-[0-1]{1}[0-9]{1}-[0-3]{1}[0-9]{1}$/)) {
            alertM += "-Datum's Format überprüfen!\n";
            BoolT = true;
        }
    }
    if (time == "") {
        alertM += "-Zeit muss ausgefüllt werden!\n";
        BoolT = true;
    }
    else {
        if (!time.match(/^[0-2]{1}[0-9]{1}:[0-5]{1}[0-9]{1}$/)) {
            alertM += "-Datum's Format überprüfen!\n";
            BoolT = true;
        }
    }

    if (who == "") {
        alertM += "-Spieler müssen gewähltwerden!\n";
        BoolT = true;
    }
    if (place == "") {
        alertM += "-Ort muss eingegeben werden!\n";
        BoolT = true;
    }
    if (games == "") {
        alertM += "-Spiele auswählen\n";
        BoolT = true;
    }

    if (BoolT) {
        alert(alertM);
        return false;
    }
}

function isNumeric(n) {
    return !isNaN(parseInt(n)) && isFinite(n);
}