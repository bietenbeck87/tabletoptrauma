<?php
include_once("../core/dB.php");
$db = new dB();

$sGameSelect =  "Select * from brettspiele";

$sUserSelect = "Select * from users";
$allGames = $db->getAll($sGameSelect);
$allUsers = $db->getAll($sUserSelect);

$aUsers = array();
foreach($allUsers as $user){
    $aUsers[$user["NAME"]] = $user["ID"];
}

foreach($allGames as $game){
    $aBesitzer = explode("||",$game["BESITZER"]);
    foreach($aBesitzer as $UserName){
        $select1User="Select ID from users where NAME='".$UserName."'";
        $userID = $db->getOne($select1User);
        $insert = "Insert into user2game (IDGAME,IDUSER,STATUS) values ('".$game["ID"]."','".$userID."','".$game["BESTELLT"]."')";
        $db->execute($insert);
    }
}