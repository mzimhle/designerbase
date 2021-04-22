<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<title>DesignerBase Account Management System</title>
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
		<h2 class="content-header-title">{$brandData.brand_name}</h2>
		<ol class="breadcrumb">
			<li><a href="/">Home</a></li>
			<li><a href="#">Dashboard</a></li>
			<li><a href="#">{$activeSupplier.supplier_name}</a></li>
			<li><a href="/dashboard/brand/">Brands</a></li>
			<li><a href="/dashboard/brand/details.php?code={$brandData.brand_code}">{$brandData.brand_name}</a></li>
			<li class="active">Profile</li>
		</ol>
	</div>
      <div class="row">
        <div class="col-sm-12">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
				{$activeSupplier.brand_name}
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/dashboard/brand/profile.php?code={$brandData.brand_code}" method="POST" data-validate="parsley" class="form parsley-form">			
                <div class="form-group">
					<label for="brand_text">Page</label>
					<textarea id="brand_text" name="brand_text" class="form-control wysihtml5" data-required="true" rows="40">{$brandData.brand_text}</textarea>
					{if isset($errorArray.brand_text)}<span class="error">{$errorArray.brand_text}</span>{else}<span class="smalltext">Full page description about you and your work and anything that you feel you want to share about yourself.</span>{/if}					  
                </div>
                <div class="form-group"><button type="submit" class="btn btn-primary">Validate and Submit</button></div>
              </form>
              <form id="validate-basic" action="/dashboard/brand/profile.php?code={$brandData.brand_code}" method="POST" class="form parsley-form" enctype="multipart/form-data">			
				<p>Below is a list of profile images.</p>
				<table class="table table-bordered">	
					<thead>
						<tr>
							<td width="100px">Image</td>
							<td>Link</td>
							<td width="100px"></td>
						</tr>
					</thead>
					<tbody>
						{foreach from=$mediaData item=item}
						<tr>
							<td>
								<a href="{$config.site}{$item.media_path}/profile_{$item.media_code}{$item.media_ext}" target="_blank">
									<img src="{$config.site}{$item.media_path}/profile_{$item.media_code}{$item.media_ext}" width="60" />
								</a>
							</td>
							<td>
								{$config.site}{$item.media_path}/profile_{$item.media_code}{$item.media_ext}
							</td>
							<td>
								<button value="Delete" onclick="deleteModal('{$item.media_code}', '{$brandData.brand_code}', 'profile'); return false;">Delete</button>
							</td>
						</tr>			     
						{foreachelse}
						<tr>
							<td align="center" colspan="3">There are currently no items</td>
						</tr>					
						{/foreach}
					</tbody>					  
				</table>
				<p>Add new image below</p>		
                <div class="form-group">
					<input type="file" id="mediafiles[]" name="mediafiles[]" multiple />
					{if isset($errorArray.mediafiles)}<br /><span class="error">{$errorArray.mediafiles}</span>{/if}
                </div>	
                <div class="form-group"><button type="submit" class="btn btn-primary">Upload</button></div>
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
<script type="text/javascript" src="/library/javascript/plugins/wysihtml5/wysihtml5-0.3.js"></script>
<script type="text/javascript" src="/library/javascript/plugins/wysihtml5/bootstrap-wysihtml5.js"></script>
{literal}
<script type="text/javascript" language="javascript">
$(document).ready(function(){
	$('.wysihtml5').wysihtml5();	
});
</script>
{/literal}
</html>
