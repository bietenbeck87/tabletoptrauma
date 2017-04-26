<?php
include_once("../core/dB.php");
$db = new dB();

$sGameSelect =  "Select * from brettspiele";

$tagSelect = "Select * from tags";
$allGames = $db->getAll($sGameSelect);
$allTags = $db->getAll($tagSelect);

$aTags = array();
foreach($allTags as $tag){
    $aTags[$tag["TAG"]] = $tag["ID"];
}

foreach($allGames as $game){
    $aGameTags = explode("||",$game["GENRE"]);
    foreach($aGameTags as $aGameTag){
        $select1Tag="Select ID from tags where TAG='".$aGameTag."'";
        $tagID = $db->getOne($select1Tag);
        $insert = "Insert into game2tag (IDGAME,IDTAG) values ('".$game["ID"]."','".$tagID."')";
        $db->execute($insert);
    }
}