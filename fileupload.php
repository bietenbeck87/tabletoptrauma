<?php
$id = $_GET["ID"];
if(isset($_FILES['datei'])){
    if(isset($_POST["GameID"])) {
        $uploaddir = './uploads/' . $_POST["GameID"] . '/';
        $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
        if (!file_exists($uploaddir)) {
            mkdir($uploaddir, 0777, true);
        }
        move_uploaded_file($_FILES['datei']['tmp_name'], $uploaddir . $_FILES['datei']['name']);
        header('Location: singlegame.php?id=' . $_POST["GameID"]);
    }
}
?>
<meta charset="utf-8"/>
<title>UPLOAD</title>
<link rel="stylesheet" type="text/css" href="./src/css/style.css">
<script src="./src/js/goBack.js"></script>
<?php
echo "<div class='BackBtn leftBtn' onclick='goBack();'>Zurück</div>";
echo "<a href='index.php'><div class='BackBtn rightBtn'>Startseite</div></a>";
?>
<h2>File-Upload:</h2>
<div id="uploadForm"><form action="fileupload.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="GameID" value="<?php echo $id; ?>">
    <input type="file" name="datei"><br>
<button type="submit">Hochladen</button>
</form></div>