<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>DesignerBase - {$participantData.participant_name} account</title>
    <!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">	
	<meta name="keywords" content="online store, fashion, designers, clothing">
	<meta name="description" content="Designer Base - Online catalog for up and coming fashion designers">         
	<meta name="robots" content="index, follow">
	<meta name="revisit-after" content="21 days">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta property="og:title" content="DesignerBase">
	<meta property="og:image" content="http://www.designerbase.co.za/images/logo.png">  
	<meta property="og:url" content="http://www.designerbase.co.za">
	<meta property="og:site_name" content="DesignerBase">
	<meta property="og:type" content="website">
	<meta property="og:description" content="DesignerBase - Online catalog for up and coming fashion designers" />
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
                    <div class="col-md-9 col-md-push-3">
						<form action="/account/" method="POST" enctype="multipart/form-data">						
							<div class="page-header text-left">
								<h1>My Account</h1>
								<p>These are your personal details that you can update.</p>
    							{if isset($success)}
    							<p class="green">Your details have been updated successfully, they will display when you log in again.</p>
    							{/if}								
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Full Name*</label>
									<input type="text" class="form-control" required="" id="participant_name" name="participant_name" value="{$participantData.participant_name}"/>
								</div>
								<div class="form-group">
									<label>Email*</label>
									<input type="text" class="form-control" required="" id="participant_email" name="participant_email" value="{$participantData.participant_email}" readonly disabled />
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Number</label>
									<input type="text" class="form-control" id="participant_number" name="participant_number" value="{$participantData.participant_number}"  />
								</div>
								<div class="form-group">
									<label>Upload Profile</label>
									<input type="file" id="mediafile" name="mediafile" />
								</div>
							</div>									
							<div class="col-sm-12">
								<div class="form-group">
									<label>Password*</label>
									<input type="password" class="form-control" id="participant_password" name="participant_password" value="{$participantData.participant_password}"  />
								</div>						
								<div class="form-group">
									<label>Retype password*</label>
									<input type="password" class="form-control" id="participant_password_2" name="participant_password_2" value="{$participantData.participant_password}"  />
								</div>						
							</div>
							<div class="col-sm-12">
								<div class="clearfix text-left">
									<input type="submit" class="btn btn-accent min-width" value="Save">
								</div>	
								<br />	
							</div>
							{if isset($errorArray)}
							<div class="col-sm-12">
								{$errorArray}
								<br />	
							</div>
							{/if}							
						</form>
                    </div>
                    <!-- End .col-md-9 -->
                    <aside class="col-md-3 col-md-pull-9 sidebar sidebar-shop">
                        {if $participantData.media_code neq ''}
                        <!-- <img src="/images/no_avatar.jpg" width="210px" /> -->
                        <div class="widget widget-box widget-shop-category active">
							<img src="{$participantData.media_path}tmb_{$participantData.media_code}{$participantData.media_ext}" width="210px" />
                        </div>
                        {/if}
                        <!-- End .widget -->
                        <div class="widget widget-box widget-shop-category active">
                            <!-- <h3 class="widget-title">Categories</h3> -->
                            <ul class="shop-category-list accordion">
                                <li><a href="/account">My Account</a></li>
								<li><a href="/account/purchases">Previous purchases</a></li>
                            </ul>
                        </div>						
                    </aside>
                    <!-- End .col-md-3 -->
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