<?php /* Smarty version 2.6.20, created on 2018-09-11 22:28:28
         compiled from default.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'default.tpl', 32, false),)), $this); ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<title>Management System</title>
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
      <div class="row">
        <div class="col-md-12">
          <div class="portlet">
            <div class="portlet-header">
              <h3><i class="fa fa-calendar"></i>Administration</h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">
				<p>Please select an brand  before before we continue.</p>
				<?php if (isset ( $this->_tpl_vars['activeBrand'] )): ?><p>Select brand is: <span class="success"><?php echo $this->_tpl_vars['activeBrand']['brand_name']; ?>
</span></p><?php endif; ?>
                <div class="form-group">
					<label for="brand_code">Select an supplier</label>
					<select id="brand_code" name="brand_code" class="form-control">
						<option value=""> ---- </option>
						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['brandPairs'],'selected' => $this->_tpl_vars['brand']), $this);?>

					</select>
					<?php if (isset ( $this->_tpl_vars['errorArray']['brand_code'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['brand_code']; ?>
</span><?php endif; ?>
                </div>			
				<div class="form-group"><button type="submit" class="btn btn-primary">Select brand</button></div>				
			  </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col-md-8 -->
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</html>