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
	<h2 class="content-header-title">Categories</h2>
	<ol class="breadcrumb">
	<li><a href="/">Home</a></li>
	<li><a href="#">Dashboard</a></li>
	<li><a href="/dashboard/category/">Categories</a></li>
	<li>{if isset($itemData.item_code)}{$itemData.item_name}{else}Add a category{/if}</li>
	<li class="active">Details</li>
	</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					{if isset($itemData.item_code)}{$itemData.item_name}{else}Add a category{/if}
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
				<form id="validate-basic" action="/dashboard/category/details.php{if isset($itemData.item_code)}?code={$itemData.item_code}{/if}" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">
					<div class="form-group">
						<label for="item_name">Name</label>
						<input type="text" id="item_name" name="item_name" class="form-control" data-required="true" value="{$itemData.item_name}" />
						{if isset($errorArray.item_name)}<span class="error">{$errorArray.item_name}</span>{else}<span class="smalltext">Full name of the item as it will be seen on the website</span>{/if}					  
					</div>
					{if isset($itemData.item_code)}
					<div class="form-group">
						<b>URL</b><br />
						<p><a href="#" target="_bank">{$itemData.item_url}</a></p>
					</div>	
					{/if}
					<div class="form-group"><button type="submit" class="btn btn-primary">Validate and Submit</button></div>
				</form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->	
		<div class="col-sm-3">
			<div class="list-group">  
				<a href="/dashboard/category/" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;My Bands
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				{if isset($itemData)}
				<a href="#" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;Details
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a href="/dashboard/category/media.php?code={$itemData.item_code}" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;Images
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a href="/dashboard/category/section.php?code={$itemData.item_code}" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;Sections
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
</html>
