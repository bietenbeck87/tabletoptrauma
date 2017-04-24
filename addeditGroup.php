<?php
include_once("./core/dB.php");
$db = new dB();

if(isset($_GET["id"])){
    $group = $db->getAll("Select * from groups where ID='".$_GET["id"]."'");
}
if(isset($_POST["groupID"])){
    $db->execute("update groups set NAME = '".$_POST["name"]."' where ID='".$_POST["groupID"]."'");
    header('Location: index.php');
}else {
    if (isset($_POST["name"]) && isset($_COOKIE["loggedInBG"])) {
        $db->execute("insert into groups (NAME,GROUPADMIN) value ('" . $_POST["name"] . "','" . $_COOKIE["loggedInBG"] . "')");
        $createdGroup = $db->getAll("select * from groups where NAME='" . $_POST["name"] . "' and GROUPADMIN='" . $_COOKIE["loggedInBG"] . "' order by ID desc limit 1");
        $db->execute("insert into user2group (IDUSER,IDGROUP) value ('" . $_COOKIE["loggedInBG"] . "','" . $createdGroup[0]["ID"] . "')");
        header('Location: index.php');
    }
}
?>
<meta charset="utf-8"/>
<title>USER</title>
<link rel="stylesheet" type="text/css" href="./src/css/style.css">
<script src="./src/js/jquery-3.2.1.min.js"></script>
<script src="./src/js/validategroup.js"></script>

<a href='index.php'>
    <div id="BackBtn">Zurück</div>
</a>
<div class="editForm">
    <form name="addeditform" action="addeditGroup.php" method="post" onsubmit="return validateForm()">
        <label>GroupName:</label><input type="text" name="name" <?php if(isset($group)){ echo "value='".$group[0]["NAME"]."'";} ?>>
        <?php if(!isset($group)) {
            echo "<button type = 'submit' name = 'buttonChecked' > Gruppe Anlegen </button >";
         }else{
            echo "<input type='hidden' value='".$group[0]["ID"]."' name='groupID'><button type = 'submit' name = 'buttonChecked' > Gruppe speichern </button >";
        }?>
        </form>
    <?php if(isset($group)){
        $link = $_SERVER["HTTP_HOST"]."/login.php?group=".$group[0]["ID"]."&ghash=".md5($group[0]["NAME"]);
        echo $link;
        echo "<a href='whatsapp://send?text=".$link."' data-action='share/whatsapp/share'><img src='./src/img/whatsapp-button.jpg'></a>";
    }?>
</div>