<?php
function upload_hisupplier($filename) {
    $url = "http://upload.hisupplier.com/image/swfupload_img?comId=431976&watermark=true&onlyStoreToDisk=true&watermarkTextColor=%23cccccc&watermarkRight=true&textFontSize=0&imgType=3&imgExts=*.jpg%3B*.jpeg%3B*.gif&fileName=kzYffugewX3SrpyfD-dog2.jpg&watermarkText=zhoushandazhong.en.hisupplier.com&imgSize=500";
    $post_data = array(
        'img'=> new CURLFile($filename),
    );
    $response = upload($url, $post_data);

    if(!$response['err']) {
        $res = json_decode(str_replace("'", '"', $response['res']));
        $img = '';
        foreach($res[0] as $key => $value) {
            if($key == 'imgName')
                $value = 'cc.jpg';
            $img .= "$key=$value;";
        }
        return $img;
    } else {
        return false;
    }

}
