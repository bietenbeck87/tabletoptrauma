<meta charset="utf-8"/>
<title>Termine</title>
<script src="./src/js/jquery-3.2.1.min.js"></script>
<script language="javascript" type="text/javascript" src="./src/js/validatedates.js"></script>
<script src="./src/js/accordion.js"></script>
<script src="./src/js/goBack.js"></script>
<link rel="stylesheet" type="text/css" href="./src/css/style.css">
<?php
include_once("./core/dB.php");
include_once("./core/helper.php");
echo "<div class='BackBtn leftBtn' onclick='goBack();'>Zurück</div>";
echo "<a href='index.php'><div class='BackBtn rightBtn'>Startseite</div></a>";
echo "<div class='clear'></div>";
if (isset($_COOKIE["loggedInBG"])) {
    $db = new dB();
    $helper = new helper();
    $aState = array(0 => "grey", 1 => "green", 2 => "red");
    if(isset($_GET["state"]) && isset($_GET["id"])){
     $SQLDateUpdate="Update user2date set STATE='".$_GET["state"]."' where IDUSER='".$_COOKIE["loggedInBG"]."' and IDDATE='".$_GET["id"]."'";
     $db->execute($SQLDateUpdate);
    }
    if (isset($_POST["date"])) {
        $games = implode("||", $_POST["games"]);
        $ID = time();
        $SQLINSERT = "INSERT INTO termine (ID,DATE,TIME,PLACE,GAMES,IDUSER) value ('" . mysql_real_escape_string($ID) . "','" . mysql_real_escape_string($_POST["date"]) . "','" . mysql_real_escape_string($_POST["time"]) . "','" . mysql_real_escape_string($_POST["place"]) . "','" . mysql_real_escape_string($games) . "','" . mysql_real_escape_string($_COOKIE["loggedInBG"]) . "')";
        $db->execute($SQLINSERT);
        $SQLINSERTU2D = "Insert into user2date (IDDATE,IDUSER,STATE) value ('" . $ID . "','" . $_COOKIE["loggedInBG"] . "','1')";
        $db->execute($SQLINSERTU2D);
        if (isset($_POST["who"])) {
            foreach ($_POST["who"] as $userID) {
                $SQLINSERTU2D = "Insert into user2date (IDDATE,IDUSER,STATE) value ('" . $ID . "','" . $userID . "','0')";
                $db->execute($SQLINSERTU2D);
                $sSQLgetUser = "Select * from users where ID ='$userID'";
                $user = $db->getAll($sSQLgetUser)[0];
                if($user["GETNEWS"] == 1){
                  $sMSG="Sie wurden zu einem neuen Termin eingeladen am ".$_POST["date"]." um ".$_POST["time"]." Uhr bei ".$_POST["place"];
                  $helper->SendMail($user["EMAIL"],$sMSG,"Neuer Termin");
                }
            }
        }
    }
    if (isset($_GET["delete"])) {
        $SQLDELETE = "DELETE from termine where ID='" . mysql_real_escape_string($_GET["delete"]) . "'";
        $db->execute($SQLDELETE);

        $SQLDELETERel = "DELETE from user2date where IDDATE='" . mysql_real_escape_string($_GET["delete"]) . "'";
        $db->execute($SQLDELETERel);
    }


    $GameListSQL = "Select * from brettspiele where ERWEITERUNG is Null order by Name";
    $GameList = $db->getAll($GameListSQL);
    $userList = $helper->getUsersFromGroups($db, $_COOKIE["loggedInBG"]);
    $dates = $db->getAll("Select distinct t.* from termine as t join user2date as u on t.ID=u.IDDATE where u.IDUSER=" . $_COOKIE["loggedInBG"] . " order by t.DATE, t.TIME desc");


    echo "<div id='terminForm'>
    <h3>Termin erstellen</h3>
    <form name='dateForm' action='termine.php?id=" . $groupID . "' method='post' onsubmit='return validateForm()'>
        <label>Datum:(YYYY-MM-DD)</label><input name='date' type='date'>
        <label>Uhrzeit:(HH:MM)</label><input name='time' type='time'>
        <label>WO:</label><input name='place' type='text'>
        <label>WER:</label><select multiple='multiple' name='who[]'>";
    foreach ($userList as $user) {
        echo "<option value='" . htmlentities($user['ID'], ENT_QUOTES, "UTF-8") . "'>" . htmlentities($user['NAME'], ENT_QUOTES, "UTF-8") . "</option>";
    }
    echo "</select></br>";
    echo "<label>WAS:</label><select multiple='multiple' name='games[]'>";
    foreach ($GameList as $game) {
        echo "<option value='" . htmlentities($game['NAME'], ENT_QUOTES, "UTF-8") . "'>" . htmlentities($game['NAME'], ENT_QUOTES, "UTF-8") . "</option>";
    }
    echo "</select></br>";
    if (isset($_GET["id"])) {
        echo "<input type='hidden' value='" . $_GET["id"] . "' name='id' >";
    }
    echo "<button type='submit'>Termin erstellen</button>
    </form>
</div>";
    echo "<div class='aditionalData dateContainer'>";
    foreach ($dates as $date) {
        $sSQLurState = "Select STATE from user2date where IDDATE='" . $date["ID"] . "' and IDUSER='".$_COOKIE["loggedInBG"]."'";
        $urState = $db->getOne($sSQLurState);
        $sSQLUser = "Select * from user2date where IDDATE='" . $date["ID"] . "'";
        $user2dates = $db->getAll($sSQLUser);
        $games = "<ul class='gameList'>";
        foreach (explode("||", $date["GAMES"]) as $game) {
            $games .= "<li>" . $game . "</li>";
        }
        $games .= "</ul>";

        echo "<h2 class='accord'>";
        if($urState == 0 ){
          echo "<span class='newDate'>*NEW*</span>";
        }
        echo$date["DATE"] . " - " . $date["TIME"];
        if ($date["IDUSER"] == $_COOKIE["loggedInBG"]) {
            echo "<a href='termine.php?delete=" . $date["ID"] . "'><button class='deleteButton'>löschen</button ></a>";
        }
        echo "</h2><div class='extensions accElement'>
    Ort: <span class='fat'>" . $date["PLACE"] . "</span><br> Spiele: " . $games . "
    <div class='userStates'>";
        foreach ($user2dates as $user2date) {
            $sqlUserName = "Select NAME from users where ID='" . $user2date["IDUSER"] . "'";
            $name = $db->getOne($sqlUserName);
            echo "<div class='userState' style='background-color: " . $aState[$user2date["STATE"]] . "'>" . $name ;
            if ($user2date["STATE"] == 0 && $user2date["IDUSER"] == $_COOKIE["loggedInBG"]) {
                echo "<a href='termine.php?state=1&id=".$date["ID"]."'><button>annehmen</button></a><a href='termine.php?state=2&id=".$date["ID"]."'><button>ablehnen</button></a>";
            }
            if ($user2date["STATE"] == 1 && $user2date["IDUSER"] == $_COOKIE["loggedInBG"]) {
                echo "<a href='termine.php?state=2&id=".$date["ID"]."'><button>ablehnen</button></a>";
            }
            if ($user2date["STATE"] == 2 && $user2date["IDUSER"] == $_COOKIE["loggedInBG"]) {
                echo "<a href='termine.php?state=1&id=".$date["ID"]."'><button>annehmen</button></a>";
            }
            echo "</div>";
        }
        echo "</div></div>";
    }
    echo "</div>";
}
else {
    echo "Bitte einloggen.";
}



