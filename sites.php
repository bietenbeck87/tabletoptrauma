<?php
include_once("./core/dB.php");
$db = new dB();
$sql = "select * from sites";
$shops = $db->getAll($sql);
$aShops = array();
$i=0;
foreach($shops as $shop){
    $aShops[$shop["TYPE"]][$i]["NAME"] =$shop["NAME"];
    $aShops[$shop["TYPE"]][$i]["URL"] =$shop["URL"];
    $aShops[$shop["TYPE"]][$i]["COMMENTARY"] =$shop["COMMENTARY"];
    $i++;
}
?>
<meta charset="utf-8"/>
<title>SHOPS</title>
<link rel="stylesheet" type="text/css" href="./src/css/style.css">
<script src="./src/js/goBack.js"></script>
<?php
echo "<div class='BackBtn leftBtn' onclick='goBack();'>Zurück</div>";
echo "<a href='index.php'><div class='BackBtn rightBtn'>Startseite</div></a>";
echo "<div class='clear'></div>";
?>
<div id="SiteDiv">
    <?php
    foreach($aShops as $type =>$aShopContainter){
       echo "<h2>".$type."</h2><ul>";
        foreach($aShopContainter as $aShop){
            echo "<li title='".$aShop["COMMENTARY"]."'><a href='".$aShop["URL"]."'>".$aShop["NAME"]."</a></li>";
        }
        echo "</ul>";
    }
    ?>
</div>