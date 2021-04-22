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
	<link href="/css/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css"  />
</head>
<body>
{include_php file='includes/header.php'}
<div class="container">
  <div class="content">
    <div class="content-container">
	<div class="content-header">
	<h2 class="content-header-title">Advert</h2>
	<ol class="breadcrumb">
	<li><a href="/">Home</a></li>
	<li><a href="/advert/">Advert</a></li>
	<li>{if isset($advertData)}{$advertData.advert_code}{else}Add a advert{/if}</li>
	<li class="active">Details</li>
	</ol>
	</div>	
      <div class="row">
        <div class="col-sm-12">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
				{if isset($advertData)}{$advertData.advert_code}{else}Add a advert{/if}
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/advert/details.php{if isset($advertData)}?code={$advertData.advert_code}{/if}" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">
                <div class="form-group">
					<label for="advert_type">Type</label>
					<select id="advert_type" name="advert_type" class="form-control">
						<option value=""> ------ </option>
						<option value="BANNER" {if $advertData.advert_type eq 'BANNER'}selected{/if}> BANNER </option>
						<option value="SQUARE" {if $advertData.advert_type eq 'SQUARE'}selected{/if}> SQUARE </option>
						<option value="RECTHORIZONTAL" {if $advertData.advert_type eq 'RECTHORIZONTAL'}selected{/if}> HORIZONTAL RECTANGLE </option>
						<option value="RECTVERTICAL" {if $advertData.advert_type eq 'RECTVERTICAL'}selected{/if}> VERTICAL RECTANGLE </option>
						<option value="SLIDER" {if $advertData.advert_type eq 'SLIDER'}selected{/if}> SLIDER </option>
						<option value="PRODUCT" {if $advertData.advert_type eq 'PRODUCT'}selected{/if}> PRODUCT </option>
					</select>
					{if isset($errorArray.advert_type)}<span class="error">{$errorArray.advert_type}</span>{else}<span class="smalltext">The type of advert this is.</span>{/if}					  
                </div>
                <div class="form-group">
					<label for="advert_position">Position</label>
					<select id="advert_position" name="advert_position" class="form-control">
						<option value=""> ------ </option>
						<option value="TOP" {if $advertData.advert_position eq 'TOP'}selected{/if}> TOP </option>
						<option value="SIDEBAR" {if $advertData.advert_position eq 'SIDEBAR'}selected{/if}> SIDEBAR </option>
						<option value="FOOTER" {if $advertData.advert_position eq 'FOOTER'}selected{/if}> FOOTER </option>
						<option value="PAGE" {if $advertData.advert_position eq 'PAGE'}selected{/if}> PAGE </option>
						<option value="FEATURED" {if $advertData.advert_position eq 'FEATURED'}selected{/if}> FEATURED </option>
					</select>
					{if isset($errorArray.advert_position)}<span class="error">{$errorArray.advert_position}</span>{else}<span class="smalltext">Position of the advert on the page</span>{/if}					  
                </div>				
                <div class="form-group">
					<label for="advert_page">Page</label>
					<input id="advert_page" name="advert_page" class="form-control" type="text" value="{$advertData.advert_page}"/>
					{if isset($errorArray.advert_page)}<span class="error">{$errorArray.advert_page}</span>{else}<span class="smalltext">Add a page this should be showing on, e.g. HOME, CATALOG, etc..</span>{/if}					  
                </div>
                <div class="form-group">
					<label for="advert_text">Text</label>
					<textarea id="advert_text" name="advert_text" class="form-control wysihtml5" type="text" value="{$advertData.advert_text}" rows="5"></textarea>
					{if isset($errorArray.advert_text)}<span class="error">{$errorArray.advert_text}</span>{else}<span class="smalltext">Text message of the advert</span>{/if}					  
                </div>				
                <div class="form-group">
					<label for="advert_url">URL</label>
					<input id="advert_url" name="advert_url" class="form-control" type="text" value="{$advertData.advert_url}"/>
					{if isset($errorArray.advert_url)}<span class="error">{$errorArray.advert_url}</span>{else}<span class="smalltext">Add a url link of the advert</span>{/if}					  
                </div>	
                <div class="form-group">
					<label for="advert_date_start">Date: Start</label>
					<input id="advert_date_start" name="advert_date_start" class="form-control" type="text" value="{$advertData.advert_date_start}"/>
					{if isset($errorArray.advert_date_start)}<span class="error">{$errorArray.advert_date_start}</span>{else}<span class="smalltext">Add start date of the advert</span>{/if}					  
                </div>
                <div class="form-group">
					<label for="advert_date_end">Date: End</label>
					<input id="advert_date_end" name="advert_date_end" class="form-control" type="text" value="{$advertData.advert_date_end}"/>
					{if isset($errorArray.advert_date_end)}<span class="error">{$errorArray.advert_date_end}</span>{else}<span class="smalltext">Add end date of the advert</span>{/if}					  
                </div>
                <div class="form-group"><button type="submit" class="btn btn-primary">Validate and Submit</button></div>
            </div>				
            </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
		  {if isset($advertData) && $advertData.advert_type eq 'PRODUCT'}
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
				Add product codes
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/advert/details.php{if isset($advertData)}?code={$advertData.advert_code}{/if}" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">			
                <div class="form-group">
					<label for="catalog_code">Product code</label>
					<input id="catalog_code" name="catalog_code" class="form-control" type="text" value=""/>
					{if isset($errorArray.catalog_code)}<span class="error">{$errorArray.catalog_code}</span>{else}<span class="smalltext">Product this item is linked to</span>{/if}					  
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Validate and Submit</button>
                    <input type="hidden" value="1" name="catalog_link" id="catalog_link" />  
                </div>
                <div class="form-group">
				<p>Below is a list of advert products to be on featured lists.</p>
				<table class="table table-bordered">	
					<thead>
						<tr>
							<td></td>
							<td>Name - Description</td>
							<td>Price</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					{foreach from=$linkData item=catalog}
    					<tr>
    						<td>
    							<a href="{$config.site}{$catalog.media_path}big_{$catalog.media_code}{$catalog.media_ext}" target="_blank">
    								<img src="{$config.site}{$catalog.media_path}tny_{$catalog.media_code}{$catalog.media_ext}" width="60" />
    							</a>
    						</td>	
    						<td>{$catalog.catalog_name} - {$catalog.catalog_text}</td>
    						<td>R {$catalog.price_amount}</td>
    						<td>
    						    <button value="Delete" class="btn btn-danger" onclick="deleteFeatureModal('{$catalog.link_code}'); return false;">Delete</button>
    						</td>
    					</tr>			     
					{foreachelse}
    					<tr>
    						<td align="center" colspan="4">There are currently no products added</td>
    					</tr>					
					{/foreach}
					</tbody>					  
				</table>
                </div>				
              </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->	
		{/if}          
		  {if isset($advertData) && $advertData.advert_type neq 'PRODUCT'}
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
				Upload image(s) and their texts
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/advert/details.php{if isset($advertData)}?code={$advertData.advert_code}{/if}" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">			
                <div class="form-group">
					<label for="mediafiles">Image Upload</label>
					<input type="file" id="mediafiles" name="mediafiles" />
					{if isset($errorArray.mediafiles)}<span class="error">{$errorArray.mediafiles}</span>{/if}
					<span>N.B.: Only .gif, .jpg, .jpeg or .png</span>
                </div>	
                <div class="form-group">
					<label for="media_url">URL</label>
					<input id="media_url" name="media_url" class="form-control" type="text" value="{$advertData.media_url}"/>
					{if isset($errorArray.media_url)}<span class="error">{$errorArray.media_url}</span>{else}<span class="smalltext">URL linking of this image as an advert will be linking to</span>{/if}					  
                </div>				
                <div class="form-group">
					<label for="media_text">Image Text</label>
					<textarea id="media_text" name="media_text" class="form-control wysihtml5" type="text" value="{$advertData.media_text}" rows="5"></textarea>
					{if isset($errorArray.media_text)}<span class="error">{$errorArray.media_text}</span>{else}<span class="smalltext">Optionally add a message for this particular image, will also be used for alt and title</span>{/if}					  
                </div>				
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Validate and Submit</button>
                    <input type="hidden" value="1" name="image_link" id="image_link" />
                </div>
                <div class="form-group">
				<p>Below is a list of advert images linked to this advert.</p>
				<table class="table table-bordered">	
					<thead>
						<tr>
							<td>Image</td>
							<td>Text</td>
							<td></td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					{foreach from=$mediaData item=advert}
						<tr>
							<td>
								<a href="{$config.site}{$advert.media_path}{$advert.media_code}{$advert.media_ext}" target="_blank">
									<img src="{$config.site}{$advert.media_path}{$advert.media_code}{$advert.media_ext}" width="60" />
								</a>
							</td>	
							<td>{$advert.media_text}</td>							
							<td>
								{if $advert.media_primary eq '0'}
									<button value="Make Primary" class="btn btn-danger" onclick="statusSubModal('{$advert.media_code}', '1', 'details', '{$advertData.advert_code}'); return false;">Primary</button>
								{else}
									<b>Primary</b>
								{/if}
							</td>
							<td>
								{if $advert.media_primary eq '0'}
									<button value="Delete" class="btn btn-danger" onclick="deleteModal('{$advert.media_code}', '{$advertData.advert_code}', 'details'); return false;">Delete</button>
								{else}
									<b>Primary</b>
								{/if}
							</td>
						</tr>			     
					{foreachelse}
						<tr>
							<td align="center" colspan="3">There are currently no adverts</td>
						</tr>					
					{/foreach}
					</tbody>					  
				</table>
                </div>				
              </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->	
		{/if}		  
        </div> <!-- /.col -->
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
{include_php file='includes/footer.php'}
{include_php file='includes/javascript.php'}
<script type="text/javascript" src="/library/javascript/plugins/wysihtml5/wysihtml5-0.3.js"></script>
<script type="text/javascript" src="/library/javascript/plugins/wysihtml5/bootstrap-wysihtml5.js"></script>
{literal}
<script type="text/javascript" language="javascript">
$(document).ready(function(){

	$('.wysihtml5').wysihtml5();
	
    var dateFormat = "yy-mm-dd",
      from = $( "#advert_date_start" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
		  dateFormat: "yy-mm-dd",
          numberOfMonths: 3
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#advert_date_end" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
		dateFormat: "yy-mm-dd",
        numberOfMonths: 3
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
      return date;
    }
	});
	function deleteFeature() {
		$.ajax({
			type: "GET",
			url: "details.php?deletefeature=1",
			data: "featurecode="+$('#catalogcode').val(),
			dataType: "json",
			success: function(data){
				if(data.result == 1) {
                    window.location.href = window.location.href;
				} else {
					$('#deleteFeatureModal').modal('hide');
					$.howl ({
					  type: 'danger'
					  , title: 'Error Message'
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

	function deleteFeatureModal(code) {
		$('#catalogcode').val(code);
		$('#deleteFeatureModal').modal('show');
		return false;
	}
	
  </script>
{/literal}
<!-- Modal -->
<div class="modal fade" id="deleteFeatureModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Delete Item</h4>
			</div>
			<div class="modal-body">Are you sure you want to delete this featured product?</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
				<button class="btn btn-warning" type="button" onclick="javascript:deleteFeature();">Delete Feature</button>
				<input type="hidden" id="catalogcode" name="catalogcode" value=""/>
			</div>
		</div>
	</div>
</div>
<!-- modal -->

</html>
