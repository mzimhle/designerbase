<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Designer Base - {$brandData.brand_name} - {$brandData.brand_description}</title>
    <!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">	
	<meta name="keywords" content="{$brandData.brand_name|lower}, {$brandData.brand_description|lower}">
	<meta name="description" content="Designer Base - {$brandData.brand_name} - {$brandData.brand_description}">         
	<meta name="robots" content="index, follow">
	<meta name="revisit-after" content="21 days">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta property="og:title" content="Designer Base - {$brandData.brand_name}">
	<meta property="og:image" content="http://www.designerbase.co.za/images/logo.png">  
	<meta property="og:url" content="http://www.designerbase.co.za">
	<meta property="og:site_name" content="Designer Base - {$brandData.brand_name}">
	<meta property="og:type" content="website">
	<meta property="og:description" content="{$brandData.brand_description}">
    <!-- Google Fonts -->
    <link href="http://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700%7COswald:300,400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="/css/plugins.min.css">
    <link rel="stylesheet" href="/css/style.css">
	<!-- <link rel="stylesheet" href="/css/bootstrap.min.css"> -->
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
                        <div class="shop-row">
							<div class="shop-container max-col-4" data-layout="fitRows">
								{foreach from=$catalogItems item=catalog}
								<div class="product-item">
									<div class="product">
										<figure class="product-image-container">
											<a href="/{$brandData.brand_url}/{$catalog.item_url}-{$catalog.catalog_url}/{$catalog.catalog_code|lower}" title="{$catalog.brand_name} - {$catalog.catalog_name} - {$catalog.price_amount}" alt="{$catalog.brand_name} - {$catalog.catalog_name} - {$catalog.price_amount}">
												<img src="{$catalog.media_path}tmb_{$catalog.media_code}{$catalog.media_ext}" title="{$catalog.brand_name} - {$catalog.catalog_name} - {$catalog.price_amount}" alt="{$catalog.brand_name} - {$catalog.catalog_name} - {$catalog.price_amount}"/>
											</a>
											<a href="/{$brandData.brand_url}/{$catalog.item_url}-{$catalog.catalog_url}/{$catalog.catalog_code|lower}" class="btn-quick-view">{$catalog.item_name}</a>	
											<div class="product-action">
												{if $catalog.price_discount neq '0'}
												<a href="#" class="btn-product btn-wishlist" title="{$catalog.brand_name} - {$catalog.catalog_name} discount">
													-{$catalog.price_discount}%
												</a>
												{/if}		
												{if in_array($catalog.catalog_code, $basketlist)}
												<a href="/basket/empty/{$catalog.catalog_code}" class="btn-product btn-remove-cart" title="Remove {$catalog.brand_name} - {$catalog.catalog_name} from basket" alt="Remove {$catalog.brand_name} - {$catalog.catalog_name} from basket">
													<i class="icon-product icon-bag"></i>
													<span>Remove</span>
												</a>
												{else}
												<a href="javascript:addBasketItemModal('{$catalog.catalog_code}', '{$catalog.catalog_name}', '{$catalog.price_code}', '{$catalog.price_amount}', '{$catalog.media_path}tmb_{$catalog.media_code}{$catalog.media_ext}');" class="btn-product btn-add-cart" title="Add {$catalog.brand_name} - {$catalog.catalog_name} to basket" alt="Add {$catalog.brand_name} - {$catalog.catalog_name} to basket">
													<i class="icon-product icon-bag"></i>
													<span>Add to basket</span>
												</a>
												{/if}												
											</div><!-- End .product-action -->											
										</figure>
										<div class="ratings-container">
											<div class="product-ratings">
												<span class="ratings" style="width:{$catalog.rate_percent}%"></span>
												<!-- End .ratings -->
											</div>
											<!-- End .product-ratings -->
										</div>
										<h3 class="product-title">
											<a href="/{$brandData.brand_url}/{$catalog.item_url}-{$catalog.catalog_url}/{$catalog.catalog_code|lower}" title="{$catalog.brand_name} - {$catalog.catalog_name} - {$catalog.price_amount}" alt="{$catalog.brand_name} - {$catalog.catalog_name} - {$catalog.price_amount}">{$catalog.catalog_name}</a>
										</h3>
										<a href="/{$brandData.brand_url}" title="{$brandData.brand_name}" alt="{$brandData.brand_name}" style="color: #e41f3b !important; font-size: 11px;">{$brandData.brand_name}</a>
										<div class="product-price-container">
											<span class="product-price">R {$catalog.price_amount}</span>
										</div><!-- Endd .product-price-container -->
									</div><!-- End .product -->
								</div><!-- End .product-item -->
								{foreachelse}
								<div class="empty-box red">There are no search results for the current search criteria you chose.</div>
								{/foreach}
							</div><!-- End .shop-container -->
                        </div><!-- End .shop-row -->
						{if $paginator->pageCount gt 1}
						<nav aria-label="Page Navigation">
							<ul class="pagination">
								{foreach from=$paginator->pagesInRange item=page}
								<li {if $paginator->current eq $page}class="active"{/if}><a href="/{$brandData.brand_url}/?page={$page}{if $querystring neq ''}&{$querystring}{/if}">{$page}</a></li>
								{/foreach}
							</ul>
						</nav>
						{/if}
                    </div>
                    <!-- End .col-md-9 -->
                    <aside class="col-md-3 col-md-pull-9 sidebar sidebar-shop">
                        <div class="widget" >
                            <p style="text-align: center;vertical-align: middle;"><span style="color: #e41f3b; font-size: 15px;font-weight: bold;">{$brandData.brand_name}</span></p>
                            <img src="{$brandData.media_path}tny_{$brandData.media_code}{$brandData.media_ext}" width="215" height="297" style="display: block;margin-left: auto;margin-right: auto;" title="{$brandData.brand_name} - {$brandData.brand_description}" alt="{$brandData.brand_name} - {$brandData.brand_description}" />
							<br /><span>{$brandData.brand_description}</span>
							{if $brandData.brand_social_facebook neq '' or $brandData.brand_social_twitter neq '' or $brandData.brand_social_instagram neq '' or $brandData.brand_social_pinterest neq ''}
                            <br />
							<div class="share_the_story">
								{if $brandData.brand_social_facebook neq ''}
								<a class="facebook" href="{$brandData.brand_social_facebook}" target="_blank" title="{$brandData.brand_name} facebook page" alt="{$brandData.brand_name} facebook page"><i class="fa fa-facebook"></i>Facebook</a>
								{/if}
								{if $brandData.brand_social_twitter neq ''}
								<a class="twitter" href="https://twitter.com/{$brandData.brand_social_twitter}" target="_blank" title="{$brandData.brand_name} twitter account" alt="{$brandData.brand_name} twitter account"><i class="fa fa-twitter"></i>Twitter</a>
								{/if}
								{if $brandData.brand_social_instagram neq ''}
								<a class="instagram" href="https://instagram.com/{$brandData.brand_social_instagram}" target="_blank" title="{$brandData.brand_name} instagram account" alt="{$brandData.brand_name} instagram account"><i class="fa fa-instagram"></i>Instagram</a>
								{/if}
								{if $brandData.brand_social_pinterest neq ''}
								<a class="pinterest" href="{$brandData.brand_social_pinterest}" target="_blank" title="{$brandData.brand_name} pinterest account" alt="{$brandData.brand_name} pinterest account"><i class="fa fa-pinterest"></i>Pinterest</a>
								{/if}
							</div>	
							{/if}
                        </div>
                        <!-- End .widget -->
						{if isset($advertVertical)}
						{foreach from=$advertVertical.media item=vertical}
						<div class="widget widget-banner">
							<div class="banner banner-image">
								<a href="{$vertical.media_url}" title="{$vertical.media_text}" alt="{$vertical.media_text}">
									<img src="{$vertical.media_path}{$vertical.media_code}{$vertical.media_ext}" alt="{$vertical.media_text}" title="{$vertical.media_text}" />
								</a>
							</div>
						</div>
						{/foreach}
						{/if}
						{include_php file='includes/register.php'}
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
	<script src="/library/javascript/bootstrap.min.js"></script>
</body>
</html>