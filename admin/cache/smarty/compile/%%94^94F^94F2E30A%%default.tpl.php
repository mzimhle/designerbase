<?php /* Smarty version 2.6.20, created on 2018-02-06 08:48:30
         compiled from checkout/default.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'checkout/default.tpl', 50, false),)), $this); ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<title>DesignerBase</title>
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
		<h2 class="content-header-title">Checkout</h2>
		<ol class="breadcrumb">
			<li><a href="/">Home</a></li>	
			<li><a href="/checkout/">Checkout</a></li>
			<li class="active">List</li>
		</ol>
	</div>	  
	<div class="row">
        <div class="col-md-12">		
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-hand-o-up"></i>
                Checkout List
              </h3>
            </div> <!-- /.portlet-header -->	
			<div class="portlet-content">
		    	<div class="row">
                    <div class="col-md-12">			
        				<div class="form-group">
        				  <label for="filter_search">Search by catalog name, description, invoice number, email, cellphone number and address</label>
        				  <input type="text" id="filter_search" name="filter_search" class="form-control" value="" />
        				</div>
			        </div>
			    </div>
		    	<div class="row">
                    <div class="col-md-3">				    
        				<div class="form-group">
        					<label for="filter_status">Transaction Status</label>
        					<select type="text" id="filter_status" name="filter_status" class="form-control">
        						<option value=""> All </option>
                                <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['statusPairs']), $this);?>

        					</select>
        				</div>
        			</div>
                    <div class="col-md-3">				    
        				<div class="form-group">
        					<label for="filter_stage">Delivery Stage</label>
        					<select type="text" id="filter_stage" name="filter_stage" class="form-control">
        						<option value=""> All </option>
                                <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['stagePairs']), $this);?>

        					</select>
        				</div>
        			</div>        			
        			<div class="col-md-3">	
        				<div class="form-group">
        				  <label for="filter_brand">Search by brand</label>
        				  <select type="text" id="filter_brand" name="filter_brand" class="form-control">
        					<option value=""> All </option>
        					<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['brandPairs']), $this);?>

        				  </select>
        				</div>
				    </div>
        			<div class="col-md-3">	
        				<div class="form-group">
        				  <label for="filter_areapostregion">Search by province</label>
        				  <select type="text" id="filter_areapostregion" name="filter_areapostregion" class="form-control">
        					<option value=""> All </option>
        					<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['areapostregionPairs']), $this);?>

        				  </select>
        				</div>
				    </div>				    
        		</div>
				<div class="form-group">
					<button type="button" onclick="getRecords(); return false;" class="btn btn-primary">Search</button>
					<!-- <button type="button" onclick="csv(); return false;" class="btn">Download CSV</button> -->
					<button type="button" onclick="clearFilters(); return false;" class="btn">Clear Filters</button>
				</div>
				<p>There are <span id="result_count" name="result_count" class="success">0</span> records showing. We are displaying <span id="result_display" name="result_display" class="success">0</span> records per page.</p>
				<div id="tableContent" align="center">
					<!-- Start Content Table -->
					<div class="content_table">
						<img src="/images/ajax_loader.gif" />
					 </div>
					 <!-- End Content Table -->	
				</div>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->	
  </div> <!-- /.content --> 
</div> <!-- /.container -->
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php echo '
<script type="text/javascript">
$(document).ready(function() {
	getRecords();
});

function getRecords() {
	var html		= \'\';

	var filter_search		    = $(\'#filter_search\').val() != \'undefined\' ? $(\'#filter_search\').val() : \'\';
	var filter_status	        = $(\'#filter_status\').val() != \'undefined\' ? $(\'#filter_status\').val() : \'\';
	var filter_brand	        = $(\'#filter_brand\').val() != \'undefined\' ? $(\'#filter_brand\').val() : \'\';
	var filter_areapostregion	= $(\'#filter_areapostregion\').val() != \'undefined\' ? $(\'#filter_areapostregion\').val() : \'\';
	var filter_stage	        = $(\'#filter_stage\').val() != \'undefined\' ? $(\'#filter_stage\').val() : \'\';
	
	/* Clear table contants first. */			
	$(\'#tableContent\').html(\'\');
	
	$(\'#tableContent\').html(\'<table cellpadding="0" cellspacing="0" width="100%" border="0" class="display" id="dataTable"><thead><tr><th>Trans. Status</th><th></th><th>Price</th><th>Invoice Code</th><th>Brand</th><th>Delivery Date</th><th>Participant</th><th>Address</th><th>Extra Info.</th><th>Stage Level</th><th>State Notes</th><th></th></tr></thead><tbody id="checkoutbody"><tr><td colspan="5" align="center"></td></tr></tbody></table>\');	

	oTable = $(\'#dataTable\').dataTable({
		"bJQueryUI": true,
		"aoColumns" : [
		    { sWidth: "5%" },
			{ sWidth: "5%" },
			{ sWidth: "5%" },
			{ sWidth: "5%" },
			{ sWidth: "8%" },
			{ sWidth: "5%" },
			{ sWidth: "10%" },
			{ sWidth: "15%" },
			{ sWidth: "15%" },
			{ sWidth: "5%" },
			{ sWidth: "20%" },
			{ sWidth: "5%" }
		],
		"sPaginationType": "full_numbers",							
		"bSort": false,
		"bFilter": false,
		"bInfo": false,
		"iDisplayStart": 0,
		"iDisplayLength": 100,				
		"bLengthChange": false,									
		"bProcessing": true,
		"bServerSide": true,		
		"sAjaxSource": "?action=search&filter_csv=0&filter_search="+filter_search+"&filter_status="+filter_status+"&filter_brand="+filter_brand+"&filter_areapostregion="+filter_areapostregion+"&filter_stage="+filter_stage,
		"fnServerData": function ( sSource, aoData, fnCallback ) {
			$.getJSON( sSource, aoData, function (json) {
			if (json.result === false) {
				$(\'#checkoutbody\').html(\'<tr><td colspan="5" align="center">No results</td></tr>\');											
			} else {
				$(\'#result_count\').html(json.iTotalDisplayRecords);
				$(\'#result_display\').html(json.iTotalRecords);
			}
			fnCallback(json);
			});
		},
		"fnDrawCallback": function(){
		}
	});
	return false;
}

function csv() {
	var filter_search		= $(\'#filter_search\').val() != \'undefined\' ? $(\'#filter_search\').val() : \'\';
	var filter_department	= $(\'#filter_department\').val() != \'undefined\' ? $(\'#filter_department\').val() : \'\';
	var filter_technician	= $(\'#filter_technician\').val() != \'undefined\' ? $(\'#filter_technician\').val() : \'\';
	window.location.href	= "/checkout/?action=search&filter_csv=1&filter_search="+filter_search+"&filter_department="+filter_department+"&filter_technician="+filter_technician;
	return false;
}

function clearFilters() {
	window.location.href	= "/checkout/";
	return false;
}

function submitStage() {
    var modal_stage_code            = $(\'#modal_stage_code\').val();
    var modal_stage_notes           = $(\'#modal_stage_notes\').val();
    var modal_mail_brand            = $(\'#modal_mail_brand\').val();
    var modal_mail_brand_message    = $(\'#modal_mail_brand_message\').val();
    var modal_mail_customer         = $(\'#modal_mail_customer\').val();
    var modal_mail_customer_message = $(\'#modal_mail_customer_message\').val();
    
    if(modal_stage_code == \'\') {
        alert(\'Please select a stage\');
        return false;
    }
    
    if(modal_stage_notes == \'\') {
        alert(\'Please add a note\');
        return false;
    }
    
    if(modal_mail_customer == 1) {
        if(modal_mail_customer_message == \'\') {
            alert(\'Please add a customer message to mail\');
            return false;
        }
    }
    
    if(modal_mail_brand == 1) {
        if(modal_mail_brand_message == \'\') {
            alert(\'Please add a customer message to mail\');
            return false;
        }
    }
    
	$.ajax({
		type: "GET",
		url: "default.php",
		data: "modal_stage_submit=1&modal_stage_code="+modal_stage_code+"&modal_stage_notes="+modal_stage_notes+"&checkoutitemcode="+$(\'#checkoutitemcode\').val()+"&modal_mail_customer="+modal_mail_customer+"&modal_mail_customer_message="+modal_mail_customer_message+"&modal_mail_brand="+modal_mail_brand+"&modal_mail_brand_message="+modal_mail_brand_message,
		dataType: "json",
		success: function(data){
			if(data.result == 1) {
                $(\'#stageModal\').modal(\'hide\');
                getRecords();
			} else {
				alert(data.message);
			}
		}
	});
	
    return false;
}
function stageModal(id) {
	$.ajax({
		type: "GET",
		url: "default.php",
		data: "checkoutitem_stage="+id,
		dataType: "json",
		success: function(data){
			if(data.result == 1) {
                $(\'#checkoutitemcode\').val(id);
                $(\'.modal_catalogname\').html(data.data.catalog_name);
                $(\'.modal_checkoutcode\').html(data.data.checkout_code);
                $(\'.modal_deliverydate\').html(data.data.brand_delivery);
                $(\'.modal_checkoutitem_note\').html(data.data.checkoutitem_note);
                $(\'.modal_catalogdescription\').html(data.data.catalog_text);
                
                $(\'.modal_participantname\').html(data.data.participant_name);
                $(\'.modal_participantnumber\').html(data.data.participant_number);
                $(\'.modal_participantemail\').html(data.data.participant_email);
                $(\'.modal_brandname\').html(data.data.brand_name);
                $(\'.modal_brandemail\').html(data.data.brand_email);
                $(\'.modal_brandnumber\').html(data.data.brand_number);
                
                $(\'.modal_areapostregionid\').html(data.data.demarcation_name);
                $(\'.modal_checkoutaddress\').html(data.data.checkout_address);
                
                $(\'.modal_stagedescription\').html(data.data.checkoutstage_name);
                $(\'.modal_stagenotes\').html(data.data.link_text);
                
                /* Add image. */
                var img = document.createElement("img");
                img.src = \''; ?>
<?php echo $this->_tpl_vars['config']['site']; ?>
<?php echo '\'+data.data.media_path+\'tny_\'+data.data.media_code+data.data.media_ext+\'?rand=\'+Math.floor(Math.random() * 10000);
                // This next line will just add it to the <body> tag
                $(\'.modal_media\').html(img);                
                $(\'#stageModal\').modal(\'show\');
			} else {
				$(\'#stageModal\').modal(\'hide\');
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
</script>
'; ?>

<!-- Modal -->
<div class="modal fade" id="stageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width: 1057px !important;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Update Stage</h4>
			</div>
			<div class="modal-body">
			    <table class="table">
			        <tr>
			            <td class="modal_media"></td>
			            <td>
            		    	<div class="row">
                                <div class="col-md-12">			
                    				<div class="form-group">
                    				  <label>Delivery Stage</label>
                    					<select type="text" id="modal_stage_code" name="modal_stage_code" class="form-control">
                                            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['stagePairs']), $this);?>

                    					</select>
                    				</div>
            			        </div>
                                <div class="col-md-12">
                    				<div class="form-group">
                    				  <label>Notes</label>
                                        <textarea id="modal_stage_notes" name="modal_stage_notes" rows="3" cols="20" class="form-control"></textarea>
                    				</div>
            			        </div> 
                                <div class="col-md-12">			
                    				<div class="form-group">
                    				  <label>Would you like to send an email to the brand</label>
                    					<select type="text" id="modal_mail_brand" name="modal_mail_brand" class="form-control">
                                            <option value="0">NO - Do not email brand</option>
                                            <option value="1">YES - Email Brand</option>
                    					</select>
                    				</div>
            			        </div>
                                <div class="col-md-12">
                    				<div class="form-group">
                    				  <label>Message to Brand</label>
                                        <textarea id="modal_mail_brand_message" name="modal_mail_brand_message" rows="3" cols="20" class="form-control"></textarea>
                    				</div>
            			        </div>
                                <div class="col-md-12">			
                    				<div class="form-group">
                    				  <label>Would you like to send an email to the customer</label>
                    					<select type="text" id="modal_mail_customer" name="modal_mail_customer" class="form-control">
                                            <option value="0">NO - Do not email customer</option>
                                            <option value="1">YES - Email customer</option>
                    					</select>
                    				</div>
            			        </div>
                                <div class="col-md-12">
                    				<div class="form-group">
                    				  <label>Message to customer</label>
                                        <textarea id="modal_mail_customer_message" name="modal_mail_customer_message" rows="3" cols="20" class="form-control"></textarea>
                    				</div>
            			        </div>             			        
                                <div class="col-md-12">			
                    				<div class="form-group">
                                        <p>Please make sure you have selected the stage and have added the notes for each stage before submitting.</p>
                                        <button type="button" class="btn btn-primary" onclick="submitStage(); return false;">Process</button>
                    				</div>
            			        </div>             			        
            			    </div>
			            </td>
			        </tr>
			    
			    <p>Below are its full details.:</p>
			    <table class="table">
                    <tr>
                        <td><b>Delivery Stage</b></td>
                        <td class="modal_stagedescription"></td>
                        <td><b>Notes</b></td>
                        <td class="modal_stagenotes"></td>                              
                    </tr>			        
                    <tr>
                        <td><b>Invoice Ref.</b></td>
                        <td class="modal_checkoutcode"></td>
                        <td><b>Item</b></td>
                        <td class="modal_catalogname"></td>                              
                    </tr>
                    <tr>
                        <td><b>Delivery Date</b></td>
                        <td class="modal_deliverydate"></td>                        
                        <td><b>Extra Info</b></td>
                        <td class="modal_checkoutitem_note"></td>                               
                    </tr>
                    <tr>
                        <td><b>Participant Name</b></td>
                        <td class="modal_participantname"></td>                        
                        <td><b>Participant Contacts</b></td>
                        <td>Cell <span class="modal_participantnumber"></span> / Email: <span class="modal_participantemail"></span></td>                               
                    </tr>
                    <tr>
                        <td><b>Province Code</b></td>
                        <td class="modal_areapostregionid"></td>                        
                        <td><b>Address</b></td>
                        <td class="modal_checkoutaddress"></td>                               
                    </tr>                     
                    <tr>
                        <td><b>Brand Name</b></td>
                        <td class="modal_brandname"></td>                        
                        <td><b>Brand Contacts</b></td>
                        <td>Cell <span class="modal_brandnumber"></span> / Email: <span class="modal_brandemail"></span></td>                               
                    </tr>                     
			    </table>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
				<input type="hidden" name="checkoutitemcode" id="checkoutitemcode" value="" />
			</div>
		</div>
	</div>
</div>
<!-- modal -->

</body>
</html>