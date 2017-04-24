<?php
include_once("./core/dB.php");
$db = new dB();
if (isset($_POST['Name']) && $_POST['Password']) {
    $Name = $_POST['Name'];
    $Password = md5($_POST['Password']);
    $statement = "SELECT ID FROM users WHERE EMAIL = '" . $Name . "' and PW='" .$Password. "'";
    $ID = $db->getOne($statement);
    if ($ID) {
        if ($_POST["groupid"]) {
            $getGroup = "Select * from groups where ID='" . $_POST["groupid"] . "'";
            $group = $db->getAll($getGroup)[0];
            if (md5($group["NAME"]) == $_POST["grouphash"]) {
                $checkUser = $db->getAll("Select * from user2group where IDGROUP='" . $_POST["groupid"] . "' and IDUSER='" . $ID . "'");
                if (!$checkUser) {
                    $db->execute("insert into user2group (IDUSER,IDGROUP) value ('" . $ID . "','" . $_POST["groupid"] . "')");
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
<a href='index.php'>
    <div id="BackBtn">Zurück</div>
</a>
<div id="loginBox">
    <form action="login.php" method="post">
        EMAIL:<br>
        <input type="text" size="40" maxlength="250" name="Name"><br><br>

        Password:<br>
        <input type="password" size="40" maxlength="250" name="Password"><br>
        <?php
        if (isset($_GET["group"]) && isset($_GET["ghash"])) {
            echo "<input type='hidden' value='" . $_GET["group"] . "' name='groupid'><input type='hidden' value='" . $_GET["ghash"] . "' name='grouphash'>";
        }
        ?>
        <input type="submit" value="Login">
    </form>
</div>