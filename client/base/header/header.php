<?php
$active = explode('/', $_SERVER['PHP_SELF'])[2];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>发布产品</title>
    <link href="/widget/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/widget/uploader/webuploader.css" rel="stylesheet">

</head>
<body>
<div class="navbar">
    <div class="navbar-inner">
        <a class="brand" href="#">产品</a>
        <ul class="nav">
            <li class='<?php  if($active == 'user') echo 'active'?>'><a href="/">首页</a></li>
            <li class='<?php  if($active == 'account') echo 'active'?>'><a class="active" href="/account">账号</a></li>
            <li class='<?php  if($active == 'product') echo 'active'?>'><a href="/product">商品</a></li>
            <li class='<?php  if($active == 'log') echo 'active'?>'><a href="/log">日志</a></li>
        </ul>
    </div>
</div>
<script type="text/javascript" src="/widget/jquery/dist/jquery.js"></script>
<script type="text/javascript" src="/widget/bootstrap/js/bootstrap.min.js"></script>
<script>

</script>