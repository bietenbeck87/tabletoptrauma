<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>TABLETOP TRAUMA</title>
    <link rel="stylesheet" type="text/css" href="./src/css/style.css">
    <link rel="stylesheet" href="./src/css/lightbox.min.css">
    <script src="./src/js/lightbox-plus-jquery.min.js"></script>
    <script src="./src/js/accordion.js"></script>
</head>
<body>
<?php
$id = $_GET["id"];
if ($_SERVER["HTTP_HOST"] == "bg.as-cf.de") {
    $inDIR = "";
}
else {
    $inDIR = "brettspiele/";
}
$aBestelltArray = array(0 => "ist angekommen", 1 => "wurde bestellt", 2 => "wurde zur Wantsliste hinzugefügt");

include_once("./core/dB.php");
include_once("./core/helper.php");

$aKoop = array(0 => "Nein",
    1 => "Koop",
    2 => "Koop + DM",
    3 => "Koop + Verräter",
    4 => "Teams");
$db = new dB();
$helper = new helper();
$getGame = "select * from brettspiele where ID=" . $id;
$game = $db->getAll($getGame);
$game = $game[0];
if (isset($_GET["status"]) && $_COOKIE["loggedInBG"]) {
    $loggedInUser = $db->getAll("Select * from users where ID='" . $_COOKIE["loggedInBG"] . "'");
    $user2Game = $db->getAll("Select * from user2game where IDUSER='" . $_COOKIE["loggedInBG"] . "' and IDGAME='" . $game["ID"] . "'");
    if (isset($user2Game[0])) {
        if ($_GET["status"] == "delete") {
            $db->execute("Delete from user2game where id='" . $user2Game[0]["ID"] . "'");
        }
        else {
            $db->execute("Update user2game set STATUS='" . $_GET["status"] . "' where id='" . $user2Game[0]["ID"] . "'");
            if ($game["ERWEITERUNG"]) {
                $message = "Die Erweiterung \"" . $game["NAME"] . "\" von " . $loggedInUser[0]["NAME"] . " " . $aBestelltArray[$_GET["status"]];
                $newsSQL = "insert into news (GAMEID,MESSAGE,USERID) value('" . $game["ID"] . "','" . $message . "','" . $loggedInUser[0]["ID"] . "')";
                $db->execute($newsSQL);
            }
            else {
                $message = "Das Spiel \"" . $game["NAME"] . "\" von " . $loggedInUser[0]["NAME"] . " " . $aBestelltArray[$_GET["status"]];
                $newsSQL = "insert into news (GAMEID,MESSAGE,USERID) value('" . $game["ID"] . "','" . $message . "','" . $loggedInUser[0]["ID"] . "')";
                $db->execute($newsSQL);
            }
        }
    }
    else {
        $test = "Insert into user2game (IDGAME,IDUSER,STATUS) value ('" . $game["ID"] . "','" . $_COOKIE["loggedInBG"] . "','" . $_GET["status"] . "'";
        $db->execute("Insert into user2game (IDGAME,IDUSER,STATUS) value ('" . $game["ID"] . "','" . $_COOKIE["loggedInBG"] . "','" . $_GET["status"] . "')");
        if ($game["ERWEITERUNG"]) {
            $message = "Die Erweiterung \"" . $game["NAME"] . "\" von " . $loggedInUser[0]["NAME"] . " " . $aBestelltArray[$_GET["status"]];
            $newsSQL = "insert into news (GAMEID,MESSAGE,USERID) value('" . $game["ID"] . "','" . $message . "','" . $loggedInUser[0]["ID"] . "')";
            $db->execute($newsSQL);
        }
        else {
            $message = "Das Spiel \"" . $game["NAME"] . "\" von " . $loggedInUser[0]["NAME"] . " " . $aBestelltArray[$_GET["status"]];
            $newsSQL = "insert into news (GAMEID,MESSAGE,USERID) value('" . $game["ID"] . "','" . $message . "','" . $loggedInUser[0]["ID"] . "')";
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
    $baseGame = $db->getAll("select * from brettspiele where ID=" . $game["ERWEITERUNG"])[0];
    $extendsBaseGame = $db->getAll("select * from brettspiele where ERBT=" . $baseGame["ID"]);
}
$genre = str_replace("||", "<br>", $game["GENRE"]);
echo "<a href='index.php'><div id='BackBtn'>Zurück</div></a>";
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
foreach ($aBesitzer as $ubannerName) {
    $banner .= "<div class='banner' style='background:#" . $ubannerName["FLAGCOLOR"] . ";' title='" . $ubannerName["NAME"] . "'><div id='shortName'>" . substr($ubannerName["NAME"], 0, 1) . "</div><img  src='./src/img/owner_banner.png'></div>";
}
echo "</div>
<div class='gameinfo'>
<div class='packed'>
	<div class='Banner_div'>" . $banner . "</div>
		<div class='picture'><img src='" . $game["BILD"] . "'></div>
</div>
<div class='data'>
	Daten
	<div class='dataContainer'>
    <div class='spieler bBot'><img class='icon' src='./src/img/player.jpg'></br>" . $game["MIN_P"] . " - " . $game["MAX_P"] . "</div>
    <div class='zeit bBot'><img class='icon' src='./src/img/clock.jpg'></br>" . $game["MIN_T"] . " - " . $game["MAX_T"] . " min.</div>
    <div class='genre bBot'><img class='icon' src='./src/img/genre.png'></br>" . $genre . "</div>
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
        echo "<a href='addeditGame.php?GameID=" . $game["ID"] . "'><button>Edit</button></a>";
    }
    echo "<a href='fileupload.php?ID=" . $game["ID"] . "'><button>Add File</button></a>";
}
if (!$ext) {
    if (isset($_COOKIE["loggedInBG"])) {
        echo "<a href='addeditGame.php?GameID=" . $game["ID"] . "&extension=true'><button>Add Extension</button></a>";
    }
}
echo "</div><div class='descriptionbox'>Beschreibung<div class='gamedescription'>" . str_replace(["\r"], "</br>", $game["DESCRIPTION"]) . "</div></div></div>";
if ($_COOKIE["loggedInBG"]) {
    $user2Game = $db->getAll("Select * from user2game where IDUSER='" . $_COOKIE["loggedInBG"] . "' and IDGAME='" . $game["ID"] . "'");
    echo "<div class='gameButtons'>";
    if (isset($user2Game[0])) {
        if ($user2Game[0]["STATUS"] == "1") {
            echo "<div class='deactiveBtn'>ordered</div>";
        }
        else {
            echo "<a href='singlegame.php?id=" . $game["ID"] . "&status=1'><div class='activeBtn'>ordered</div></a>";
        }
        if ($user2Game[0]["STATUS"] == "0") {
            echo "<div class='deactiveBtn'>arrived</div>";
        }
        else {
            echo "<a href='singlegame.php?id=" . $game["ID"] . "&status=0'><div class='activeBtn'>arrived</div></a>";
        }
        if ($user2Game[0]["STATUS"] == "0" || $user2Game[0]["STATUS"] == "1") {
            echo "<a href='singlegame.php?id=" . $game["ID"] . "&status=delete'><div class='activeBtn'>lost</div></a>";
        }
    }
    else {
        echo "<a href='singlegame.php?id=" . $game["ID"] . "&status=1'><div class='activeBtn'>ordered</div></a><a href='singlegame.php?id=" . $game["ID"] . "&status=0'><div class='activeBtn'>arrived</div></a>";
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
            foreach ($aBesitzer as $ubannerName) {
                $banner .= "<div class='banner' style='background:#" . $ubannerName["FLAGCOLOR"] . ";' title='" . $ubannerName["NAME"] . "'><div id='shortName'>" . substr($ubannerName["NAME"], 0, 1) . "</div><img  src='./src/img/owner_banner.png'></div>";

            }
            $genre = str_replace("||", "<br>", $extension["GENRE"]);
            echo "<tr class='" . $rowEvenOdd . "'><td><a href=singlegame.php?id=" . $extension["ID"] . "><div class='packed'><div class='Banner_div'>" . $banner . "</div><div class='mainImg'><img src='" . $extension["BILD"] . "'></div></div></a></td><td>" . $extension["NAME"] . "</td><td>" . $extension["MIN_P"] . " - " . $extension["MAX_P"] . "</td><td>" . $extension["MIN_T"] . " - " . $extension["MAX_T"] . " min.</td><td>" . $aKoop[$extension["KOOP"]] . "</td><td>" . $genre . "</td></tr>";
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
            echo '<iframe id="ytplayer" type="text/html" width="640" height="360" src="http://www.youtube.com/embed/' . $output_array[2] . '" frameborder="0"/>';
            echo "</div></div>";
        }
    }


    $sqlNearGames = "Select * from brettspiele where ERWEITERUNG is null and ID !='" . $game["ID"] . "'";
    $aGenre = explode("||", $game["GENRE"]);
    foreach ($aGenre as $sGenre) {
        $sqlNearGames .= " and GENRE like '%" . $sGenre . "%'";
    }
    $sqlNearGames .= " order by MIN_P ,MAX_P, NAME";
    $genreSpecificGames = $db->getAll($sqlNearGames);
    if (count($genreSpecificGames) >= 1) {
        echo "<h2 class='accord'>Spiele mit gleichem Genre</h2><div class='genreGames accElement'>";
        echo "<div class='singleTable'><table><tr id='head'><td>Bild</td><td>Name</td><td>Spieleranzahl</td><td>Spielzeit</td><td>Koop?</td><td>Genre</td></tr>";
        $rowEvenOdd = "odd";
        foreach ($genreSpecificGames as $specGame) {


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
            foreach ($aBesitzer as $ubannerName) {
                $banner .= "<div class='banner' style='background:#" . $ubannerName["FLAGCOLOR"] . ";' title='" . $ubannerName["NAME"] . "'><div id='shortName'>" . substr($ubannerName["NAME"], 0, 1) . "</div><img  src='./src/img/owner_banner.png'></div>";
            }
            $genre = str_replace("||", "<br>", $specGame["GENRE"]);
            echo "<tr class='" . $rowEvenOdd . "'><td><a href=singlegame.php?id=" . $specGame["ID"] . "><div class='packed'><div class='Banner_div'>" . $banner . "</div><div class='mainImg'><img src='" . $specGame["BILD"] . "'></div></div></a></td><td>" . $specGame["NAME"] . "</td><td>" . $specGame["MIN_P"] . " - " . $specGame["MAX_P"] . "</td><td>" . $specGame["MIN_T"] . " - " . $specGame["MAX_T"] . " min.</td><td>" . $aKoop[$specGame["KOOP"]] . "</td><td>" . $genre . "</td></tr>";
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
else {
    $genre = str_replace("||", "<br>", $baseGame ["GENRE"]);

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
    foreach ($aBesitzer as $ubannerName) {
        $banner .= "<div class='banner' style='background:#" . $ubannerName["FLAGCOLOR"] . ";' title='" . $ubannerName["NAME"] . "'><div id='shortName'>" . substr($ubannerName["NAME"], 0, 1) . "</div><img  src='./src/img/owner_banner.png'></div>";
    }

    echo "<h2 class='accord'>Erweiterung von:</h2><div class='basegame accElement'>";
    echo "<div class='singleTable'><table><tr id='head'><td>Bild:</td><td>Name:</td><td>Spieleranzahl:</td><td>Spielzeit:</td><td>Koop?:</td><td>Genre:</td></tr>";

    echo "<tr class='odd'><td><a href=singlegame.php?id=" . $baseGame ["ID"] . "><div class='packed'><div class='Banner_div'>" . $banner . "</div><div class='mainImg'><img src='" . $baseGame ["BILD"] . "'></div></div></a></td><td>" . $baseGame ["NAME"] . "</td><td>" . $baseGame ["MIN_P"] . " - " . $baseGame ["MAX_P"] . "</td><td>" . $baseGame ["MIN_T"] . " - " . $baseGame ["MAX_T"] . " min.</td><td>" . $aKoop[$baseGame ["KOOP"]] . "</td><td>" . $genre . "</td></tr>";
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
            foreach ($aBesitzer as $ubannerName) {
                $banner .= "<div class='banner' style='background:#" . $ubannerName["FLAGCOLOR"] . ";' title='" . $ubannerName["NAME"] . "'><div id='shortName'>" . substr($ubannerName["NAME"], 0, 1) . "</div><img  src='./src/img/owner_banner.png'></div>";
            }
            echo "<tr class='" . $rowEvenOdd . "'><td><a href=singlegame.php?id=" . $extendedGame ["ID"] . "><div class='packed'><div class='Banner_div'>" . $banner . "</div><div class='mainImg'><img src='" . $extendedGame ["BILD"] . "'></div></div></a></td><td>" . $extendedGame ["NAME"] . "</td><td>" . $extendedGame ["MIN_P"] . " - " . $extendedGame ["MAX_P"] . "</td><td>" . $extendedGame ["MIN_T"] . " - " . $extendedGame ["MAX_T"] . " min.</td><td>" . $aKoop[$extendedGame ["KOOP"]] . "</td><td>" . $genre . "</td></tr>";
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
            echo "<a href='http://" . $_SERVER["HTTP_HOST"] . "/" . $inDIR . $img["path"] . "' data-lightbox='gameImages'><img src='" . $img["thumb"] . "'></a>";
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