<?php
include_once("./core/dB.php");
$db = new dB();
if (isset($_POST['Name']) && $_POST['Password']) {
    $Name = $_POST['Name'];
    $Password = md5($_POST['Password']);
    $statement = "SELECT ID FROM users WHERE EMAIL = '" . mysql_real_escape_string($Name) . "' and PW='" .$Password. "'";
    $ID = $db->getOne($statement);
    if ($ID) {
        if ($_POST["groupid"]) {
            $getGroup = "Select * from groups where ID='" . mysql_real_escape_string($_POST["groupid"]) . "'";
            $group = $db->getAll($getGroup)[0];
            if (md5($group["NAME"]) == $_POST["grouphash"]) {
                $checkUser = $db->getAll("Select * from user2group where IDGROUP='" . mysql_real_escape_string($_POST["groupid"]) . "' and IDUSER='" . mysql_real_escape_string($ID) . "'");
                if (!$checkUser) {
                    $db->execute("insert into user2group (IDUSER,IDGROUP) value ('" . mysql_real_escape_string($ID) . "','" . mysql_real_escape_string($_POST["groupid"]) . "')");
                }
            }
        }
        setcookie("loggedInBG", $ID, time() + 18000);
        header('Location: index.php');
    }
    else {
        $errorMessage = "Einlogdaten Falsch!";
    }
}
?>
<?php
if (isset($errorMessage)) {
    echo $errorMessage;
}
?>
<meta charset="utf-8"/>
<title>LOGIN</title>
<link rel="stylesheet" type="text/css" href="./src/css/style.css">
<script src="./src/js/goBack.js"></script>
<?php
echo "<div class='BackBtn leftBtn' onclick='goBack();'>Zurück</div>";
echo "<a href='index.php'><div class='BackBtn rightBtn'>Startseite</div></a>";
echo "<div class='clear'></div>";
?>
<div id="loginBox">
    <form action="login.php" method="post">
        E-MAIL:<br>
        <input type="text" size="40" maxlength="250" name="Name"><br><br>

        Passwort:<br>
        <input type="password" size="40" maxlength="250" name="Password"><br>
        <?php
        if (isset($_GET["group"]) && isset($_GET["ghash"])) {
            echo "<input type='hidden' value='" . $_GET["group"] . "' name='groupid'><input type='hidden' value='" . $_GET["ghash"] . "' name='grouphash'>";
        }
        ?>
        <input type="submit" value="Login">
    </form>
</div>