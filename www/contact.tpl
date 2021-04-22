<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Designer Base - Register to become a member of DesignerBase</title>
    <!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">	
	<meta name="keywords" content="online catalog, product list, designer fashion, accessories, foot wear, art">
	<meta name="description" content="Designer Base - Register to become a member of DesignerBase">         
	<meta name="robots" content="index, follow">
	<meta name="revisit-after" content="21 days">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta property="og:title" content="Designer Base">
	<meta property="og:image" content="http://www.designerbase.co.za/images/logo.png">  
	<meta property="og:url" content="http://www.designerbase.co.za">
	<meta property="og:site_name" content="Designer Base">
	<meta property="og:type" content="website">
	<meta property="og:description" content="Designer Base - Register to become a member of DesignerBase">
    <!-- Google Fonts -->
    <link href="http://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700%7COswald:300,400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="/css/plugins.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/images/icons/favicon.png" />
    <!-- Modernizr -->
    <script src="/library/javascript/modernizr.js"></script>
</head>
<body>
    <div id="wrapper">
		{include_php file='includes/header.php'}
        <div class="main">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
						<div class="page-header" style="margin-top: -32px;">
							<h1>Contact Us</h1>
							<p>Below is where you can send us a message for any enquiry you might have for us to respond to.</p>
						</div><!-- End .page-header -->
						<form action="/contact" method="POST" class="signup-form">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Full name*</label>
										<input type="text" class="form-control" id="enquiry_name" name="enquiry_name" required />
									</div><!-- End .form-group -->
								</div><!-- End .col-sm-4 -->
								<div class="col-sm-6">
									<div class="form-group">
										<label>Email address*</label>
										<input type="text" class="form-control" id="enquiry_email" name="enquiry_email" required />
									</div><!-- End .form-group -->
								</div><!-- End .col-sm-4 -->
							</div><!-- End .row -->
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>Message*</label>
										<textarea id="enquiry_message" class="form-control" name="enquiry_message" cols="100" rows="6" required></textarea>
									</div><!-- End .form-group -->
								</div><!-- End .col-sm-4 -->
							</div><!-- End .row -->
							{if isset($errorArray)}
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<p class="red">{$errorArray}</p>
									</div><!-- End .form-group -->
								</div><!-- End .col-sm-4 -->
							</div><!-- End .row -->
							{/if}
							{if isset($success)}
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<p class="green">
											You have been successfully registered, you will be sent an email which you will need to confirm / verify your email address.
										</p>
									</div><!-- End .form-group -->
								</div><!-- End .col-sm-4 -->
							</div><!-- End .row -->
							{/if}								
							<div class="clearfix form-action">
								<input type="submit" class="btn btn-primary min-width" value="Send">
							</div><!-- End .form-action -->
						</form>
					</div><!-- End .col-md-12 -->
                </div>
                <!-- End .row -->
            </div>
            <!-- End .container -->
        </div>
        <!-- End .main -->
		{include_php file='includes/footer.php'}
    </div>
    <!-- End #wrapper -->
    <a id="scroll-top" href="#top" title="Scroll top"><i class="fa fa-angle-up"></i></a>
    <!-- End -->
    <script src="/library/javascript/plugins.js"></script>
    <script src="/library/javascript/main.js"></script>
</body>
</html>