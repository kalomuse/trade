<?php
require_once ('getAttr.php');
function upload_eb80($filename, $cookie) {
    $url = "http://www.eb80.com/Member/MyPic.aspx";
    $arr = get_attr($url, $cookie);
    $post_data = array(
        'txtName' => 'abc',
        'FileUpload1'=> new CURLFile($filename),
        '__VIEWSTATE' => $arr['view'],
        '__EVENTVALIDATION'=> $arr['event'],
        'btnSubmit'=>'Upload new Image sure',
    );
    $response = upload($url, $post_data, $cookie);


}
