<meta charset="utf-8"/>
<title>Termine</title>
<script language="javascript" type="text/javascript" src="./src/js/validatedates.js"></script>
<link rel="stylesheet" type="text/css" href="./src/css/style.css">
<?php
include_once("./core/dB.php");
$db = new dB();
$GameListSQL = "Select * from brettspiele where ERWEITERUNG is Null order by Name";
$GameList = $db->getAll($GameListSQL);

if (isset($_POST["date"])) {
    $games = implode("||", $_POST["games"]);

    $SQLINSERT = "INSERT INTO termine (DATE,TIME,WHO,PLACE,GAMES,IDGROUP,IDUSER) value ('" . $_POST["date"] . "','" . $_POST["time"] . "','" . $_POST["who"] . "','" . $_POST["place"] . "','" . $games . "','".$_POST["id"]."','".$_COOKIE["loggedInBG"]."')";
    $db->execute($SQLINSERT);
}
if (isset($_GET["delete"])) {
    $SQLDELETE = "DELETE from termine where ID='" . $_GET["delete"] . "'";
    $db->execute($SQLDELETE);
}
echo "<a href='index.php'><div id='BackBtn'>Zurück</div></a>";
if ((isset($_GET["id"]) && $_GET["id"] != "")) {
    $groupID = $_GET["id"];
    $selectedGroup = $db->getAll("Select * from groups where ID='" . $groupID . "'");
    if ($selectedGroup) {
        $SQLGET = "SELECT * from termine where IDGROUP='".$groupID."' order by DATE desc, TIME desc";
        $DATES = $db->getAll($SQLGET);
        if (isset($_COOKIE["loggedInBG"])) {
            echo
            "<div id='terminForm'>
    <h3>Termin erstellen</h3>
    <form name='dateForm' action='termine.php?id=".$groupID."' method='post' onsubmit='return validateForm()'>
        <label>Datum:(YYYY-MM-DD)</label><input name='date' type='date'>
        <label>Uhrzeit:(HH:MM)</label><input name='time' type='time'>
        <label>WO:</label><input name='place' type='text'>
        <label>WER:</label><input name='who' type='text'>
        <label>WAS:</label><select multiple='multiple' name='games[]'>";
            foreach ($GameList as $game) {
                echo "<option value='" . $game["NAME"] . "'>" . $game["NAME"] . "</option>";
            }
            echo "</select></br>";
        if(isset($_GET["id"])){
            echo "<input type='hidden' value='".$_GET["id"]."' name='id' >";
        }
        echo "<button type='submit'>Termin erstellen</button>
    </form>
</div>";
        }
        echo "<div id='termine'><table><tr class='head'><td>AKTIV?</td><td>TERMIN</td><td>WO?</td><td>MIT WEM?</td><td>WAS?</td><td>löschen</td></tr>";

        date_default_timezone_set('Europe/Berlin');
        $now = date("Y-m-d H:i:s");
        $rowEvenOdd = "odd";
        foreach ($DATES as $dateData) {
            $class = "inactive";
            $deleteButton = "";
            $dataDate = $dateData['DATE'] . " " . $dateData['TIME'];
            if ($dataDate >= $now) {
                $class = "active";
                if (isset($_COOKIE["loggedInBG"]) && $_COOKIE["loggedInBG"] == $dateData["IDUSER"]) {
                    $deleteButton = "<a href='termine.php?id=".$groupID."&delete=" . $dateData["ID"] . "'><button>delete</button></a>";
                }
            }
            $sGames = str_replace("||", "</br>", $dateData['GAMES']);
            $dateTime = $dateData['DATE'] . " " . $dateData['TIME'];
            $readableDateFormat = date("d.m.Y - H:i", strtotime($dateTime));
            echo "<tr class='" . $rowEvenOdd . "'><td><div class='" . $class . "'></div></td><td>" . $readableDateFormat . "</td><td>" . $dateData['PLACE'] . "</td><td>" . $dateData['WHO'] . "</td><td>" . $sGames . "</td><td>" . $deleteButton . "</td></tr>";
            if ($rowEvenOdd == "odd") {
                $rowEvenOdd = "even";
            }
            else {
                $rowEvenOdd = "odd";
            }
        }
        echo "</table></div>";

    }
}
