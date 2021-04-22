<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
		<title>Designer Base - Check out your basket items</title>
		<!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">	
		<meta name="keywords" content="online catalog, product list, designer fashion, accessories, foot wear, art">
		<meta name="description" content="Designer Base - Check out your basket items">         
		<meta name="robots" content="index, follow">
		<meta name="revisit-after" content="21 days">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta property="og:title" content="Designer Base">
		<meta property="og:image" content="http://www.designerbase.co.za/images/logo.png">  
		<meta property="og:url" content="http://www.designerbase.co.za">
		<meta property="og:site_name" content="DesignerBase">
		<meta property="og:type" content="website">
		<meta property="og:description" content="Designer Base - Check out your basket items">
        <!-- Google Fonts -->
        <link href="http://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700%7COswald:300,400,500,600,700" rel="stylesheet">
        <link rel="stylesheet" href="/css/plugins.min.css">
        <link rel="stylesheet" href="/css/style.css">
        <link rel="stylesheet" href="/css/jquery-ui.min-autocomplete.css">
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
                                <h1>Checkout Confirmation</h1>
                                <p>You have <span class="green">{$basketlist|@count}</span> item(s) in your basket.</p>
                            </div><!-- End .page-header -->
							<form action="/basket/edit" method="POST" class="signin-form">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="10%" align="center">Product</th>
											<th width="60%" align="center">Extra Info</th>
                                            <th width="10%" align="center">Price</th>
                                            <th width="10%" align="center">Quantity</th>
                                            <th align="center">Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										{if isset($basket)}
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
											<td class="product-col" style="padding: 10px !important;" align="center">
											    <textarea cols="10" class="form-control" id="text_{$item.catalog_code}" name="text_{$item.catalog_code}">{$item.basket_text}</textarea>
											</td>
                                            <td class="price-col" align="center">R {$item.price_amount|number_format}</td>
                                            <td class="quantity-col" align="center">
                                                <input class="cart-product-quantity form-control" type="text" value="{$item.basket_quantity}" id="quantity_{$item.catalog_code}" name="quantity_{$item.catalog_code}" />
                                            </td>
                                            <td class="total-col" align="center">R {$item.basket_total|number_format}</td>
                                            <td class="delete-col" align="center"><a href="/basket/empty/{$item.catalog_code}" class="btn-delete" title="Remove {$item.brand_name} - {$item.catalog_name} - {$item.price_amount}" alt="Remove {$item.brand_name} - {$item.catalog_name} - {$item.price_amount}" role="button"></a></td>
                                        </tr>
										{/foreach}
										{else}
										<tr>
											<td colspan="6">
												There are currently not items in your basket.
											</td>
										</tr>
										{/if}
										{if isset($output)}
										<tr>
											<td colspan="6" class="red">
												{$output}
											</td>
										</tr>
										{/if}										
                                    </tbody>
                                </table>
                            </div><!-- End .table-responsive -->
							<div class="page-header text-center">
								<h1>My Details</h1>
								<p>Please confirm your details below</p>
							</div><!-- End .page-header -->  	                            
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Full name*</label>
										<input type="text" class="form-control" id="participant_name" name="participant_name" required value="{$participantData.participant_name}" {if isset($participantData)}readonly disabled{/if} />
									</div><!-- End .form-group -->
								</div><!-- End .col-sm-4 -->

								<div class="col-sm-6">
									<div class="form-group">
										<label>South African Cellphone number*</label>
										<input type="text" class="form-control" id="participant_number" name="participant_number" required value="{$participantData.participant_number}" {if isset($participantData)}readonly disabled{/if} />
									</div><!-- End .form-group -->
								</div><!-- End .col-sm-4 -->											
							</div><!-- End .row -->
							<div class="row">
						        <div class="col-sm-12">
									<div class="form-group">
										<label>Email address*</label>
										<input type="text" class="form-control" id="participant_email" name="participant_email" required email value="{$participantData.participant_email}" {if isset($participantData)}readonly disabled{/if} />
									</div><!-- End .form-group -->
								</div><!-- End .col-sm-4 -->
							</div><!-- End .row -->
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>Physical Address*</label>
										<input type="text" class="form-control" id="participant_address" name="participant_address" required value="{$participantData.participant_address}" />
									</div><!-- End .form-group -->
								</div><!-- End .col-sm-4 -->
							</div><!-- End .row -->							
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>City / Town* (Enter first 2 letters of the town, surburb or city and select from the displayed dropdown.)</label>
										<input type="text" class="form-control" id="areapost_name" name="areapost_name" required value="{$participantData.areapost_name}" />
										<input type="hidden" name="areapost_code" id="areapost_code" value="{$participantData.areapost_code}" />
									</div><!-- End .form-group -->
								</div><!-- End .col-sm-4 -->
							</div><!-- End .row -->
							{if isset($basket)}
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="cart-proceed">
                                        <p><input type="submit" class="btn btn-accent pull-right min-width" value="Update all details" /></p><br /><br />
                                        <p class="cart-subtotal"><span>SUB TOTAL :</span>R {$baskettotal|number_format}</p>
										<p class="cart-subtotal"><span>Delivery Cost :</span>R {if isset($checkoutdelivery)}{$checkoutdelivery|number_format}{else}T.B.A{/if}</p>
                                        <p class="cart-total"><span>Grand TOTAL :</span> <span class="text-accent">R {$basketgrandtotal|number_format}</span></p>
                                        {if isset($checkoutdelivery)}
										<input type="button" onclick="window.location.href='/basket/checkout'; return false;" class="btn btn-accent pull-right min-width" value="Proceed to Payment" />
										{/if}
                                    </div><!-- Endd .cart-proceed -->
                                </div><!-- End .col-sm-4 -->
                            </div><!-- End .row -->
							{/if}
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
        <script src="/library/javascript/jquery-ui-autocomplete.min.js"></script>
        {literal}
        <script type="text/javascript" language="javascript">
            $(document).ready(function(){
        		$( "#areapost_name" ).autocomplete({
        			source: "/feeds/areapost.php",
        			minLength: 2,
        			select: function( event, ui ) {
        				if(ui.item.id == '') {
        					$('#areapost_name').html('');
        					$('#areapost_code').val('');					
        				} else {
        					$('#areapost_name').html('<b>' + ui.item.value + '</b>');
        					$('#areapost_code').val(ui.item.id);	
        				}
        				$('#areapost_name').val('');										
        			}
        		});			
            });
        </script>
        {/literal}      
    </body>
</html>