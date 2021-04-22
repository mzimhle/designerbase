<?php /* Smarty version 2.6.20, created on 2018-02-06 08:48:23
         compiled from comment/default.tpl */ ?>
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
		<h2 class="content-header-title">Comments</h2>
		<ol class="breadcrumb">
			<li><a href="/">Home</a></li>
			<li class="active">Latest comments</li>
		</ol>
	</div>	
      <div class="row">
        <div class="col-sm-12">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
				<i class="fa fa-tasks"></i>
				Comment list
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">           							
			<div class="form-group">
				<label for="client_code">Search by name, message, etc...</label>
				<input type="text" class="form-control" id="filter_text" name="filter_text" size="60" value="" />
			</div>
			<div class="form-group">
				<button type="button" onClick="getAll();" class="btn btn-primary">Search</button>
				<button type="button" onClick="getReset();" class="btn">Reset</button>
			</div>			
				<div id="tableContent">Loading comments details..... Please wait...</div>	
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
		
		$(\'#tableContent\').html(\'<table class="table" id="dataTable"><thead><tr>									<th></th><th>Name</th><th>Percentage</th><th>Message</th><th></th></tr></thead><tbody id="tablebody" name="tablebody"><tr><td colspan="5"><td></tr></tbody></table>\');	
			
		oTable = $(\'#dataTable\').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"aoColumns": [
				{ "sWidth" : "5%" },
				{ "sWidth" : "15%" },
				{ "sWidth" : "3%" },
				{ "sWidth" : "40%" },
				{ "sWidth" : "7%" }
			],
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
						$(\'#tablebody\').html(\'<tr><td colspan="" align="center" colspan="5"></td></tr>\');
					}
					fnCallback(json)
				});
			},
			"fnDrawCallback": function(){
			}
		});	
		return false;
	}

	function commentVetModal(id) {
		$.ajax({
			type: "GET",
			url: "default.php",
			data: "getComment="+id,
			dataType: "json",
			success: function(data){
				if(data.result == 1) {
					$(\'#commentcode\').val(id);
					$(\'#commentmessage\').html(data.data.comment_message);
					$(\'#commentpercentage\').html(data.data.rate_number);
					var status = \'\';
					if(data.data.comment_active == 1) {
						status = "<span class=\'success\'>Active</span>";
					} else if(data.data.comment_active == 1) {
						status = "<span class=\'error\'>In-active</span>";
					} else {
						status = "<span>Not vetted</span>";
					}
					$(\'#commentstatus\').html(status);
					$(\'#commentVetModal\').modal(\'show\');
				} else {
					$.howl ({
					  type: \'danger\'
					  , title: \'Error Message\'
					  , content: data.error
					  , sticky: $(this).data (\'sticky\')
					  , lifetime: 7500
					  , iconCls: $(this).data (\'icon\')
					});
				}
			}
		});
		return false;
	}
	
	function changeVet() {

		var commentcode	= $(\'#commentcode\').val();
		var vetstatus	= $(\'#vet_status\').val();

		$.ajax({
			type: "GET",
			url: "default.php",
			data: "updateComment="+commentcode+"&vetstatus="+vetstatus,
			dataType: "json",
			success: function(data){
				if(data.result == 1) {
					getAll();
					$(\'#commentVetModal\').modal(\'hide\');
				} else {
					$(\'#commentError\').html(data.error);
				}
			}
		});
		return false;
	}
</script>
'; ?>

<!-- Modal -->
<div class="modal fade" id="commentVetModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Vet comment</h4>
			</div>
			<div class="modal-body">
				<p>Below are the details of the comment</p>
				<table class="table">
					<tr>
						<td><b>Comment</b></td>
						<td><span id="commentmessage" name="commentmessage"></span></td>
					</tr>
					<tr>
						<td><b>Percentage</b></td>
						<td><span id="commentpercentage" name="commentpercentage"></span></td>
					</tr>
					<tr>
						<td><b>Current status</b></td>
						<td><span id="commentstatus" name="commentstatus"></span></td>
					</tr>					
				</table>			
				<p>Below is where you can vet this comment</p>
				<div class="form-group">
					<label for="vet_status">Change status</label>
					<select id="vet_status" name="vet_status" class="form-control">
						<option value=""> ----- </option>
						<option value="1"> Approve </option>
						<option value="0"> Decline </option>
					</select>
				</div>
				<button class="btn btn-warning" type="button" onclick="javascript:changeVet();">Vet</button>
				<br />
				<p class="error" id="commentError" name="commentError"></p>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
				<input type="hidden" id="commentcode" name="commentcode" value="" />
			</div>
		</div>
	</div>
</div>
<!-- modal -->
</html>