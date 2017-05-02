<?php
include_once("./core/dB.php");
$db = new dB();
if (isset($_GET["ID"])) {
    $user = $db->getAll("Select * from users where ID='" . mysql_real_escape_string($_GET["ID"]) . "'");
}
if (isset($_POST["id"])) {
    $user = $db->getAll("Select * from users where ID='" . mysql_real_escape_string($_POST["id"]) . "'");
    if (isset($_POST["newpassword"]) && $_POST["newpassword"] != "") {
        if (md5($_POST["oldpassword"]) == $user[0]["PW"]) {
            $db->execute("update users set PW='" . md5($_POST["newpassword"]) . "', FLAGCOLOR='" . mysql_real_escape_string($_POST["colorflag"]) . "' where ID='" . mysql_real_escape_string($user[0]["ID"]) . "'");
            echo "Data saved!";
        }
        else {
            echo "Wrong Password";
        }
    }
    else {
        $db->execute("update users set FLAGCOLOR='" . mysql_real_escape_string($_POST["colorflag"]) . "' where ID='" . mysql_real_escape_string($user[0]["ID"]) . "'");
    }
    $user = $db->getAll("Select * from users where ID='" . mysql_real_escape_string($_POST["id"]) . "'");;
}
elseif (isset($_POST["name"])) {
    $identicalUser = $db->getAll("select * from users where EMAIL='" . mysql_real_escape_string($_POST["mail"]) . "'");
    if ($identicalUser) {
        echo "user with E-mail allready exists";
    }
    else {
        $db->execute("insert into users (NAME,EMAIL,PW,FLAGCOLOR) value ('" . mysql_real_escape_string($_POST["name"]) . "','" . mysql_real_escape_string($_POST["mail"]) . "','" . md5($_POST["password"]) . "','" . mysql_real_escape_string($_POST["colorflag"]) . "')");
        $user = $db->getAll("select * from users where EMAIL='" . mysql_real_escape_string($_POST["mail"]) . "'");
        setcookie("loggedInBG", $user[0]["ID"], time() + 18000);
        header('Location: index.php');
    }

}

?>
<meta charset="utf-8"/>
<title>USER</title>
<link rel="stylesheet" type="text/css" href="./src/css/style.css">
<script src="./src/js/jquery-3.2.1.min.js"></script>
<script src="./src/js/color.js"></script>
<script src="./src/js/validateuser.js"></script>

<?php
echo "<a href='".$GLOBALS['_SERVER']['HTTP_REFERER']."'><div class='BackBtn leftBtn'>Zurück</div></a>";
echo "<a href='index.php'><div class='BackBtn rightBtn'>Startseite</div></a>";
?>
<div class="editForm">
    <form name="addeditform" action="addeditUser.php" method="post" onsubmit="return validateForm()">
        <?php
        if (!isset($user)) {
            echo '<label>Username:</label><input type="text" name="name" id="nameInput">';
        } ?>
        <?php if (!isset($user)) {
            echo '<label>Email:</label><input type="text" name="mail">';
        } ?>
        <?php if (!isset($user)) {
            echo '<label>Password:</label><input type="password" name="password">';
        }
        else {
            echo '<label>new Password:</label><input type="password" name="newpassword">';
        }
        ?>
        <label>Color:</label>#<input type="text" name="colorflag" id="colorInput" <?php if (isset($user)) {
            echo "value='" . $user[0]["FLAGCOLOR"] . "'";
        } ?>>
        <div class="showflags">
        <div id="colorPick" class="banner" <?php if (isset($user)) {
            echo "style='background:#" . $user[0]["FLAGCOLOR"] . ";'";
        } ?>>
            <div class="shortName"><?php if (isset($user)) {
                    echo substr($user[0]["NAME"], 0, 1);
                } ?></div>
            <img src="./src/img/owner_banner_wanted.png"></div>

        <div id="colorPick" class="banner" <?php if (isset($user)) {
                    echo "style='background:#" . $user[0]["FLAGCOLOR"] . ";'";
                } ?>>
                    <div class="shortName"><?php if (isset($user)) {
                            echo substr($user[0]["NAME"], 0, 1);
                        } ?></div>
                    <img src="./src/img/owner_banner_ordered.png"></div>
        <div id="colorPick" class="banner" <?php if (isset($user)) {
                    echo "style='background:#" . $user[0]["FLAGCOLOR"] . ";'";
                } ?>>
                    <div class="shortName"><?php if (isset($user)) {
                            echo substr($user[0]["NAME"], 0, 1);
                        } ?></div>
                    <img src="./src/img/owner_banner_arrived.png"></div>
        </div>
        <div class="clear"></div>
        <?php if (isset($user)) {
            echo '<label>Old Password:</label><input type="password" name="oldpassword">';
        } ?>
        <?php if (isset($user)) {
            echo '<input type="hidden" name="id" value="' . $user[0]["ID"] . '">';
        } ?>

        <?php if (isset($user)) {
            echo "<button type = 'submit' name = 'buttonChecked' > save User - Data </button >";
        }else{
            echo "<button type = 'submit' name = 'buttonChecked' >create User</button >";
        } ?>
    </form>
</div>