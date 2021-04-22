<?php /* Smarty version 2.6.20, created on 2018-09-11 12:29:10
         compiled from dashboard/feature/default.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'dashboard/feature/default.tpl', 56, false),)), $this); ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<title>DesignerBase Account Management System</title>
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
		<h2 class="content-header-title">Features</h2>
		<ol class="breadcrumb">
			<li><a href="/">Home</a></li>
			<li><a href="#">Dashboard</a></li>
			<li class="active">Features</li>
		</ol>
	</div>	
      <div class="row">
        <div class="col-sm-12">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					Features
              </h3>
            </div> <!-- /.portlet-header -->
			<div class="portlet-content">	
				<div class="col-sm-6">
					<div class="form-group">
						<label for="filter_type">Search by type</label>
						<select class="form-control" id="filter_type" name="filter_type">
							<option value="COLOUR"> COLOUR </option>
							<option value="SIZE"> SIZE </option>
							<option value="GENDER"> GENDER </option>
							<option value="MATERIAL"> MATERIAL </option>
						</select>
					</div>
					<div class="form-group">
						<label for="filter_text">Search by name and value</label>
						<input type="text" class="form-control" id="filter_text" name="filter_text" size="60" value="" />
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label for="filter_cipher">Search by cipher</label>
						<select class="form-control" id="filter_cipher" name="filter_cipher">
							<option value=""> -----  </option>
							<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['selectCipher']), $this);?>
						
						</select>
					</div>					
					<div class="form-group">
						<label for="filter_variable">Search by variable</label>
						<select class="form-control" id="filter_variable" name="filter_variable">
							<option value=""> -----  </option>
							<option value="WIDTH"> WIDTH </option>
							<option value="HEIGHT"> HEIGHT </option>
							<option value="WAIST"> WAIST </option>
							<option value="LENGTH"> LENGTH ( e.g. shoe size ) </option>
						</select>
					</div>					
				</div>	
				<div class="col-sm-12">				
					<div class="form-group">
						<button type="button" onClick="getAll();" class="btn btn-primary">Search</button>
						<button type="button" onClick="getReset();" class="btn">Reset</button>
					</div>
					<div id="tableContent">Loading catalogs details..... Please wait...</div>	
				</div>				
			</div>
            <div class="portlet-content">		
				<form id="validate-basic" action="/dashboard/feature/" method="POST" data-validate="parsley" class="form parsley-form" data-validate="parsley" enctype="multipart/form-data">
					<div class="col-sm-12">						  
						<p>Add a new feature below</p>	
						<div class="form-group">
							<label for="item_type">Type</label>
							<select id="item_type" name="item_type" class="form-control">
								<option value=""> ------- </option>
								<option value="COLOUR"> COLOUR </option>
								<option value="SIZE"> SIZE </option>
								<option value="GENDER"> GENDER </option>
								<option value="MATERIAL"> MATERIAL </option>
							</select>
							<?php if (isset ( $this->_tpl_vars['errorArray']['item_type'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['item_type']; ?>
</span><?php else: ?><span class="smalltext">Type of the feature</span><?php endif; ?>					  
						</div>
						<div class="form-group" id="item_cipher_group">
							<label for="item_cipher" id="item_cipher_label">Cipher</label>
							<select id="item_cipher" name="item_cipher" class="form-control">
								<option value=""> -----  </option>
								<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['selectCipher']), $this);?>

							</select>
							<?php if (isset ( $this->_tpl_vars['errorArray']['item_cipher'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['item_cipher']; ?>
</span><?php else: ?><span class="smalltext">Code of the feature</span><?php endif; ?>					  
						</div>
						<div class="form-group" id="item_variable_group">
							<label for="item_variable">Variable</label>
							<select id="item_variable" name="item_variable" class="form-control">
								<option value=""> ------- </option>
								<option value="WIDTH"> WIDTH </option>
								<option value="HEIGHT"> HEIGHT </option>						
								<option value="WAIST"> WAIST </option>
								<option value="LENGTH"> LENGTH ( e.g. shoe size ) </option>
							</select>
							<?php if (isset ( $this->_tpl_vars['errorArray']['item_variable'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['item_variable']; ?>
</span><?php else: ?><span class="smalltext">Type of the feature</span><?php endif; ?>					  
						</div>
						<div class="form-group" id="item_name_group">
							<label for="item_name">Name</label>
							<input type="text" id="item_name" name="item_name" class="form-control" value="" />
							<?php if (isset ( $this->_tpl_vars['errorArray']['item_name'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['item_name']; ?>
</span><?php else: ?><span class="smalltext">Name of the feature</span><?php endif; ?>					  
						</div>
						<div class="form-group" id="item_value_group">
							<label for="item_value">Value</label>
							<input type="text" id="item_value" name="item_value" class="form-control" value="" />
							<?php if (isset ( $this->_tpl_vars['errorArray']['item_value'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['item_value']; ?>
</span><?php else: ?><span class="smalltext">Value of feature, e.g. HTML code (#DFE83D), size (XXL), etc...</span><?php endif; ?>					  
						</div>
                        <div class="form-group" id="item_image_group">
        					<label for="mediafiles">Image Upload</label>
        					<input type="file" id="mediafile" name="mediafile" />
        					<?php if (isset ( $this->_tpl_vars['errorArray']['mediafile'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['mediafile']; ?>
</span><?php else: ?><span class="smalltext">N.B.: If your media are too big and being cropped, please use the windows software "Paint" or "Microsoft Office Picture Manager" to resize them.</span><?php endif; ?>					  
                        </div>						
						<div class="form-group">
							<button type="submit" class="btn btn-primary">Upload and Save</button>
						</div>
					</div>
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

<?php echo '
<script type="text/javascript" language="javascript">
$(document).ready(function(){
    $("#item_type").change(function(){
        selectType();
    });
	selectType();
	getAll();
});

function getReset() {
	$(\'#filter_text\').val(\'\');
	$(\'#filter_type\').val(\'\');
	$(\'#filter_variable\').val(\'\');
	$(\'#filter_cipher\').val(\'\');
	getAll();
}

function getAll() {
	/* Clear table contants first. */			
	$(\'#tableContent\').html(\'\');

	var type		= $(\'#filter_type\').val();
	var cipher		= $(\'#filter_cipher\').val();
	var variable	= $(\'#filter_variable\').val();
	var text		= $(\'#filter_text\').val();
	var tr			= 0;
	
	if(type == \'COLOUR\') {
		$(\'#tableContent\').html(\'<table class="table" id="dataTable"><thead><tr><th>Type</th><th>Name</th><th>Value</th><th></th><th></th></tr></thead><tbody id="tablebody" name="tablebody"><tr><td colspan="5"><td></tr></tbody></table>\');	
		tr = 5;
	} else if(type == \'SIZE\') {
		$(\'#tableContent\').html(\'<table class="table" id="dataTable"><thead><tr><th>Type</th><th>Cipher</th><th>Variable</th><th>Value</th><th></th></tr></thead><tbody id="tablebody" name="tablebody"><tr><td colspan="5"><td></tr></tbody></table>\');	
		tr = 5;
	} else if(type == \'GENDER\') {
		$(\'#tableContent\').html(\'<table class="table" id="dataTable"><thead><tr><th>Type</th><th>Name</th><th>Value</th><th></th></tr></thead><tbody id="tablebody" name="tablebody"><tr><td colspan="4"><td></tr></tbody></table>\');	
		tr = 4;
	} else if(type == \'MATERIAL\') {
		$(\'#tableContent\').html(\'<table class="table" id="dataTable"><thead><tr><th>Type</th><th>Name</th><th></th></tr></thead><tbody id="tablebody" name="tablebody"><tr><td colspan="3"><td></tr></tbody></table>\');	
		tr = 3;
	} else {
		$(\'#tableContent\').html(\'<table class="table" id="dataTable"><thead><tr><th>Type</th><th>Name</th><th>Cipher</th><th>Variable</th><th>Value</th><th></th></tr></thead><tbody id="tablebody" name="tablebody"><tr><td colspan="6"><td></tr></tbody></table>\');	
		tr = 6;
	}

	oTable = $(\'#dataTable\').dataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",							
		"bSort": false,
		"bFilter": false,
		"bInfo": false,
		"iDisplayStart": 0,
		"iDisplayLength": 20,				
		"bLengthChange": false,									
		"bProcessing": true,
		"bServerSide": true,		
		"sAjaxSource": "?action=tablesearch&filter_text="+text+"&filter_type="+type+"&filter_variable="+variable+"&filter_cipher="+cipher,
		"fnServerData": function ( sSource, aoData, fnCallback ) {
			$.getJSON( sSource, aoData, function (json) {
				if (json.result === false) {
					$(\'#tablebody\').html(\'<tr><td colspan="" align="center" colspan="\'+tr+\'"></td></tr>\');
				}
				fnCallback(json)
			});
		},
		"fnDrawCallback": function(){
		}
	});	
	return false;
}

function selectType() {
	var type = $("#item_type :selected").val();

	if(type == \'COLOUR\') {
		$(\'#item_cipher_group\').hide();
		$(\'#item_variable_group\').hide();
		$(\'#item_name_group\').show();
		$(\'#item_value_group\').show();
		$(\'#item_image_group\').show();
	} else if(type == \'SIZE\') {
		$(\'#item_cipher_group\').show();
		$(\'#item_variable_group\').show();
		$(\'#item_name_group\').hide();
		$(\'#item_value_group\').show();
		$(\'#item_image_group\').hide();
	} else if(type == \'GENDER\') {
		$(\'#item_cipher_group\').hide();
		$(\'#item_variable_group\').hide();
		$(\'#item_name_group\').show();
		$(\'#item_value_group\').show();
		$(\'#item_image_group\').hide();
	} else if(type == \'MATERIAL\') {
		$(\'#item_cipher_group\').hide();
		$(\'#item_variable_group\').hide();
		$(\'#item_name_group\').show();
		$(\'#item_value_group\').hide();
		$(\'#item_image_group\').hide();
	} else {
		$(\'#item_cipher_group\').hide();
		$(\'#item_variable_group\').hide();
		$(\'#item_name_group\').hide();
		$(\'#item_value_group\').hide();
		$(\'#item_image_group\').hide();
	}
	$(\'#item_cipher\').val(\'\');
	$(\'#item_variable\').val(\'\');
	$(\'#item_name\').val(\'\');
	$(\'#item_value\').val(\'\');
	return false;
}
</script>
'; ?>

</html>