<?php
    require_once("../../path.php");
    require_once("$CLIENT/base/header/header.php");
    require_once("$SERVER/app/account.php");
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
</style>
<div class="container">
    <table class="table table-bordered">
        <thead>
            <td>网站地址</td>
            <td>网站名称</td>
            <td>账 号</td>
            <td>密 码</td>
            <td>操作</td>
        </thead>
        <tbody>
            <?php foreach(query() as $a) { ?>
            <tr id="<?= $a['id'] ?>">
                <td name="site_url"><a href="<?= $a['site_url'] ?>" target="_blank"><?= $a['site_url'] ?></a></td>
                <td name="site_name"><?= $a['site_name'] ?></td>
                <td name="account"><?= $a['account'] ?></td>
                <td name="password"><?= $a['password'] ?></td>
                <td class="action">
                    <span class="blue alter">修改</span>
                    <span class="blue save hide">保存</span> |
                    <span class="blue reg"><a <?php if($a['mark'] == 'hisupplier.com') {$mark = $a['mark'];echo 'mark='.$a['mark'].' data-toggle="modal" data-target=".code-dialog"';} else {echo 'mark='.$a['mark']." onclick='register(this.attributes[\"mark\"].value);'";} ?>>注册</a></span>
                </td>
            </tr>
            <?php } ?>
        </tbody>


    </table>
</div>
<div class="modal fade code-dialog" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div style="margin-left:170px; padding: 20px 0px;">
                <div><span>验证码：</span><input style="width: 138px;margin-right:10px;" id="code" type="text"><span class="blue getcode">看不清，换一张</span></div>
                <img id="validateCodeImg" style="margin-left: 55px;" src="/server/send/<?= $mark?>/register.php?action=code">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary btn-ok">确认</button>
            </div>
        </div>
    </div>
</div>
<script>
    function register(mark, code) {
        let url = '';
        if(code) {
            url = `/server/send/${mark}/register.php?action=index&code=${code}`;
        }else {
            url = `/server/send/${mark}/register.php?action=index`;
        }
        $.get(url, function(res) {
            $('.getcode').click();
            $('#code').val('');
            alert(res.msg);
        });
    }
    $('.btn-ok').click(function() {
        if($('#code').val()) {
            register('hisupplier.com', $('#code').val());
            $('.code-dialog').modal('hide');
        }
    });
    $('.getcode').click(function(e) {
        e.preventDefault();
        $(this).parents('.modal-content').find('#validateCodeImg').attr('src', '/server/send/<?= $mark ?>/register.php?action=code&random=' + Math.random());
    });
    $('#validateCodeImg').click(function() {
        $(this).attr('src', '/server/send/<?= $mark?>/register.php?action=code');
    });
    $('.alter').click((e) => {
        let $tr = $(e.target).parents('tr');
        $tr.find('td').each(function() {
            if(!$(this).hasClass('action')) {
                let text = $(this).text();
                let name = $(this).attr('name');
                $(this).html(`<input type='text' name=${name} value=${text}>`);
            }
        });
        $tr.find('.alter').hide();
        $tr.find('.save').show();
    });
    $('.save').click((e) => {
        let $tr = $(e.target).parents('tr');
        let data = {'id': $tr.attr('id')};
        $tr.find('input').each(function() {
            let value = $(this).val();
            let name = $(this).attr('name');
            data[name] = value;
        });

        $.post("/server/app/account.php?action=save", data, (res) => {
            if(res.ok) {
                location.reload();
            } else {
                alert(res.msg);
            }
        });

    });

</script>

<?php require_once("$CLIENT/base/footer/footer.php"); ?>

