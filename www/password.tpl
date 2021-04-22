<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Designer Base - Resend my password</title>
    <!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">	
	<meta name="keywords" content="online catalog, product list, designer fashion, accessories, foot wear, art">
	<meta name="description" content="Designer Base - Resend my password">         
	<meta name="robots" content="index, follow">
	<meta name="revisit-after" content="21 days">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta property="og:title" content="Designer Base">
	<meta property="og:image" content="http://www.designerbase.co.za/images/logo.png">  
	<meta property="og:url" content="http://www.designerbase.co.za">
	<meta property="og:site_name" content="Designer Base">
	<meta property="og:type" content="website">
	<meta property="og:description" content="Designer Base - Resend my password">
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
                    <div class="col-md-{if isset($advertVertical)}9{else}12{/if}">
						<div class="page-header" style="margin-top: -32px;">
							<h1>Forgot Password</h1>
							<p>If you have forgotten your password, please put in your email address below and we will resend it to you.</p>
						</div><!-- End .page-header -->
						<form action="/password" method="POST" class="signin-form">
							<div class="form-group">
								<label>E-mail Address*</label>
								<input type="email" class="form-control" required name="participant_email" id="participant_email">
							</div><!-- End .form-group -->
							{if isset($errorArray)}
							<div class="form-group">
								<p class="error">{$errorArray}</p>
							</div><!-- End .form-group -->
							{/if}
							{if isset($success)}
							<div class="form-group">
								<p class="success">
									You have been successfully registered, you will be sent an email which you will need to confirm / verify your email address.
								</p>
							</div><!-- End .form-group -->
							{/if}
							<div class="clearfix form-action">
								<a href="/login" class="btn btn-primary pull-right min-width">SIGN IN</a>
								<input type="submit" class="btn btn-accent pull-left min-width" value="RESEND PASSWORD" />
							</div><!-- End .form-action -->
						</form>
					</div><!-- End .col-md-9 -->
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