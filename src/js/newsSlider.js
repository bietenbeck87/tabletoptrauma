$(document).ready(function () {
    var i = 2;
    var DomID = "";
    window.setInterval(function () {
        animation(i);
        i++;
        if (i == 11) {
            i = 1;
        }
    }, 3000);

    function animation() {
        DomID = "#news_" + i;
        $(".newsElement").hide("slow");
        $(DomID).show("slow");
    }
});