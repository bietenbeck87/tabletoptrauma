<?php
if (isset($_POST["groups"])) {
    if ($_POST["groups"] == "false") {
        if (isset($_COOKIE["selectedGroup"])) {
            setcookie("selectedGroup", $_POST["groups"], time() - 3600);
            header('Location: index.php');
        }
    }
    else {
        if (isset($_COOKIE["selectedGroup"]) && $_COOKIE["selectedGroup"] != $_POST["groups"]) {
            setcookie("selectedGroup", $_POST["groups"], time() + 18000);
            header('Location: index.php');
        }
        elseif (!isset($_COOKIE["selectedGroup"])) {
            setcookie("selectedGroup", $_POST["groups"], time() + 18000);
            header('Location: index.php');
        }
    }

}
?>
    <meta charset="utf-8"/>
    <title>TABLETOP TRAUMA</title>
    <link rel="stylesheet" type="text/css" href="./src/css/style.css">
    <script src="./src/js/jquery-3.2.1.min.js"></script>
    <script src="./src/js/newsSlider.js"></script>
    <script src="./src/js/eyes.js"></script>

<?php
include_once("./core/dB.php");
include_once("./core/helper.php");
$db = new dB();
$helper = new helper();

$getTags = "select * from tags";
$aTags = $db->getAll($getTags);
if (isset($_COOKIE["loggedInBG"])) {
    $getUserGroups = "Select g.* from groups as g join user2group as u2gr on g.ID=u2gr.IDGROUP where u2gr.IDUSER='" . $_COOKIE["loggedInBG"] . "'";
    $userGroups = $db->getAll($getUserGroups);
    if (isset($_COOKIE["selectedGroup"])) {
        $getGroupUsers = "Select u.* from users as u join user2group as u2gr on u.ID=u2gr.IDUSER where IDGROUP='" . $_COOKIE["selectedGroup"] . "'";
        $aGroupUser = $db->getAll($getGroupUsers);
    }
}

if (isset($_COOKIE["loggedInBG"])) {
    if (isset($_COOKIE["selectedGroup"])){
        $getNews ="Select n.* from news as n join user2group as u2gr on n.USERID =u2gr.IDUSER where u2gr.IDGROUP='".$_COOKIE["selectedGroup"]."' order by n.ID desc limit 10";
    }else {
        $getNews = "select * from news where USERID='".$_COOKIE["loggedInBG"]."' order by ID desc limit 10";
    }
    $News = $db->getAll($getNews);
}else{
    $News=array();
}
?>
    <div id="btnLine">
        <div id="logo">
            <div id="blood"></div>
            <div id="logoDiv">
                <?php if (isset($_COOKIE["loggedInBG"]) && isset($_COOKIE["selectedGroup"])) {
                    $selectedGroup = $db->getAll("Select *from groups where ID='".$_COOKIE["selectedGroup"]."'");
                    if($selectedGroup[0]["GROUPPIC"] != ""){
                        echo "<img src='".$selectedGroup[0]["GROUPPIC"]."'>";
                    }
                    else{
                        echo "<img src='./src/img/logos.png'>";
                    }
                }else{
                    echo "<img src='./src/img/logos.png'>";
                }
                ?>
            </div>
        </div>
        <div id="buttons">
            <div class="floatCenter">

                <a href="bgg_hot.php">
                    <div id="hot" class="topBtn">BGG-HOTLIST</div>
                </a>
                <?php if(isset($_COOKIE["loggedInBG"]) && isset($_COOKIE["selectedGroup"])){
                    echo "<a href='termine.php?id=".$_COOKIE["selectedGroup"]."'><div id='dateBtn' class='topBtn'>Termine</div></a>";
                }
                ?>
                <?php
                if (!isset($_COOKIE["loggedInBG"])) {
                    echo '<a href="login.php">
        <div id="login" class="topBtn">Login</div>
    </a>';
                }
                if (isset($_COOKIE["loggedInBG"])) {
                    echo '<a href="addeditGame.php">
        <div id="login" class="topBtn">Add Game</div>
    </a>';
                } ?>
                <a href="sites.php">
                    <div id="sites" class='topBtn'>Sites</div>
                </a>
                <div class='clear'></div>
                <?php
                if(!isset($_COOKIE["loggedInBG"])) {
                    echo "<a href = 'addeditUser.php' ><div id = 'register' class='topBtn' >register</div></a>";
                }
                if(isset($_COOKIE["loggedInBG"])) {
                    echo "<a href ='addeditUser.php?ID=".$_COOKIE["loggedInBG"]."' ><div id = 'register' class='topBtn' >User Menu</div></a>";
                    echo "<a href='addeditGroup.php'><div id='createGroup' class='topBtn'>create Group</div></a>";
                }
                ?>
                <div class="clear"></div>
            </div>
        </div>
    </div>

    <div id='News'>
        <?php
        $i = 1;
        $class = "";
        foreach ($News as $aNews) {
            if ($i != 1) {
                $class = "hidden";
            }

            echo "<div class='newsElement " . $class . "' id='news_" . $i . "'>" . $i . " - " . $aNews["MESSAGE"] . "</div>";
            $i++;
        }
        ?>
    </div>
    <form action="index.php" method="post">

        <?php if (isset($userGroups) && count($userGroups) >= 1) {
            echo "<div class='filterGroups'><div class='formInputs'><Select name='groups'><option value='false'>Group</option>";
            foreach ($userGroups as $userGroup) {
                if (isset($_COOKIE["selectedGroup"]) && $_COOKIE["selectedGroup"] == $userGroup["ID"]) {
                    $sSelected = " selected='selected'";
                }
                else {
                    $sSelected = "";
                }
                echo "<option" . $sSelected . " value='" . $userGroup["ID"] . "'>" . $userGroup["NAME"] . "</option>";
            }
            echo "</Select></div>";
            echo "<div class='formBtn'><button type='submit' id='changeButton'>change Group</button></div>";
            $selectedGroupInfo = $db->getAll("Select * from groups where ID='".$_COOKIE["selectedGroup"]."'");
            if(isset($_COOKIE["loggedInBG"]) && $_COOKIE["loggedInBG"] == $selectedGroupInfo[0]["GROUPADMIN"]){
                echo "<a href='addeditGroup.php?id=".$_COOKIE["selectedGroup"]."'><div class='formBtn'><button type='button' id='changeButton'>edit Group</button></div></a>";
            }
            echo "<div class='clear'></div></div>";
        }
        ?>


        <div class="filterGames">

            <div class="formBtn">
                <button type="submit" id="searchButton">Search</button>
            </div>
            <div class="formInputs">
                <input name="namesearch" type="text" <?php if (isset($_POST["namesearch"])) {
                    echo "value='" . $_POST["namesearch"] . "'";
                } ?>>
                <Select name="playerCount">
                    <option value="false">Player</option>
                    <option <?php if (isset($_POST["playerCount"]) && $_POST["playerCount"] == "1") {
                        echo "selected='selected'";
                    } ?>>1
                    </option>
                    <option <?php if (isset($_POST["playerCount"]) && $_POST["playerCount"] == "2") {
                        echo "selected='selected'";
                    } ?>>2
                    </option>
                    <option <?php if (isset($_POST["playerCount"]) && $_POST["playerCount"] == "3") {
                        echo "selected='selected'";
                    } ?>>3
                    </option>
                    <option <?php if (isset($_POST["playerCount"]) && $_POST["playerCount"] == "4") {
                        echo "selected='selected'";
                    } ?>>4
                    </option>
                    <option <?php if (isset($_POST["playerCount"]) && $_POST["playerCount"] == "5") {
                        echo "selected='selected'";
                    } ?>>5
                    </option>
                    <option <?php if (isset($_POST["playerCount"]) && $_POST["playerCount"] == "6") {
                        echo "selected='selected'";
                    } ?>>6
                    </option>
                    <option <?php if (isset($_POST["playerCount"]) && $_POST["playerCount"] == "7") {
                        echo "selected='selected'";
                    } ?>>7
                    </option>
                    <option <?php if (isset($_POST["playerCount"]) && $_POST["playerCount"] == "8") {
                        echo "selected='selected'";
                    } ?>>8
                    </option>
                    <option <?php if (isset($_POST["playerCount"]) && $_POST["playerCount"] == "9") {
                        echo "selected='selected'";
                    } ?>>9
                    </option>
                    <option <?php if (isset($_POST["playerCount"]) && $_POST["playerCount"] == "10") {
                        echo "selected='selected'";
                    } ?>>10
                    </option>
                    <option <?php if (isset($_POST["playerCount"]) && $_POST["playerCount"] == "11") {
                        echo "selected='selected'";
                    } ?>>11
                    </option>
                    <option <?php if (isset($_POST["playerCount"]) && $_POST["playerCount"] == "12") {
                        echo "selected='selected'";
                    } ?>>12
                    </option>
                </Select>
                <Select name="playTime">
                    <option value="false">Time</option>
                    <option value="30" <?php if (isset($_POST["playTime"]) && $_POST["playTime"] == "30") {
                        echo "selected='selected'";
                    } ?>>< 30min
                    </option>
                    <option value="60" <?php if (isset($_POST["playTime"]) && $_POST["playTime"] == "60") {
                        echo "selected='selected'";
                    } ?>>< 60min
                    </option>
                    <option value="90" <?php if (isset($_POST["playTime"]) && $_POST["playTime"] == "90") {
                        echo "selected='selected'";
                    } ?>>< 90min
                    </option>
                    <option value="120" <?php if (isset($_POST["playTime"]) && $_POST["playTime"] == "120") {
                        echo "selected='selected'";
                    } ?>>< 120min
                    </option>
                    <option value="180" <?php if (isset($_POST["playTime"]) && $_POST["playTime"] == "180") {
                        echo "selected='selected'";
                    } ?>>< 180min
                    </option>
                    <option value="240" <?php if (isset($_POST["playTime"]) && $_POST["playTime"] == "240") {
                        echo "selected='selected'";
                    } ?>>< 240min
                    </option>
                </Select>
                <Select name="Koop">
                    <option value="false">Coop</option>
                    <option value="0" <?php if (isset($_POST["Koop"]) && $_POST["Koop"] == "0") {
                        echo "selected='selected'";
                    } ?>>Nein
                    </option>
                    <option value="1" <?php if (isset($_POST["Koop"]) && $_POST["Koop"] == "1") {
                        echo "selected='selected'";
                    } ?>>Koop
                    </option>
                    <option value="2" <?php if (isset($_POST["Koop"]) && $_POST["Koop"] == "2") {
                        echo "selected='selected'";
                    } ?>>Koop + DM
                    </option>
                    <option value="3" <?php if (isset($_POST["Koop"]) && $_POST["Koop"] == "3") {
                        echo "selected='selected'";
                    } ?>>Koop + Verräter
                    </option>
                    <option value="4" <?php if (isset($_POST["Koop"]) && $_POST["Koop"] == "4") {
                        echo "selected='selected'";
                    } ?>>Teams
                    </option>
                </Select>
                <Select name="Genre">
                    <option value="false">Genre</option>
                    <?php
                    foreach ($aTags as $tag) {
                        if (isset($_POST["Genre"]) && $_POST["Genre"] == $tag["TAG"]) {
                            $sSelected = " selected='selected'";
                        }
                        else {
                            $sSelected = "";
                        }
                        echo "<option" . $sSelected . ">" . $tag["TAG"] . "</option>";
                    }
                    ?>
                </Select>
                <?php
                //USERS
                if (isset($_COOKIE["selectedGroup"])) {
                    echo "<Select name='besitzer'><option value='false'>Owner</option>";

                    foreach ($aGroupUser as $user) {
                        if (isset($_POST["besitzer"]) && $_POST["besitzer"] == $user["ID"]) {
                            $sSelected = " selected='selected'";
                        }
                        else {
                            $sSelected = "";
                        }
                        echo "<option" . $sSelected . " value='" . $user["ID"] . "'>" . $user["NAME"] . "</option>";
                    }
                    echo "</Select>";
                } ?>
            </div>
            <div class="clear"></div>
        </div>
    </form>
<?php
$aKoop = array(0 => "Nein",
    1 => "Koop",
    2 => "Koop + DM",
    3 => "Koop + Verräter",
    4 => "Teams");
$add = "";
if (isset($_POST["namesearch"]) && $_POST["namesearch"] != "") {
    $add = " and Name like '%" . $_POST["namesearch"] . "%'";
}
if (isset($_POST["playerCount"]) && $_POST["playerCount"] != "false") {
    $add .= " and MIN_P <=" . $_POST["playerCount"] . " and MAX_P >=" . $_POST["playerCount"];
}
if (isset($_POST["playTime"]) && $_POST["playTime"] != "false") {
    $add .= " and MAX_T <=" . $_POST["playTime"];
}
if (isset($_POST["Koop"]) && $_POST["Koop"] != "false") {
    $add .= " and KOOP like '" . $_POST["Koop"] . "'";
}
if (isset($_POST["Genre"]) && $_POST["Genre"] != "false") {
    $add .= " and GENRE like '%" . $_POST["Genre"] . "%'";
}
if (isset($_COOKIE["selectedGroup"])) {
    if (isset($_POST["besitzer"]) && $_POST["besitzer"] != "false") {
        $getGames = "Select distinct b.* from brettspiele as b join user2game as u2g on b.ID=u2g.IDGAME join user2group as u2gr on u2g.IDUSER =u2gr.IDUSER where u2g.IDUSER ='" . $_POST["besitzer"] . "' and u2gr.IDGROUP='" . $_COOKIE["selectedGroup"] . "' and ERWEITERUNG is Null";
    }
    else {
        $getGames = "Select distinct b.* from brettspiele as b join user2game as u2g on b.ID=u2g.IDGAME join user2group as u2gr on u2g.IDUSER =u2gr.IDUSER where u2gr.IDGROUP='" . $_COOKIE["selectedGroup"] . "' and ERWEITERUNG is Null";
    }
}
else {
    $getGames = "Select b.* from brettspiele as b where 1=1 and ERWEITERUNG is Null";
}

$add .= " order by MIN_P ,MAX_P, NAME";

$getGames = $getGames . $add;

$games = $db->getAll($getGames);
$gameCount = count($games);
$extBaseIDS = array();
foreach ($games as $extcount) {
    if (!in_array($extcount["ID"], $extBaseIDS)) {
        $extBaseIDS[] = $extcount["ID"];
    }
}
if (count($extBaseIDS) >= 1) {
    $getExt = "Select count(ID) from brettspiele where ERWEITERUNG in (" . implode(",", $extBaseIDS) . ")";
    $extCount = $db->getOne($getExt);
}
else {
    $extCount = 0;
}


echo "<div id='gamecount'><b>" . $gameCount . "</b> Spiele gefunden mit <b>" . $extCount . "</b> Erweiterungen</div>";
echo "<div id='gameTableDiv'><table><tr id='head'><td>Bild</td><td>Name</td><td>Spieleranzahl</td><td>Spielzeit</td><td>Koop?</td><td>Genre</td></tr>";

$rowEvenOdd = "odd";
foreach ($games as $game) {

    //Banner
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
        $banner .= "<div class='banner' style='background:#".$ubannerName["FLAGCOLOR"].";' title='".$ubannerName["NAME"]."'><div id='shortName'>".substr($ubannerName["NAME"],0,1)."</div><img  src='./src/img/owner_banner.png'></div>";
    }
    $genre = str_replace("||", "<br>", $game["GENRE"]);
    echo "<tr class='" . $rowEvenOdd . "'><td><a href=singlegame.php?id=" . $game["ID"] . "><div class='packed'><div class='Banner_div'>" . $banner . "</div><div class='mainImg'><img src='" . $game["BILD"] . "'></div></div></a></td><td>" . $game["NAME"] . "</td><td>" . $game["MIN_P"] . " - " . $game["MAX_P"] . "</td><td>" . $game["MIN_T"] . " - " . $game["MAX_T"] . " min.</td><td>" . $aKoop[$game["KOOP"]] . "</td><td>" . $genre . "</td></tr>";
    if ($rowEvenOdd == "odd") {
        $rowEvenOdd = "even";
    }
    else {
        $rowEvenOdd = "odd";
    }
}
echo "</table><div id='footer'></div></div>"

?>