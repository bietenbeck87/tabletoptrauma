$(document).ready(function () {
    $(".accord").click(function(){
        $(this).next(".accElement").toggle();
        $(this).toggleClass("selected");
    })
})
