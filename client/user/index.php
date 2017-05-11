<?php
require_once("../../path.php");
require_once("$CLIENT/base/header/header.php");
require_once("$SERVER/app/user.php");
?>
<style>
    .form-container {
        width: 500px;
        margin: 0 auto;
        padding-top: 20px;
    }
    .control-group input {
        width: 300px;
    }
    label {
        float: left;
        width: 90px;
        padding-top: 5px;
        text-align: right;;
        margin-right: 18px;
    }
    #distpicker select {
        width: 80px;
        margin-right: 5px;
    }
    .btn {
        margin-left: 200px;
        display: block;
        width: 100px;
    }
    #uploader {
        position: relative;
        height: 110px;
        margin-left: 120px;
    }
    #filePicker {
        position: absolute;
        left: 200px;
        top: 20px;

    }
    .img-list {
        width: 85px;
    }

</style>


<?php $user = query(); ?>
<div class="form-container">
    <form class="form-horizontal" id="form">
        <div class="control-group">
            <label  for="company_name">公司名称</label>
            <input type="text" id="company_name" value="<?= $user[0]['company_name'] ?>">
        </div>
        <div class="control-group">
            <label  for="company_en_name">公司英文名称</label>
            <input type="text" id="company_en_name" value="<?= $user[0]['company_en_name'] ?>">
        </div>
        <div class="control-group">
            <label  for="name">公司所在地</label>
            <div id="distpicker" data-toggle="distpicker">
                <select data-province="<?= $user[0]['province'] ?>" id="province"></select><!-- 省 -->
                <select data-city="<?= $user[0]['city'] ?>" id="city"></select><!-- 市 -->
                <select data-district="<?= $user[0]['district'] ?>"id="district"></select><!-- 区 -->
            </div>
        </div>
        <div class="control-group">
            <label  for="company_address">详细地址</label>
            <input type="text" id="company_address" value="<?= $user[0]['company_address'] ?>">
        </div>
        <div class="control-group">
            <label  for="zip">邮编</label>
            <input type="text" id="zip" value="<?= $user[0]['zip'] ?>">
        </div>
        <div class="control-group">
            <label  for="contact_name">联系人姓名</label>
            <input type="text" id="contact_name" value="<?= $user[0]['contact_name'] ?>" placeholder="last name" style="width:100px;">
            <input type="text" id="contact_name_first" value="<?= $user[0]['contact_name_first'] ?>" placeholder="first name" style="width:100px;">
        </div>
        <div class="control-group">
            <label for="contact_phone">电话号码</label>
            <input type="text" id="pre_contact_phone" value="<?= $user[0]['pre_contact_phone'] ?>" style="width: 60px;"> -
            <input type="text" id="contact_phone" value="<?= $user[0]['contact_phone'] ?>" style="width: 213px;">
        </div>
        <div class="control-group">
            <label for="contact_fax">传真</label>
            <input type="text" id="pre_contact_fax" value="<?= $user[0]['pre_contact_fax'] ?>" style="width: 60px;"> -
            <input type="text" id="contact_fax" value="<?= $user[0]['contact_fax'] ?>" style="width: 213px;">
        </div>
        <div class="control-group">
            <label  for="email">联系邮箱</label>
            <input type="text" id="email" value="<?= $user[0]['email'] ?>">
        </div>
        <div class="control-group">
            <label  for="boss_name">企业法人</label>
            <input type="text" id="boss_name" value="<?= $user[0]['boss_name'] ?>">
        </div>
        <div class="control-group">
            <label  for="company_number">营业执照号</label>
            <input type="text" id="company_number" value="<?= $user[0]['company_number'] ?>">
        </div>
        <div id="uploader">
            <!--用来存放item-->
            <div id="fileList" class="uploader-list">
                <div id="filePicker">选择图片</div>
                <div class="img-container">
                    <?php if($user[0]["company_number_img"]) echo '<div class="img-list"><img style="width:100px;height:100px;" src="'.$user[0]["company_number_img"].'"></div>' ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label  for="reg_email">自动注册邮箱</label>
            <input type="text" id="reg_email" value="<?= $user[0]['reg_email'] ?>" >
        </div>
        <div class="control-group">
            <label  for="reg_account">自动注册账号</label>
            <input type="text" id="reg_account" value="<?= $user[0]['reg_account'] ?>">
        </div>
        <div class="control-group">
            <label  for="reg_password">自动注册密码</label>
            <input type="text" id="reg_password" value="<?= $user[0]['reg_password'] ?>">
        </div>

    </form>
    <button class="btn" id="submit">提  交</button>
</div>
<script type="text/javascript" src="/widget/distpicker/dist/distpicker.data.js"></script>
<script type="text/javascript" src="/widget/distpicker/dist/distpicker.js"></script>
<script type="text/javascript" src="/widget/uploader/webuploader.js"></script>
<script>
    $('#submit').click(() => {
        let post_data = {};
    $('#form input[type=text]').each(function() {
        let name = $(this).attr('id');
        post_data[name] = $(this).val();
    });
    $('#form select').each(function() {
        let name = $(this).attr('id');
        post_data[name] = $(this).val();
    });

    if($('.img-list img').attr('src')) {
        post_data['company_number_img'] = $('.img-list img').attr('src');
    }
    $.post('/server/app/user.php?action=save', post_data, function(res) {
        console.log(res);
        if(!res.ok) {
            alert(res.err);
        } else {
            alert(res.msg);
            location.reload();
        }
    });
    });
</script>

<script>
    // 初始化Web Uploader
    var uploader = WebUploader.create({

        // 选完文件后，是否自动上传。
        auto: true,

        // swf文件路径
        swf: '/widget/uploader/Uploader.swf',

        // 文件接收服务端。
        server: '/server/app/user.php?action=upload',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#filePicker',

        // 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });
    // 当有文件添加进来的时候
    uploader.on( 'fileQueued', function( file ) {
        var $li = $(
                '<div id="' + file.id + '" class="img-list">' +
                '<img>' +
                '</div>'
            ),
            $img = $li.find('img');


        // $list为容器jQuery实例
        $('.img-container').html( $li );

        // 创建缩略图
        // 如果为非图片文件，可以不用调用此方法。
        // thumbnailWidth x thumbnailHeight 为 100 x 100
        uploader.makeThumb( file, function( error, src ) {
            if ( error ) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }

            $img.attr( 'src', src );
        }, 100, 100 );
    });
    // 文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {
        var $li = $( '#'+file.id ),
            $percent = $li.find('.progress span');

        // 避免重复创建
        if ( !$percent.length ) {
            $percent = $('<p class="progress"><span></span></p>')
                .appendTo( $li )
                .find('span');
        }

        $percent.css( 'width', percentage * 100 + '%' );
    });

    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on( 'uploadSuccess', function( file ) {
        $( '#'+file.id ).addClass('upload-state-done');
    });

    // 文件上传失败，显示上传出错。
    uploader.on( 'uploadError', function( file ) {
        var $li = $( '#'+file.id ),
            $error = $li.find('div.error');

        // 避免重复创建
        if ( !$error.length ) {
            $error = $('<div class="error"></div>').appendTo( $li );
        }

        $error.text('上传失败');
    });

    // 完成上传完了，成功或者失败，先删除进度条。
    uploader.on( 'uploadComplete', function( file ) {
        $( '#'+file.id ).find('.progress').remove();
    });
</script>
<?php require_once("$CLIENT/base/footer/footer.php"); ?>

