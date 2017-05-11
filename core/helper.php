<?php

class helper
{
    function thumbnail($imgfile, $speicherordner = "./uploads/thumbnail/", $filenameOnly = true)
    {
        $thumbsize = 180;

        $filename = basename($imgfile);

        if (!$filenameOnly) {
            $replace = array("/", "\\", ".");
            $filename = str_replace($replace, "_", dirname($imgfile)) . "_" . $filename;
        }
        $ordner = $speicherordner;

        if (!is_dir($ordner)) {
            mkdir($ordner, 0777, true);
        }
        if (file_exists($ordner . $filename))
            return $ordner . $filename;
        if (!file_exists($imgfile))
            return false;


        $endung = strrchr($imgfile, ".");

        list($width, $height) = getimagesize($imgfile);
        $imgratio = $width / $height;
        $newheight = $thumbsize;
        $newwidth = $thumbsize * $imgratio;

        if (function_exists("imagecreatetruecolor"))
            $thumb = imagecreatetruecolor($newwidth, $newheight);
        else
            $thumb = imagecreate($newwidth, $newheight);

        if ($endung == ".jpg") {
            imageJPEG($thumb, $ordner . "temp.jpg");
            $thumb = imagecreatefromjpeg($ordner . "temp.jpg");

            $source = imagecreatefromjpeg($imgfile);
        }
        else if ($endung == ".gif") {
            imageGIF($thumb, $ordner . "temp.gif");
            $thumb = imagecreatefromgif($ordner . "temp.gif");

            $source = imagecreatefromgif($imgfile);
        }

        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        if ($endung == ".png")
            imagepng($thumb, $ordner . $filename);
        else if ($endung == ".gif")
            imagegif($thumb, $ordner . $filename);
        else
            imagejpeg($thumb, $ordner . $filename, 100);


        ImageDestroy($thumb);
        ImageDestroy($source);


        return $ordner . $filename;
    }

    public function getUser4Game($db, $gameID, $group = false, $userID = "")
    {
        $formattedArray = array();
        if ($group) {
            $UserIDS = $db->getAll("Select u.*,u2g.STATUS from users as u join user2game as u2g on u.ID=u2g.IDUSER join user2group as u2gr on u.ID=u2gr.IDUSER where IDGAME ='" . $gameID . "' and u2gr.IDGROUP='" . $group . "'");
        }
        else {
            $UserIDS = $db->getAll("Select u.*,u2g.STATUS from users as u join user2game as u2g on u.ID=u2g.IDUSER where u2g.IDGAME ='" . $gameID . "' and u.ID='" . $userID . "'");
        }
        foreach ($UserIDS as $userData) {
            $formattedArray[$userData["ID"]] = $userData;
        }
        return $formattedArray;
    }

    function grab_image($url, $saveto)
    {
        if (!file_exists($saveto)) {
            mkdir($saveto, 0777, true);
        }
        $PicPath = $saveto . "/thumb.jpg";
        $ch = curl_init($url);
        $fp = fopen($PicPath, 'w+');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_REFERER, 'https://boardgamegeek.com/');
        $findsomething = curl_exec($ch);
        curl_close($ch);
        fclose($fp);

        return $PicPath;
    }

    public function sendMail2People($db,$userID,$nachricht,$betreff)
    {
        $sSQL="SELECT distinct   u2.EMAIL
        FROM      users u
        JOIN      user2group ug ON (ug.IDUSER = u.ID)
        JOIN      user2group ug2 ON (ug2.IDGROUP = ug.IDGROUP)
        JOIN      users u2 ON (u2.ID = ug2.IDUSER and u.ID != u2.ID and u2.GETNEWS='1')
        WHERE     u.id = '".$userID."'";

        $aMails = $db->getAll($sSQL);
        if(count($aMails)>= 1) {
            $sMails = "";
            foreach ($aMails as $aMail) {
                $sMails .= $aMail["EMAIL"] . ",";
            }
            $empfaenger = substr($sMails,0,strlen($sMails)-1);
            $header = 'From: noreply@pubgaming.de' . "\r\n" .
                'Reply-To: noreply@pubgaming.de' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            mail($empfaenger, $betreff, $nachricht, $header);
        }
    }

}