<?php
require_once("Valite.php");

function get_code($abs_path, $name) {
    $img_dir = $abs_path.$name;
    $valite = new Valite();
    $dh = opendir($img_dir);
    $data = array();
    while (($file = readdir($dh)) != false) {
        if ($file != '.' && $file != '..' && $file != '.DS_Store') {
            $data[$img_dir . '/' . $file] = array();
            $str = explode('.', $file);
            for ($i = 0; $i < strlen($str[0]); $i++) {
                $data[$img_dir . '/' . $file][] = $str[0][$i];
            }
        }
    }

    foreach ($data as $key => $value) {
        $valite->bmp2png($key);
        $valite->setImage($key);
        $valite->getHec($name);
        $valite->filterInfo();
        $valite->study($value);
    }

    $valite->bmp2png($abs_path."test/1.png");
    $valite->setImage($abs_path."test/1.png");
    $valite->getHec($name);
    $msg = $valite->filterInfo();
    //$valite->Draw();
    return $valite->run();

}
?>