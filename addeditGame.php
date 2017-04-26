<?php
include_once("./core/dB.php");
include_once("./core/helper.php");
$db = new dB();
$helper = new helper();

$aBestelltArray = array(0 => "ist angekommen", 1 => "wurde bestellt", 2 => "wurde zur Wantsliste hinzugefügt");

$getTags = "select * from tags";
$aTags = $db->getAll($getTags);

$getTags2Game="Select b.ID,t.TAG from brettspiele as b left join game2tag as g2g on b.ID=g2g.IDGAME join tags as t on g2g.IDTAG=t.ID";
$gameTags = $db->getAll($getTags2Game);
$aGameTags = array();
foreach($gameTags as $gameTag){
    $aGameTags[$gameTag["ID"]][] = $gameTag["TAG"];
}

$b = false;
$ext = false;
$extendsID = "";

if (isset($_GET["GameID"])) {
    $gameID = $_GET["GameID"];
    $extendsID = " and ID!=$gameID";
    $gameSQL = "select * from brettspiele where ID =" . $gameID;
    $game = $db->getAll($gameSQL)[0];
    $statusID = $game["BESTELLT"];
    if(isset($aGameTags[$game["ID"]])) {
        $genre = $aGameTags[$game["ID"]];
    }else {
        $genre = array();
    }
    $ExtList = explode("||", $game['ERBT']);
    if ($_GET["extension"] != true) {
        $b = true;
    }
    else {
        $ext = true;
    }
}
if (isset($_COOKIE["loggedInBG"])) {
    $LoggedInuser = $db->getAll("select * from users where ID=" . $_COOKIE["loggedInBG"])[0];
}


$extendsList = "Select * from brettspiele where ERWEITERUNG is Null" . $extendsID . " order by Name";
$extendsList = $db->getAll($extendsList);

if (isset($_POST["name"]) && $_POST["name"] != "" && isset($_POST["min_p"]) && $_POST["min_p"] != "" && isset($_POST["max_p"]) && $_POST["max_p"] != "" && isset($_POST["min_t"]) && $_POST["min_t"] != "" && isset($_POST["max_t"]) && $_POST["max_t"] != "" && isset($_POST["img"]) && $_POST["img"] != "" && isset($_POST["url"]) && $_POST["url"] != "") {

    if (isset($_POST['extends'])) {
        $extensionList = implode("||", $_POST['extends']);
    }
    else {
        $extensionList = "";
    }
    if (!isset($_POST["status"])) {
        $bestellt = 0;
    }
    else {
        $bestellt = $_POST["status"];
    }

    if (isset($_POST["GameID"])) {
        $IDGame = $_POST["GameID"];

        if (isset($_POST["deletes"])) {
            $fileDirPath = "./uploads/" . $IDGame . "/";
            $fileDirThumbPath = "./uploads/thumbnail/" . $IDGame . "/";

            foreach ($_POST["deletes"] as $file2Delete) {
                $filePath = $fileDirPath . $file2Delete;
                $thumbPath = $fileDirThumbPath . $file2Delete;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                if (file_exists($thumbPath)) {
                    unlink($thumbPath);
                }
            }
        }
        $sqlAddEdit = "Update brettspiele set NAME='" . mysql_real_escape_string($_POST["name"]) . "',DESCRIPTION='" . mysql_real_escape_string($_POST["description"]) . "', MIN_P='" . $_POST["min_p"] . "',MAX_P='" . $_POST["max_p"] . "',MIN_T='" . $_POST["min_t"] . "',MAX_T='" . $_POST["max_t"] . "',URL='" . $_POST["url"] . "',BILD='" . $_POST["img"] . "',YOUTUBE='" . $_POST["yt"] . "',KOOP='" . $_POST["koop"] . "',ERBT='" . $extensionList . "' where ID='" . $IDGame . "'";

        if (isset($_POST['genre'])) {
            $aTags = $_POST['genre'];
            $db->execute("delete from game2tag where IDGAME='".$IDGame."'");
            foreach ($aTags as $tag) {
              $insertTag = "Insert into game2tag(IDGAME,IDTAG) value ('".$IDGame."','".$tag."')";
                $db->execute($insertTag);
            }
        }
    }
    else {
        if (isset($_POST["GameIDExt"])) {

            $highestID = $db->getOne("select max(ID) from brettspiele where ERWEITERUNG='" . $_POST["GameIDExt"] . "'");
            if ($highestID) {
                $IDGame = $highestID + 1;
            }
            else {
                $IDGame = $_POST["GameIDExt"] + 1;
            }
            $sqlAddEdit = "insert into brettspiele (ID,NAME,DESCRIPTION,ERWEITERUNG,MIN_P,MAX_P,MIN_T,MAX_T,URL,BILD,YOUTUBE,KOOP,ERBT,CREATEDBY) values ('" . $IDGame . "','" . mysql_real_escape_string($_POST["name"]) . "','" . mysql_real_escape_string($_POST["description"]) . "','" . $_POST["GameIDExt"] . "','" . $_POST["min_p"] . "','" . $_POST["max_p"] . "','" . $_POST["min_t"] . "','" . $_POST["max_t"] . "','" . $_POST["url"] . "','" . $_POST["img"] . "','" . $_POST["yt"] . "','" . $_POST["koop"] . "','','".$LoggedInuser["ID"]."')";
            if (isset($_POST['genre'])) {
                $aTags = $_POST['genre'];
                foreach ($aTags as $tag) {
                  $insertTag = "Insert into game2tag (IDGAME,IDTAG) value ('".$IDGame."','".$tag."')";
                    $db->execute($insertTag);
                }
            }
            $sqlUser2Game = "insert into user2game (IDGAME,IDUSER,STATUS) value ('".$IDGame."','".$LoggedInuser["ID"]."','".$bestellt."')";
            $db->execute($sqlUser2Game);
            $message = "Die Erweiterung \"" . $_POST["name"] . "\" von " . $LoggedInuser["Name"] . " " . $aBestelltArray[$bestellt];
            $newsSQL = "insert into news (GAMEID,MESSAGE,USERID) value('" . $IDGame . "','" . $message . "','".$LoggedInuser["ID"]."')";
            $db->execute($newsSQL);
        }
        else {
            $highestID = $db->getOne("select max(ID) from brettspiele where ERWEITERUNG is NULL");
            $IDGame = $highestID + 100;
            $sqlAddEdit = "insert into brettspiele (ID,NAME,DESCRIPTION,MIN_P,MAX_P,MIN_T,MAX_T,URL,BILD,YOUTUBE,KOOP,ERBT,CREATEDBY) values ('" . $IDGame . "','" . mysql_real_escape_string($_POST["name"]) . "','" . mysql_real_escape_string($_POST["description"]) . "','" . $_POST["min_p"] . "','" . $_POST["max_p"] . "','" . $_POST["min_t"] . "','" . $_POST["max_t"] . "','" . $_POST["url"] . "','" . $_POST["img"] . "','" . $_POST["yt"] . "','" . $_POST["koop"] . "','" . $extensionList . "','".$LoggedInuser["ID"]."')";
            if (isset($_POST['genre'])) {
                $aTags = $_POST['genre'];
                foreach ($aTags as $tag) {
                  $insertTag = "Insert into game2tag (IDGAME,IDTAG) value ('".$IDGame."','".$tag."')";
                    $db->execute($insertTag);
                }
            }
            $sqlUser2Game = "insert into user2game (IDGAME,IDUSER,STATUS) value ('".$IDGame."','".$LoggedInuser["ID"]."','".$bestellt."')";
            $db->execute($sqlUser2Game);
            $message = "Das Spiel \"" . $_POST["name"] . "\" von " . $LoggedInuser["NAME"] . " " . $aBestelltArray[$bestellt];
            $newsSQL = "insert into news (GAMEID,MESSAGE,USERID) value('" . $IDGame . "','" . $message . "','".$LoggedInuser["ID"]."')";
            $db->execute($newsSQL);
        }
    }
    $db->execute($sqlAddEdit);
}
if ($IDGame) {
    header('Location: singlegame.php?id=' . $IDGame);
}
?>
<meta charset="utf-8"/>
<title>TABLETOP TRAUMA</title>
<script language="javascript" type="text/javascript" src="./src/js/validateeditgames.js"></script>
<link rel="stylesheet" type="text/css" href="./src/css/style.css">
<a href="http://www.boardgamegeek.com" target="_blank">
    <button>Open BoardGameGeek</button>
</a>

<div class="editForm">
    <form name="addeditform" action="addeditGame.php" method="post" onsubmit="return validateForm()">
        <fieldset>
            <?php if ($b) {
                echo "<input type='hidden' name='GameID' value='" . $gameID . "'>";
            }
            elseif ($ext) {
                echo "<input type='hidden' name='GameIDExt' value='" . $gameID . "'>";
            }
            echo "<input type='hidden' name='StatusID' value='" . $statusID . "'>";
            ?>
            <label>*Spiel-Name:</label><input type="text" name="name" <?php if ($b) {
                echo "value='" . $game['NAME'] . "'";
            } ?>>
            <label>*Min. Spielerzahl:</label><input type="text" name="min_p" <?php if ($b || $ext) {
                echo "value='" . $game['MIN_P'] . "'";
            } ?>>
            <label>*Max. Spielerzahl:</label><input type="text" name="max_p" <?php if ($b || $ext) {
                echo "value='" . $game['MAX_P'] . "'";
            } ?>>
            <label>*Min. Spielzeit:</label><input type="text" name="min_t" <?php if ($b || $ext) {
                echo "value='" . $game['MIN_T'] . "'";
            } ?>>
            <label>*Max. Spielzeit:</label><input type="text" name="max_t" <?php if ($b || $ext) {
                echo "value='" . $game['MAX_T'] . "'";
            } ?>>
            <label>Beschreibung:</label>
		<textarea name='description'><?php if ($b || $ext) {
                echo $game['DESCRIPTION'];
            } ?></textarea>
            <label>*URL:</label><input type="text" name="url" <?php if ($b) {
                echo "value='" . $game['URL'] . "'";
            } ?>>
            <label>*Bild-Link:</label><input type="text" name="img" <?php if ($b) {
                echo "value='" . $game['BILD'] . "'";
            } ?>>
            <label>YOUTUBE-URL:</label><input type="text" name="yt" <?php if ($b) {
                echo "value='" . $game['YOUTUBE'] . "'";
            } ?>>
            <label>Koop:</label>
            <Select name="koop">
                <option value="0" <?php if ($b && $game['KOOP'] == "0") {
                    echo "selected='selected'";
                } ?>>Nein
                </option>
                <option value="1" <?php if ($b && $game['KOOP'] == "1") {
                    echo "selected='selected'";
                } ?>>Koop
                </option>
                <option value="2" <?php if ($b && $game['KOOP'] == "2") {
                    echo "selected='selected'";
                } ?>>Koop + DM
                </option>
                <option value="3" <?php if ($b && $game['KOOP'] == "3") {
                    echo "selected='selected'";
                } ?>>Koop + Verräter
                </option>
                <option value="4" <?php if ($b && $game['KOOP'] == "4") {
                    echo "selected='selected'";
                } ?>>Teams
                </option>
            </Select>
            <label>Genre:</label>
            <select multiple="multiple" name="genre[]">
                <?php
                foreach ($aTags as $tag) {
                    if ($b && in_array($tag["TAG"], $genre)) {
                        $sSelected = " selected='selected'";
                    }
                    else {
                        $sSelected = "";
                    }
                    echo "<option value='".$tag["ID"]."' " . $sSelected . ">" . $tag["TAG"] . "</option>";
                }
                ?>
            </select>
        </fieldset>
        </br>
        <?php
        if (!isset($_GET["GameID"])) {
        echo"<fieldset>
            <label>steht zur Verfügung:</label><input type='radio' name='status' value='0' ";
            if ($game["BESTELLT"] == 0) {
                echo "checked";
            }
            echo"><label>ist bestellt:</label><input type='radio' name='status' value='1' ";
            if ($game["BESTELLT"] == 1) {
                echo "checked";
            }
            echo "><label>auf Wantliste:</label><input type='radio' name='status' value='2' ";
            if ($game["BESTELLT"] == 2) {
                echo "checked";
            }
            echo "></fieldset>";
        }?>
        </br>
        <?php
        if (!$ext) {
            echo '<fieldset><label>Erweiterungen erben von:</label><select multiple="multiple" name="extends[]">';
            foreach ($extendsList as $extends) {
                if (in_array($extends["ID"], $ExtList)) {
                    $sSelected = " selected='selected'";
                }
                else {
                    $sSelected = "";
                }
                echo "<option value=" . $extends["ID"] . " " . $sSelected . ">" . $extends["NAME"] . "</option>";
            }
            echo "</select></fieldset>";
        }
        if (isset($game)) {
            echo "</br><fieldset><label>Files Löschen:</label><select  multiple='multiple' name='deletes[]'>";
            $fileDirPath = "./uploads/" . $game["ID"] . "/";
            if (file_exists($fileDirPath)) {
                if ($dh = opendir($fileDirPath)) {
                    while (($file = readdir($dh)) !== false) {
                        $fileInfo = pathinfo($fileDirPath . $file);
                        if ($fileInfo['extension'] != "") {
                            echo "<option value='" . $fileInfo['basename'] . "'>" . $fileInfo['basename'] . "</option>";
                        }
                    }
                    closedir($dh);
                }
            }
            echo "</select></fieldset>";
        }


        if ($b) {
            echo "<button type='submit' name='buttonChecked'>Spiel speichern</button>";
        }
        else {
            echo "<button type='submit' name='buttonChecked'>Spiel erstellen</button>";
        }
        ?>

    </form>
</div>

