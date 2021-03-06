<?php /* Smarty version 2.6.20, created on 2018-01-12 10:40:28
         compiled from dashboard/brand/media.tpl */ ?>
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
		<h2 class="content-header-title"><?php echo $this->_tpl_vars['brandData']['brand_name']; ?>
</h2>
		<ol class="breadcrumb">
        	<li><a href="/">Home</a></li>
        	<li><a href="/dashboard/">Dashboard</a></li>
        	<li><a href="/dashboard/brand/">Brands</a></li>
        	<li><?php echo $this->_tpl_vars['brandData']['brand_name']; ?>
</li>
        	<li class="active">Media</li>
		</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					Media list
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/dashboard/brand/media.php?code=<?php echo $this->_tpl_vars['brandData']['brand_code']; ?>
" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">			
				<p>Below is a list of brand images.</p>
				<table class="table table-bordered">	
					<thead>
						<tr>
							<td>Image</td>
							<td></td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					<?php $_from = $this->_tpl_vars['mediaData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
						<tr>
							<td>
								<a href="<?php echo $this->_tpl_vars['config']['site']; ?>
<?php echo $this->_tpl_vars['item']['media_path']; ?>
/big_<?php echo $this->_tpl_vars['item']['media_code']; ?>
<?php echo $this->_tpl_vars['item']['media_ext']; ?>
" target="_blank">
									<img src="<?php echo $this->_tpl_vars['config']['site']; ?>
<?php echo $this->_tpl_vars['item']['media_path']; ?>
/tny_<?php echo $this->_tpl_vars['item']['media_code']; ?>
<?php echo $this->_tpl_vars['item']['media_ext']; ?>
" width="60" />
								</a>
							</td>
							<td>
								<?php if ($this->_tpl_vars['item']['media_primary'] == '0'): ?>
									<button value="Make Primary" class="btn btn-danger" onclick="statusSubModal('<?php echo $this->_tpl_vars['item']['media_code']; ?>
', '1', 'media', '<?php echo $this->_tpl_vars['brandData']['brand_code']; ?>
'); return false;">Primary</button>
								<?php else: ?>
								<b>Primary</b>
								<?php endif; ?>
							</td>
							<td>
								<?php if ($this->_tpl_vars['item']['media_primary'] == '0'): ?>
									<button value="Delete" class="btn btn-danger" onclick="deleteModal('<?php echo $this->_tpl_vars['item']['media_code']; ?>
', '<?php echo $this->_tpl_vars['brandData']['brand_code']; ?>
', 'media'); return false;">Delete</button>
								<?php else: ?>
									<b>Primary</b>
								<?php endif; ?>
							</td>
						</tr>			     
					<?php endforeach; else: ?>
						<tr>
							<td align="center" colspan="3">There are currently no items</td>
						</tr>					
					<?php endif; unset($_from); ?>
					</tbody>					  
				</table>
				<p>Add new image below</p>		
                <div class="form-group">
					<label for="mediafiles">Image Upload</label>
					<input type="file" id="mediafiles[]" name="mediafiles[]" multiple />
					<?php if (isset ( $this->_tpl_vars['errorArray'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']; ?>
</span><?php endif; ?>
					<br /><span>N.B.: If your media are too big and being cropped, please use the windows software "Paint" or "Microsoft Office Picture Manager" to resize them to at least be 430px in width and 590px in height at least.</span>
                </div>	
                <div class="form-group"><button type="submit" class="btn btn-primary">Upload and Save</button></div>
              </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->		
		<div class="col-sm-3">
			<div class="list-group">  
				<a href="/dashboard/brand/" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;List
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a href="/dashboard/brand/details.php?code=<?php echo $this->_tpl_vars['brandData']['brand_code']; ?>
" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;Details
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a href="/dashboard/brand/media.php?code=<?php echo $this->_tpl_vars['brandData']['brand_code']; ?>
" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;Images
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>			
			</div> <!-- /.list-group -->
		</div>		
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</html>