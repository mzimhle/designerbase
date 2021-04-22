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
	<h2 class="content-header-title">{if isset($brandData.brand_code)}{$brandData.brand_name}{else}Add a brand{/if}</h2>
	<ol class="breadcrumb">
	<li><a href="/">Home</a></li>
	<li><a href="/dashboard/">Dashboard</a></li>
	<li><a href="/dashboard/brand/">Brands</a></li>
	<li>{if isset($brandData.brand_code)}{$brandData.brand_name}{else}Add a brand{/if}</li>
	<li class="active">Details</li>
	</ol>
	</div>	 
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>{if isset($brandData.brand_code)}Edit a brand{else}Add a brand{/if}
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/dashboard/brand/details.php{if isset($brandData.brand_code)}?code={$brandData.brand_code}{/if}" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">			  
                <div class="form-group">
					<label for="brand_name">Name</label>
					<input type="text" id="brand_name" name="brand_name" class="form-control" data-required="true" value="{$brandData.brand_name}" />
					{if isset($errorArray.brand_name)}<span class="error">{$errorArray.brand_name}</span>{else}<span class="smalltext">Full name of the brand as it will be seen on the website</span>{/if}					  
                </div>
                <div class="form-group">
					<label for="brand_delivery">Delivery Time in weeks</label>
					<select id="brand_delivery" name="brand_delivery" class="form-control" data-required="true" >
						<option value="1"> 1 </option>
						<option value="2"> 2 </option>
						<option value="3"> 3 </option>
						<option value="4"> 4 </option>
						<option value="5"> 5 </option>
						<option value="6"> 6 </option>
						<option value="7"> 7 </option>
						<option value="8"> 8 </option>
						<option value="9"> 9 </option>
						<option value="10"> 10 </option>
					</select>
					{if isset($errorArray.supplier_code)}<span class="error">{$errorArray.supplier_code}</span>{else}<span class="smalltext">Please select a supplier this brand is under.</span>{/if}					  
                </div>                
				{if isset($brandData.brand_code)}
                <div class="form-group">
					<b>Your brand catalog link</b><br />
					<p><a href="{$config.site}/{$brandData.brand_url}" target="_bank">{$config.site}/{$brandData.brand_url}</a></p>
                </div>	
				{/if}				
                <div class="form-group">
					<label for="brand_email">Email Address</label>
					<input type="text" id="brand_email" name="brand_email" class="form-control" data-required="true" value="{$brandData.brand_email}" />
					{if isset($errorArray.brand_email)}<span class="error">{$errorArray.brand_email}</span>{else}<span class="smalltext">This email address will be used on the enquiry form.</span>{/if}					  
                </div>	
                <div class="form-group">
					<label for="brand_number">Cellphone Number</label>
					<input type="text" id="brand_number" name="brand_number" class="form-control" data-required="true" value="{$brandData.brand_number}" />
					{if isset($errorArray.brand_number)}<span class="error">{$errorArray.brand_email}</span>{else}<span class="smalltext">Cellphone number will be used for communications</span>{/if}					  
                </div>                
                <div class="form-group">
					<label for="brand_description">Description</label>
					<textarea id="brand_description" name="brand_description" class="form-control" data-required="true" data-parsley-maxlength="255" rows="3" cols="40">{$brandData.brand_description}</textarea>
					{if isset($errorArray.brand_description)}<span class="error">{$errorArray.brand_description}</span>{else}<span class="smalltext">Short description of the brand, no more than 255 characters.</span>{/if}					  
                </div>
                <div class="form-group">
					<label for="brand_website">Brand Website</label>
					<input type="text" id="brand_website" name="brand_website" class="form-control" value="{$brandData.brand_website}" />
					{if isset($errorArray.brand_website)}<span class="error">{$errorArray.brand_website}</span>{else}<span class="smalltext">The website where customers can see all your details.</span>{/if}					  
                </div>
                <div class="form-group">
					<label for="brand_social_facebook">Social Media Link: Facebook Page URL</label>
					<input type="text" id="brand_social_facebook" name="brand_social_facebook" class="form-control" value="{$brandData.brand_social_facebook}" />
					{if isset($errorArray.brand_social_facebook)}<span class="error">{$errorArray.brand_social_facebook}</span>{else}<span class="smalltext">Your facebook page or brand account LINK or URL.</span>{/if}					  
                </div>		
                <div class="form-group">
					<label for="brand_social_twitter">Social Media Link: Twitter Account ( Handler ONLY )</label>
					<input type="text" id="brand_social_twitter" name="brand_social_twitter" class="form-control" value="{$brandData.brand_social_twitter}" />
					{if isset($errorArray.brand_social_twitter)}<span class="error">{$errorArray.brand_social_twitter}</span>{else}<span class="smalltext">Your twitter brand account LINK or URL ( e.g. https://twitter.com/designerbasesa ).</span>{/if}					  
                </div>
                <div class="form-group">
					<label for="brand_social_instagram">Social Media Link: Instagram Account ( Handler ONLY )</label>
					<input type="text" id="brand_social_instagram" name="brand_social_instagram" class="form-control" value="{$brandData.brand_social_instagram}" />
					{if isset($errorArray.brand_social_instagram)}<span class="error">{$errorArray.brand_social_instagram}</span>{else}<span class="smalltext">Your instagram brand account LINK or URL.</span>{/if}					  
                </div>	
                <div class="form-group">
					<label for="brand_social_pinterest">Social Media Link: Pinterest Account URL</label>
					<input type="text" id="brand_social_pinterest" name="brand_social_pinterest" class="form-control" value="{$brandData.brand_social_pinterest}" />
					{if isset($errorArray.brand_social_pinterest)}<span class="error">{$errorArray.brand_social_pinterest}</span>{else}<span class="smalltext">Your pinterest brand account LINK or URL.</span>{/if}					  
                </div>			
                <div class="form-group"><button type="submit" class="btn btn-primary">Validate and Submit</button></div>
              </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->	
		<div class="col-sm-3">
			<div class="list-group">  
				<a href="/dashboard/brand/" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;My Bands
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				{if isset($brandData)}
				<a href="/dashboard/brand/details.php?code={$brandData.brand_code}" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;Details
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a href="/dashboard/brand/media.php?code={$brandData.brand_code}" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;Images
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
