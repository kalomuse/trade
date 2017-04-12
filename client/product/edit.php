<?php
require_once("../../path.php");
require_once("$SERVER/app/product.php");
require_once("$CLIENT/base/header/header.php");
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
        width: 70px;
        padding-top: 5px;
        text-align: right;;
        margin-right: 18px;
    }
    #uploader {
        position: relative;
        height: 90px;
        margin-left: 100px;
    }
    #filePicker {
        position: absolute;
        left: 200px;
        top: 20px;

    }
    .img-list {
        width: 85px;
    }
    .btn {
        margin-left: 200px;
        display: block;
        width: 100px;
    }
    .button-list {
        margin-top: 5px;
    }
</style>


<?php $res = list_product() ?>
<div class="form-container">
    <form class="form-horizontal" id="form">
        <div class="control-group">
            <label  for="name">产品名</label>
            <input type="text" id="name" placeholder="请输入产品名" value="<?= $res[0]['name'] ?>">
        </div>
        <div class="control-group">
            <label for="category">产品分类</label>
            <input type="text" id="category" name="category" readonly="readonly" value="<?= $res[0]['category'] ?>">
            <div id="cate" class="col-md-10" data-required="true" style="width: 1430px;position:relative;">

            </div>
            <div class="button-list" style="display:none;">
                <button class="ok">确定</button>
                <button class="cancel">关闭</button>
            </div>
        </div>
        <div class="control-group">
            <label for="brief">产品摘要</label>
            <input type="text" id="brief" name="brief" value="<?= $res[0]['brief'] ?>">
        </div>
        <div class="control-group">
            <label for="description">详细描述</label>
            <textarea id="description" name="description" rows="5"><?= $res[0]['description'] ?></textarea>
        </div>
        <div id="uploader">
            <!--用来存放item-->
            <div id="fileList" class="uploader-list">
                <div id="filePicker">选择图片</div>
                <div class="img-container">
                    <div class="img-list"><img style="width:100px;height:100px;" src="<?= $res[0]['img'] ?>"></div>
                </div>
            </div>
        </div>
    </form>
    <button class="btn" id="submit">提  交</button>


</div>

<script type="text/javascript" src="/widget/uploader/webuploader.js"></script>
<script type="text/javascript" src="/conf/cat.js"></script>
<script>
    function get_catgory(cat, id, deep) {
        for (let i in cat) {
            if(!(deep)) {
                if (cat[i].id == id) {
                    return cat[i].s;
                }
            } else {
                if(cat[i].s) {
                    let res = get_catgory(cat[i].s, id, deep - 1);
                    if(res) {
                        return res;
                    }
                } else {
                    return false;
                }
            }
        }
    }

    function write_catgory(id, deep){
        var tmp_cat = get_catgory(cat, id, deep);
        if(deep == 1)
            $('#cate3').remove();
        if(tmp_cat) {
            var id = 'cate' + (deep + 1);
            if($('#' + id).length) {
                for (let i in tmp_cat) {
                    if(tmp_cat[i].isleaf == 'false') add = '+ ';
                    else add = '';
                    str += `<option value=${tmp_cat[i].id} deep=${deep + 1} onclick="write_catgory(${tmp_cat[i].id}, ${deep + 1})">${add+tmp_cat[i].n}</option>`;
                }
                $('#' + id).html(str);
            } else {
                var str = `<select id=${id} size="8">`;
                for (let i in tmp_cat) {
                    if(tmp_cat[i].isleaf == 'false') add = '+ ';
                    else add = '  ';
                    str += `<option value=${tmp_cat[i].id} deep=${deep + 1} onclick="write_catgory(${tmp_cat[i].id}, ${deep + 1})">${add+tmp_cat[i].n}</option>`;
                }
                str += '<select/>';
                $('#cate').append(str);

            }
        }
    }

    $(function () {
        $('#submit').click(() => {
            let post_data = {};
        $('#form input[type=text]').each(function() {
            let name = $(this).attr('id');
            post_data[name] = $(this).val();
        });
        post_data['description'] = $('#description').val();
        $.post('/server/app/product.php?action=update&id=<?= $res[0]['id'] ?>', post_data, function(res) {
            if(!res.ok) {
                alert(res.err);
            } else {
                alert(res.msg);
                location.href = "/product";
            }
        });
    });
        $('#category').click(() =>  {
            $('.button-list').show();
        if($('#category').val() && $('#cate').find('select').length)
            $('#cate').show();
        else
            write_catgory(0, 0);
    });
        $('.ok').click((e) =>  {
            $('#category').attr('data', '');
        e.preventDefault();
        $('#cate').find('select').each(function() {
            let data = $('#category').attr('data');
            $('#category').attr('data',  data + $(this).find('option:selected').text() + ' >> ');
        });
        let str = $('#category').attr('data').replace(/( >> | >>  >> )$/, '');
        str = str.replace(/\+ /g, '');
        $('#category').attr('data', str);
        $('#category').val($('#category').attr('data'));
        $('#cate').hide();
        $('.button-list').hide();
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
        server: '/server/app/product.php?action=upload',

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

