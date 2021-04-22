<?php /* Smarty version 2.6.20, created on 2018-02-06 08:46:40
         compiled from dashboard/brand/details.tpl */ ?>
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
	<h2 class="content-header-title"><?php if (isset ( $this->_tpl_vars['brandData']['brand_code'] )): ?><?php echo $this->_tpl_vars['brandData']['brand_name']; ?>
<?php else: ?>Add a brand<?php endif; ?></h2>
	<ol class="breadcrumb">
	<li><a href="/">Home</a></li>
	<li><a href="/dashboard/">Dashboard</a></li>
	<li><a href="/dashboard/brand/">Brands</a></li>
	<li><?php if (isset ( $this->_tpl_vars['brandData']['brand_code'] )): ?><?php echo $this->_tpl_vars['brandData']['brand_name']; ?>
<?php else: ?>Add a brand<?php endif; ?></li>
	<li class="active">Details</li>
	</ol>
	</div>	 
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i><?php if (isset ( $this->_tpl_vars['brandData']['brand_code'] )): ?>Edit a brand<?php else: ?>Add a brand<?php endif; ?>
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/dashboard/brand/details.php<?php if (isset ( $this->_tpl_vars['brandData']['brand_code'] )): ?>?code=<?php echo $this->_tpl_vars['brandData']['brand_code']; ?>
<?php endif; ?>" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">			  
                <div class="form-group">
					<label for="brand_name">Name</label>
					<input type="text" id="brand_name" name="brand_name" class="form-control" data-required="true" value="<?php echo $this->_tpl_vars['brandData']['brand_name']; ?>
" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['brand_name'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['brand_name']; ?>
</span><?php else: ?><span class="smalltext">Full name of the brand as it will be seen on the website</span><?php endif; ?>					  
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
					<?php if (isset ( $this->_tpl_vars['errorArray']['supplier_code'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['supplier_code']; ?>
</span><?php else: ?><span class="smalltext">Please select a supplier this brand is under.</span><?php endif; ?>					  
                </div>                
				<?php if (isset ( $this->_tpl_vars['brandData']['brand_code'] )): ?>
                <div class="form-group">
					<b>Your brand catalog link</b><br />
					<p><a href="<?php echo $this->_tpl_vars['config']['site']; ?>
/<?php echo $this->_tpl_vars['brandData']['brand_url']; ?>
" target="_bank"><?php echo $this->_tpl_vars['config']['site']; ?>
/<?php echo $this->_tpl_vars['brandData']['brand_url']; ?>
</a></p>
                </div>	
				<?php endif; ?>				
                <div class="form-group">
					<label for="brand_email">Email Address</label>
					<input type="text" id="brand_email" name="brand_email" class="form-control" data-required="true" value="<?php echo $this->_tpl_vars['brandData']['brand_email']; ?>
" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['brand_email'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['brand_email']; ?>
</span><?php else: ?><span class="smalltext">This email address will be used on the enquiry form.</span><?php endif; ?>					  
                </div>	
                <div class="form-group">
					<label for="brand_number">Cellphone Number</label>
					<input type="text" id="brand_number" name="brand_number" class="form-control" data-required="true" value="<?php echo $this->_tpl_vars['brandData']['brand_number']; ?>
" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['brand_number'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['brand_email']; ?>
</span><?php else: ?><span class="smalltext">Cellphone number will be used for communications</span><?php endif; ?>					  
                </div>                
                <div class="form-group">
					<label for="brand_description">Description</label>
					<textarea id="brand_description" name="brand_description" class="form-control" data-required="true" data-parsley-maxlength="255" rows="3" cols="40"><?php echo $this->_tpl_vars['brandData']['brand_description']; ?>
</textarea>
					<?php if (isset ( $this->_tpl_vars['errorArray']['brand_description'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['brand_description']; ?>
</span><?php else: ?><span class="smalltext">Short description of the brand, no more than 255 characters.</span><?php endif; ?>					  
                </div>
                <div class="form-group">
					<label for="brand_website">Brand Website</label>
					<input type="text" id="brand_website" name="brand_website" class="form-control" value="<?php echo $this->_tpl_vars['brandData']['brand_website']; ?>
" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['brand_website'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['brand_website']; ?>
</span><?php else: ?><span class="smalltext">The website where customers can see all your details.</span><?php endif; ?>					  
                </div>
                <div class="form-group">
					<label for="brand_social_facebook">Social Media Link: Facebook Page URL</label>
					<input type="text" id="brand_social_facebook" name="brand_social_facebook" class="form-control" value="<?php echo $this->_tpl_vars['brandData']['brand_social_facebook']; ?>
" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['brand_social_facebook'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['brand_social_facebook']; ?>
</span><?php else: ?><span class="smalltext">Your facebook page or brand account LINK or URL.</span><?php endif; ?>					  
                </div>		
                <div class="form-group">
					<label for="brand_social_twitter">Social Media Link: Twitter Account ( Handler ONLY )</label>
					<input type="text" id="brand_social_twitter" name="brand_social_twitter" class="form-control" value="<?php echo $this->_tpl_vars['brandData']['brand_social_twitter']; ?>
" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['brand_social_twitter'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['brand_social_twitter']; ?>
</span><?php else: ?><span class="smalltext">Your twitter brand account LINK or URL ( e.g. https://twitter.com/designerbasesa ).</span><?php endif; ?>					  
                </div>
                <div class="form-group">
					<label for="brand_social_instagram">Social Media Link: Instagram Account ( Handler ONLY )</label>
					<input type="text" id="brand_social_instagram" name="brand_social_instagram" class="form-control" value="<?php echo $this->_tpl_vars['brandData']['brand_social_instagram']; ?>
" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['brand_social_instagram'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['brand_social_instagram']; ?>
</span><?php else: ?><span class="smalltext">Your instagram brand account LINK or URL.</span><?php endif; ?>					  
                </div>	
                <div class="form-group">
					<label for="brand_social_pinterest">Social Media Link: Pinterest Account URL</label>
					<input type="text" id="brand_social_pinterest" name="brand_social_pinterest" class="form-control" value="<?php echo $this->_tpl_vars['brandData']['brand_social_pinterest']; ?>
" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['brand_social_pinterest'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['brand_social_pinterest']; ?>
</span><?php else: ?><span class="smalltext">Your pinterest brand account LINK or URL.</span><?php endif; ?>					  
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
				<?php if (isset ( $this->_tpl_vars['brandData'] )): ?>
				<a href="/dashboard/brand/details.php?code=<?php echo $this->_tpl_vars['brandData']['brand_code']; ?>
" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;Details
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a href="/dashboard/brand/media.php?code=<?php echo $this->_tpl_vars['brandData']['brand_code']; ?>
" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;Images
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>				
				<?php endif; ?>
			</div> <!-- /.list-group -->
		</div>
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</html>