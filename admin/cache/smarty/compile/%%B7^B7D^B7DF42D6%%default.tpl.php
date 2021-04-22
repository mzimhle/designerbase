<?php /* Smarty version 2.6.20, created on 2018-02-06 08:46:33
         compiled from dashboard/brand/default.tpl */ ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<title>DesignerBase System</title>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/css.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</head>
<body>
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<div class="container">
  <div class="content">
    <div class="content-container">
	<div class="content-header">
		<h2 class="content-header-title">Brands</h2>
		<ol class="breadcrumb">
			<li><a href="/">Home</a></li>
			<li><a href="/dashboard/">Dashboard</a></li>
			<li class="active">Brands</li>
		</ol>
	</div>	
      <div class="row">
        <div class="col-sm-12">
		<button class="btn btn-secondary fr" type="button" onclick="link('/dashboard/brand/details.php'); return false;">Add a new Brand</button><br/ ><br />
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
				Brands
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/dashboard/brand/" method="POST" data-validate="parsley" class="form parsley-form">			
				<table class="table table-bordered">	
					<thead>
						<tr>
							<td></td>
							<td>Profile</td>
							<td>Name</td>
							<td>Email</td>
							<td>Number</td>
							<td>Delivery Time</td>
							<td>Twitter</td>
							<td>Instagram</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					<?php $_from = $this->_tpl_vars['brandData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
						<tr>
							<td>
								<?php if ($this->_tpl_vars['item']['media_path'] == ''): ?><img src="/images/avatar.jpg" width="80" /><?php else: ?><img src="<?php echo $this->_tpl_vars['config']['site']; ?>
<?php echo $this->_tpl_vars['item']['media_path']; ?>
tny_<?php echo $this->_tpl_vars['item']['media_code']; ?>
<?php echo $this->_tpl_vars['item']['media_ext']; ?>
" width="80" /><?php endif; ?>
							</td>
							<td><a href="https://www.designerbase.co.za/<?php echo $this->_tpl_vars['item']['brand_url']; ?>
" target="_blank"><?php echo $this->_tpl_vars['item']['brand_url']; ?>
</a></td>
							<td><a href="/dashboard/brand/details.php?code=<?php echo $this->_tpl_vars['item']['brand_code']; ?>
"><?php echo $this->_tpl_vars['item']['brand_name']; ?>
</a></td>
							<td><?php echo $this->_tpl_vars['item']['brand_email']; ?>
</td>
							<td><?php echo $this->_tpl_vars['item']['brand_number']; ?>
</td>
							<td><?php echo $this->_tpl_vars['item']['brand_delivery']; ?>
</td>
							<td><?php echo $this->_tpl_vars['item']['brand_social_twitter']; ?>
</td>
							<td><?php echo $this->_tpl_vars['item']['brand_social_instagram']; ?>
</td>
							<td><button value="Delete" class="btn btn-danger" onclick="deleteModal('<?php echo $this->_tpl_vars['item']['brand_code']; ?>
', '', 'default'); return false;">Delete</button></td>
						</tr>			     
					<?php endforeach; else: ?>
						<tr>
							<td align="center" colspan="8">There are currently no items</td>
						</tr>					
					<?php endif; unset($_from); ?>
					</tbody>					  
				</table>
              </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->				
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</html>