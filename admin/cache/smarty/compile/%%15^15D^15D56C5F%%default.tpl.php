<?php /* Smarty version 2.6.20, created on 2018-01-29 14:31:22
         compiled from template/default.tpl */ ?>
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
		<h2 class="content-header-title">Template</h2>
		<ol class="breadcrumb">
			<li><a href="/">Home</a></li>
			<li><a href="#">Template</a></li>
			<li class="active">List</li>
		</ol>
	</div>	
      <div class="row">
        <div class="col-sm-12">
		<button class="btn btn-secondary fr" type="button" onclick="link('/template/details.php'); return false;">Add a new template</button><br/ ><br />
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					template list
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/dashboard/brand/" method="POST" data-validate="parsley" class="form parsley-form">			
				<table class="table table-bordered">	
					<thead>
						<tr>
							<td>Code</td>
							<td>Type</td>
							<td>Category</td>
							<td>View</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					<?php $_from = $this->_tpl_vars['templateData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
						<tr>
							<td><a href="/template/details.php?code=<?php echo $this->_tpl_vars['item']['template_code']; ?>
"><?php echo $this->_tpl_vars['item']['template_code']; ?>
</a></td>
							<td><?php echo $this->_tpl_vars['item']['template_type']; ?>
</td>
							<td><?php echo $this->_tpl_vars['item']['template_category']; ?>
</td>
							<td><a href="/template/view.php?code=<?php echo $this->_tpl_vars['item']['template_code']; ?>
" target="_blank">View</a></td>
							<td><button value="Delete" class="btn btn-danger" onclick="deleteModal('<?php echo $this->_tpl_vars['item']['template_code']; ?>
', '', 'default'); return false;">Delete</button></td>
						</tr>			     
					<?php endforeach; else: ?>
						<tr>
							<td align="center" colspan="4">There are currently no items</td>
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