<?php
include_once("./core/dB.php");
$db = new dB();
if (isset($_GET["ID"])) {
    $user = $db->getAll("Select * from users where ID='" . mysql_real_escape_string($_GET["ID"]) . "'");
}
if (isset($_POST["id"])) {
    if(isset($_POST["news"]) && $_POST["news"] == 1){
        $news=1;
    }else{
        $news=0;
    }
    $user = $db->getAll("Select * from users where ID='" . mysql_real_escape_string($_POST["id"]) . "'");
    if (isset($_POST["newpassword"]) && $_POST["newpassword"] != "") {
        if (md5($_POST["oldpassword"]) == $user[0]["PW"]) {
            $db->execute("update users set PW='" . md5($_POST["newpassword"]) . "', FLAGCOLOR='" . mysql_real_escape_string($_POST["colorflag"]) . "',GETNEWS='".$news."' where ID='" . mysql_real_escape_string($user[0]["ID"]) . "'");
            echo "Data saved!";
        }
        else {
            echo "Wrong Password";
        }
    }
    else {
        $db->execute("update users set FLAGCOLOR='" . mysql_real_escape_string($_POST["colorflag"]) . "',GETNEWS='".$news."' where ID='" . mysql_real_escape_string($user[0]["ID"]) . "'");
    }
    $user = $db->getAll("Select * from users where ID='" . mysql_real_escape_string($_POST["id"]) . "'");;
}
elseif (isset($_POST["name"])) {
    $identicalUser = $db->getAll("select * from users where EMAIL='" . mysql_real_escape_string($_POST["mail"]) . "'");
    if ($identicalUser) {
        echo "user with E-mail allready exists";
    }
    else {
        if(isset($_POST["news"]) && $_POST["news"] == 1){
            $news=1;
        }else{
            $news=0;
        }
        $db->execute("insert into users (NAME,EMAIL,PW,FLAGCOLOR,GETNEWS) value ('" . mysql_real_escape_string($_POST["name"]) . "','" . mysql_real_escape_string($_POST["mail"]) . "','" . md5($_POST["password"]) . "','" . mysql_real_escape_string($_POST["colorflag"]) . "','".$news."')");
        $user = $db->getAll("select * from users where EMAIL='" . mysql_real_escape_string($_POST["mail"]) . "'");
        $empfaenger = 'bietenbeck87@gmail.com';
        $betreff = 'Neuer User';
        $nachricht = 'Ein Neuer user wurde angelegt. Email:'.$_POST["mail"].'  Name:'.$_POST["name"];
        $header = 'From: noreply@pubgaming.de' . "\r\n" .
            'Reply-To: noreply@pubgaming.de' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($empfaenger, $betreff, $nachricht, $header);
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
<script src="./src/js/goBack.js"></script>
<script src="./src/js/validateuser.js"></script>

<?php
echo "<div class='BackBtn leftBtn' onclick='goBack();'>Zurück</div>";
echo "<a href='index.php'><div class='BackBtn rightBtn'>Startseite</div></a>";
echo "<div class='clear'></div>";
?>
<div class="editForm">
    <form name="addeditform" action="addeditUser.php" method="post" onsubmit="return validateForm()">
        <?php
        if (!isset($user)) {
            echo '<label>Benutzername:</label><input type="text" name="name" id="nameInput">';
        } ?>
        <?php if (!isset($user)) {
            echo '<label>E-mail:</label><input type="text" name="mail">';
        } ?>
        <?php if (!isset($user)) {
            echo '<label>Passwort:</label><input type="password" name="password">';
        }
        else {
            echo '<label>neues Passwort:</label><input type="password" name="newpassword">';
        }
        ?>
        <?php if (isset($user)) {
            echo '<label>altes Passwort:</label><input type="password" name="oldpassword">';
        } ?>
        <label>Farbe:</label>#<input type="text" name="colorflag" id="colorInput" <?php if (isset($user)) {
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
            echo '<input type="hidden" name="id" value="' . $user[0]["ID"] . '">';
        } ?>
        <label>News-Mails?:</label><input type="checkbox" value="1" name="news" <?php if($user[0]["GETNEWS"] == 1){echo "checked='checked'";}?>><br>
        <?php if (isset($user)) {
            echo "<button type = 'submit' name = 'buttonChecked' > Speichern </button >";
        }else{
            echo "<button type = 'submit' name = 'buttonChecked' >Benutzer erstellen</button >";
        } ?>
    </form>
</div>