<?php /* Smarty version 2.6.20, created on 2018-09-11 22:28:31
         compiled from catalog/details.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'catalog/details.tpl', 49, false),)), $this); ?>
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
	
	<link href="/css/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css"  />
</head>
<body>
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<div class="container">
  <div class="content">
    <div class="content-container">
	<div class="content-header">
	<h2 class="content-header-title">Catalog</h2>
	<ol class="breadcrumb">
	<li><a href="/">Home</a></li>
	<li><a href="#"><?php echo $this->_tpl_vars['activeBrand']['brand_name']; ?>
</a></li>
	<li><a href="/catalog/">Catalog</a></li>
	<li><?php if (isset ( $this->_tpl_vars['catalogData'] )): ?><?php echo $this->_tpl_vars['catalogData']['catalog_name']; ?>
<?php else: ?>Add a catalog<?php endif; ?></li>
	<li class="active">Details</li>
	</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
				<?php if (isset ( $this->_tpl_vars['catalogData'] )): ?><?php echo $this->_tpl_vars['catalogData']['catalog_name']; ?>
<?php else: ?>Add a catalog<?php endif; ?>
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/catalog/details.php<?php if (isset ( $this->_tpl_vars['catalogData'] )): ?>?code=<?php echo $this->_tpl_vars['catalogData']['catalog_code']; ?>
<?php endif; ?>" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">
                <div class="form-group">
					<label for="catalog_name">Name</label>
					<input type="text" id="catalog_name" name="catalog_name" class="form-control" data-required="true" value="<?php echo $this->_tpl_vars['catalogData']['catalog_name']; ?>
" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['catalog_name'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['catalog_name']; ?>
</span><?php else: ?><span class="smalltext">Full name of the catalog as it will be seen on the website</span><?php endif; ?>					  
                </div>		
                <div class="form-group">
					<label for="category_code">Category</label>
					<select id="category_code" name="category_code" class="form-control" data-required="true" >
						<option value=""> ------------ </option>
						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['categoryData'],'selected' => $this->_tpl_vars['catalogData']['item_parent_code']), $this);?>

					</select>
					<?php if (isset ( $this->_tpl_vars['errorArray']['category_code'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['category_code']; ?>
</span><?php else: ?><span class="smalltext">The category the catalog is under</span><?php endif; ?>					  
                </div>	
                <div class="form-group">
					<label for="item_code">Section</label>
					<select id="item_code" name="item_code" class="form-control" data-required="true" >
						<option value=""> Select category first </option>
					</select>
					<?php if (isset ( $this->_tpl_vars['errorArray']['item_code'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['item_code']; ?>
</span><?php else: ?><span class="smalltext">Select section of a category if a category has sections under it.</span><?php endif; ?>					  
                </div>				
                <div class="form-group">
					<label for="catalog_text">Description</label>
					<textarea id="catalog_text" name="catalog_text" class="form-control wysihtml5" data-required="true" rows="15"><?php echo $this->_tpl_vars['catalogData']['catalog_text']; ?>
</textarea>
					<?php if (isset ( $this->_tpl_vars['errorArray']['catalog_text'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['catalog_text']; ?>
</span><?php else: ?><span class="smalltext">Short or page description of your catalog.</span><?php endif; ?>					  
                </div>
                <div class="form-group"><button type="submit" class="btn btn-primary">Validate and Submit</button></div>
              </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->	
		<div class="col-sm-3">
			<div class="list-group">  
				<a href="/catalog/" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;List
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<?php if (isset ( $this->_tpl_vars['catalogData'] )): ?>
				<a href="/catalog/details.php?code=<?php echo $this->_tpl_vars['catalogData']['catalog_code']; ?>
" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;Details
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>				
				<a href="/catalog/feature.php?code=<?php echo $this->_tpl_vars['catalogData']['catalog_code']; ?>
" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;Features
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<!--
				<a href="/catalog/price.php?code=<?php echo $this->_tpl_vars['catalogData']['catalog_code']; ?>
" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;Price
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				-->
				<a href="/catalog/media.php?code=<?php echo $this->_tpl_vars['catalogData']['catalog_code']; ?>
" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;Media
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<?php endif; ?>
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

<script type="text/javascript" src="/library/javascript/plugins/wysihtml5/wysihtml5-0.3.js"></script>
<script type="text/javascript" src="/library/javascript/plugins/wysihtml5/bootstrap-wysihtml5.js"></script>
<?php echo '
<script type="text/javascript" language="javascript">

function changeCategory() {
	
	var category = $("#category_code :selected").val();
	
	if(category != \'\') {
		$.ajax({ 
			type: "GET",
			url: "details.php'; ?>
?code=<?php echo $this->_tpl_vars['catalogData']['catalog_code']; ?>
<?php echo '",
			data: "parent_category="+category,
			dataType: "html",
			success: function(data){
				$(\'#item_code\').html(data);
			}
		});			
	}
}

$(document).ready(function(){
	$(\'.wysihtml5\').wysihtml5();	
	changeCategory();
	$("#category_code").change(function(){
		changeCategory();
	});
});
</script>
'; ?>

</html>