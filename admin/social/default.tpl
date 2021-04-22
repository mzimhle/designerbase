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
	{include_php file='includes/css.php'}
</head>
<body>
{include_php file='includes/header.php'}
<div class="container">
  <div class="content">
    <div class="content-container">
	<div class="content-header"> 
		<h2 class="content-header-title">Social</h2>
		<ol class="breadcrumb">
		<li><a href="/">Home</a></li>
		<li class="active">Social</li>
		</ol>
	</div>	  
	<div class="row">
        <div class="col-md-12">
		<button class="btn btn-secondary fr" type="button" onclick="link('/social/details.php'); return false;">Add a new social</button><br/ ><br />
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-hand-o-up"></i>
                social list
              </h3>
            </div> <!-- /.portlet-header -->			  
			<div class="portlet-content">
				<div class="form-group">
				  <label for="filter_text">Search for social</label>
				  <input type="text" id="filter_text" name="filter_text" class="form-control" value="" />
				</div>								
				<div class="form-group">
					<button type="button" onclick="getRecords(); return false;" class="btn btn-primary">Search</button>
				</div>
				<div id="tableContent" align="center"></div>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->	
  </div> <!-- /.content -->
</div> <!-- /.container -->
{include_php file='includes/footer.php'}
{include_php file='includes/javascript.php'}
{literal}
<script type="text/javascript">
$(document).ready(function() {
	getRecords();
});

function getRecords() {
	/* Clear table contants first. */			
	$('#tableContent').html('');
	
	$('#tableContent').html('<table cellpadding="0" cellspacing="0" width="100%" border="0" class="display" id="dataTable"><thead><tr><th></th><th>Message</th><th>Date sent</th><th>Output</th><th></th></tr></thead><tbody id="tdbody"><tr><td colspan="5" align="center"></td></tr></tbody></table>');

	oJobsTable = $('#dataTable').dataTable({
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
		"sAjaxSource": "?action=tablesearch&filter_text="+$('#filter_text').val(),
		"fnServerData": function ( sSource, aoData, fnCallback ) {
			$.getJSON( sSource, aoData, function (json) {
				if (json.result === false) {
					$('#tdbody').html('<tr><td colspan="5" align="center"></td></tr>');
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
{/literal}
</html>