<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Designer Base - Login on the website to access it's full potential</title>
    <!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">	
	<meta name="keywords" content="online catalog, product list, designer fashion, accessories, foot wear, art">
	<meta name="description" content="Designer Base - Login on the website to access it's full potential">         
	<meta name="robots" content="index, follow">
	<meta name="revisit-after" content="21 days">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta property="og:title" content="Designer Base">
	<meta property="og:image" content="http://www.designerbase.co.za/images/logo.png">  
	<meta property="og:url" content="http://www.designerbase.co.za">
	<meta property="og:site_name" content="Designer Base">
	<meta property="og:type" content="website">
	<meta property="og:description" content="Designer Base - Login on the website to access it's full potential">
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
							<h1>Login</h1>
							<p>Login to access your Designer Base account</p>
						</div><!-- End .page-header -->
						<form action="/login" method="POST" class="signin-form">
							<div class="form-group">
								<label>E-mail Address*</label>
								<input type="email" class="form-control" required id="username" name="username" />
							</div><!-- End .form-group -->
							<div class="form-group">
								<label>Password*</label>
								<input type="password" class="form-control" required id="password" name="password" />
							</div><!-- End .form-group -->
							<div class="clearfix form-more">
								<a href="/password" class="help-link">LOST YOUR PASSWORD?</a>
							</div><!-- End .form-more -->
							<div class="clearfix form-action">
								<a href="/register/" class="btn btn-primary pull-right min-width">CREATE ACCOUNT</a>
								<input type="submit" class="btn btn-accent pull-left min-width" value="SIGN IN">
							</div><!-- End .form-action -->
							{if isset($loginmessage)}
							<br />
							<div class="clearfix form-more">
								<p class="red">{$loginmessage}</p>
							</div><!-- End .form-more -->							
							{/if}
						</form>
					</div><!-- End .col-md-9 -->
					{if isset($advertVertical)}
					<div class="col-md-3">
					{foreach from=$advertVertical.media item=vertical}
						<div class="banner banner-image">
							<a href="{$vertical.media_url}" title="{$vertical.media_text}" alt="{$vertical.media_text}">
								<img src="{$vertical.media_path}{$vertical.media_code}{$vertical.media_ext}" alt="{$vertical.media_text}" title="{$vertical.media_text}" />
							</a>
						</div>
					{/foreach}
					<!-- End .widget -->
					</div>							
					{/if} 										
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