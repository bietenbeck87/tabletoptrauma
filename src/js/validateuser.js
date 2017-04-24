function validateForm() {
    var BoolT=false;
    var alertM = "";
    var name = document.forms["addeditform"]["name"].value;
    var mail = document.forms["addeditform"]["mail"].value;
    var password = document.forms["addeditform"]["password"].value;


    if (name == "") {
        alertM +="-Username muss ausgefüllt werden!\n";
        BoolT = true;
    }
    if (mail == "") {
        alertM +="-Email muss ausgefüllt werden!\n";
        BoolT = true;
    }
    if (password == "") {
        alertM +="-Password muss ausgefüllt werden!\n";
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