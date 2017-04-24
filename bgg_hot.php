<meta charset="utf-8"/>
<title>HOTNESS LIST</title>
<link rel="stylesheet" type="text/css" href="./src/css/style.css">
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
echo "<a href='index.php'><div id='BackBtn'>Zurück</div></a>";
echo "<table class='hotlisttable'>";
echo "<tr class='head'><td>RANK:</td><td>BILD:</td><td>Name</td><td>ERSCHEINUNGS-JAHR:</td></tr>";
foreach($array["item"] as $gameData){
echo "<tr class='".$rowEvenOdd."'><td>".$gameData['@attributes']['rank']."</td><td><img src='".$gameData['thumbnail']['@attributes']['value']."'></td><td>".$gameData['name']['@attributes']['value']."</td><td>".$gameData['yearpublished']['@attributes']['value']."</td></tr>";
    if ($rowEvenOdd == "odd") {
        $rowEvenOdd = "even";
    }
    else {
        $rowEvenOdd = "odd";
    }

}
echo "</table>";
