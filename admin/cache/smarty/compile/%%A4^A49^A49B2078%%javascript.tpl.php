<?php /* Smarty version 2.6.20, created on 2018-09-11 22:44:07
         compiled from includes/javascript.tpl */ ?>
<script src="/library/javascript/libs/jquery-1.10.1.min.js"></script>
<script src="/library/javascript/libs/jquery-ui-1.10.3.js"></script>
<script src="/library/javascript/libs/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script src="/library/javascript/libs/excanvas.compiled.js"></script>
<![endif]-->
<!-- Plugin JS -->
<script src="/library/javascript/plugins/icheck/jquery.icheck.js"></script>
<script src="/library/javascript/plugins/select2/select2.js"></script>
<script src="/library/javascript/libs/raphael-2.1.2.min.js"></script>
<script src="/library/javascript/plugins/morris/morris.min.js"></script>
<script src="/library/javascript/plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="/library/javascript/plugins/nicescroll/jquery.nicescroll.min.js"></script>
<script src="/library/javascript/plugins/fullcalendar/fullcalendar.min.js"></script>

<script src="/library/javascript/plugins/parsley/parsley.js"></script>
<script src="/library/javascript/plugins/icheck/jquery.icheck.js"></script>
<!-- <script src="/library/javascript/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="/library/javascript/plugins/timepicker/bootstrap-timepicker.js"></script> -->
<script src="/library/javascript/plugins/simplecolorpicker/jquery.simplecolorpicker.js"></script>
<script src="/library/javascript/plugins/magnific/jquery.magnific-popup.min.js"></script>
<script src="/library/javascript/plugins/howl/howl.js"></script>
<!-- App JS -->
<script src="/library/javascript/target-admin.js"></script>
<!-- Plugin JS -->
<script src="/library/javascript/demos/dashboard.js"></script>
<script src="/library/javascript/demos/calendar.js"></script>
<!--
<script src="/library/javascript/demos/charts/morris/area.js"></script>
<script src="/library/javascript/demos/charts/morris/donut.js"></script>
-->
<script src="/library/javascript/datatables/jquery.dataTables.js"></script>
<script src="/library/javascript/datatables/jquery.truncatable.js"></script>

<script src="/library/javascript/jquery-ui-time-picker.js"></script>

<?php echo '
<script type="text/javascript">
	function deleteitem() {
		
		var id 		= $(\'#itemcode\').val();
		var page 	= $(\'#itempage\').val();
		var code 	= $(\'#maincode\').val();
		
		parameter = \'\';
		if(code != \'\') {
			parameter = \'&code=\'+code;
		}
		
		$.ajax({
				type: "GET",
				url: page+".php",
				data: "delete_code="+id+parameter,
				dataType: "json",
				success: function(data){
						if(data.result == 1) {
							if(typeof oTable != \'undefined\') {
								$(\'#deleteModal\').modal(\'hide\');
								oTable.fnDraw();
							} else {
								window.location.href = window.location.href;
							}
						} else {
							
							$(\'#deleteModal\').modal(\'hide\');
							
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

	function deleteModal(id, code, page) {
		$(\'#itemcode\').val(id);
		$(\'#maincode\').val(code);
		$(\'#itempage\').val(page);
		$(\'#deleteModal\').modal(\'show\');
		return false;
	}
	
	function changeSubStatus() {
		var id 			= $(\'#itemsubcode\').val();
		var status		= $(\'#itemsubstatus\').val();
		var page 		= $(\'#itemsubpage\').val();	
		var parent	= $(\'#itemsubparent\').val();
		
		$.ajax({
				type: "GET",
				url: page+".php?code="+parent,
				data: "status_code="+id+"&status="+status,
				dataType: "json",
				success: function(data){
					if(data.result == 1) {
						window.location.href = window.location.href;
					} else {
						$(\'#statusModal\').modal(\'hide\');
						$.howl ({
						  type: \'info\'
						  , title: \'Notification\'
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
	
	function statusSubModal(id, status, page, parent) {
		$(\'#itemsubcode\').val(id);
		$(\'#itemsubstatus\').val(status);
		$(\'#itemsubpage\').val(page);
		$(\'#itemsubparent\').val(parent);
		$(\'#statusSubModal\').modal(\'show\');
	}
	
	function changestatus() {
		
		var id 		= $(\'#itemcode\').val();
		var status	= $(\'#itemstatus\').val();
		var page 	= $(\'#itempage\').val();
		
		$.ajax({
				type: "GET",
				url: page+".php",
				data: "status_code="+id+"&status="+status,
				dataType: "json",
				success: function(data){
					if(data.result == 1) {
						window.location.href = window.location.href;
					} else {
						$(\'#statusModal\').modal(\'hide\');
						$.howl ({
						  type: \'info\'
						  , title: \'Notification\'
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
	function statusModal(id, status, page) {
		$(\'#itemcode\').val(id);
		$(\'#itemstatus\').val(status);
		$(\'#itempage\').val(page);
		$(\'#statusModal\').modal(\'show\');
	}

	function viewModal(title, page) {
		$(\'#itemtitle\').html(title);
		$(\'#itempage\').html(page);
		$(\'#viewModal\').modal(\'show\');
	}
	
</script>
'; ?>

<!-- Modal -->
<div class="modal fade" id="statusSubModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Change Status</h4>
			</div>
			<div class="modal-body">Are you sure you want to change this item's status?</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
				<button class="btn btn-warning" type="button" onclick="javascript:changeSubStatus();">Change Item Status</button>
				<input type="hidden" id="itemsubcode" name="itemsubcode" value="" />
				<input type="hidden" id="itemsubstatus" name="itemsubstatus" value="" />
				<input type="hidden" id="itemsubpage" name="itemsubpage" value=""/>
				<input type="hidden" id="itemsubparent" name="itemsubparent" value=""/>
			</div>
		</div>
	</div>
</div>
<!-- modal -->
<!-- Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="itemtitle" name="itemtitle">View Information</h4>
			</div>
			<div class="modal-body" id="itempage" name="itempage"></div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- modal -->
<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Delete Item</h4>
			</div>
			<div class="modal-body">Are you sure you want to delete this item?</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
				<button class="btn btn-warning" type="button" onclick="javascript:deleteitem();">Delete Item</button>
				<input type="hidden" id="itemcode" name="itemcode" value=""/>
				<input type="hidden" id="itempage" name="itempage" value=""/>
				<input type="hidden" id="maincode" name="maincode" value=""/>
			</div>
		</div>
	</div>
</div>
<!-- modal -->
<!-- Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Change Item Status</h4>
			</div>
			<div class="modal-body">Are you sure you want to change this item's status?</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
				<button class="btn btn-warning" type="button" onclick="javascript:changestatus();">Change Item Status</button>
				<input type="hidden" id="itemcode" name="itemcode" value="" />
				<input type="hidden" id="itemstatus" name="itemstatus" value="" />
				<input type="hidden" id="itempage" name="itempage" value=""/>
			</div>
		</div>
	</div>
</div>
<!-- modal -->