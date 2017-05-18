<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>TABLETOP TRAUMA</title>
    <link rel="stylesheet" type="text/css" href="./src/css/style.css">
    <link rel="stylesheet" href="./src/css/lightbox.min.css">
    <script src="./src/js/lightbox-plus-jquery.min.js"></script>
    <script src="./src/js/accordion.js"></script>
    <script src="./src/js/goBack.js"></script>
</head>
<body>
<?php
$id = $_GET["id"];
$aBestelltArray = array(0 => "ist angekommen", 1 => "wurde bestellt", 2 => "wurde zur Wantsliste hinzugefügt");
$aFlags = array(0 =>"owner_banner_arrived.png",1=>"owner_banner_ordered.png",2=>"owner_banner_wanted.png");
$aFlagDesc = array(0 => "available", 1 => "ordered", 2 => "wanted");

include_once("./core/dB.php");
include_once("./core/helper.php");

$aKoop = array(0 => "Nein",
    1 => "Koop",
    2 => "Koop + DM",
    3 => "Koop + Verräter",
    4 => "Teams");
$db = new dB();
$helper = new helper();
$getGame = "select * from brettspiele where ID=" . mysql_real_escape_string($id);
$game = $db->getAll($getGame);
$game = $game[0];

$getTags2Game="Select b.ID,t.TAG from brettspiele as b left join game2tag as g2g on b.ID=g2g.IDGAME join tags as t on g2g.IDTAG=t.ID";
$gameTags = $db->getAll($getTags2Game);
$aGameTags = array();
foreach($gameTags as $gameTag){
    $aGameTags[$gameTag["ID"]][] = $gameTag["TAG"];
}
$idTaggedGames ="";
if(isset($aGameTags[$game["ID"]])){
    $mainGameTags = $aGameTags[$game["ID"]];
    foreach($aGameTags as $key => $gameTags){
        $bl=true;
        if($key ==$game["ID"]){
            continue;
        }
        foreach($mainGameTags as $mainGameTag){
            if(!in_array($mainGameTag,$gameTags)){
                $bl=false;
            }
        }
        if($bl){
            $idTaggedGames.="'".$key."',";
        }
    }
    $idTaggedGames = substr($idTaggedGames,0,strlen($idTaggedGames)-1);
}

if (isset($_GET["status"]) && $_COOKIE["loggedInBG"]) {
    $loggedInUser = $db->getAll("Select * from users where ID='" . mysql_real_escape_string($_COOKIE["loggedInBG"]) . "'");
    $user2Game = $db->getAll("Select * from user2game where IDUSER='" . mysql_real_escape_string($_COOKIE["loggedInBG"]) . "' and IDGAME='" . mysql_real_escape_string($game["ID"]) . "'");
    if (isset($user2Game[0])) {
        if ($_GET["status"] == "delete") {
            $db->execute("Delete from user2game where id='" . mysql_real_escape_string($user2Game[0]["ID"]) . "'");
        }
        else {
            $db->execute("Update user2game set STATUS='" . mysql_real_escape_string($_GET["status"]) . "' where id='" . mysql_real_escape_string($user2Game[0]["ID"]) . "'");
            if ($game["ERWEITERUNG"]) {
                $message = "Die Erweiterung \"" . $game["NAME"] . "\" von " . $loggedInUser[0]["NAME"] . " " . $aBestelltArray[$_GET["status"]];
                $helper->sendMail2People($db,$loggedInUser[0]["ID"],$message,"Erweiterung ". $aBestelltArray[$_GET["status"]]);
                $db->execute("Update news set ACTIVE=0 where GAMEID='".$game["ID"]."' and USERID='".$loggedInUser[0]["ID"]."'");
                $newsSQL = "insert into news (GAMEID,MESSAGE,USERID) value('" . mysql_real_escape_string($game["ID"]) . "','" . mysql_real_escape_string($message) . "','" . mysql_real_escape_string($loggedInUser[0]["ID"]) . "')";
                $db->execute($newsSQL);
            }
            else {
                $message = "Das Spiel \"" . $game["NAME"] . "\" von " . $loggedInUser[0]["NAME"] . " " . $aBestelltArray[$_GET["status"]];
                $helper->sendMail2People($db,$loggedInUser[0]["ID"],$message,"Spiel ". $aBestelltArray[$_GET["status"]]);
                $db->execute("Update news set ACTIVE=0 where GAMEID='".$game["ID"]."' and USERID='".$loggedInUser[0]["ID"]."'");
                $newsSQL = "insert into news (GAMEID,MESSAGE,USERID) value('" . mysql_real_escape_string($game["ID"]) . "','" . mysql_real_escape_string($message) . "','" . mysql_real_escape_string($loggedInUser[0]["ID"]) . "')";
                $db->execute($newsSQL);
            }
        }
    }
    else {
        $db->execute("Insert into user2game (IDGAME,IDUSER,STATUS) value ('" . mysql_real_escape_string($game["ID"]) . "','" . mysql_real_escape_string($_COOKIE["loggedInBG"]) . "','" . mysql_real_escape_string($_GET["status"]) . "')");
        if ($game["ERWEITERUNG"]) {
            $message = "Die Erweiterung \"" . $game["NAME"] . "\" von " . $loggedInUser[0]["NAME"] . " " . $aBestelltArray[$_GET["status"]];
            $helper->sendMail2People($db,$loggedInUser[0]["ID"],$message,"Erweiterung ". $aBestelltArray[$_GET["status"]]);
            $db->execute("Update news set ACTIVE=0 where GAMEID='".$game["ID"]."' and USERID='".$loggedInUser[0]["ID"]."'");
            $newsSQL = "insert into news (GAMEID,MESSAGE,USERID) value('" . mysql_real_escape_string($game["ID"]) . "','" . mysql_real_escape_string($message) . "','" . mysql_real_escape_string($loggedInUser[0]["ID"]) . "')";
            $db->execute($newsSQL);
        }
        else {
            $message = "Das Spiel \"" . $game["NAME"] . "\" von " . $loggedInUser[0]["NAME"] . " " . $aBestelltArray[$_GET["status"]];
            $helper->sendMail2People($db,$loggedInUser[0]["ID"],$message,"Spiel ". $aBestelltArray[$_GET["status"]]);
            $db->execute("Update news set ACTIVE=0 where GAMEID='".$game["ID"]."' and USERID='".$loggedInUser[0]["ID"]."'");
            $newsSQL = "insert into news (GAMEID,MESSAGE,USERID) value('" . mysql_real_escape_string($game["ID"]) . "','" . mysql_real_escape_string($message) . "','" . mysql_real_escape_string($loggedInUser[0]["ID"]) . "')";
            $db->execute($newsSQL);
        }
    }
}
if ($game["ERBT"]) {
    $gotExt = "(" . str_replace("||", ",", $game["ERBT"]) . "," . $id . ")";
    $getExtensions = "select * from brettspiele where ERWEITERUNG in " . $gotExt;
}
else {
    $getExtensions = "select * from brettspiele where ERWEITERUNG=" . $id;
}
$extensions = $db->getAll($getExtensions);
if ($game["ERWEITERUNG"]) {
    $ext = true;
    $baseGame = $db->getAll("select * from brettspiele where ID=" . mysql_real_escape_string($game["ERWEITERUNG"]))[0];
    $extendsBaseGame = $db->getAll("select * from brettspiele where ERBT=" . mysql_real_escape_string($baseGame["ID"]));
}
echo "<div class='BackBtn leftBtn' onclick='goBack();'>Zurück</div>";
echo "<a href='index.php'><div class='BackBtn rightBtn'>Startseite</div></a>";
echo "<div class='clear'></div>";
echo "
<div class='gameName'>" . $game["NAME"];
if ($ext) {
    echo " (Erweiterung)";
}

if (isset($_COOKIE["selectedGroup"])) {
    $aBesitzer = $helper->getUser4Game($db, $game["ID"], $_COOKIE["selectedGroup"], "");
}
elseif (isset($_COOKIE["loggedInBG"])) {
    $aBesitzer = $helper->getUser4Game($db, $game["ID"], "", $_COOKIE["loggedInBG"][0]);
}
else {
    $aBesitzer = array();
}
$banner = "";
if(isset($aGameTags[$game["ID"]])) {
    $tags = implode("<br>", $aGameTags[$game["ID"]]);
}else{
    $tags="";
}
foreach ($aBesitzer as $ubannerName) {
    $banner .= "<div class='banner' style='background:#" . $ubannerName["FLAGCOLOR"] . ";' title='" . $ubannerName["NAME"] . " - ".$aFlagDesc[$ubannerName["STATUS"]]."'><div class='shortName'>" . substr($ubannerName["NAME"], 0, 1) . "</div><img  src='./src/img/".$aFlags[$ubannerName["STATUS"]]."'></div>";
}
if(!file_exists("./uploads/".$game["ID"]."/thumb/thumb.jpg")){
    $mainIMG =$helper->grab_image($game["BILD"],"./uploads/".$game["ID"]."/thumb");
}else{
    $mainIMG= "./uploads/".$game["ID"]."/thumb/thumb.jpg";
}

echo "</div>
<div class='gameinfo'>
<div class='packed'>
	<div class='Banner_div'>" . $banner . "</div>
		<div class='picture'><img src='" . $mainIMG . "'></div>
</div>
<div class='data'>
	Daten
	<div class='dataContainer'>
    <div class='spieler bBot'><img class='icon' src='./src/img/player.jpg'></br>" . $game["MIN_P"] . " - " . $game["MAX_P"] . "</div>
    <div class='zeit bBot'><img class='icon' src='./src/img/clock.jpg'></br>" . $game["MIN_T"] . " - " . $game["MAX_T"] . " min.</div>
    <div class='genre bBot'><img class='icon' src='./src/img/genre.png'></br>" . $tags . "</div>
    <div class='link noBot'><img class='icon' src='./src/img/link.png'></br>
    <ul>
    <li><a href='" . $game["URL"] . "' target='_blank'>BoardgameGeek-Link</a></li>";
if ($game["YOUTUBE"]) {
    echo "<li><a href='" . $game["YOUTUBE"] . "' target='_blank'>YOUTUBE-Link</a></li>";
}
echo "</ul></div>
    </div>";

if (isset($_COOKIE["loggedInBG"])) {
    $admin = $db->getOne("Select ADMIN from users where ID='" . $_COOKIE["loggedInBG"] . "'");
    if (($game["CREATEDBY"] == $_COOKIE["loggedInBG"]) || $admin == 1) {
        echo "<a href='addeditGame.php?GameID=" . $game["ID"] . "'><button>Bearbeiten</button></a>";
    }
    echo "<a href='fileupload.php?ID=" . $game["ID"] . "'><button><span class='add'>+</span>Datei</button></a>";
}
if (!$ext) {
    if (isset($_COOKIE["loggedInBG"])) {
        echo "<a href='addeditGame.php?GameID=" . $game["ID"] . "&extension=true'><button><span class='add'>+</span>Erweiterung</button></a>";
    }
}
echo "</div><div class='descriptionbox'>Beschreibung<div class='gamedescription'>" . str_replace(["\r"], "</br>", $game["DESCRIPTION"]) . "</div></div></div>";
if ($_COOKIE["loggedInBG"]) {
    $user2Game = $db->getAll("Select * from user2game where IDUSER='" . $_COOKIE["loggedInBG"] . "' and IDGAME='" . $game["ID"] . "'");
    echo "<div class='gameButtons'>";
    if (isset($user2Game[0])) {
        if ($user2Game[0]["STATUS"] == "1") {
            echo "<div class='deactiveBtn'>bestellt</div>";
        }
        else {
            echo "<a href='singlegame.php?id=" . $game["ID"] . "&status=1'><div class='activeBtn'>bestellt</div></a>";
        }

        if ($user2Game[0]["STATUS"] == "0") {
            echo "<div class='deactiveBtn'>verfügbar</div>";
        }
        else {
            echo "<a href='singlegame.php?id=" . $game["ID"] . "&status=0'><div class='activeBtn'>verfügbar</div></a>";
        }
        if ($user2Game[0]["STATUS"] == "0" || $user2Game[0]["STATUS"] == "1" || $user2Game[0]["STATUS"] == "2") {
            echo "<a href='singlegame.php?id=" . $game["ID"] . "&status=delete'><div class='activeBtn'>entfernen</div></a>";
        }
    }
    else {
        echo "<a href='singlegame.php?id=" . $game["ID"] . "&status=1'><div class='activeBtn'>bestellt</div></a><a href='singlegame.php?id=" . $game["ID"] . "&status=0'><div class='activeBtn'>verfügbar</div></a><a href='singlegame.php?id=" . $game["ID"] . "&status=2'><div class='activeBtn'>Want</div></a>";
    }
    echo "</div>";
}


echo "<div class='aditionalData'>";
$fileDirPath = "./uploads/" . $game["ID"] . "/";
$imgs = array();
$files = array();
if (file_exists($fileDirPath)) {
    if ($dh = opendir($fileDirPath)) {
        $picCount = 0;
        $fileCount = 0;
        while (($file = readdir($dh)) !== false) {
            $fileInfo = pathinfo($fileDirPath . $file);
            if (strtolower($fileInfo['extension']) == "jpg" || strtolower($fileInfo['extension']) == "png") {
                $imgs[$picCount]["path"] = $fileDirPath . $fileInfo['basename'];
                $imgs[$picCount]["thumb"] = $helper->thumbnail($fileDirPath . $fileInfo['basename'], "./uploads/thumbnail/" . $game["ID"] . "/");
                $imgs[$picCount]["name"] = $fileInfo['basename'];
                $picCount++;
            }
            elseif ($fileInfo['extension'] != "") {
                $files[$fileCount]["path"] = $fileDirPath . $fileInfo['basename'];
                $files[$fileCount]["name"] = $fileInfo['basename'];
                $fileCount++;
            }
        }
        closedir($dh);
    }
}
if (!$ext) {
    if (count($extensions) >= 1) {

        echo "<h2 class='accord'>Erweiterungen</h2><div class='extensions accElement'>";
        echo "<div class='singleTable'><table><tr id='head'><td>Bild</td><td>Name</td><td>Spieleranzahl</td><td>Spielzeit</td><td>Koop?</td><td>Genre</td></tr>";
        $rowEvenOdd = "odd";
        foreach ($extensions as $extension) {
            if(!file_exists("./uploads/".$extension["ID"]."/thumb/thumb.jpg")){
                $mainIMG =$helper->grab_image($extension["BILD"],"./uploads/".$extension["ID"]."/thumb");
            }else{
                $mainIMG= "./uploads/".$extension["ID"]."/thumb/thumb.jpg";
            }

            //Banner
            if (isset($_COOKIE["selectedGroup"])) {
                $aBesitzer = $helper->getUser4Game($db, $extension["ID"], $_COOKIE["selectedGroup"], "");
            }
            elseif (isset($_COOKIE["loggedInBG"])) {
                $aBesitzer = $helper->getUser4Game($db, $extension["ID"], "", $_COOKIE["loggedInBG"][0]);
            }
            else {
                $aBesitzer = array();
            }
            $banner = "";
            if(isset($aGameTags[$extension["ID"]])) {
                $tags = implode("<br>", $aGameTags[$extension["ID"]]);
            }else{
                $tags="";
            }
            foreach ($aBesitzer as $ubannerName) {
                $banner .= "<div class='banner' style='background:#" . $ubannerName["FLAGCOLOR"] . ";' title='" . $ubannerName["NAME"] . " - ".$aFlagDesc[$ubannerName["STATUS"]]."'><div class='shortName'>" . substr($ubannerName["NAME"], 0, 1) . "</div><img  src='./src/img/".$aFlags[$ubannerName["STATUS"]]."'></div>";

            }
            echo "<tr class='" . $rowEvenOdd . "'><td><a href=singlegame.php?id=" . $extension["ID"] . "><div class='packed'><div class='Banner_div'>" . $banner . "</div><div class='mainImg'><img src='" . $mainIMG . "'></div></div></a></td><td>" . $extension["NAME"] . "</td><td>" . $extension["MIN_P"] . " - " . $extension["MAX_P"] . "</td><td>" . $extension["MIN_T"] . " - " . $extension["MAX_T"] . " min.</td><td>" . $aKoop[$extension["KOOP"]] . "</td><td>" . $tags . "</td></tr>";
            if ($rowEvenOdd == "odd") {
                $rowEvenOdd = "even";
            }
            else {
                $rowEvenOdd = "odd";
            }
        }
        echo "</table></div></div>";
    }
    if (count($imgs) >= 1) {
        echo "<h2 class='accord'>Bilder</h2><div class='images accElement'><div id='uimgs'>";

        foreach ($imgs as $img) {
            echo "<a href='http://" . $_SERVER["HTTP_HOST"] . "/" . $inDIR . $img["path"] . "' data-lightbox='gameImages'><img src='" . $img["thumb"] . "'></a>";
        }
        echo "</div></div>";
    }

    if (count($files) >= 1) {
        echo "<h2 class='accord'>Dateien</h2><div class='files accElement'><div id='ufiles'>";
        foreach ($files as $file) {
            echo "<a href='http://" . $_SERVER["HTTP_HOST"] . "/" . $inDIR . $file["path"] . "' download>" . $file["name"] . "</a></br>";
        }
        echo "</div></div>";
    }

    $fileDirPath = "./uploads/plugins/" . $game["ID"] . "/";
    if (file_exists($fileDirPath)) {
        if ($dh = opendir($fileDirPath)) {
            while (($file = readdir($dh)) !== false) {
                if (is_dir($fileDirPath . $file) && $file != "." && $file != "..") {
                    if (file_exists($fileDirPath . $file . "/index.php")) {
                        echo "<h2 class='accord'>" . $file . " (Plugin)</h2><div class='files accElement'><div id='uplugins'>";
                        echo "<iframe src='" . $fileDirPath . $file . "/index.php'></iframe>";
                        echo "</div></div>";
                    }
                }
            }
        }
    }
    if ($game["YOUTUBE"]) {
        preg_match("/(.*\/watch\?v=)(.*)/", $game["YOUTUBE"], $output_array);
        if ($output_array[2]) {
            echo "<h2 class='accord'>Video</h2><div class='youtube accElement'><div id='youtube'>";
            echo '<iframe id="ytplayer" type="text/html" width="640" height="360" src="http://www.youtube.com/embed/' . $output_array[2] . '" frameborder="0"></iframe>';
            echo "</div></div>";
        }
    }


    if($idTaggedGames != "") {
        $sqlNearGames = "Select * from brettspiele where ERWEITERUNG is null and ID in (" . $idTaggedGames . ")";
        $sqlNearGames .= " order by MIN_P ,MAX_P, NAME";
        $genreSpecificGames = $db->getAll($sqlNearGames);
        if (count($genreSpecificGames) >= 1) {
            echo "<h2 class='accord'>Spiele mit gleichem Genre</h2><div class='genreGames accElement'>";
            echo "<div class='singleTable'><table><tr id='head'><td>Bild</td><td>Name</td><td>Spieleranzahl</td><td>Spielzeit</td><td>Koop?</td><td>Genre</td></tr>";
            $rowEvenOdd = "odd";
            foreach ($genreSpecificGames as $specGame) {
                if(!file_exists("./uploads/".$specGame["ID"]."/thumb/thumb.jpg")){
                    $mainIMG =$helper->grab_image($specGame["BILD"],"./uploads/".$specGame["ID"]."/thumb");
                }else{
                    $mainIMG= "./uploads/".$specGame["ID"]."/thumb/thumb.jpg";
                }

                //Banner
                if (isset($_COOKIE["selectedGroup"])) {
                    $aBesitzer = $helper->getUser4Game($db, $specGame["ID"], $_COOKIE["selectedGroup"], "");
                }
                elseif (isset($_COOKIE["loggedInBG"])) {
                    $aBesitzer = $helper->getUser4Game($db, $specGame["ID"], "", $_COOKIE["loggedInBG"][0]);
                }
                else {
                    $aBesitzer = array();
                }
                $banner = "";
                if (isset($aGameTags[$specGame["ID"]])) {
                    $tags = implode("<br>", $aGameTags[$specGame["ID"]]);
                }
                else {
                    $tags = "";
                }
                foreach ($aBesitzer as $ubannerName) {
                    $banner .= "<div class='banner' style='background:#" . $ubannerName["FLAGCOLOR"] . ";' title='" . $ubannerName["NAME"] . " - " . $aFlagDesc[$ubannerName["STATUS"]] . "'><div class='shortName'>" . substr($ubannerName["NAME"], 0, 1) . "</div><img  src='./src/img/" . $aFlags[$ubannerName["STATUS"]] . "'></div>";
                }
                echo "<tr class='" . $rowEvenOdd . "'><td><a href=singlegame.php?id=" . $specGame["ID"] . "><div class='packed'><div class='Banner_div'>" . $banner . "</div><div class='mainImg'><img src='" . $mainIMG . "'></div></div></a></td><td>" . $specGame["NAME"] . "</td><td>" . $specGame["MIN_P"] . " - " . $specGame["MAX_P"] . "</td><td>" . $specGame["MIN_T"] . " - " . $specGame["MAX_T"] . " min.</td><td>" . $aKoop[$specGame["KOOP"]] . "</td><td>" . $tags . "</td></tr>";
                if ($rowEvenOdd == "odd") {
                    $rowEvenOdd = "even";
                }
                else {
                    $rowEvenOdd = "odd";
                }
            }
            echo "</table></div></div>";
        }
    }
}
else {
    //Banner
    if (isset($_COOKIE["selectedGroup"])) {
        $aBesitzer = $helper->getUser4Game($db, $baseGame["ID"], $_COOKIE["selectedGroup"], "");
    }
    elseif (isset($_COOKIE["loggedInBG"])) {
        $aBesitzer = $helper->getUser4Game($db, $baseGame["ID"], "", $_COOKIE["loggedInBG"][0]);
    }
    else {
        $aBesitzer = array();
    }
    $banner = "";
    if(isset($aGameTags[$baseGame["ID"]])) {
        $tags = implode("<br>", $aGameTags[$baseGame["ID"]]);
    }else{
        $tags="";
    }
    foreach ($aBesitzer as $ubannerName) {
        $banner .= "<div class='banner' style='background:#" . $ubannerName["FLAGCOLOR"] . ";' title='" . $ubannerName["NAME"] . " - ".$aFlagDesc[$ubannerName["STATUS"]]."'><div class='shortName'>" . substr($ubannerName["NAME"], 0, 1) . "</div><img  src='./src/img/".$aFlags[$ubannerName["STATUS"]]."'></div>";
    }
    if(!file_exists("./uploads/".$baseGame["ID"]."/thumb/thumb.jpg")){
        $mainIMG =$helper->grab_image($baseGame["BILD"],"./uploads/".$baseGame["ID"]."/thumb");
    }else{
        $mainIMG= "./uploads/".$baseGame["ID"]."/thumb/thumb.jpg";
    }

    echo "<h2 class='accord'>Erweiterung von:</h2><div class='basegame accElement'>";
    echo "<div class='singleTable'><table><tr id='head'><td>Bild:</td><td>Name:</td><td>Spieleranzahl:</td><td>Spielzeit:</td><td>Koop?:</td><td>Genre:</td></tr>";

    echo "<tr class='odd'><td><a href=singlegame.php?id=" . $baseGame ["ID"] . "><div class='packed'><div class='Banner_div'>" . $banner . "</div><div class='mainImg'><img src='" . $mainIMG . "'></div></div></a></td><td>" . $baseGame ["NAME"] . "</td><td>" . $baseGame ["MIN_P"] . " - " . $baseGame ["MAX_P"] . "</td><td>" . $baseGame ["MIN_T"] . " - " . $baseGame ["MAX_T"] . " min.</td><td>" . $aKoop[$baseGame ["KOOP"]] . "</td><td>" . $tags . "</td></tr>";
    if (count($extendsBaseGame) >= 1) {
        $rowEvenOdd = "even";
        foreach ($extendsBaseGame as $extendedGame) {
            if (isset($_COOKIE["selectedGroup"])) {
                $aBesitzer = $helper->getUser4Game($db, $extendedGame["ID"], $_COOKIE["selectedGroup"], "");
            }
            elseif (isset($_COOKIE["loggedInBG"])) {
                $aBesitzer = $helper->getUser4Game($db, $extendedGame["ID"], "", $_COOKIE["loggedInBG"][0]);
            }
            else {
                $aBesitzer = array();
            }
            $banner = "";
            if(isset($aGameTags[$extendedGame["ID"]])) {
                $tags = implode("<br>", $aGameTags[$extendedGame["ID"]]);
            }else{
                $tags="";
            }
            foreach ($aBesitzer as $ubannerName) {
                $banner .= "<div class='banner' style='background:#" . $ubannerName["FLAGCOLOR"] . ";' title='" . $ubannerName["NAME"] . " - ".$aFlagDesc[$ubannerName["STATUS"]]."'><div class='shortName'>" . substr($ubannerName["NAME"], 0, 1) . "</div><img  src='./src/img/".$aFlags[$ubannerName["STATUS"]]."'></div>";
            }
            if(!file_exists("./uploads/".$extendedGame["ID"]."/thumb/thumb.jpg")){
                $mainIMG =$helper->grab_image($extendedGame["BILD"],"./uploads/".$extendedGame["ID"]."/thumb");
            }else{
                $mainIMG= "./uploads/".$extendedGame["ID"]."/thumb/thumb.jpg";
            }
            echo "<tr class='" . $rowEvenOdd . "'><td><a href=singlegame.php?id=" . $extendedGame ["ID"] . "><div class='packed'><div class='Banner_div'>" . $banner . "</div><div class='mainImg'><img src='" . $mainIMG . "'></div></div></a></td><td>" . $extendedGame ["NAME"] . "</td><td>" . $extendedGame ["MIN_P"] . " - " . $extendedGame ["MAX_P"] . "</td><td>" . $extendedGame ["MIN_T"] . " - " . $extendedGame ["MAX_T"] . " min.</td><td>" . $aKoop[$extendedGame ["KOOP"]] . "</td><td>" . $tags . "</td></tr>";
            if ($rowEvenOdd == "odd") {
                $rowEvenOdd = "even";
            }
            else {
                $rowEvenOdd = "odd";
            }
        }
    }
    echo "</table></div></div>";

    if (count($imgs) >= 1) {
        echo "<h2 class='accord'>Bilder:</h2><div id='uimgs' class='accElement'>";

        foreach ($imgs as $img) {
            echo "<a href='http://" . $_SERVER["HTTP_HOST"] . "/" . $img["path"] . "' data-lightbox='gameImages'><img src='" . $img["thumb"] . "'></a>";
        }
        echo "</div>";
    }

    if (count($files) >= 1) {
        echo "<h2 class='accord'>Dateien:</h2><div id='ufiles' class='accElement'>";
        foreach ($files as $file) {
            echo "<a href='http://" . $_SERVER["HTTP_HOST"] . "/" . $inDIR . $file["path"] . "' download>" . $file["name"] . "</a></br>";
        }
        echo "</div>";
    }
}



echo "</div></body></html>";