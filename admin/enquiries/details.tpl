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
</head>
<body>
{include_php file='includes/header.php'}
<div class="container">
  <div class="content">
    <div class="content-container">
	<div class="content-header">
	<h2 class="content-header-title">Brands</h2>
	<ol class="breadcrumb">
	<li><a href="/">Home</a></li>
	<li><a href="/enquiries/">Enquiries</a></li>
	<li>{if isset($enquiryData)}{$enquiryData.enquiry_name}{else}Add a enquiry{/if}</li>
	<li class="active">Details</li>
	</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					REF#{$enquiryData.enquiry_code}
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/enquiries/details.php{if isset($enquiryData)}?code={$enquiryData.enquiry_code}{/if}" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">
                <div class="form-group">
					<label for="enquiry_name">Enquiry name</label><br />
					{$enquiryData.enquiry_name}
                </div>
                <div class="form-group">
					<label for="enquiry_email">Enquiry email</label><br />
					{$enquiryData.enquiry_email}
                </div>	
                <div class="form-group">
					<label for="enquiry_message">Message</label><br />
					{$enquiryData.enquiry_message}
                </div>
                <div class="form-group">
					<label for="product_name">Product</label><br />
					{$enquiryData.product_name} ( REF#{$enquiryData.product_code} )
                </div>
                <div class="form-group">
					<label for="brand_name">Brand</label><br />
					{$enquiryData.brand_name}
                </div>				
                <div class="form-group">
					{if $enquiryData.image_path eq ''}
						<img src="/images/avatar.jpg" width="120" />
					{else}
						<img src="http://www.designerbase.co.za{$enquiryData.image_path}tny_{$enquiryData.image_code}{$enquiryData.image_ext}" />
					{/if}
                </div> <!-- /.form-group -->					
              </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->	
		<div class="col-sm-3">
			<div class="list-group">  
				<a href="/enquirys/" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;List
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
			</div> <!-- /.list-group -->
		</div>
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
{include_php file='includes/footer.php'}
{include_php file='includes/javascript.php'}
</html>
