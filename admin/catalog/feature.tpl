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
		<h2 class="content-header-title">{$catalogData.catalog_name}</h2>
		<ol class="breadcrumb">
			<li><a href="/">Home</a></li>
			<li><a href="#">{$activeBrand.brand_name}</a></li>
			<li><a href="/catalog/">Catalog</a></li>
			<li><a href="/catalog/details.php?code={$catalogData.catalog_code}">{$catalogData.catalog_name}</a></li>
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
				<div class="col-sm-12">	
					<div class="form-group">
						<label for="filter_type">Type</label>
						<select id="filter_type" name="filter_type" class="form-control">
							<option value=""> ------- </option>
							<option value="COLOUR"> COLOUR </option>
							<option value="SIZE"> SIZE </option>
							<option value="GENDER"> GENDER </option>
							<option value="MATERIAL"> MATERIAL </option>
						</select>				  
					</div>				
					<div class="form-group">
						<button type="button" onClick="getAll();" class="btn btn-primary">Search</button>
					</div>
					<br />
					<div id="tableContent">Loading.... Please wait...</div>	
					<br />
				</div>				
				<br /><br />
				<form id="validate-basic" action="/dashboard/feature/default.php?code={$itemData.item_code}" method="POST" data-validate="parsley" class="form parsley-form">	
					<div class="col-sm-12">						  
						<p>Add a new feature below</p>	
						<div class="form-group">
							<label for="item_type">Search by type</label>
							<select id="item_type" name="item_type" class="form-control">
								<option value="COLOUR"> COLOUR </option>
								<option value="SIZE"> SIZE </option>
								<option value="GENDER"> GENDER </option>
								<option value="MATERIAL"> MATERIAL </option>
							</select>				  
						</div>
						<div class="form-group">
							<label for="feature_table"><span id="selectedtype"></span> Features</label>
							<div id="feature_table" name="feature_table">
								<table class="table table-bordered">	
									<thead>
										<tr>
											<td>Name</td>
											<td></td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td></td>
										</tr>			     
									</tbody>					  
								</table>
							</div>
						</div>
						<div class="form-group">
							<button type="button" onclick="addFeature(); return false;" class="btn btn-primary">Add feature(s)</button>
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
{include_php file='includes/footer.php'}
{include_php file='includes/javascript.php'}
{literal}
<script type="text/javascript" language="javascript">
var category = '{/literal}{$catalogData.item_parent_name}{literal}';
$(document).ready(function(){
    $("#item_type").change(function(){
        selectType();
    });
	getAll();
	selectType();
});

function addFeature() {
	/* Get the type. */
	var type	= $("#item_type :selected").val();
	var feature	= '';
	var code	= '';
	var items	= [];
	var text	= '';
	/* Disable the select box. So that it cannot be changed. */
	$('#item_type').attr("disabled", true); 

	$('.feature_item').each(function(){
		feature = $(this).val();		
		/* Check if checked. */
		if($(this).is(':checked')) {
			if(type == 'MATERIAL') {
				items.push(feature);
				if($('#feature_text_'+feature).val() != '') {
					text  += '&'+feature+'='+$('#feature_text_'+feature).val();
				}
			} else if(type == 'SIZE') {
				/* Check and get the size. */
				if($('#size_'+feature).val() != '') {
					text  += '&size_'+feature+'='+$('#size_'+feature).val();
				} else {
					$.howl ({
						type: 'info' ,title: 'Notification' ,content: "Please add a size" ,sticky: $(this).data('sticky'),lifetime: 7500 ,iconCls: $(this).data ('icon')
					});
					return false;
				}
				/* Get the bust. */
				if($('#bust_'+feature).val() != '') {
					text  += '&bust_'+feature+'='+$('#bust_'+feature).val();
				}	
				/* Get the waist. */
				if($('#waist_'+feature).val() != '') {
					text  += '&waist_'+feature+'='+$('#waist_'+feature).val();
				}
				/* Get the hips. */
				if($('#hips_'+feature).val() != '') {
					text  += '&hips_'+feature+'='+$('#hips_'+feature).val();
				}
				/* Get the price */
				if($('#price_'+feature).val() != '') {
					text  += '&price_'+feature+'='+$('#price_'+feature).val();
				} else {
					$.howl ({
						type: 'info' ,title: 'Notification' ,content: "Please add a price for the size" ,sticky: $(this).data('sticky'),lifetime: 7500 ,iconCls: $(this).data ('icon')
					});
					return false;
				}
				items.push(feature);				
			} else {
				items.push(feature);
			}
		}
	});

	if(items.length > 0) {
		$.ajax({
			type: "GET",
			url: "feature.php?add_feature=1&code={/literal}{$catalogData.catalog_code}{literal}",
			data: "type="+type+"&items="+items+text,
			dataType: "json",
			success: function(data){
				if(data.result == 0) {
					$.howl ({
						type: 'info' ,title: 'Notification' ,content: data.message ,sticky: $(this).data('sticky'),lifetime: 7500 ,iconCls: $(this).data ('icon')
					});
				} else {
					getAll();
					$.howl ({
						type: 'success' ,title: 'Notification' ,content: 'Features were successfully added' ,sticky: $(this).data('sticky'),lifetime: 7500 ,iconCls: $(this).data ('icon')
					});
					selectType();
				}
				$('#item_type').attr("disabled", false);
			}
		});	
	} else {
		$.howl ({
		  type: 'warning' ,title: 'Warning' ,content: 'Please select at least one feature to add.' ,sticky: $(this).data ('sticky') ,lifetime: 7500 ,iconCls: $(this).data ('icon')
		});
	}
	return false;
}

var oTable;

function selectType() {
	var type	= $("#item_type :selected").val();
	var html	= '';

	$("#selectedtype").html(type);
	
	if(type == 'COLOUR') {
		$('#feature_table').html('<table class="table" id="featureTable"><thead><tr><th>Type</th><th>Name</th><th></th><th></th></tr></thead><tbody id="featureBody" name="featureBody"><tr><td colspan="4">Loading....<td></tr></tbody></table>');	
		tr = 4;
	} else if(type == 'SIZE') {
		console.log(category);
		if(category == 'Fashion') {
			$('#feature_table').html('<table class="table" id="featureTable"><thead><tr><th>Type</th><th>Cipher</th><th>Variable</th><th>Value</th><th>Bust</th><th>Waist</th><th>Hips</th><th>Price</th><th></th></tr></thead><tbody id="featureBody" name="featureBody"><tr><td colspan="9">Loading....<td></tr></tbody></table>');	
			tr = 9;
		} else {
			$('#feature_table').html('<table class="table" id="featureTable"><thead><tr><th>Type</th><th>Cipher</th><th>Variable</th><th>Value</th><th>Price</th><th></th></tr></thead><tbody id="featureBody" name="featureBody"><tr><td colspan="6">Loading....<td></tr></tbody></table>');	
			tr = 6;
		}
	} else if(type == 'GENDER') {
		$('#feature_table').html('<table class="table" id="featureTable"><thead><tr><th>Type</th><th>Name</th><th></th></tr></thead><tbody id="featureBody" name="featureBody"><tr><td colspan="4">Loading....<td></tr></tbody></table>');	
		tr = 4;
	} else if(type == 'MATERIAL') {
		$('#feature_table').html('<table class="table" id="featureTable"><thead><tr><th>Type</th><th>Name</th><th></th><th></th></tr></thead><tbody id="featureBody" name="featureBody"><tr><td colspan="3">Loading....<td></tr></tbody></table>');	
		tr = 3;
	} else {
		$('#feature_table').html('<table class="table" id="featureTable"><thead><tr><th>Type</th><th>Name</th><th>Cipher</th><th>Variable</th><th>Value</th><th></th></tr></thead><tbody id="featureBody" name="featureBody"><tr><td colspan="6">Loading....<td></tr></tbody></table>');	
		tr = 6;
	}

	$.ajax({
		type: "GET",
		url: "feature.php",
		data: "get_features="+type+"&code={/literal}{$catalogData.catalog_code}{literal}",
		dataType: "json",
		success: function(data){
			if(data.result == 1) {
				if(data.records.length > 0) {
					for(var i = 0; i < data.records.length; i++) {
						item = data.records[i];
						if(type == 'COLOUR') {
							html += '<tr>';
							html += '<td>'+item.item_type+'</td>';
							html += '<td>'+item.item_name+'</td>';
							html += '<td><span class="colorbox" style="background: '+item.item_value+'"></span></td>';
							html += '<td><input type="checkbox" value="'+item.item_code+'" class="feature_item" /></td>';
							html += '</tr>';
						} else if(type == 'SIZE') {
							if(category == 'Fashion') {
								html += '<tr>';
								html += '<td>'+item.item_type+'</td>';
								html += '<td>'+item.item_cipher+'</td>';
								html += '<td>'+item.item_variable+'</td>';
								html += '<td><input type="text" value="'+item.item_value+'" id="size_'+item.item_code+'" name="size_'+item.item_code+'" size="2" /></td>';
								html += '<td><input type="text" value="" id="bust_'+item.item_code+'" name="bust_'+item.item_code+'" size="2" /></td>';
								html += '<td><input type="text" value="" id="waist_'+item.item_code+'" name="waist_'+item.item_code+'" size="2" /></td>';
								html += '<td><input type="text" value="" id="hips_'+item.item_code+'" name="hips_'+item.item_code+'" size="2" /></td>';
								html += '<td><input type="text" value="" id="price_'+item.item_code+'" name="price_'+item.item_code+'" size="5" /></td>';								
								html += '<td><input type="checkbox" value="'+item.item_code+'" class="feature_item" /></td>';
								html += '</tr>';
							} else {
								html += '<tr>';
								html += '<td>'+item.item_type+'</td>';
								html += '<td>'+item.item_cipher+'</td>';
								html += '<td>'+item.item_variable+'</td>';
								html += '<td><input type="number" min="0" value="'+item.item_value+'" id="size_'+item.item_code+'" name="size_'+item.item_code+'" size="2" /></td>';
								html += '<td><input type="text" value="" id="price_'+item.item_code+'" name="price_'+item.item_code+'" size="2" /></td>';
								html += '<td><input type="checkbox" value="'+item.item_code+'" class="feature_item" /></td>';
								html += '</tr>';							
							}
						} else if(type == 'GENDER') {
							html += '<tr>';
							html += '<td>'+item.item_type+'</td>';
							html += '<td>'+item.item_name+'</td>';
							html += '<td><input type="checkbox" value="'+item.item_code+'" class="feature_item" /></td>';
							html += '</tr>';
						} else if(type == 'MATERIAL') {
							html += '<tr>';
							html += '<td>'+item.item_type+'</td>';
							html += '<td>'+item.item_name+'</td>';
							html += '<td><input type="text" class="form-control" id="feature_text_'+item.item_code+'" name="feature_text_'+item.item_code+'" /></td>';
							html += '<td><input type="checkbox" value="'+item.item_code+'" class="feature_item" /></td>';
							html += '</tr>';
						} else {
							html += '<tr><td>No feature type has been selected</td></tr>';
						}
					}
				} else {
					html = '<tr><td colspan="'+tr+'">There are currently no features</td></tr>';
				}
				$('#featureBody').html(html);
			} else {
				
			}
		}
	});
	return false;
}

function getAll() {
	/* Clear table contants first. */			
	$('#tableContent').html('');

	var type	= $('#filter_type').val();
	var tr		= 0;

	if(type == 'COLOUR') {
		$('#tableContent').html('<table class="table" id="dataTable"><thead><tr>									<th>Type</th><th>Name</th><th></th><th></th></tr></thead><tbody id="tablebody" name="tablebody"><tr><td colspan="4"></td></tr></tbody></table>');	
		tr = 4;
	} else if(type == 'SIZE') {
		if(category == 'Fashion') {
			$('#tableContent').html('<table class="table" id="dataTable"><thead><tr>									<th>Type</th><th>Cipher</th><th>Variable</th><th>Size</th><th>Bust</th><th>Waist</th><th>Hips</th><th>Amount</th><th>Update Price</th><th>Primary</th><th></th></tr></thead><tbody id="tablebody" name="tablebody"><tr><td colspan="11"></td></tr></tbody></table>');	
			tr = 11;
		} else {
			$('#tableContent').html('<table class="table" id="dataTable"><thead><tr>									<th>Type</th><th>Cipher</th><th>Variable</th><th>Size</th><th>Amount</th><th>Update Price</th><th>Primary</th><th></th></tr></thead><tbody id="tablebody" name="tablebody"><tr><td colspan="8"></td></tr></tbody></table>');	
			tr = 8;
		}
	} else if(type == 'GENDER') {
		$('#tableContent').html('<table class="table" id="dataTable"><thead><tr>									<th>Type</th><th>Name</th><th></th></tr></thead><tbody id="tablebody" name="tablebody"><tr><td colspan="4"><td></tr></tbody></table>');	
		tr = 4;
	} else if(type == 'MATERIAL') {
		$('#tableContent').html('<table class="table" id="dataTable"><thead><tr>									<th>Type</th><th>Name</th><th></th><th></th></tr></thead><tbody id="tablebody" name="tablebody"><tr><td colspan="3"><td></tr></tbody></table>');	
		tr = 3;
	} else {
		$('#tableContent').html('<table class="table" id="dataTable"><thead><tr>									<th>Type</th><th>Name</th><th>Cipher</th><th>Variable</th><th>Value</th><th>Text</th><th>Amount</th><th>Update Price</th><th>Primary</th><th></th></tr></thead><tbody id="tablebody" name="tablebody"><tr><td colspan="10"><td></tr></tbody></table>');	
		tr = 10;
	}

	oTable = $('#dataTable').dataTable({
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
		"sAjaxSource": "?action=tablesearch&filter_type="+type+"&code={/literal}{$catalogData.catalog_code}{literal}",
		"fnServerData": function ( sSource, aoData, fnCallback ) {
			$.getJSON( sSource, aoData, function (json) {
				if (json.result === false) {
					$('#tablebody').html('<tr><td align="center" colspan="'+tr+'"></td></tr>');
				}
				fnCallback(json)
			});
		},
		"fnDrawCallback": function(){
		}
	});	
	return false;
}

function makePrimaryModal(code) {
	$('#primarycode').val(code);
	$('#makePrimaryModal').modal('show');
	return false;
}

function makePrimary() {
	var primarycode = $('#primarycode').val();
	$.ajax({
		type: "GET",
		url: "feature.php",
		data: "update_primary_size="+primarycode+"&code={/literal}{$catalogData.catalog_code}{literal}",
		dataType: "json",
		success: function(data){
			if(data.result == 1) {
				getAll();
				$('#makePrimaryModal').modal('hide');
			} else {
				$('#makePrimaryModal').modal('hide');
				$.howl ({
				  type: 'info'
				  , title: 'Notification'
				  , content: data.error
				  , sticky: $(this).data ('sticky')
				  , lifetime: 7500
				  , iconCls: $(this).data ('icon')
				});	
			}
		}
	});
	return false;
}

function updatePriceModal(featurecode) {

	$.ajax({
		type: "GET",
		url: "feature.php",
		data: "get_price_size="+featurecode+"&code={/literal}{$catalogData.catalog_code}{literal}",
		dataType: "json",
		success: function(data){
			if(data.result == 1) {
				var html = '';
				var item = null;
				for(var i = 0; i < data.records.length; i++) {
					item = data.records[i];
					html += '<tr>';
					html += '<td class="'+(item.price_active == 1 ? 'success' : 'error')+'">'+item.price_id+'</td>';
					html += '<td class="'+(item.price_active == 1 ? 'success' : 'error')+'">R '+item.price_original+'</td>';
					html += '<td class="'+(item.price_active == 1 ? 'success' : 'error')+'">R '+item.price_amount+'</td>';
					html += '<td class="'+(item.price_active == 1 ? 'success' : 'error')+'">'+item.price_discount+'%</td>';
					html += '<td class="'+(item.price_active == 1 ? 'success' : 'error')+'">'+item.price_date_start+'</td>';
					html += '<td class="'+(item.price_active == 1 ? 'success' : 'error')+'">'+item.price_date_end+'</td>';
					html += '</tr>';
					
					if(item.price_active == 1) {
						$('#price_code').val(item.price_code);
					}
				}
				$('#pricetable').html(html);
				$('#pricefeaturecode').val(featurecode);
				$('#updatePriceModal').modal('show');
			} else {
				$('#updatePriceModal').modal('hide');
				$.howl ({
				  type: 'info'
				  , title: 'Notification'
				  , content: 'There is no price added for this, its not a size'
				  , sticky: $(this).data ('sticky')
				  , lifetime: 7500
				  , iconCls: $(this).data ('icon')
				});	
			}
		}
	});
	return false;
}

function updatePrice() {
	/* Get all the variables. */
	var feature			= $('#pricefeaturecode').val();
	var price_original	= $('#price_original').val();
	var price_discount	= $('#price_discount').val();
	var price_code		= $('#price_code').val();
	/* Clear the error. */
	$('#priceamounterror').html('');

	$.ajax({
		type: "GET",
		url: "feature.php",
		data: "add_price_size="+feature+"&price_code="+price_code+"&price_original="+price_original+"&price_discount="+price_discount+"&code={/literal}{$catalogData.catalog_code}{literal}",
		dataType: "json",
		success: function(data){
			if(data.result == 1) {
				getAll();
				$('#updatePriceModal').modal('hide');
			} else {
				$('#priceamounterror').html(data.error);
			}
		}
	});
	return false;
}
</script>
{/literal}
<!-- Modal -->
<div class="modal fade" id="updatePriceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Update Price</h4>
			</div>
			<div class="modal-body">
				<p>Below is a list of the current and last changed prices.</p>
				<table class="table table-bordered">
					<thead>
						<tr>
							<td>ID</td>
							<td>Price - Original</td>
							<td>Price - Calculated</td>						
							<td>Discount</td>
							<td>Start Date</td>
							<td>End Date</td>
						</tr>
					</thead>
					<tbody id="pricetable" name="pricetable"></tbody>
				</table>
				<p>Add new price below</p>		
				<div class="form-group">
					<label for="price_original">Original Amount</label>
					<input type="text" id="price_original" name="price_original"  size="20" class="form-control" data-required="true" />
					<em class="smalltext">Add the price amount.</em>
				</div>
				<div class="form-group">
					<label for="price_discount">Discount %</label>
					<input type="number" id="price_discount" name="price_discount" min="0" max="100" value="0" class="form-control" data-required="true"  />
					<em class="smalltext">Make sure the discounted percentage is between 0 and 100.</em>				
				</div>
				<p class="error" id="priceamounterror" name="priceamounterror"></p>
				<div class="form-group">
					<button type="button" class="btn btn-primary" onclick="updatePrice(); return false;">Save</button>
				</div>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
				<input type="hidden" id="pricefeaturecode" name="pricefeaturecode" value="" />
				<input type="hidden" id="price_code" name="price_code" value="" />
			</div>
		</div>
	</div>
</div>
<!-- modal -->
<!-- Modal -->
<div class="modal fade" id="makePrimaryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Make primary</h4>
			</div>
			<div class="modal-body">Are you sure you want to make this price the primary one? </div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
				<button class="btn btn-warning" type="button" onclick="javascript:makePrimary();">Primary</button>
				<input type="hidden" id="primarycode" name="primarycode" value="" />
			</div>
		</div>
	</div>
</div>
<!-- modal -->
</html>