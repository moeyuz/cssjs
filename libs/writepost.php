<?php

/**
 * menber.php
 * Author     : 小灯泡设计
 * Date       : 2020/4/3
 * Version    : 1.0
 * Description: 编辑器功能
 **/


/**
 * 后台编辑器
 */
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('tagshelper', 'tagslist');
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('myyodu', 'one');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('myyodu', 'one');

// 在编辑文章和编辑页面的底部注入代码
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('myyodu', 'render');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('myyodu', 'render');

class myyodu {

    public static function render()
    {

        Typecho_Widget::widget('Widget_Options')->to($options);
        ?>
<script>
// 粘贴文件上传
$(document).ready(function () {
    // 上传URL
    var uploadUrl = '<?php Helper::security()->index('/action/upload'); ?>';
    // 处理有特定的 CID 的情况
    var cid = $('input[name="cid"]').val();
    if (cid) {
        uploadUrl += '&cid=' + cid;
    }

    // 上传文件函数
    function uploadFile(file) {
        // 生成一段随机的字符串作为 key
        var index = Math.random().toString(10).substr(2, 5) + '-' + Math.random().toString(36).substr(2);
        // 默认文件后缀是 png，在Chrome浏览器中剪贴板粘贴的图片都是png格式，其他浏览器暂未测试
        var fileName = index + '.png';

        // 上传时候提示的文字
        var uploadingText = '[图片上传中...(' + index + ')]';

        // 先把这段文字插入
        var textarea = $('#text'), sel = textarea.getSelection(),
        offset = (sel ? sel.start : 0) + uploadingText.length;
        textarea.replaceSelection(uploadingText);
        // 设置光标位置
        textarea.setSelection(offset, offset);

        // 设置附件栏信息
        // 先切到附件栏
        $('#tab-files-btn').click();

        // 更新附件的上传提示
        var fileInfo = {
            id: index,
            name: fileName
        }
        fileUploadStart(fileInfo);

        // 是时候展示真正的上传了
        var formData = new FormData();
        formData.append('name', fileName);
        formData.append('file', file, fileName);

        $.ajax({
            method: 'post',
            url: uploadUrl,
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                var url = data[0], title = data[1].title;
                textarea.val(textarea.val().replace(uploadingText, '![' + title + '](' + url + ')'));
                // 触发输入框更新事件，把状态压人栈中，解决预览不更新的问题
                textarea.trigger('paste');
                // 附件上传的UI更新
                fileUploadComplete(index, url, data[1]);
            },
            error: function (error) {
                textarea.val(textarea.val().replace(uploadingText, '[图片上传错误...]\n'));
                // 触发输入框更新事件，把状态压人栈中，解决预览不更新的问题
                textarea.trigger('paste');
                // 附件上传的 UI 更新
                fileUploadError(fileInfo);
            }
        });
    }

    // 监听输入框粘贴事件
    document.getElementById('text').addEventListener('paste', function (e) {
      var clipboardData = e.clipboardData;
      var items = clipboardData.items;
      for (var i = 0; i < items.length; i++) {
        if (items[i].kind === 'file' && items[i].type.match(/^image/)) {
          // 取消默认的粘贴操作
          e.preventDefault();
          // 上传文件
          uploadFile(items[i].getAsFile());
          break;
        }
      }
    });



    //
    // 以下代码均来自 /admin/file-upload-js.php，无奈只好复制粘贴过来实现功能
    //

    // 更新附件数量显示
    function updateAttacmentNumber () {
        var btn = $('#tab-files-btn'),
            balloon = $('.balloon', btn),
            count = $('#file-list li .insert').length;

        if (count > 0) {
            if (!balloon.length) {
                btn.html($.trim(btn.html()) + ' ');
                balloon = $('<span class="balloon"></span>').appendTo(btn);
            }

            balloon.html(count);
        } else if (0 == count && balloon.length > 0) {
            balloon.remove();
        }
    }

    // 开始上传文件的提示
    function fileUploadStart (file) {
        $('<li id="' + file.id + '" class="loading">'
            + file.name + '</li>').appendTo('#file-list');
    }

    // 上传完毕的操作
    var completeFile = null;
    function fileUploadComplete (id, url, data) {
        var li = $('#' + id).removeClass('loading').data('cid', data.cid)
            .data('url', data.url)
            .data('image', data.isImage)
            .html('<input type="hidden" name="attachment[]" value="' + data.cid + '" />'
                + '<a class="insert" target="_blank" href="###" title="<?php _e('点击插入文件'); ?>">' + data.title + '</a><div class="info">' + data.bytes
                + ' <a class="file" target="_blank" href="<?php $options->adminUrl('media.php'); ?>?cid='
                + data.cid + '" title="<?php _e('编辑'); ?>"><i class="i-edit"></i></a>'
                + ' <a class="delete" href="###" title="<?php _e('删除'); ?>"><i class="i-delete"></i></a></div>')
            .effect('highlight', 1000);

        attachInsertEvent(li);
        attachDeleteEvent(li);
        updateAttacmentNumber();

        if (!completeFile) {
            completeFile = data;
        }
    }

    // 增加插入事件
    function attachInsertEvent (el) {
        $('.insert', el).click(function () {
            var t = $(this), p = t.parents('li');
            Typecho.insertFileToEditor(t.text(), p.data('url'), p.data('image'));
            return false;
        });
    }

    // 增加删除事件
    function attachDeleteEvent (el) {
        var file = $('a.insert', el).text();
        $('.delete', el).click(function () {
            if (confirm('<?php _e('确认要删除文件 %s 吗?'); ?>'.replace('%s', file))) {
                var cid = $(this).parents('li').data('cid');
                $.post('<?php Helper::security()->index('/action/contents-attachment-edit'); ?>',
                    {'do' : 'delete', 'cid' : cid},
                    function () {
                        $(el).fadeOut(function () {
                            $(this).remove();
                            updateAttacmentNumber();
                        });
                    });
            }

            return false;
        });
    }

    // 错误处理，相比原来的函数，做了一些微小的改造
    function fileUploadError (file) {
        var word;

        word = '<?php _e('上传出现错误'); ?>';

        var fileError = '<?php _e('%s 上传失败'); ?>'.replace('%s', file.name),
            li, exist = $('#' + file.id);

        if (exist.length > 0) {
            li = exist.removeClass('loading').html(fileError);
        } else {
            li = $('<li>' + fileError + '<br />' + word + '</li>').appendTo('#file-list');
        }

        li.effect('highlight', {color : '#FBC2C4'}, 2000, function () {
            $(this).remove();
        });
    }
})
</script>
<?php
    } 
    
    public static function one()
    {      
    ?>
<script src="/usr/themes/spimes/assets/css/wmd.js"></script>
<script src="/usr/themes/spimes/owo/dist/OwO.js"></script>
<link rel="stylesheet" href="/usr/themes/spimes/owo/dist/OwO.min.css" type="text/css" media="all">
<link rel="stylesheet" href="/usr/themes/spimes/assets/css/setting.fb.css">
<?php
    }
    
}
class tagshelper {
    public static function tagslist()
    {      
    $tag="";$taglist="";$i=0;//循环一次利用到两个位置
Typecho_Widget::widget('Widget_Metas_Tag_Cloud', 'sort=count&desc=1&limit=200')->to($tags);
while ($tags->next()) {
$tag=$tag."'".$tags->name."',";
$taglist=$taglist."<a id=".$i." onclick=\"$(\'#tags\').tokenInput(\'add\', {id: \'".$tags->name."\', tags: \'".$tags->name."\'});\">".$tags->name."</a>";
$i++;
}
?><style>.Posthelper a{cursor: pointer; padding: 0px 6px; margin: 2px 0;display: inline-block;border-radius: 2px;text-decoration: none;}
.Posthelper a:hover{background: #ccc;color: #fff;}.fullscreen #tab-files{right: 0;}/*解决全屏状态下鼠标放到附件上传按钮上导致的窗口抖动问题*/
</style>
<script>
  function chaall () {
   var html='';
 $("#file-list li .insert").each(function(){
   var t = $(this), p = t.parents('li');
   var file=t.text();
   var url= p.data('url');
   var isImage= p.data('image');
   if ($("input[name='markdown']").val()==1) {
   html = isImage ? html+'\n!['+file+'](' + url + ')\n':''+html+'';
   }else{
   html = isImage ? html+'<img src="' + url + '" alt="' + file + '" />\n':''+html+'';
   }
    });
   var textarea = $('#text');
   textarea.replaceSelection(html);return false;
    }

    function chaquan () {
   var html='';
 $("#file-list li .insert").each(function(){
   var t = $(this), p = t.parents('li');
   var file=t.text();
   var url= p.data('url');
   var isImage= p.data('image');
   if ($("input[name='markdown']").val()==1) {
   html = isImage ? html+'':html+'\n['+file+'](' + url + ')\n';
   }else{
   html = isImage ? html+'':html+'<a href="' + url + '"/>' + file + '</a>\n';
   }
    });
   var textarea = $('#text');
   textarea.replaceSelection(html);return false;
    }
function filter_method(text, badword){
    //获取文本输入框中的内容
    var value = text;
    var res = '';
    //遍历敏感词数组
    for(var i=0; i<badword.length; i++){
        var reg = new RegExp(badword[i],"g");
        //判断内容中是否包括敏感词		
        if (value.indexOf(badword[i]) > -1) {
            $('#tags').tokenInput('add', {id: badword[i], tags: badword[i]});
        }
    }
    return;
}
var badwords = [<?php echo $tag; ?>];
function chatag(){
var textarea=$('#text').val();
filter_method(textarea, badwords); 
}
  $(document).ready(function(){
    $('#file-list').after('<div class="Posthelper"><a class="w-100" onclick=\"chaall()\" style="background: #467B96;background-color: #3c6a81;text-align: center; padding: 5px 0; color: #fbfbfb; box-shadow: 0 1px 5px #ddd;">插入所有图片</a><a class="w-100" onclick=\"chaquan()\" style="background: #467B96;background-color: #3c6a81;text-align: center; padding: 5px 0; color: #fbfbfb; box-shadow: 0 1px 5px #ddd;">插入所有非图片附件</a></div>');
    $('#tags').after('<div style="margin-top: 35px;" class="Posthelper"><ul style="list-style: none;border: 1px solid #D9D9D6;padding: 6px 12px; max-height: 240px;overflow: auto;background-color: #FFF;border-radius: 2px;margin-bottom: 0;"><?php echo $taglist; ?></ul><a class="w-100" onclick=\"chatag()\" style="background: #467B96;background-color: #3c6a81;text-align: center; padding: 5px 0; color: #fbfbfb; box-shadow: 0 1px 5px #ddd;">检测内容插入标签</a></div>');
  }); 
  </script>
<?php
    }
}