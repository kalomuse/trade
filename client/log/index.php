<?php
require_once("../../path.php");
require_once("$CLIENT/base/header/header.php");
require_once("$SERVER/app/log.php");
?>

<style>
    thead {
        font-size: 18px;
        font-weight: bold;
    }
    thead td {
        height: 30px;
    }
    .blue {
        color: #08c;
        cursor: pointer;
    }
    input[type=text] {
        width: 150px;
    }
    .hide {
        display: none;
    }
    td img{
        max-width: 100px;
    }
    .action {
        width: 70px;
    }
</style>
<div class="container">
    <table class="table table-bordered">
        <thead>
        <td>结果</td>
        <td>说明</td>
        <td>网站url</td>
        <td>产品ID</td>
        <td>产品名</td>
        </thead>
        <tbody>
        <?php foreach(list_log() as $a) { ?>
            <tr id="<?= $a['id'] ?>">
                <td name="结果"><?=  $a['success']? "成功": "失败"; ?></td>
                <td name="说明"><?= $a['msg'] ?></td>
                <td name="网站url"><?= $a['site_url'] ?></td>
                <td name="产品ID"><?= $a['product_id'] ?></td>
                <td name="产品名"><?= $a['product_name'] ?></td>
            </tr>
        <?php } ?>
        </tbody>


    </table>
</div>
<link href="/widget/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<ul class="pagination">
    <li><a href="#">&laquo;</a></li>
    <li><a href="#">1</a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">4</a></li>
    <li><a href="#">5</a></li>
    <li><a href="#">&raquo;</a></li>
</ul>

<?php require_once("$CLIENT/base/footer/footer.php"); ?>
