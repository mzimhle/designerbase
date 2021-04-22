<?php /* Smarty version 2.6.20, created on 2018-09-11 22:28:29
         compiled from catalog/default.tpl */ ?>
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
		<h2 class="content-header-title">Catalog</h2>
		<ol class="breadcrumb">
			<li><a href="/">Home</a></li>
			<li><a href="#"><?php echo $this->_tpl_vars['activeBrand']['brand_name']; ?>
</a></li>
			<li><a href="/catalog/">Catalog</a></li>
			<li class="active">List</li>
		</ol>
	</div>	
      <div class="row">
        <div class="col-sm-12">
		<button class="btn btn-secondary fr" type="button" onclick="link('/catalog/details.php'); return false;">Add a new catalog</button><br/ ><br />
          <div class="portlet">
            <div class="portlet-header">
              <h3>
				<i class="fa fa-tasks"></i>
				Catalog list
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">           							
			<div class="form-group">
				<label for="client_code">Search by name or category</label>
				<input type="text" class="form-control" id="filter_text" name="filter_text" size="60" value="" />
			</div>
			<div class="form-group">
				<button type="button" onClick="getAll();" class="btn btn-primary">Search</button>
				<button type="button" onClick="getReset();" class="btn">Reset</button>
			</div>			
				<div id="tableContent">Loading catalogs details..... Please wait...</div>	
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
<script type="text/javascript">
	$(document).ready(function() {
		getAll();
	});

	var oTable	= null;

	function getReset() {
		$(\'#filter_text\').val(\'\');
		getAll();
	}

	function getAll() {
		/* Clear table contants first. */			
		$(\'#tableContent\').html(\'\');
		
		$(\'#tableContent\').html(\'<table class="table" id="dataTable"><thead><tr>									<th></th><th>Name</th><th>Amount</th><th>Category</th><th></th></tr></thead><tbody id="tablebody" name="tablebody"><tr><td colspan="4"><td></tr></tbody></table>\');	
			
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
			"sAjaxSource": "?action=tablesearch&filter_text"+$(\'#filter_text\').val(),
			"fnServerData": function ( sSource, aoData, fnCallback ) {
				$.getJSON( sSource, aoData, function (json) {
					if (json.result === false) {
						$(\'#tablebody\').html(\'<tr><td colspan="" align="center" colspan="4"></td></tr>\');
					}
					fnCallback(json)
				});
			},
			"fnDrawCallback": function(){
			}
		});	
		return false;
	}
</script>
'; ?>

</html>