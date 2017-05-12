<meta charset="utf-8"/>
<title>HOTNESS LIST</title>
<link rel="stylesheet" type="text/css" href="./src/css/style.css">
<script src="./src/js/goBack.js"></script>
<?php
$s = curl_init();
$url="https://www.boardgamegeek.com/xmlapi2/hot";
curl_setopt($s,CURLOPT_URL,$url);
curl_setopt($s,CURLOPT_RETURNTRANSFER, 1);
$xmlstring = curl_exec($s);
curl_close($s);
$xml = simplexml_load_string($xmlstring);
$json = json_encode($xml);
$array = json_decode($json,TRUE);
$rowEvenOdd = "odd";
echo "<div class='BackBtn leftBtn' onclick='goBack();'>Zurück</div>";
echo "<a href='index.php'><div class='BackBtn rightBtn'>Startseite</div></a>";
echo "<div class='clear'></div>";
echo "<table class='hotlisttable'>";
echo "<tr class='head'><td>RANK:</td><td>BILD:</td><td>Name</td><td>ERSCHEINUNGS-JAHR:</td></tr>";
foreach($array["item"] as $gameData){
echo "<tr class='".$rowEvenOdd."'><td>".$gameData['@attributes']['rank']."</td><td><a href='https://boardgamegeek.com/boardgame/".$gameData['@attributes']['id']."/' target='_blank'><img src='".$gameData['thumbnail']['@attributes']['value']."'></a></td><td>".$gameData['name']['@attributes']['value']."</td><td>".$gameData['yearpublished']['@attributes']['value']."</td></tr>";
    if ($rowEvenOdd == "odd") {
        $rowEvenOdd = "even";
    }
    else {
        $rowEvenOdd = "odd";
    }

}
echo "</table>";
