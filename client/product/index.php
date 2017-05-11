<?php
require_once("../../path.php");
require_once("$CLIENT/base/header/header.php");
require_once("$SERVER/app/product.php");
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
    <a class="btn" href="/product/add.php" style="width:100px;margin-bottom: 10px;" >新 建 +</a>
    <table class="table table-bordered">
        <thead>
        <td>产品名</td>
        <td>分类</td>
        <td>价格</td>
        <td>摘要</td>
        <td>详细描述</td>
        <td>图片</td>
        <td>发送次数</td>
        <td>操作</td>
        </thead>
        <tbody>
        <?php foreach(list_product() as $a) { ?>
            <tr id="<?= $a['id'] ?>">
                <td name="name"><?= $a['name'] ?></td>
                <td name="category"><?= $a['category'] ?></td>
                <td name="price"><?= $a['price'] ?></td>
                <td name="brief"><?= $a['brief'] ?></td>
                <td name="description"><?= $a['description'] ?></td>
                <td class="name="img"><img src="<?= $a['img'] ?>"></td>
                <td class="name="count"><?= $a['count'] ?></td>
                <td class="action">
                    <a class="blue" href="/product/edit.php?id=<?= $a['id'] ?>">编辑</a> |
                    <span class="blue send">发送</span>
                </td>
            </tr>
        <?php } ?>
        </tbody>


    </table>
</div>
<script>
    $('.send').click(function(e) {
        var $tr = $(e.target).parents('tr');
        $.post("/server/send/index.php", {'id': $tr.attr('id')}, function(res) {
            if(res.ok) {
                alert(res.msg);
            } else {
                alert(res.err);
            }
        });
    });


</script>

<?php require_once("$CLIENT/base/footer/footer.php"); ?>

