$(document).ready(function () {
    $("#nameInput").blur(function(){
      var name = $("#nameInput").val().substr(0,1);
      $("#shortName").text(name);
  });

    $("#colorInput").blur(function(){
      var Color = "#"+$("#colorInput").val();
      $("#colorPick").css("background",Color);
  });
})
