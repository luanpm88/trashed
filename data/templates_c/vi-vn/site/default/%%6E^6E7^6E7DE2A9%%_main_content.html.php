<?php /* Smarty version 2.6.27, created on 2014-04-14 08:16:45
         compiled from default/studypost/_main_content.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'the_url', 'default/studypost/_main_content.html', 373, false),array('function', 'formhash', 'default/studypost/_main_content.html', 543, false),)), $this); ?>
<?php echo '
<script type="application/x-javascript">
    
    function showPlaceHolder(editor)
    {
        if (editor.getContent() == "" && editor.id == "studypost-content") {
            $(\'.studypost-content-placeholder\').css("top", $(\'.mce-edit-area\').offset().top+7);
            $(\'.studypost-content-placeholder\').css("left", $(\'.mce-edit-area\').offset().left+6);
            
            $(\'.studypost-content-placeholder\').live("click", function() {
                tinymce.get("studypost-content").focus();
            });
            
            $(\'.studypost-content-placeholder\').show();
            
            setTimeout(function(){$("#studypost-content_ifr").contents().find("body").html("")},0);
        }
        else
        {
            hidePlaceHolder(editor);
        }
        
    }
    
    function hidePlaceHolder(editor)
    {
        if (editor.id == "studypost-content") {
            $(\'.studypost-content-placeholder\').hide();
        }
    }
    
    function deleteStudypostcomment(box)
    {
        var id = box.attr("rel");
        
        $.ajax({   
            url: ROOT_URL+"index.php?do=studypost&action=deleteComment&id="+id,
            success: function(data){
                box.parent().find(".count_current_comment").html(parseInt(box.parent().find(".count_current_comment").html())-1);
                box.remove();
            }
        });
    }
    
    function checkStatsEditor(texta)
    {
            if ($.trim(texta.val()).length > 3 || texta.parent().parent().find(".stars .result").attr("value") != "0") {
                texta.parent().parent().find(".send-button").addClass("active");
            }
            else
            {
                texta.parent().parent().find(".send-button").removeClass("active");
            }
    }
    
    function loadStudyPostCommnets(studypost_id, current_count)
    {
        var count = "";
        if (typeof current_count != "undefined") {
            count = current_count;
            count = $(\'.studypost_box[rel=\'+studypost_id+\'] .comment_list .is_item\').length - 1;
        }
        
        $.ajax({   
            url: ROOT_URL+"index.php?do=studypost&action=ajaxLoadStudypostComments&studypost_id="+studypost_id+"&count="+count,
            success: function(data){
                //alert(data);
                
                $(\'.studypost_box[rel=\'+studypost_id+\'] .comment_list\').html(data);
                
                if (count != "") {
                    $(\'.studypost_box[rel=\'+studypost_id+\'] .count_current_comment\').html(parseInt(count)+10);
                }
            }   
        });  
    }
    
    function postStudypostComment(form)
    {
        $.ajax({   
            type: "POST",            
            url: form.attr("action"),
            data: form.serialize(),
            success: function(data){
                var studypost_id = form.find("input[name=\'comment[studypost_id]\']").val();
                loadStudyPostCommnets(studypost_id);
                
                if (form.parent().find("input[name=\'comment[star]\']").val() != "0") {
                    form.find(".post_star").hide();
                }
                
                form.find("textarea").val("");
                form.find(".stars .star[rel=\'0\']").trigger("click");
                form.find(".stars .star").removeClass("light");                
                
                checkStatsEditor(form.find("textarea"));
            }   
        }); 
    }
    
    function deleteStudypost(id)
    {
        $.ajax({   
            url: ROOT_URL+"index.php?do=studypost&action=delete&id="+id,
            success: function(data){
                //$(\'#studypost-main-content\').html(data);
                hideEditStudypostForm();                
                $(\'.studypost_box[rel=\'+id+\']\').remove();
                load_pos -= 1;
            }   
        }); 
    }
    
    function hideEditStudypostForm()
    {
        var item_des = $(\'.studypost_box .inner-content\');
        var item_src = $(\'.edit_studypost_form\');
        
        item_des.css("visibility","visible");
        item_des.css("height","auto");
        item_src.addClass("hide_editor");
        item_src.css("position","");
        item_src.css("left","");
        
        clearInterval(resizeEditorInterval);
    }
    
    function showEditStudypostForm(id)
    {
        var item_des = $(\'.studypost_box[rel=\'+id+\'] .inner-content\');
        var item_src = $(\'.edit_studypost_form\');
        var editor = tinymce.get(item_src.find(\'textarea\').attr("id"));
        
        item_src.find(\'input[name="studypost[id]"]\').val(id);
        editor.setContent(item_des.html());
        item_src.removeClass("hide_editor");
        item_des.css("visibility","hidden");
        item_src.css("top", item_des.offset().top);
        item_src.css("left", item_des.offset().left);
        item_src.width(item_des.width());
        item_des.height(item_src.height());
        item_src.css("position", "absolute");
        
        
        editor.execCommand(\'mceAutoResize\');
        onChangeEditor(editor, false);
        
        resizeEditorInterval = setInterval(function() {item_des.height(item_src.height());},500);
    }
    
    function clearStudypostForm()
    {
        var editor = tinymce.get(\'studypost-content\');
        $(\'#studypost-content\').val("");
        editor.setContent("");
        showPlaceHolder(editor);
    }
    
    function loadStudyPosts(new_list)
    {
        if (typeof new_list != "undefined")
        {
            $(\'#studypost-main-content\').html("");
            load_pos = 0;
            scroll_enabled = false;
        }
        
        $.ajax({   
            url: ROOT_URL+"index.php?do=studypost&action=ajaxLoadStudyposts&type="+ACTION+"&id="+ID+"&load_pos="+load_pos+"&load_num="+load_num,
            success: function(data){
                $(\'#studypost-main-content\').append(data);
                scroll_enabled = true;
                load_pos += load_num;
            }   
        });
    }
    
    function postStudypost(form)
    {
        var editor = tinymce.get(form.find(\'textarea\').attr("id"));
        form.find(\'textarea\').val(editor.getContent());
        
        $.ajax({
            type: "POST",            
            url: form.attr("action"),
            data: form.serialize(),
            success: function(data){
                clearStudypostForm()
                loadStudyPosts(true);
                $("html, body").animate({ scrollTop: $(\'.studypost_form\').offset().top }, 100);
            }   
        });  
    }
    
    function editStudypost(form)
    {
        
        var editor = tinymce.get(form.find(\'textarea\').attr("id"));
        form.find(\'textarea\').val(editor.getContent());
        
        $.ajax({   
            type: "POST",            
            url: form.attr("action"),
            data: form.serialize(),
            success: function(data){
                clearStudypostForm();
                //loadStudyPosts();
                hideEditStudypostForm();
                var boxid = form.find("input[name=\'studypost[id]\']").val();
                
                $(\'.studypost_box[rel=\'+boxid+\'] .box_content .inner-content\').html(data);
            }   
        });  
    }
    
    function inserEditorFile(url, image) {
        $(\'#uploadIVbutton\').attr(\'disabled\',\'\');
        $(\'#uploadIVbutton\').attr(\'value\',\'Tải ảnh/video\');
        if (image) {
            currentEditor.execCommand(\'mceInsertContent\', false, "<p><img width=\'100%\' src=\''; ?>
<?php echo $this->_tpl_vars['WebRootUrl']; ?>
<?php echo 'attachment/"+url+"\' /></p><p></p>");
            currentEditor.focus();
            
            currentEditor.execCommand(\'mceAutoResize\');
        }
        else
        {
            alert("Video đã được chèn thành công. Sau khi nhấn nút lưu ở dưới, bạn xem video này ở trang chi tiết.");
            currentEditor.execCommand(\'mceInsertContent\', false, \'<video controls width="640" height="360">\'
                                        +\'<source src="'; ?>
<?php echo $this->_tpl_vars['WebRootUrl']; ?>
<?php echo 'attachment/\'+url+\'" type="video/mp4" />\'
                                        +\'Your browser does not support the video tag.</video>\');
            currentEditor.execCommand(\'mceAutoResize\');
        }
        
        //move to last line
        currentEditor.selection.select(currentEditor.getBody(), true); // ed is the editor instance
        currentEditor.selection.collapse(false);
    }
	
    function checkUploadEditorInput() {
        //code
        if($(\'#uploadEditorFile\').val() == \'\')
        {
            $(\'#uploadEditorFile\').css(\'border\', \'solid 1px red\');
            return false;
        } else
        {
            $(\'#uploadEditorFile\').css(\'border\', \'none\');
            $(\'#uploadIVbutton\').attr(\'disabled\',\'disabled\');
            $(\'#uploadIVbutton\').attr(\'value\',\'Đang tải...\');
            return true;
        }
    }
    
    function countWord(string) {
        if (string == \'\') {
            return 0;
        }
        //alert(string.replace(/(<p>|<\\/p>)/g, ""));
        return string.replace(/(<p>|<\\/p>)/g, \'\').replace(/\\n/g,\' \').replace(/\\s(\\s)*/ig,\' \').split(\' \').length;
    }
    
    function onChangeEditor(editor, main)
    {
        var content = editor.getContent();
        
        //salert(editor.parent());
        var box = \'\';
        if (main) {
            box = \'.facelike_postform \';
        }
        else
        {
            box = \'.edit_studypost_form \';
        }
        
        $(box+\'.word-count span\').html(countWord(content));
        
        if (countWord(content) > 2 && content != \'\') {
            $(box+\'.send-button\').addClass("active");
        }
        else
        {            
            $(box+\'.send-button\').removeClass("active");
        }
        
        if ($.trim(content) == \'\') {
            //showPlaceHolder(editor);
        }
        else
        {
            //hidePlaceHolder(editor);
        }
    }
    
    function hideEditorControl()
    {

    }
    
    function showEditor(item, main)
    {
        tinymce.init({
                selector: item,
                plugins: [
                        "autoresize advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "table directionality emoticons template textcolor paste textcolor"
                ],
                language : \'vi_VN\',
        
                toolbar1: "preview code bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | fontselect fontsizeselect | forecolor backcolor",
                toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink image media | preview",
                toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons",
        
                menubar: false,
                toolbar_items_size: \'small\',
        
                style_formats: [
                        {title: \'Bold text\', inline: \'b\'},
                        {title: \'Red text\', inline: \'span\', styles: {color: \'#ff0000\'}},
                        {title: \'Red header\', block: \'h1\', styles: {color: \'#ff0000\'}},
                        {title: \'Example 1\', inline: \'span\', classes: \'example1\'},
                        {title: \'Example 2\', inline: \'span\', classes: \'example2\'},
                        {title: \'Table styles\'},
                        {title: \'Table row 1\', selector: \'tr\', classes: \'tablerow1\'}
                ],
        
                templates: [
                        {title: \'Test template 1\', content: \'Test 1\'},
                        {title: \'Test template 2\', content: \'Test 2\'}
                ],
                
                setup: function(ed) {                            
                            ed.on(\'keypress\', function(e) {
                               onChangeEditor(ed, main);
                            });
                            ed.on(\'keyup\', function(e) {
                               onChangeEditor(ed, main);
                            });
                            ed.on(\'init\', function(e) {
                               $(\'.mce-toolbar-grp\').addClass("editor-hide");
                               onChangeEditor(ed, main);
                               showPlaceHolder(ed);
                            });
                            ed.on(\'change\', function(e) {
                               onChangeEditor(ed, main);                               
                            });
                            ed.on(\'click\', function(e) {
                               onChangeEditor(ed, main);
                            });
                            ed.on(\'focus\', function(e) {
                                var content = ed.getContent();
                                hidePlaceHolder(ed);
                                onChangeEditor(ed, main);
                                if(main) $("#studypost-content_ifr").contents().find("body").addClass("pdb20");
                                if(main) $("#studypost-content_ifr").css("min-height", "80px");
                                if(main) hideEditStudypostForm();
                            });
                            ed.on(\'blur\', function(e) {
                                var content = ed.getContent();
                                showPlaceHolder(ed);
                                onChangeEditor(ed, main);
                            });
                        },
                        
                entity_encoding : "raw",
                autoresize_bottom_margin : 1,
                content_css : "'; ?>
<?php echo $this->_tpl_vars['theme_img_path']; ?>
<?php echo 'css/editorcontent.css"

        });
    }
    
    var ROOT_URL = "'; ?>
<?php echo smarty_function_the_url(array('module' => "root-url"), $this);?>
<?php echo '";
    var currentEditor;
    var resizeEditorInterval;
    var ACTION = "'; ?>
<?php echo $_GET['action']; ?>
<?php echo '";
    if (ACTION == "school") {
        TEXTAREA_STR = \'<p>Đăng tải thông tin cho trường của bạn...</p>\';
    }
    else if(ACTION == "group")
    {
        TEXTAREA_STR = \'<p>Đăng tải thông tin cho nhóm của bạn...</p>\';
    }
    else if (ACTION == "memberpage")
    {
        TEXTAREA_STR = \'<p>Đăng tải thông tin cho trang của bạn...</p>\';
    }
    var ID = "'; ?>
<?php echo $_GET['id']; ?>
<?php echo '";
    $(document).ready(function() {
        
        showEditor(\'#studypost-content\', true);
        showEditor(\'#edit-studypost-content\', false);        
        
        $(\'.show-editor-button\').live("click", function() {
            if ($(this).parent().parent().find(\'.mce-toolbar-grp\').hasClass("editor-hide")) {
                $(this).parent().parent().find(\'.mce-toolbar-grp\').removeClass("editor-hide");
                $(this).addClass("showed");
            }
            else {
                $(this).parent().parent().find(\'.mce-toolbar-grp\').addClass("editor-hide");
                $(this).removeClass("showed");
            }
            var editor = tinymce.get($(this).parent().parent().find("textarea").attr("id"));
            editor.focus();
            $(\'.studypost-content-placeholder\').css("top", $(\'.mce-edit-area\').offset().top+7);
            $(\'.studypost-content-placeholder\').css("left", $(\'.mce-edit-area\').offset().left+6);
        });
        
        $(\'.facelike_postform .send-button.active\').live(\'click\', function() {
            postStudypost($(this).parent().parent());
        });
        
        $(\'.edit_studypost_form .send-button.active\').live(\'click\', function() {
            editStudypost($(this).parent().parent());
        });
        
        //load study posts
        loadStudyPosts(true);
        
        $(\'.add-image-button\').click(function() {
            currentEditor = tinymce.get($(this).parent().parent().find("textarea").attr("id"));
        });
        
        $(\'.studypost_box .box_edit_but\').live("click", function() {
            hideEditStudypostForm();
            showEditStudypostForm($(this).parent().parent().attr(\'rel\'));
        })
        
        $(\'.studypost_box .box_delete_but\').live("click", function() {
            hideEditStudypostForm();
            deleteStudypost($(this).parent().parent().attr(\'rel\'));
        })
        
        $(\'.edit_studypost_form .close-button\').live("click", function() {
            hideEditStudypostForm();
        });
        
        $(\'.post_star .star\').live("mouseover", function() {
            var rel = parseInt($(this).attr("rel"));
            $(this).parent().find(\'.star\').each(function() {
                if (parseInt($(this).attr("rel")) <= rel) {
                    $(this).addClass("light");
                }
                else
                {
                    $(this).removeClass("light");
                }
            });
            $(this).parent().find(\'.result\').html($(this).attr("rel"));
            if ($(this).attr("rel") == "0") {
                $(this).parent().find(\'.result\').html("");
            }
        });
        
        $(\'.post_star .star\').live("mouseout", function() {
            $(this).parent().find(\'.star\').removeClass(\'light\');
            $(this).parent().find(\'.result\').html($(this).parent().find(\'.result\').attr("value"));
            if ($(this).parent().find(\'.result\').attr("value") == "0") {
                $(this).parent().find(\'.result\').html("");
            }
            
            $(this).parent().find(\'.star\').each(function() {
                if (parseInt($(this).attr("rel")) <= parseInt($(this).parent().find(\'.result\').attr("value"))) {
                    $(this).addClass("light");
                }
            });           
        });
        
        $(\'.post_star .star\').live("click", function() {
            $(this).parent().find(\'.result\').attr("value", $(this).attr(\'rel\'));
            $(this).parent().find(\'.result\').html($(this).attr(\'rel\'));
            if ($(this).attr(\'rel\') == "0") {
                $(this).parent().find(\'.result\').html("");
            }
            
            $(this).parent().parent().find("input[name=\'comment[star]\']").val($(this).attr(\'rel\'));
            
            checkStatsEditor($(this).parent().parent().find(\'.editor textarea\'));
        });
        
        //hide show stats
        $(\'.studypost_box .stats ul li a\').live("click",function() {
            //$(\'.tab_item\').css("display","none");
            //$(this).parent().parent().parent().find(\'#\'+$(this).attr("rel")+"_content").css("display","block");
        });
        
        $(\'.studypost_box .actions .send-button\').live("click",function(e) {
            e.preventDefault();
        });
        
        $(\'.studypost_box .actions .send-button.active\').live("click",function(e) {
            var form = $(this).parent().parent();
            postStudypostComment(form);
            e.preventDefault();
        });
        
        $(\'.stats_content .editor textarea\').live("change keyup keydown paste cut copy",function(e) {            
            checkStatsEditor($(this));
        });
        
        $(\'.studypost_box\').live("mouseover",function() {
            checkStatsEditor($(this).find(\'.stats_content .editor textarea\'));
        });
        
        $(\'.comment_item .commentbox_delete_but\').live("click", function() {            
            deleteStudypostcomment($(this).parent().parent());
        })
        
        $(\'.view_morecomment a\').live("click", function() {
            //alert($(this).parent().find(".count_current_comment").html());
            
            loadStudyPostCommnets($(this).parent().parent().parent().parent().attr("rel"), $(this).parent().find(".count_current_comment").html())
        });
        
        $(\'.studypost-content-placeholder\').html(TEXTAREA_STR);
        
        
    });
    
    var scroll_enabled = false;
    var load_pos = 0;
    var load_num = 5;
    $(document).scroll(function(){		
	if(($(document).height()-$(window).height()-$(document).scrollTop()) < 500){
	    if (scroll_enabled) {
		scroll_enabled = false;
		//code
		console.log(\'Scrolled to bottom\');
		
                loadStudyPosts();		
	    }
	}
    });
    
</script>
'; ?>
                        
                        
                        
                        <div class="facelike_content">
                            <?php if ($this->_tpl_vars['belongToGroup'] || $this->_tpl_vars['belongToSchool'] || $this->_tpl_vars['belongToMemberpage']): ?>
                                <div class="facelike_postform">
                                    <form class="studypost_form" method="post" action="<?php echo smarty_function_the_url(array('module' => 'studypost','action' => 'post'), $this);?>
">
                                        <?php echo smarty_function_formhash(array(), $this);?>

                                        <?php if ($_GET['action'] == 'school'): ?>
                                            <input type="hidden" name="studypost[school_id]" value="<?php echo $this->_tpl_vars['school']['id']; ?>
" />
                                        <?php elseif ($_GET['action'] == 'group'): ?>
                                            <input type="hidden" name="studypost[group_id]" value="<?php echo $_GET['id']; ?>
" />
                                        <?php elseif ($_GET['action'] == 'memberpage'): ?>
                                            <input type="hidden" name="studypost[memberpage_id]" value="<?php echo $_GET['id']; ?>
" />
                                        <?php endif; ?>
                                        
                                        <div class="textarea-content">
                                            <div class="top-controls">
                                                <a href="javascript:void(0)" onclick="javascript:document.getElementById('imagefile').click();" class="add-image-button">Tải ảnh/video</a>
                                                <a href="javascript:void(0)" class="show-editor-button">Công cụ soạn thảo</a>
                                            </div>                             
                                            <textarea name="studypost[content]" style="width:100%;height:0px;" id="studypost-content"></textarea>
                                            
                                        </div>
                                        
                                        <div class="bottom-control">
                                            <label class="word-count">Số từ: <span></span></label>
                                            <input type="button" value="Gửi bài" class="send-button" />
                                        </div>
                                    </form>
                                    
                                    <div id="uploadImageVideo" style="margin-top: -595px;">
                                        <iframe style="display: none" id="insertFrame" name="insertFrame" ></iframe>
                                        <form method="POST" action="<?php echo $this->_tpl_vars['SiteUrl']; ?>
index.php?do=product&action=uploadEditorFile" name="insertPicForm" id="insertPicForm" target="insertFrame" enctype="multipart/form-data" onsubmit="return checkUploadEditorInput()">
                                                <input type="hidden" name="do" value="product" />
                                                <input type="hidden" name="action" value="uploadEditorFile" />
                                                <input type="hidden" name="tag" value="studypost_<?php echo $this->_tpl_vars['pb_userinfo']['username']; ?>
_" /> 
                                                <input style="visibility: hidden; position: absolute; top: -20000px" id="imagefile" type="file" name="uploadEditorFile" id="uploadEditorFile" onchange="$('#insertPicForm').submit()" />                                                    
                                        </form>
                                    </div>
                                    
                                </div>
                                <br style="clear: both" />
                                <p class="line-gray">.</p>
                            <?php endif; ?>
                            
                            <div id="studypost-main-content"></div>
                            <div id="studypost-bottom-line-content"></div>
                            
                            <div class="edit_studypost_form hide_editor" style="">
                                <form class="studypost_form" method="post" action="<?php echo smarty_function_the_url(array('module' => 'studypost','action' => 'update'), $this);?>
">
                                    <?php echo smarty_function_formhash(array(), $this);?>

                                    
                                    <?php if ($_GET['action'] == 'school'): ?>
                                        <input type="hidden" name="studypost[school_id]" value="<?php echo $this->_tpl_vars['school']['id']; ?>
" />
                                    <?php elseif ($_GET['action'] == 'group'): ?>
                                        <input type="hidden" name="studypost[group_id]" value="<?php echo $_GET['id']; ?>
" />
                                    <?php endif; ?>
                                    
                                    <input type="hidden" name="studypost[id]" value="" />
                                    
                                    <div class="textarea-content">
                                        <div class="top-controls">
                                            <a href="javascript:void(0)" onclick="javascript:document.getElementById('imagefile').click();" class="add-image-button">Tải ảnh/video</a>
                                            
                                            
                                            <a href="javascript:void(0)" class="show-editor-button">Công cụ soạn thảo</a>
                                        </div>                             
                                        <textarea name="studypost[content]" style="width:100%" id="edit-studypost-content"></textarea>                                
                                    </div>
                                    
                                    <div class="bottom-control">
                                        <label class="word-count">Số từ: <span></span></label>
                                        
                                        <input type="button" value="Đóng" class="close-button" />
                                        <input type="button" value="Lưu lại" class="send-button" />
                                    </div>
                                </form>
                            </div>
                            
                        </div>

<div class="studypost-content-placeholder"></div>