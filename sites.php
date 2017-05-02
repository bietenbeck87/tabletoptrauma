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
<?php
echo "<a href='".$GLOBALS['_SERVER']['HTTP_REFERER']."'><div class='BackBtn leftBtn'>Zurück</div></a>";
echo "<a href='index.php'><div class='BackBtn rightBtn'>Startseite</div></a>";
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