<?php /* Smarty version 2.6.20, created on 2018-01-11 09:35:13
         compiled from mailing/default.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'mailing/default.tpl', 84, false),)), $this); ?>
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
      <div class="row">
        <div class="col-sm-8">		
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					mailing list
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">       							
			<div class="form-group">
				<p>So far you have <span class="members_count success">0</span> subscribers so far. </p>
			</div>			
			<div class="form-group">
				<label for="client_code">Search by name, number, email or category name</label>
				<input type="text" class="form-control"  id="filter_text" name="filter_text" size="60" value="" />					
			</div>
			<div class="form-group">
				<button type="button" onClick="getAll();" class="btn btn-primary">Search</button>
				<button type="button" onClick="getReset();" class="btn">Reset</button>
			</div>			
				<div id="tableContent">Loading mailings details..... Please wait...</div>	
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					Import CSV file
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/mailing/" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">
				<input type="hidden" id="import_mailings" name="import_mailings" value="1" />
                <div class="form-group">
					<label for="import_file">Upload CSV File</label>
					<input type="file" id="import_file" name="import_file" data-required="true" value="" />					  
                </div>
                <div class="form-group">
					<label for="import_category">Category</label>
					<input type="text" id="import_category" name="import_category" class="form-control" data-required="true" value="" />
                </div>				
                <div class="form-group"><button type="submit" class="btn btn-primary">Validate and Submit</button></div>
				<?php if (isset ( $this->_tpl_vars['import_message'] )): ?>
				<div class="form-group error">
					<?php echo $this->_tpl_vars['import_message']; ?>

				</div>				
				<?php endif; ?>				
				<p>Please note, the format for the <span class="success">csv or txt</span> file should be as follows, e.g.:<p>		
				<p class="success">name,email,number<br />
				mandla,mandla@gmail.com,0812698741<br />
				mandla,mandla@gmail.com,<br />
				mandla,,0812698741<br />
				</p><br />
				<p>Below will be the list of imported subscriber details</p>
				<table class="table table-bordered table-highlight">	
					<thead>
						<th align="left">Total</th>
						<th align="left">Added </th>
						<th align="left">Not Added</th>
						<th align="left">Duplicate Cell</th>
						<th align="left">Duplicate Email</th>
					</thead>
					<tbody>
						<tr>
							<?php if (isset ( $this->_tpl_vars['import_data'] )): ?>
							<td><?php echo ((is_array($_tmp=@$this->_tpl_vars['import_data']['total'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
</td>
							<td><?php echo ((is_array($_tmp=@$this->_tpl_vars['import_data']['successful'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
</td>
							<td><?php echo ((is_array($_tmp=@$this->_tpl_vars['import_data']['baddata'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
</td>
							<td><?php echo ((is_array($_tmp=@$this->_tpl_vars['import_data']['duplicatecell'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
</td>
							<td><?php echo ((is_array($_tmp=@$this->_tpl_vars['import_data']['duplicateemail'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
</td>
							<?php else: ?>
							<td colspan="5">No import done yet.</td>
							<?php endif; ?>
						</tr>
						<?php if (isset ( $this->_tpl_vars['import_data'] )): ?>
						<tr>
							<td colspan="5"><?php echo $this->_tpl_vars['import_data']['badlines']; ?>
</td>
						</tr>						
						<?php endif; ?>
					</tbody>
				</table>	
              </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->			  
        </div> <!-- /.col -->
        <div class="col-sm-4">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					Add a mailing
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/mailing/" method="POST" data-validate="parsley" class="form parsley-form">
				<input type="hidden" id="mailing_form" name="mailing_form" value="1" />				
                <div class="form-group">
					<label for="mailing_name">Name</label>
					<input type="text" id="mailing_name" name="mailing_name" class="form-control" data-required="true" value="" />			  
                </div>				
                <div class="form-group">
					<label for="mailing_email">Email</label>
					<input type="text" id="mailing_email" name="mailing_email" class="form-control" value="" />				  
                </div>			 	
                <div class="form-group">
					<label for="mailing_cellphone">Cellphone</label>
					<input type="text" id="mailing_cellphone" name="mailing_cellphone" class="form-control" value="" />
                </div>
                <div class="form-group">
					<label for="mailing_category">Category</label>
					<input type="text" id="mailing_category" name="mailing_category" class="form-control" value="" />
                </div>					
                <div class="form-group">
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
				<?php if (isset ( $this->_tpl_vars['mailing_form'] )): ?>
					<div class="form-group">
						<p class="success">The mailing has been successfully added / updated</p>
					</div>
				<?php endif; ?>
				<?php if (isset ( $this->_tpl_vars['errorArray'] )): ?>
					<div class="form-group">
						<p class="error"><?php echo $this->_tpl_vars['errorArray']; ?>
</p>
					</div>
				<?php endif; ?>				
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
<script type="text/javascript">
$(document).ready(function() {
	getAll();
});

function deleteSubscriptionModal(code) {
	$(\'#delete_subscription_code\').val(code);
	$(\'#deleteSubscriptionModalModal\').modal(\'show\');
	return false;
}

function deleteSubscription() {
		
		var code 		= $(\'#delete_subscription_code\').val();
		
		$.ajax({
				type: "GET",
				url: "/",
				data: "delete_subscription_code="+code,
				dataType: "json",
				success: function(data){
						if(data.result == 1) {
							window.location.href = window.location.href;
						} else {

							$(\'#deleteSubscriptionModalModal\').modal(\'hide\');

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
	
function updateSubModal(code) {

	$(\'#sub_update_error\').hide();
	$(\'#sub_update_error\').html(\'\');
	$(\'#sub_update_success\').hide();

	$.ajax({
		type: "GET",
		url: "/",
		data: "update_sub_code="+code,
		dataType: "json",
		success: function(data){
			if(data.result == 1) {
				$(\'#sub_update_name\').val(data.subscription.subscription_name);
				$(\'#sub_update_code\').val(data.subscription.subscription_code);
				$(\'#sub_update_fullname\').html(data.subscription.subscription_name);

				$(\'#updateSubscriptionModal\').modal(\'show\');
			} else {
				$(\'#updateSubscriptionModal\').modal(\'hide\');
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

function updateModal(code) {

	$(\'#part_update_error\').hide();
	$(\'#part_update_error\').html(\'\');
	$(\'#part_update_success\').hide();
	$.ajax({
		type: "GET",
		url: "/mailing/",
		data: "update_code="+code,
		dataType: "json",
		success: function(data){
			if(data.result == 1) {
				$(\'#part_update_name\').val(data.mailing.mailing_name);
				$(\'#part_update_email\').val(data.mailing.mailing_email);
				$(\'#part_update_cellphone\').val(data.mailing.mailing_cellphone);
				$(\'#part_update_code\').val(data.mailing.mailing_code);				
				$(\'#part_update_category\').val(data.mailing.mailing_category);
				$(\'#part_update_fullname\').html(data.mailing.mailing_name);
				$(\'#updateModal\').modal(\'show\');
			} else {
				$(\'#updateModal\').modal(\'hide\');
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

function updatemailing() {
	$.ajax({
		type: "POST",
		url: "/mailing/",
		data: "mailing_form_ajax=1&mailing_name="+$(\'#part_update_name\').val()+"&mailing_email="+$(\'#part_update_email\').val()
			+"&mailing_cellphone="+$(\'#part_update_cellphone\').val()+"&mailing_code="+$(\'#part_update_code\').val()+"&mailing_category="+$(\'#part_update_category\').val(),
		dataType: "json",
		success: function(data){
			$(\'#part_update_success\').hide();
			$(\'#part_update_error\').hide();
			if(data.result == 1) {
				$(\'#part_update_success\').show();
				$(\'#part_update_error\').hide();
				getAll();
			} else {
				$(\'#part_update_error\').show();
				$(\'#part_update_error\').html(data.error);
				$(\'#part_update_success\').hide();
			}
		}
	});
}

function updateSubscription() {
	$.ajax({
		type: "POST",
		url: "/mailing/",
		data: "subscription_form_ajax=1&subscription_name="+$(\'#sub_update_name\').val()+"&subscription_code="+$(\'#sub_update_code\').val(),
		dataType: "json",
		success: function(data){

			$(\'#sub_update_success\').hide();
			$(\'#sub_update_error\').hide();

			if(data.result == 1) {
				window.location.href = window.location.href;
			} else {
				$(\'#sub_update_error\').show();
				$(\'#sub_update_error\').html(data.error);
				$(\'#sub_update_success\').hide();
			}
		}
	});
}

var oTable	= null;

function getReset() {
	$(\'#filter_text\').val(\'\');
	getAll();
}

function getAll() {
	var html	= \'\';

	/* Clear table contants first. */			
	$(\'#tableContent\').html(\'\');
	
	$(\'#tableContent\').html(\'<table class="table" id="dataTable"><thead><tr><th>Name</th><th>Email</th><th>Cellphone</th><th>Category</th><th></th><th></th></tr></thead><tbody id="tablebody" name="tablebody"><tr><td colspan="5">There are currently no records<td></tr></tbody></table>\');	
		
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
		"sAjaxSource": "?action=tablesearch&filter_text="+$(\'#filter_text\').val(),
		"fnServerData": function ( sSource, aoData, fnCallback ) {
			$.getJSON( sSource, aoData, function (json) {
				if (json.result === false) {
					$(\'#tablebody\').html(\'<tr><td colspan="" align="center" colspan="5">There are currently no records</td></tr>\');
				}
				$(\'.members_count\').html(json.iTotalDisplayRecords);
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

<!-- Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Update mailing</h4>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to update the details of the mailing <b><span id="part_update_fullname" class="success"></span></b>?</p>
              <form id="validate-basic" action="#" method="POST" data-validate="parsley" class="form parsley-form">
				<input type="hidden" id="mailing_form" name="mailing_form" value="1" />
                <div class="form-group">
					<label for="part_update_name">Name</label>
					<input type="text" id="part_update_name" name="part_update_name" class="form-control" value="" />			  
                </div>				
                <div class="form-group">
					<label for="part_update_email">Email</label>
					<input type="text" id="part_update_email" name="part_update_email" class="form-control" value="" />
                </div>				
                <div class="form-group">
					<label for="part_update_cellphone">Cellphone</label>
					<input type="text" id="part_update_cellphone" name="part_update_cellphone" data-required="true" class="form-control" value="" />
                </div>
                <div class="form-group">
					<label for="part_update_category">Category</label>
					<input type="text" id="part_update_category" name="part_update_category" data-required="true" class="form-control" value="" />
                </div>				
                <div class="form-group success" id="part_update_success" style="display: none;">The mailing has been successfully updated.</div>
				<div class="form-group error" id="part_update_error" style="display: none;"></div>
              </form>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
				<button class="btn btn-warning" type="button" onclick="javascript:updatemailing();">Update</button>
				<input type="hidden" id="part_update_code" name="part_update_code" value="" />
			</div>
		</div>
	</div>
</div>
<!-- modal -->
<!-- Modal -->
<div class="modal fade" id="deleteSubscriptionModalModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Delete Item</h4>
			</div>
			<div class="modal-body">Are you sure you want to delete this item?</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
				<button class="btn btn-warning" type="button" onclick="javascript:deleteSubscription();">Delete Item</button>
				<input type="hidden" id="delete_subscription_code" name="delete_subscription_code" value=""/>
			</div>
		</div>
	</div>
</div>
<!-- modal -->
<!-- Modal -->
<div class="modal fade" id="updateSubscriptionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Update Subscription</h4>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to update this subscription <b><span id="sub_update_fullname" class="success"></span></b>?</p>
              <form id="validate-basic" action="#" method="POST" data-validate="parsley" class="form parsley-form">
				<input type="hidden" id="subscription_form_ajax" name="subscription_form_ajax" value="1" />
                <div class="form-group">
					<label for="sub_update_name">Name</label>
					<input type="text" id="sub_update_name" name="sub_update_name" class="form-control" value="" maxlength="20" />			  
                </div>												
                <div class="form-group success" id="sub_update_success" style="display: none;">The mailing has been successfully updated.</div>
				<div class="form-group error" id="sub_update_error" style="display: none;"></div>
              </form>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
				<button class="btn btn-warning" type="button" onclick="javascript:updateSubscription();">Update</button>
				<input type="hidden" id="sub_update_code" name="sub_update_code" value="" />
			</div>
		</div>
	</div>
</div>
<!-- modal -->
</html>