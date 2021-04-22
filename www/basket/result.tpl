<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
		<title>Designer Base - Online payment results</title>
		<!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">	
		<meta name="keywords" content="online catalog, product list, designer fashion, accessories, foot wear, art">
		<meta name="description" content="Designer Base - Online payment results">         
		<meta name="robots" content="index, follow">
		<meta name="revisit-after" content="21 days">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta property="og:title" content="Designer Base">
		<meta property="og:image" content="http://www.designerbase.co.za/images/logo.png">  
		<meta property="og:url" content="http://www.designerbase.co.za">
		<meta property="og:site_name" content="DesignerBase">
		<meta property="og:type" content="website">
		<meta property="og:description" content="Designer Base - Online payment results">
        <!-- Google Fonts -->
        <link href="http://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700%7COswald:300,400,500,600,700" rel="stylesheet">
        <link rel="stylesheet" href="/css/plugins.min.css">
        <link rel="stylesheet" href="/css/style.css">
		{literal}
		<style type="text/css">
		.table-responsive .table td {
			 border: none !important; 
			 padding: 30px 0 0 !important; 
			 vertical-align: middle !important; 
			 font-size: 14px !important; 
			 line-height: 1.7 !important; 
			 color: #262634 !important;		
		}
		</style>
		{/literal}
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="/images/icons/favicon.png">
        <!-- Modernizr -->
        <script src="assets/js/modernizr.js"></script>
    </head>
    <body>
        <div id="wrapper">
			{include_php file='includes/header.php'}
            <div class="main">
                <div class="container">
                    <div class="row">
						<div class="col-md-12">
                            <div class="page-header text-center">
                                <h1>Checkout Results</h1>
                            </div><!-- End .page-header -->
							<form action="#" method="POST" class="signin-form">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="text-left " >
                                        {if isset($success)}
                                        <p class="cart-subtotal"><span class="green">SUCCESSFUL PAYMENT:</span></p>
                                        <p class="cart-subtotal"><span class="green">
                                            Your payment has been successful, thank you for shoppnig with designer base. We have sent you an email with confirmation of your order.<br />
                                            Through out this process we will give you email feed back on the progress of your order, for any other information please send us an email on info@designerbase.co.za<br />
                                            with the below reference for this purchase.
                                        </p>
                                        <p class="cart-subtotal"><span class="green">REFERENCE: {$checkoutData.checkout_code}</span></p>
                                        {else}
                                        <p class="cart-subtotal"><span class="">UNSUCCESSFUL PAYMENT:</span></p>
                                        <p class="cart-subtotal"><span class="red">{$errors}</span></p>
                                        {/if}
                                        <p>Below are your checkout items.</p>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th width="10%" align="center">Product</th>
            											<th width="60%" align="center">Extra Info</th>
                                                        <th width="10%" align="center">Price</th>
                                                        <th width="10%" align="center">Quantity</th>
                                                        <th align="center">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
            										{foreach from=$basket item=item}
                                                    <tr>
                                                        <td class="product-col" align="center">
                                                            <div class="product">
                                                                <figure class="product-image-container">
            														<a href="/catalog/{$item.brand_url}/{$item.item_url}-{$item.catalog_url}/{$item.catalog_code|lower}" title="{$item.brand_name} - {$item.catalog_name} - {$item.price_amount}" alt="{$item.brand_name} - {$item.catalog_name} - {$item.price_amount}">
            															<img src="{$item.media_path}" title="{$item.brand_name} - {$item.catalog_name} - {$item.price_amount}" alt="{$item.brand_name} - {$item.catalog_name} - {$item.price_amount}" />
            														</a>
                                                                </figure>
                                                            </div><!-- End .product -->
                                                        </td>
            											<td class="product-col" style="padding: 10px !important;" align="center">{$item.basket_text}</td>
                                                        <td class="price-col" align="center">R {$item.price_amount|number_format}</td>
                                                        <td class="quantity-col" align="center">{$item.basket_quantity}</td>
                                                        <td class="total-col" align="center">R {$item.basket_total|number_format}</td>
                                                    </tr>
            										{/foreach}
                                                </tbody>
                                            </table>
                                        </div><!-- End .table-responsive -->                                        
                                    </div><!-- Endd .cart-proceed -->
                                </div><!-- End .col-sm-4 -->
                            </div><!-- End .row -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="text-left">
                                        <p class="cart-subtotal"><span>SUB TOTAL :</span>R {$baskettotal|number_format}</p>
										<p class="cart-subtotal"><span>Delivery Cost :</span>R {if isset($checkoutdelivery)}{$checkoutdelivery|number_format}{else}T.B.A{/if}</p>
                                        <p class="cart-total"><span>Grand TOTAL :</span> <span class="text-accent">R {$basketgrandtotal|number_format}</span></p>
                                    </div><!-- Endd .cart-proceed -->
                                </div><!-- End .col-sm-4 -->
                            </div><!-- End .row -->
							</form>
                        </div>
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .main -->
			{include_php file='includes/footer.php'}
        </div><!-- End #wrapper -->
        <a id="scroll-top" href="#top" title="Scroll top"><i class="fa fa-angle-up"></i></a>
        <!-- End -->
        <script src="/library/javascript/plugins.js"></script>
        <script src="/library/javascript/main.js"></script>
    </body>
</html>