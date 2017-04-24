function validateForm() {
    var BoolT=false;
    var alertM = "";
    var name = document.forms["addeditform"]["name"].value;

    if (name == "") {
        alertM +="-Name muss ausgefüllt werden!\n";
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