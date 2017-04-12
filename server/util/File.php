<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 17/3/14
 * Time: 下午10:08
 */

require_once ("../../path.php");

function save_file($name='img_path') {
    global $PATH;
    $upload_dir = "$PATH/public/upload";
    $img_path = "/public/upload";
    if ($_FILES["file"]["error"] > 0) {
        echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
    else  {
        $_FILES["file"]["name"] = time().$_FILES["file"]["name"];
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir);
        }
        $url = $upload_dir.'/'.$_FILES["file"]["name"];
        $img_path = $img_path.'/'.$_FILES["file"]["name"];
        move_uploaded_file($_FILES["file"]["tmp_name"], $url);
        setcookie($name, $img_path, time() + 60*20, '/');
        return $img_path;
    }
}
