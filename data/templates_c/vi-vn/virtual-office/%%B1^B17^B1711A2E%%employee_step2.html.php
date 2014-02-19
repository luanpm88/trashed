<?php /* Smarty version 2.6.27, created on 2014-01-08 10:44:18
         compiled from employee_step2.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'editor', 'employee_step2.html', 413, false),array('function', 'formhash', 'employee_step2.html', 829, false),array('modifier', 'default', 'employee_step2.html', 840, false),)), $this); ?>
<?php $this->assign('page_title', "Hồ sơ xin việc"); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
<script>
	
	function uploadLogo(item) {
		//alert("uploading......");
		$(\'#upload_logo_form\').submit();
		$(\'#EmployeeAvatar img\').css(\'opacity\',\'0.3\');
	}
	
	function changeLogo(image) {
		//alert("Thay logo thành công");
		$(\'#EmployeeAvatar img\').css(\'opacity\',\'1\');
		d = new Date();
		$(\'#EmployeeAvatar\').html(\'<img alt="(tỉ lệ: 1.2 x 1 - VD: 600 x 500)" title="(tỉ lệ: 1.2 x 1 - VD: 600 x 500)" style="margin-bottom: 0" src="../attachment/\'+image+"?"+d.getTime()+\'" width="230" id="LogoCom" alt="" />\');
		//$(\'#EmployeeAvatar\').html(\'src\', \'../attachment/\'+image+"?"+d.getTime());
		$(\'#EmployeeAvatar img\').resizecrop({
			width:170,
			height:170		   
		});
		
		$(\'#change_logoz a\').html(\''; ?>
<?php echo $this->_tpl_vars['_change_personal_photo']; ?>
<?php echo '\');
		
		'; ?>
<?php if (! $this->_tpl_vars['item']['photo']): ?><?php echo '
			$(\'#image_tmp\').val(image);
		'; ?>
<?php endif; ?><?php echo '
	}
	
	function finishEmployee()
	{
		var ok = true;
		
		if ($(\'tr.skills .employee_boxcontent p.note\').length) {
			if(!$(\'tr.skills .boxerror\').length) $(\'tr.skills .employee_boxcontent\').append(\'<div class="boxerror">Cần bổ sung thông tin</div>\');
			$("html, body").animate({ scrollTop: $(\'tr.skills\').offset().top-10}, 100);
			ok = false;
		}
		else
		{
			$(\'tr.career_objective .boxerror\').remove();
		}
		
		if (!$(\'tr.employeeeducation .boxitem\').length) {
			if(!$(\'tr.employeeeducation .boxerror\').length) $(\'tr.employeeeducation .employee_boxcontent\').append(\'<div class="boxerror">Cần bổ sung thông tin</div>\');
			$("html, body").animate({ scrollTop: $(\'tr.employeeeducation\').offset().top-10}, 100);
			ok = false;
		}
		else
		{
			$(\'tr.career_objective .boxerror\').remove();
		}
		
		if ($(\'tr.career_objective .employee_boxcontent p.note\').length) {
			if(!$(\'tr.career_objective .boxerror\').length) $(\'tr.career_objective .employee_boxcontent\').append(\'<div class="boxerror">Cần bổ sung thông tin</div>\');
			$("html, body").animate({ scrollTop: $(\'tr.career_objective\').offset().top-10}, 100);
			ok = false;
		}
		else
		{
			$(\'tr.career_objective .boxerror\').remove();
		}
		
		if(ok) window.location = "employee.php?do=finish&id='; ?>
<?php echo $_GET['id']; ?>
<?php echo '";
	}
	
	function clearForm(type)
	{
		if (type == "employeeexperience") {		
			$(\'input[name="employeeexperience[job_title]"]\').val("");
			$(\'input[name="employeeexperience[company_name]"]\').val("");
			$(\'select[name="employeeexperience[job_proficiency_id]"]\').val("");
			$(\'select[name="employeeexperience[jobindust_id]"]\').val(0);
			$(\'select[name="employeeexperience[startmonth]"]\').val(0);
			$(\'select[name="employeeexperience[startyear]"]\').val(0);
			$(\'select[name="employeeexperience[endmonth]"]\').val(0);
			$(\'select[name="employeeexperience[endyear]"]\').val(0);
			tinyMCE.get("employeeexperience[content]").setContent("");
			$(\'textarea[name="employeeexperience[content]"]\').html("");
			$(\'input[name="employeeexperience[current]"]\').prop(\'checked\', false);
		} else if (type == "employeeeducation") {
			$(\'input[name="employeeeducation[level_id]"]\').val("");
			$(\'input[name="employeeeducation[school_name]"]\').val("");
			$(\'input[name="employeeeducation[major]"]\').val("");			
			$(\'select[name="employeeeducation[startmonth]"]\').val(0);
			$(\'select[name="employeeeducation[startyear]"]\').val(0);
			$(\'select[name="employeeeducation[endmonth]"]\').val(0);
			$(\'select[name="employeeeducation[endyear]"]\').val(0);
			tinyMCE.get("employeeeducation[content]").setContent("");
			$(\'textarea[name="employeeeducation[content]"]\').html("");
			$(\'input[name="employeeeducation[current]"]\').prop(\'checked\', false);
		} else if (type == "employeereference") {
			$(\'input[name="employeereference[name]"]\').val("");
			$(\'input[name="employeereference[title]"]\').val("");
			$(\'input[name="employeereference[company]"]\').val("");
			$(\'input[name="employeereference[email]"]\').val("");
			$(\'input[name="employeereference[phone]"]\').val("");
		}
	}
	
	function showEditForm(type, boxid)
	{
		if (type == "employeeexperience") {
			$(\'tr[rel="employeeexperience"] label\').remove();
			var formdata = $(\'tr[rel="employeeexperience"] .boxitem[rel="\'+boxid+\'"] .formdata\');
			
			$(\'input[name="employeeexperience[job_title]"]\').val(formdata.find(\'.job_title\').html());
			$(\'input[name="employeeexperience[company_name]"]\').val(formdata.find(\'.company_name\').html());
			$(\'select[name="employeeexperience[job_proficiency_id]"]\').val(formdata.find(\'.job_proficiency_id\').html());
			$(\'select[name="employeeexperience[jobindust_id]"]\').val(formdata.find(\'.jobindust_id\').html());
			$(\'select[name="employeeexperience[startmonth]"]\').val(formdata.find(\'.startmonth\').html());
			$(\'select[name="employeeexperience[startyear]"]\').val(formdata.find(\'.startyear\').html());
			$(\'select[name="employeeexperience[endmonth]"]\').val(formdata.find(\'.endmonth\').html());
			$(\'select[name="employeeexperience[endyear]"]\').val(formdata.find(\'.endyear\').html());
			tinyMCE.get("employeeexperience[content]").setContent(formdata.find(\'.content\').html());
			$(\'textarea[name="employeeexperience[content]"]\').html();
			
			if (formdata.find(\'.current\').html() != "") {
				$(\'input[name="employeeexperience[current]"]\').prop(\'checked\', true);
			}
			else
			{
				$(\'input[name="employeeexperience[current]"]\').prop(\'checked\', false);
			}
			
			$(\'tr[rel="employeeexperience"] form\').append(\'<input id="item_id" type="hidden" name="employeeexperience[id]" value="\'+formdata.find(\'.id\').html()+\'" />\');
			
		} else if (type == "employeeeducation") {
			$(\'tr[rel="employeeeducation"] label\').remove();
			var formdata = $(\'tr[rel="employeeeducation"] .boxitem[rel="\'+boxid+\'"] .formdata\');
			
			$(\'input[name="employeeeducation[level_id]"]\').val(formdata.find(\'.level_id\').html());
			$(\'input[name="employeeeducation[school_name]"]\').val(formdata.find(\'.school_name\').html());
			$(\'input[name="employeeeducation[major]"]\').val(formdata.find(\'.major\').html());			
			$(\'select[name="employeeeducation[startmonth]"]\').val(formdata.find(\'.startmonth\').html());
			$(\'select[name="employeeeducation[startyear]"]\').val(formdata.find(\'.startyear\').html());
			$(\'select[name="employeeeducation[endmonth]"]\').val(formdata.find(\'.endmonth\').html());
			$(\'select[name="employeeeducation[endyear]"]\').val(formdata.find(\'.endyear\').html());
			tinyMCE.get("employeeeducation[content]").setContent(formdata.find(\'.content\').html());
			$(\'textarea[name="employeeeducation[content]"]\').html(formdata.find(\'.content\').html());
			
			if (formdata.find(\'.current\').html() != "") {
				$(\'input[name="employeeeducation[current]"]\').prop(\'checked\', true);
			}
			else
			{
				$(\'input[name="employeeeducation[current]"]\').prop(\'checked\', false);
			}
			
			$(\'tr[rel="employeeeducation"] form\').append(\'<input id="item_id" type="hidden" name="employeeeducation[id]" value="\'+formdata.find(\'.id\').html()+\'" />\');
		} else if (type == "employeereference") {
			$(\'tr[rel="employeereference"] label\').remove();
			var formdata = $(\'tr[rel="employeereference"] .boxitem[rel="\'+boxid+\'"] .formdata\');

			$(\'input[name="employeereference[name]"]\').val(formdata.find(\'.name\').html());
			$(\'input[name="employeereference[title]"]\').val(formdata.find(\'.title\').html());
			$(\'input[name="employeereference[company]"]\').val(formdata.find(\'.company\').html());
			$(\'input[name="employeereference[email]"]\').val(formdata.find(\'.email\').html());
			$(\'input[name="employeereference[phone]"]\').val(formdata.find(\'.phone\').html());
			
			$(\'tr[rel="employeereference"] form\').append(\'<input id="item_id" type="hidden" name="employeereference[id]" value="\'+formdata.find(\'.id\').html()+\'" />\');
		}
		$(\'tr[rel="\'+type+\'"] a.add_button\').parent().find(\'.employee_boxcontent\').hide();
		$(\'tr[rel="\'+type+\'"] a.add_button\').hide();
		$(\'tr[rel="\'+type+\'"] a.add_button\').parent().find(\'.editor\').removeClass("hide");
	}
	
	function updateMoveUpDown()
	{
		$(\'.list_item_employeebox\').each(function() {
			$(this).find(\'.boxitem\').find("a").css("display","inline");
			$(this).find(\'.boxitem\').first().find("a.up").css("display","none");
			$(this).find(\'.boxitem\').last().find("a.down").css("display","none");
		});
	}
	
        //alert("sdfsdfsdfs");
	jQuery(document).ready(function($) {
	        
		$(\'.MenuItem31\').addClass(\'mActive\');
		
		$(\'.rowbox a.add_button\').click(function() {
			$(this).parent().find(\'.employee_boxcontent\').hide();
			$(this).hide();
			$(this).parent().find(\'.editor\').removeClass("hide");
			
			if($(this).parent().find(\'.editor form #item_id\').length)
			{
				$(\'.editor form #item_id\').remove();
				clearForm($(this).parent().parent().attr("rel"));
			}
		});
		
		$(\'.rowbox .editor .close_button\').click(function() {
			$(this).parent().parent().find(\'.employee_boxcontent\').show();
			$(this).parent().parent().find(\'a.add_button\').show();
			$(this).parent().addClass("hide");
		});
		
		$(\'.rowbox .editor .save_button\').click(function() {
			//save mce content
			if($(this).parent().find(\'form textarea\').length) $(this).parent().find(\'form textarea\').val(tinyMCE.get($(this).parent().find(\'form textarea\').attr("name")).getContent());
			var typename = $(this).parent().parent().parent().attr("rel");
			
			var result = true;
			$(this).parent().find(\'form .required\').each(function(){
				if($(this).val() == "" || $(this).val() == "0")
				{					
					if(!$(this).parent().find("label").length) $(this).after(\'<label for="" class="errorz">Nội dung yêu cầu</label>\');
					result = false;
				}
				else
				{
					$(this).parent().find("label").remove();
				}
			});
			
			$(this).parent().find(\'form .selectgroup_required\').each(function(){
				if(($(this).find(\'select\').eq(0).val() == "0" || $(this).find(\'select\').eq(1).val() == "0") && !$(this).find("input").is(\':checked\')) {					
					if(!$(this).find("label").length) $(this).append(\'<label for="" class="errorz">Nội dung yêu cầu</label>\');
					result = false;
				}
				else
				{
					$(this).find("label").remove();
				}
			});
			
			//check for work time
			if ($(this).parent().find(\'form select[name="\'+typename+\'[startyear]"]\').length) {
				var startmonth = $(this).parent().find(\'form select[name="\'+typename+\'[startmonth]"]\').val();
				var startyear = $(this).parent().find(\'form select[name="\'+typename+\'[startyear]"]\').val();
				var endmonth = $(this).parent().find(\'form select[name="\'+typename+\'[endmonth]"]\').val();
				var endyear = $(this).parent().find(\'form select[name="\'+typename+\'[endyear]"]\').val();
				
				if (startmonth != "0" && startyear != "0" && endmonth != "0" && endyear != "0") {
					if (
						((endyear < startyear) ||
						(endyear == startyear && startmonth >= endmonth))
						&& !$(this).parent().find(\'input[name="\'+typename+\'[current]"]\').is(\':checked\')
						
					) {
						//alert($(this).parent().find(\'form input[name="employeeexperience[current]"]\').val());
						if(!$(this).parent().find(\'form .selectgroup\').find("label").length)
							$(this).parent().find(\'form .selectgroup\').eq(1).append(\'<label for="" class="errorz">Ngày kết thúc phải lớn hơn ngày bắt đầu</label>\');
						result = false;
					}
					else
					{
						$(this).parent().find(\'form .selectgroup\').find("label").remove();
					}
				}
			}
			
			if(result) $(this).parent().find(\'form\').submit();
		});
		
		$(".rowbox .editor form").on("submit",function (event) {
			event.preventDefault();
			
			//$(this).find(\'textarea\').val(tinyMCE.get($(this).find(\'textarea\').attr("name")).getContent());
			$(this).parent().prepend(\'<div class="saving"></div>\');
			$(this).parent().find(\'.saving\').height($(this).parent().height()+20);
			
			var formData = $(this).serialize();
			//alert(formData);
			$.ajax(
			{
			    type:\'post\',
			    url:\'../index.php?do=employee&action=update_step2\',
			    data:formData+"&order="+$(this).parent().parent().find(".list_item_employeebox .boxitem").length,
			    //encoding:"UTF-8",
			    beforeSend:function()
			    {				
			    },
			    complete:function()
			    {				
			    },
			    success:function(result)
			    {
				//alert(result);
				result = jQuery.parseJSON(result);
				
				$(\'.\'+result[0]+\' .employee_boxcontent\').html(result[1].replace(/\\\\/g, \'\'));
				$(\'.\'+result[0]+\' .close_button\').trigger("click");
				$(\'.\'+result[0]+\' .editor\').find(".saving").remove();
				
				$(\'.\'+result[0]+\' a.single\').html(\'Cập nhật\');
				
				updateMoveUpDown();
				clearForm(result[0]);			
			    }
			});
		});
		
		$(\'.employee_meminfo img\').resizecrop({
			width:170,
			height:170	   
		});
		
		//controls
		updateMoveUpDown();
		$(\'.list_item_employeebox .boxitem .controls a.delete\').live("click", function() {
			//alert($(this).parent().parent().attr("rel"));
			
			$(this).hide();
			$(this).parent().parent().css("background", "red");
			
			var ok = confirm("Bạn có chắc là muốn xóa mục này");
			
			if (ok) {
				id = $(this).parent().parent().attr("rel");
				var type = $(this).parent().parent().parent().parent().parent().parent().attr("rel");				
				
				$.ajax(
				{
				    type:\'post\',
				    url:\'../index.php?do=employee&action=delete_employeeitem\',
				    data: "id="+id+"&type="+type,				    
				    success:function(result)
				    {
					if(result != "0")
					{						
						if ($(\'tr[rel="\'+type+\'"] .list_item_employeebox .boxitem\').length == 1) {
							var contain = $(\'tr[rel="\'+type+\'"] .list_item_employeebox .boxitem[rel="\'+result+\'"]\').parent().parent().parent();
							contain.find(".employee_boxcontent").html(contain.find(".boxnote").html());
						}
						$(\'tr[rel="\'+type+\'"] .list_item_employeebox .boxitem[rel="\'+result+\'"]\').remove();
						
						updateMoveUpDown();
					}
				    }
				});
			}
			else
			{
				$(this).show();
				$(this).parent().parent().css("background", "none");
			}
		});
		
		$(\'.list_item_employeebox .boxitem .controls a.down\').live("click", function() {
			$(this).css("display","none");
			
			id = $(this).parent().parent().attr("rel");
			var type = $(this).parent().parent().parent().parent().parent().parent().attr("rel");
			
			$.ajax(
			{
			    type:\'post\',
			    url:\'../index.php?do=employee&action=change_order\',
			    data: "id="+id+"&type="+type+"&to=down",				    
			    success:function(result)
			    {
				if (result != "0") {
					var current = $(\'tr[rel="\'+type+\'"] .list_item_employeebox .boxitem[rel="\'+result+\'"]\');
					
					current.next().after(current.clone());
					current.remove();
					
					updateMoveUpDown();
				}
			    }
			});
		});
		
		$(\'.list_item_employeebox .boxitem .controls a.up\').live("click", function() {
			$(this).css("display","none");
			
			id = $(this).parent().parent().attr("rel");
			var type = $(this).parent().parent().parent().parent().parent().parent().attr("rel");
			
			$.ajax(
			{
			    type:\'post\',
			    url:\'../index.php?do=employee&action=change_order\',
			    data: "id="+id+"&type="+type+"&to=up",				    
			    success:function(result)
			    {
				if (result != "0") {
					var current = $(\'tr[rel="\'+type+\'"] .list_item_employeebox .boxitem[rel="\'+result+\'"]\');
					
					current.prev().before(current.clone());
					current.remove();
					
					updateMoveUpDown();
				}
			    }
			});
		});
		
		$(\'.list_item_employeebox .boxitem .controls a.edit\').live("click", function() {
			showEditForm($(this).parent().parent().parent().parent().parent().parent().attr("rel"), $(this).parent().parent().attr("rel"));
			//alert($(this).parent().parent().parent().parent().parent().parent().attr("rel"));
			//alert($(this).parent().parent().attr("rel"));
		});
		
		$(\'#change_logoz a\').click(function() {
				//alert("sdfsdf");
				$(\'#change_logo_but\').trigger(\'click\');
			});
			
			$(\'#change_logo_but\').change(function() {
				//$(\'#company_top_info #EmployeeAvatar\').html(\'<p>Logo đã được thay đổi. Bạn phải lưu thông tin để thấy logo mới.</p>\');		
				uploadLogo(this);
			});
	});

</script>
'; ?>

<script src="../scripts/jquery/jquery.textbox.js" charset="<?php echo $this->_tpl_vars['charset']; ?>
"></script>
<?php echo smarty_function_editor(array('type' => 'tiny_mce'), $this);?>


<div class="wrap clearfix">
	<div class="sidebar">
	   <div class="sidebar_menu">
	     <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "menu.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	   </div>
	</div>
	<div class="main_content employee_edit">
		<div class="blank"></div>
		    <div class="offer_banner"><img src="<?php echo $this->_tpl_vars['office_theme_path']; ?>
images/offer_01.gif" /></div>
		<div class="offer_info_title"><h2><?php echo $this->_tpl_vars['page_title']; ?>
</h2></div>
		<div class="hint"><?php echo $this->_tpl_vars['_must_input_with_star']; ?>
</div>
			
			<div class="employee_steps">
				<a href="employee.php?do=edit&id=<?php echo $this->_tpl_vars['item']['id']; ?>
"><span>1</span>Thông tin chung</a>
				<a class="active" href="#" <?php if (! $this->_tpl_vars['item']['id']): ?>class="notyet"<?php endif; ?>><span>2</span>Hồ sơ chi tiết</a>
			</div>
			<br />
			<table>
				<tr>
					<td colspan="2">
						<div class="employee_meminfo">
							<div style="margin-top: 5px;" id="change_logoz" class="emploee-avatar-but">
								<a href="javascript:void(0)"><?php echo $this->_tpl_vars['_change_personal_photo']; ?>
</a>
							</div>
							<input id="com_pic" style="margin-bottom: 5px;position: absolute;margin-left: -50000px" name="photo" type="file" id="MemberPhoto" size="32" onchange="document.getElementById('EmployeeAvatar').innerHTML='<img src=\''+this.value+'\' width=117 height=63>'">
							<div id="EmployeeAvatar" style="float: left"><img src="<?php echo $this->_tpl_vars['memberinfo']['photo']; ?>
" /></div>
							<p><label>Họ và Tên</label>: &nbsp;<?php echo $this->_tpl_vars['memberinfo']['first_name']; ?>
 <?php echo $this->_tpl_vars['memberinfo']['last_name']; ?>
</p>
							<p><label>Giới tính</label>: &nbsp;<?php if ($this->_tpl_vars['memberinfo']['gender']): ?>Nam<?php else: ?>Nữ<?php endif; ?></p>
							<p><label>Địa chỉ</label>: &nbsp;<?php echo $this->_tpl_vars['memberinfo']['address']; ?>
</p>
							<p><label>Điện thoại</label>: &nbsp;<?php echo $this->_tpl_vars['memberinfo']['mobile']; ?>
</p>
							<p><label>Email</label>: &nbsp;<?php echo $this->_tpl_vars['memberinfo']['email']; ?>
</p>
							<p>
								<a style="margin-top: 23px;" class="add_button language_add_button single" href="personal.php" target="_blank">
									(Chỉnh sửa thông tin liên hệ)</a>
							</p>
						</div>
						
					</td>
				</tr>
				<tr class="rowbox career_objective" rel="career_objective">
					<th valign="top">Mục tiêu nghề nghiệp<font class="red">*</font></th>
					<td>
						<div class="employee_boxcontent">
							<?php if ($this->_tpl_vars['item']['career_objective']): ?>
								<?php echo $this->_tpl_vars['item']['career_objective']; ?>

							<?php else: ?>
								<p class="note">Mô tả ngắn gọn công việc mong muốn và vì sao bạn muốn làm công việc này.</p>
							<?php endif; ?>
						</div>
						<div class="editor hide">
							<form>
								<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>
" />
								<input type="hidden" name="item" value="career_objective" />
								<textarea name="employee[career_objective]" class="required"><?php echo $this->_tpl_vars['item']['career_objective']; ?>
</textarea>
							</form>
							<button class="button close_button">Đóng</button>
							<button class="button save_button">Lưu</button>
						</div>
						<a class="add_button language_add_button single" href="javascript:void(0)">
							<?php if ($this->_tpl_vars['item']['career_objective']): ?>
								Cập nhật
							<?php else: ?>
								<span>+</span> Bổ sung
							<?php endif; ?>							
						</a>
					</td>
				</tr>
				<tr class="rowbox career_highlight" rel="career_highlight">
					<th valign="top">Thành tích nổi bật</th>
					<td>
						<div class="employee_boxcontent">
							<?php if ($this->_tpl_vars['item']['career_highlight']): ?>
								<?php echo $this->_tpl_vars['item']['career_highlight']; ?>

							<?php else: ?>
								<p class="note">Tóm tắt những thành tích nổi bật bạn đạt được trong công việc.</p>
							<?php endif; ?>
						</div>
						<div class="editor hide">
							<form>
								<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>
" />
								<input type="hidden" name="item" value="career_highlight" />
								<textarea name="employee[career_highlight]" class="required"><?php echo $this->_tpl_vars['item']['career_highlight']; ?>
</textarea>
							</form>							
							<button class="button close_button">Đóng</button>
							<button class="button save_button">Lưu</button>
						</div>
						<a class="add_button language_add_button single" href="javascript:void(0)">
							<?php if ($this->_tpl_vars['item']['career_highlight']): ?>
								Cập nhật
							<?php else: ?>
								<span>+</span> Bổ sung
							<?php endif; ?>							
						</a>
					</td>
				</tr>
				<tr class="rowbox employeeexperience" rel="employeeexperience">
					<th valign="top">Kinh nghiệm làm việc</th>
					<td>
						<div class="employee_boxcontent">
							<?php if ($this->_tpl_vars['item']['employeeexperience']): ?>
								<?php echo $this->_tpl_vars['item']['employeeexperience']; ?>

							<?php else: ?>
								<p class="note">Mô tả chi tiết:</p>
								<ul class="note">
									<li>Nhiệm vụ chính của từng vị trí bạn đảm trách</li>
		
									<li> Dự án bạn đã tham gia hoặc quản lý (nếu có)</li>
									<li> Thành tích, kỹ năng đạt được </li>
								</ul>
							<?php endif; ?>							
						</div>
						<div class="boxnote" style="display:none">
							<p class="note">Mô tả chi tiết:</p>
							<ul class="note">
								<li>Nhiệm vụ chính của từng vị trí bạn đảm trách</li>
		
								<li> Dự án bạn đã tham gia hoặc quản lý (nếu có)</li>
								<li> Thành tích, kỹ năng đạt được </li>
							</ul>
						</div>
						<div class="editor hide">
							<form>
								<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>
" />
								<input type="hidden" name="item" value="employeeexperience" />
								
									<fieldset>
																				
											<dl class="formRow">
												<input type="hidden" name="employeeexperience[id]" id="workexperienceid" value="">
												<dt>Chức danh<font class="red">*</font></dt>
												<dd class="formValue">
													<input class="required" type="text" class="text" maxlength="100" name="employeeexperience[job_title]" id="jobtitle_0" value="" tabindex="">													
												</dd>
							
											</dl>
											<dl class="formRow">
												<dt>Công ty<font class="red">*</font></dt>
												<dd class="formValue">
													<input class="required" type="text" class="text" maxlength="100" name="employeeexperience[company_name]" id="companyname_0" value="" tabindex="">													
												</dd>
											</dl>
											<dl class="formRow">
							
												<dt>Cấp bậc<font class="red">*</font></dt>
												<dd class="formValue">
													<select class="required" name="employeeexperience[job_proficiency_id]" id="joblevelid_0" class="span-7">
														<option value="0">Chọn</option>
															<?php $_from = $this->_tpl_vars['JobProficiencies']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['level_0'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['level_0']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key0'] => $this->_tpl_vars['item0']):
        $this->_foreach['level_0']['iteration']++;
?>
																<option value="<?php echo $this->_tpl_vars['key0']; ?>
"><?php echo $this->_tpl_vars['item0']; ?>
</option>
															<?php endforeach; endif; unset($_from); ?>
													</select>													
												</dd>
											</dl>
											<dl class="formRow">
							
												<dt>Ngành nghề<font class="red">*</font></dt>
												<dd class="formValue">
													<select class="required" name="employeeexperience[jobindust_id]" id="industryid_0" class="span-7">
														<option value="0">Chọn</option>
														<?php echo $this->_tpl_vars['JobindustOptions']; ?>

													</select>													
													
												</dd>
											</dl>
											<dl class="formRow">
							
												<dt>Từ<font class="red">*</font></dt>
												<dd class="formValue selectgroup selectgroup_required">
													<select name="employeeexperience[startmonth]" id="startmonth_0" class="span-3plus select">
														<option value="0">Tháng</option>
														<option value="1">Tháng 1</option><option value="2">Tháng 2</option><option value="3">Tháng 3</option><option value="4">Tháng 4</option><option value="5">Tháng 5</option><option value="6">Tháng 6</option><option value="7">Tháng 7</option><option value="8">Tháng 8</option><option value="9">Tháng 9</option><option value="10">Tháng 10</option><option value="11">Tháng 11</option><option value="12">Tháng 12</option>						</select>
													<select name="employeeexperience[startyear]" id="startyear_0" class="span-3plus select">
														<option value="0">Năm</option>
														<option value="2014">2014</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option>						</select>
													
												</dd>
											</dl>
											<dl class="formRow">
												<dt>Đến<font class="red">*</font></dt>
												<dd class="formValue selectgroup selectgroup_required">
													<select name="employeeexperience[endmonth]" id="endmonth_0" class="span-3plus select">
							
														<option value="0">Tháng</option>                                            
														<option value="1">Tháng 1</option><option value="2">Tháng 2</option><option value="3">Tháng 3</option><option value="4">Tháng 4</option><option value="5">Tháng 5</option><option value="6">Tháng 6</option><option value="7">Tháng 7</option><option value="8">Tháng 8</option><option value="9">Tháng 9</option><option value="10">Tháng 10</option><option value="11">Tháng 11</option><option value="12">Tháng 12</option>						</select>
													<select name="employeeexperience[endyear]" id="endyear_0" class="span-3plus select">
														<option value="0">Năm</option>
														 <option value="2014">2014</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option>						</select>
							
													<input name="employeeexperience[current]" id="current_0" type="checkbox">
													Hiện tại													
												</dd>
											</dl>
											<dl class="formRow">
												<dt>Nhiệm vụ chính &amp; Thành tích nổi bật<font class="red">*</font></dt>
												<dd class="formValue" style="clear: both">
													<textarea name="employeeexperience[content]" class="required"></textarea>													
												</dd>
											</dl>
											
									</fieldset>
								
								
								
								
								
								
								
							</form>
							<button class="button close_button">Đóng</button>
							<button class="button save_button">Lưu</button>
						</div>
						<a class="add_button language_add_button" href="javascript:void(0)"><span>+</span> Bổ sung</a>
					</td>
				</tr>
				<tr class="rowbox employeeeducation" rel="employeeeducation">
					<th valign="top">Học vấn và bằng cấp<font class="red">*</font></th>
					<td>
						<div class="employee_boxcontent">
							<?php if ($this->_tpl_vars['item']['employeeeducation']): ?>
								<?php echo $this->_tpl_vars['item']['employeeeducation']; ?>

							<?php else: ?>
								<p class="note">Liệt kê bằng cấp chuyên môn, các khóa ngắn hạn hay những chương trình sau đại học bạn đã theo học.</p>
							<?php endif; ?>
							
						</div>
						<div class="boxnote" style="display:none">
							<p class="note">Liệt kê bằng cấp chuyên môn, các khóa ngắn hạn hay những chương trình sau đại học bạn đã theo học.</p>
						</div>
						<div class="editor hide">
							<form>
								<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>
" />
								<input type="hidden" name="item" value="employeeeducation" />
								
									<fieldset>
																				
											<dl class="formRow">
												<input type="hidden" name="employeeeducation[id]" id="workexperienceid" value="">
												<dt>Bằng cấp<font class="red">*</font></dt>
												<dd class="formValue">
													<input class="required" type="text" class="text" maxlength="100" name="employeeeducation[level_id]" id="jobtitle_0" value="" tabindex="">													
												</dd>
							
											</dl>
											<dl class="formRow">
												<dt>Trường<font class="red">*</font></dt>
												<dd class="formValue">
													<input class="required" type="text" class="text" maxlength="100" name="employeeeducation[school_name]" id="companyname_0" value="" tabindex="">													
												</dd>
											</dl>
											<dl class="formRow">
							
												<dt>Chuyên ngành</dt>
												<dd class="formValue">
													<input type="text" class="text" maxlength="100" name="employeeeducation[major]" id="companyname_0" value="" tabindex="">													
												</dd>
											</dl>											
											<dl class="formRow">
							
												<dt>Từ</dt>
												<dd class="formValue selectgroup">
													<select name="employeeeducation[startmonth]" id="startmonth_0" class="span-3plus select">
														<option value="0">Tháng</option>
														<option value="1">Tháng 1</option><option value="2">Tháng 2</option><option value="3">Tháng 3</option><option value="4">Tháng 4</option><option value="5">Tháng 5</option><option value="6">Tháng 6</option><option value="7">Tháng 7</option><option value="8">Tháng 8</option><option value="9">Tháng 9</option><option value="10">Tháng 10</option><option value="11">Tháng 11</option><option value="12">Tháng 12</option>						</select>
													<select name="employeeeducation[startyear]" id="startyear_0" class="span-3plus select">
														<option value="0">Năm</option>
														<option value="2014">2014</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option>						</select>
													
												</dd>
											</dl>
											<dl class="formRow">
												<dt>Đến</dt>
												<dd class="formValue selectgroup">
													<select name="employeeeducation[endmonth]" id="endmonth_0" class="span-3plus select">
							
														<option value="0">Tháng</option>                                            
														<option value="1">Tháng 1</option><option value="2">Tháng 2</option><option value="3">Tháng 3</option><option value="4">Tháng 4</option><option value="5">Tháng 5</option><option value="6">Tháng 6</option><option value="7">Tháng 7</option><option value="8">Tháng 8</option><option value="9">Tháng 9</option><option value="10">Tháng 10</option><option value="11">Tháng 11</option><option value="12">Tháng 12</option>						</select>
													<select name="employeeeducation[endyear]" id="endyear_0" class="span-3plus select">
														<option value="0">Năm</option>
														 <option value="2014">2014</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option>						</select>
							
													<input name="employeeeducation[current]" id="current_0" type="checkbox">
													Hiện tại													
												</dd>
											</dl>
											<dl class="formRow">
												<dt>Thông tin liên quan</dt>
												<dd class="formValue" style="clear: both">
													<textarea name="employeeeducation[content]"></textarea>													
												</dd>
											</dl>
											
									</fieldset>
								
								
								
								
								
								
								
							</form>
							<button class="button close_button">Đóng</button>
							<button class="button save_button">Lưu</button>
						</div>
						<a class="add_button language_add_button" href="javascript:void(0)">
							<span>+</span> Bổ sung
						</a>
					</td>
				</tr>
				<tr class="rowbox skills" rel="skills">
					<th valign="top">Kỹ năng nổi bật<font class="red">*</font></th>
					<td>
						<div class="employee_boxcontent">
							<?php if ($this->_tpl_vars['item']['skills']): ?>
								<?php echo $this->_tpl_vars['item']['skills']; ?>

							<?php else: ?>
								<p class="note">Liệt kê những kỹ năng bạn đang có liên quan đến công việc ứng tuyển. Cho nhà tuyển dụng thấy sự khác biệt giữa bạn và các ứng viên khác.</p>
							<?php endif; ?>							
						</div>						
						<div class="editor hide">
							<form>
								<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>
" />
								<input type="hidden" name="item" value="skills" />
								<textarea name="employee[skills]" class="required"><?php echo $this->_tpl_vars['item']['skills']; ?>
</textarea>
							</form>
							<button class="button close_button">Đóng</button>
							<button class="button save_button">Lưu</button>
						</div>
						<a class="add_button language_add_button single" href="javascript:void(0)">
							<?php if ($this->_tpl_vars['item']['skills']): ?>
								Cập nhật
							<?php else: ?>
								<span>+</span> Bổ sung
							<?php endif; ?>							
						</a>
					</td>
				</tr>
				<tr class="rowbox employeereference" rel="employeereference">
					<th valign="top">Thông tin tham khảo</th>
					<td>
						<div class="employee_boxcontent">
							<?php if ($this->_tpl_vars['item']['employeereference']): ?>
								<?php echo $this->_tpl_vars['item']['employeereference']; ?>

							<?php else: ?>
								<p class="note">Những nhận xét từ đồng nghiệp/thầy cô/bạn bè sẽ giúp nhà tuyển dụng hiểu rõ hơn về tính cách và năng lực của bạn. Nên chọn người bạn nghĩ sẽ đưa ra nhận xét tốt.</p>
							<?php endif; ?>							
						</div>
						<div class="boxnote" style="display:none">
							<p class="note">Liệt kê những kỹ năng bạn đang có liên quan đến công việc ứng tuyển. Cho nhà tuyển dụng thấy sự khác biệt giữa bạn và các ứng viên khác.</p>
						</div>
						<div class="editor hide">
							<form>
								<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>
" />
								<input type="hidden" name="item" value="employeereference" />
								
									<fieldset>
																				
											<dl class="formRow">
												<input type="hidden" name="employeereference[id]" id="workexperienceid" value="">
												<dt>Họ và tên<font class="red">*</font></dt>
												<dd class="formValue">
													<input name="employeereference[name]" class="required" type="text" class="text" maxlength="100" id="jobtitle_0" value="" tabindex="">													
												</dd>							
											</dl>
											<dl class="formRow">
												<dt>Chức danh<font class="red">*</font></dt>
												<dd class="formValue">
													<input name="employeereference[title]" class="required" type="text" class="text" maxlength="100" id="jobtitle_0" value="" tabindex="">													
												</dd>
											</dl>
											<dl class="formRow">
												<dt>Công ty<font class="red">*</font></dt>
												<dd class="formValue">
													<input name="employeereference[company]" class="required" type="text" class="text" maxlength="100" id="jobtitle_0" value="" tabindex="">													
												</dd>
											</dl>
											<dl class="formRow">
												<dt>Email<font class="red">*</font></dt>
												<dd class="formValue">
													<input name="employeereference[email]" class="required" type="text" class="text" maxlength="100" id="jobtitle_0" value="" tabindex="">													
												</dd>
											</dl>
											<dl class="formRow">
												<dt>Điện thoại</dt>
												<dd class="formValue">
													<input name="employeereference[phone]" type="text" class="text" maxlength="100" id="jobtitle_0" value="" tabindex="">													
												</dd>
											</dl>											
											
									</fieldset>
								
							</form>
							<button class="button close_button">Đóng</button>
							<button class="button save_button">Lưu</button>
						</div>
						<a class="add_button language_add_button" href="javascript:void(0)"><span>+</span> Bổ sung</a>
					</td>
				</tr>
				
				<tr>
				     
				      <td class="circle_bottomright" colspan="2">
					
						<input name="save" type="submit" id="save" value="Hoàn tất" onclick="finishEmployee()">
						<input name="draft" type="submit" id="draft" value="Lưu tạm" onclick="window=location='employee.php'">
				      </td>
				</tr>
			</table>
	
	</div>
</div>

<div style="display: none">
	<iframe name="upload_logo"  id="upload_logo"></iframe>
	<form target="upload_logo" id="upload_logo_form" enctype="multipart/form-data" action="../index.php?do=product&amp;action=change_ava" method="post" id="Frm1" name="productaddfrm">
	  <?php echo smarty_function_formhash(array(), $this);?>

	  <input type="hidden" value="<?php echo $this->_tpl_vars['MEMBER']['username']; ?>
" name="admin">
	  <input type="hidden" value="<?php echo $this->_tpl_vars['MEMBER']['id']; ?>
" name="com_id">
	  <input type="file" id="change_logo_but" name="upload_logo">
	  <input type="submit" value="tải lên" style="padding: 2px 10px; margin-left: 10px;" class="checkout_but">
	</form>	
</div>

<script>
var cache_path = "../";
var app_language = '<?php echo $this->_tpl_vars['AppLanguage']; ?>
';
var area_id1 = <?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['area_id1'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
 ;
var area_id2 = <?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['area_id2'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
 ;
var area_id3 = <?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['area_id3'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
 ;
var industry_id1 = <?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['industry_id1'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
 ;
var industry_id2 = <?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['industry_id2'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
 ;
var industry_id3 = <?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['industry_id3'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
 ;
var industry_id4 = <?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['industry_id4'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
 ;
var jobtype_id = <?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['jobtype_id'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
 ;
</script>

<script src="../scripts/multi_select.js" charset="<?php echo $this->_tpl_vars['charset']; ?>
"></script>
<script src="../scripts/script_area.js"></script>
<script src="../scripts/script_industry.js"></script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>