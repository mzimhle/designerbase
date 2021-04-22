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
		<h2 class="content-header-title">Participants</h2>
		<ol class="breadcrumb">
			<li><a href="/">Home</a></li>
			<li><a href="/participant/">Participants</a></li>
			<li class="active">List</li>
		</ol>
	</div>	
      <div class="row">
        <div class="col-sm-12">
		<button class="btn btn-secondary fr" type="button" onclick="link('/participant/details.php'); return false;">Add a new participant</button><br/ ><br />
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					Participant List
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">           							
			<div class="form-group">
				<label for="client_code">Search by name, number or email</label>
				<input type="text" class="form-control"  id="filter_text" name="filter_text" size="60" value="" />					
			</div>
			<div class="form-group">
				<button type="button" onClick="getAll();" class="btn btn-primary">Search</button>
				<button type="button" onClick="getReset();" class="btn">Reset</button>
			</div>			
				<div id="tableContent">Loading participants details..... Please wait...</div>	
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->				
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
{include_php file='includes/footer.php'}
{include_php file='includes/javascript.php'}
{literal}
<script type="text/javascript">
	$(document).ready(function() {
		getAll();
	});

	function getReset() {
		$('#filter_text').val('');
		getAll();
	}

	function getAll() {				
		$('#tableContent').html('<table class="table" id="dataTable"><thead><tr><th>Name</th><th>Email</th><th>Cellphone</th><th>Location</th><th>Address</th><th></th></tr></thead><tbody id="tablebody" name="tablebody"><tr><td colspan="6"><td></tr></tbody></table>');	
			
		oTable = $('#dataTable').dataTable({
			"bJQueryUI": true,
    		"aoColumns" : [
    			{ sWidth: "15%" },
    			{ sWidth: "10%" },
    			{ sWidth: "5%" },
    			{ sWidth: "15%" },
    			{ sWidth: "40%" },
    			{ sWidth: "5%" }
    		],			
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
						$('#tablebody').html('<tr><td colspan="" align="center" colspan="6"></td></tr>');
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