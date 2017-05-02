<?php
include_once("./core/dB.php");
$db = new dB();

if(isset($_GET["id"])){
    $group = $db->getAll("Select * from groups where ID='".mysql_real_escape_string($_GET["id"])."'");
}
if(isset($_POST["groupID"])){
    $db->execute("update groups set NAME = '".mysql_real_escape_string($_POST["name"])."', GROUPPIC='". mysql_real_escape_string($_POST["picture"])."' where ID='".mysql_real_escape_string($_POST["groupID"])."'");
    header('Location: index.php');
}else {
    if (isset($_POST["name"]) && isset($_COOKIE["loggedInBG"])) {
        $db->execute("insert into groups (NAME,GROUPADMIN,GROUPPIC) value ('" . mysql_real_escape_string($_POST["name"]) . "','" . mysql_real_escape_string($_COOKIE["loggedInBG"]) . "','" . mysql_real_escape_string($_POST["picture"]) . "',)");
        $createdGroup = $db->getAll("select * from groups where NAME='" . mysql_real_escape_string($_POST["name"]) . "' and GROUPADMIN='" . mysql_real_escape_string($_COOKIE["loggedInBG"]) . "' order by ID desc limit 1");
        $db->execute("insert into user2group (IDUSER,IDGROUP) value ('" . mysql_real_escape_string($_COOKIE["loggedInBG"]) . "','" . mysql_real_escape_string($createdGroup[0]["ID"]) . "')");
        header('Location: index.php');
    }
}
?>
<meta charset="utf-8"/>
<title>USER</title>
<link rel="stylesheet" type="text/css" href="./src/css/style.css">
<script src="./src/js/jquery-3.2.1.min.js"></script>
<script src="./src/js/validategroup.js"></script>

<?php
echo "<a href='".$GLOBALS['_SERVER']['HTTP_REFERER']."'><div class='BackBtn leftBtn'>Zurück</div></a>";
echo "<a href='index.php'><div class='BackBtn rightBtn'>Startseite</div></a>";
?>
<div class="editForm">
    <form name="addeditform" action="addeditGroup.php" method="post" onsubmit="return validateForm()">
        <label>GroupName:</label><input type="text" name="name" <?php if(isset($group)){ echo "value='".$group[0]["NAME"]."'";} ?>>
        <label>GroupPicture:</label><input type="text" name="picture" <?php if(isset($group)){ echo "value='".$group[0]["GROUPPIC"]."'";} ?>>
        <?php if(!isset($group)) {
            echo "<button type = 'submit' name = 'buttonChecked' > Gruppe Anlegen </button >";
         }else{
            echo "<input type='hidden' value='".$group[0]["ID"]."' name='groupID'><button type = 'submit' name = 'buttonChecked' > Gruppe speichern </button >";
        }?>
        </form>
    <?php if(isset($group)){
        $link = $_SERVER["HTTP_HOST"]."/login.php?group=".$group[0]["ID"]."&ghash=".md5($group[0]["NAME"]);
        echo $link;
        echo "<a href='whatsapp://send?text=".$link."' data-action='share/whatsapp/share'><img id='waimg' src='./src/img/whatsapp-button.jpg'></a>";
    }?>
</div>