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
	<h2 class="content-header-title">Catalog</h2>
	<ol class="breadcrumb">
	<li><a href="/">Home</a></li>
	<li><a href="#">{$activeBrand.brand_name}</a></li>
	<li><a href="/catalog/">Catalog</a></li>
	<li>{if isset($catalogData)}{$catalogData.catalog_name}{else}Add a catalog{/if}</li>
	<li class="active">Details</li>
	</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
				{if isset($catalogData)}{$catalogData.catalog_name}{else}Add a catalog{/if}
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/catalog/details.php{if isset($catalogData)}?code={$catalogData.catalog_code}{/if}" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">
                <div class="form-group">
					<label for="catalog_name">Name</label>
					<input type="text" id="catalog_name" name="catalog_name" class="form-control" data-required="true" value="{$catalogData.catalog_name}" />
					{if isset($errorArray.catalog_name)}<span class="error">{$errorArray.catalog_name}</span>{else}<span class="smalltext">Full name of the catalog as it will be seen on the website</span>{/if}					  
                </div>		
                <div class="form-group">
					<label for="category_code">Category</label>
					<select id="category_code" name="category_code" class="form-control" data-required="true" >
						<option value=""> ------------ </option>
						{html_options options=$categoryData selected=$catalogData.item_parent_code}
					</select>
					{if isset($errorArray.category_code)}<span class="error">{$errorArray.category_code}</span>{else}<span class="smalltext">The category the catalog is under</span>{/if}					  
                </div>	
                <div class="form-group">
					<label for="item_code">Section</label>
					<select id="item_code" name="item_code" class="form-control" data-required="true" >
						<option value=""> Select category first </option>
					</select>
					{if isset($errorArray.item_code)}<span class="error">{$errorArray.item_code}</span>{else}<span class="smalltext">Select section of a category if a category has sections under it.</span>{/if}					  
                </div>				
                <div class="form-group">
					<label for="catalog_text">Description</label>
					<textarea id="catalog_text" name="catalog_text" class="form-control wysihtml5" data-required="true" rows="15">{$catalogData.catalog_text}</textarea>
					{if isset($errorArray.catalog_text)}<span class="error">{$errorArray.catalog_text}</span>{else}<span class="smalltext">Short or page description of your catalog.</span>{/if}					  
                </div>
                <div class="form-group"><button type="submit" class="btn btn-primary">Validate and Submit</button></div>
              </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->	
		<div class="col-sm-3">
			<div class="list-group">  
				<a href="/catalog/" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;List
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				{if isset($catalogData)}
				<a href="/catalog/details.php?code={$catalogData.catalog_code}" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;Details
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>				
				<a href="/catalog/feature.php?code={$catalogData.catalog_code}" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;Features
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<!--
				<a href="/catalog/price.php?code={$catalogData.catalog_code}" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;Price
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				-->
				<a href="/catalog/media.php?code={$catalogData.catalog_code}" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;Media
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				{/if}
			</div> <!-- /.list-group -->
		</div>
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

function changeCategory() {
	
	var category = $("#category_code :selected").val();
	
	if(category != '') {
		$.ajax({ 
			type: "GET",
			url: "details.php{/literal}?code={$catalogData.catalog_code}{literal}",
			data: "parent_category="+category,
			dataType: "html",
			success: function(data){
				$('#item_code').html(data);
			}
		});			
	}
}

$(document).ready(function(){
	$('.wysihtml5').wysihtml5();	
	changeCategory();
	$("#category_code").change(function(){
		changeCategory();
	});
});
</script>
{/literal}
</html>
