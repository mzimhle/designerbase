<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Designer Base - Account activation for {$participantData.participant_name} was successful</title>
    <!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">	
	<meta name="keywords" content="account, online profile, designer, base, successful, activation">
	<meta name="description" content="Designer Base - Account activation for {$participantData.participant_name} was successful">
	<meta name="robots" content="index, follow">
	<meta name="revisit-after" content="21 days">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta property="og:title" content="Designer Base">
	<meta property="og:image" content="http://www.designerbase.co.za/images/logo.png">  
	<meta property="og:url" content="http://www.designerbase.co.za">
	<meta property="og:site_name" content="Designer Base">
	<meta property="og:type" content="website">
	<meta property="og:description" content="Designer Base - Account activation for {$participantData.participant_name} was successful">
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
							<h1>Successful Activation</h1>
							<br />
							<p>Good day <span class="green">{$participantData.participant_name}</span>, you have been successfully activated in our system.</p><br />
							<p>{$loginEmail}</p>
						</div><!-- End .page-header -->
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