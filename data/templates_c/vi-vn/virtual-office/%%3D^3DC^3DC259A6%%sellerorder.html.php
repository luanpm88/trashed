<?php /* Smarty version 2.6.27, created on 2014-07-09 11:32:54
         compiled from sellerorder.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'formhash', 'sellerorder.html', 24, false),)), $this); ?>
<?php $this->assign('page_title', "Danh sách đơn đặt hàng"); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
<script>
	jQuery(document).ready(function($) {
		$(\'.MenuItem8\').addClass(\'mActive\');
	});
</script>
'; ?>


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
     <div class="main_content">
     <div class="blank"></div>
	 <div class="offer_banner"><img src="<?php echo $this->_tpl_vars['office_theme_path']; ?>
images/offer_01.gif" /></div>
     <div class="offer_info_title"><h2>Danh sách đơn đặt hàng</h2></div>

	  <form name="pmsfrm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>
">
	  <?php echo smarty_function_formhash(array(), $this);?>

       <table class="bglist">
            <tr align="left">
              
              
	      <th style="text-align: left" width="25%"><?php echo $this->_tpl_vars['_buyer']; ?>
</th>
	      <th style="text-align: left" width="20%"><?php echo $this->_tpl_vars['_message']; ?>
</th>
	      <th width="20%"><?php echo $this->_tpl_vars['_time']; ?>
</th>
	      <th width="15%" align="center"><strong><?php echo $this->_tpl_vars['_operation']; ?>
</strong></th>
	      

              
            </tr>
			<?php $_from = $this->_tpl_vars['Items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
            <tr class="bggray read<?php echo $this->_tpl_vars['item']['read']; ?>
">
              

	      <td style="text-align: left" width=10%><a href="sellerorder.php?do=view&id=<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php if ($this->_tpl_vars['item']['first_name']): ?><?php echo $this->_tpl_vars['item']['first_name']; ?>
 <?php echo $this->_tpl_vars['item']['last_name']; ?>
 <?php else: ?><?php echo $this->_tpl_vars['item']['username']; ?>
<?php endif; ?></a></td>
	      <td style="text-align: left" align="left"><?php echo $this->_tpl_vars['item']['message']; ?>
</td>
	      <td><?php echo $this->_tpl_vars['item']['created']; ?>
</td>
	      <td><a href="sellerorder.php?do=view&id=<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['_preview']; ?>
 >></a></td>
              
              
	      
              
            </tr>
			<?php endforeach; else: ?>
				<tr class="no_data info">
				  <td colspan="7">Chưa có đơn đặt hàng</td>
				</tr>
			<?php endif; unset($_from); ?>
            <tr align="center" class="bggray">
              <td colspan="5"><?php echo $this->_tpl_vars['ByPages']; ?>
</td>
            </tr>
        </table>         
	  </form>
   </div>
   </div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>