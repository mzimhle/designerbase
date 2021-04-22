<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Designer Base - {$brandData.brand_name} - {$catalogData.catalog_name} - R {$catalogData.price_amount}</title>
    <!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">	
	<meta name="keywords" content="online catalog, {$brandData.brand_name|lower}, {$catalogData.catalog_name}">
	<meta name="description" content="Designer Base - {$brandData.brand_name} - {$catalogData.catalog_name} - R {$catalogData.price_amount}">         
	<meta name="robots" content="index, follow">
	<meta name="revisit-after" content="21 days">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta property="og:title" content="DesignerBase">
	<meta property="og:image" content="http://www.designerbase.co.za/images/logo.png">  
	<meta property="og:url" content="http://www.designerbase.co.za">
	<meta property="og:site_name" content="DesignerBase - {$brandData.brand_name}">
	<meta property="og:type" content="website">
	<meta property="og:description" content="DesignerBase - {$brandData.brand_name|lower} - {$catalogData.catalog_name} - R {$catalogData.price_amount}">
    <!-- Google Fonts -->
    <link href="http://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700%7COswald:300,400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="/css/plugins.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/images/icons/favicon.png">
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
						<div class="row">
							<div class="product-gallery-container">
								<div class="product-zoom-wrapper">
									<div class="product-zoom-container">
										<img class="xzoom" id="product-zoom" src="{$catalogData.media_path}tmb_{$catalogData.media_code}{$catalogData.media_ext}" data-xoriginal="{$catalogData.media_path}big_{$catalogData.media_code}{$catalogData.media_ext}" title="{$catalogData.brand_name} - {$catalogData.catalog_name} - R {$catalogData.price_amount}" alt="{$catalogData.brand_name} - {$catalogData.catalog_name} - R {$catalogData.price_amount}" />
									</div><!-- End .product-zoom-container -->
								</div><!-- End .product-zoom-wrapper -->
								<div class="product-gallery-wrapper">
									<div class="owl-data-carousel owl-carousel product-gallery"
										{literal}data-owl-settings='{ "items":4, "margin":14, "nav": true, "dots":false }'
										data-owl-responsive='{"240": {"items": 2}, "360": {"items": 3}, "768": {"items": 4}, "992": {"items": 3}, "1200": {"items": 4} }'{/literal}>
										{foreach from=$mediaData item=media}
										<a href="#" data-image="{$media.media_path}tmb_{$media.media_code}{$media.media_ext}" data-zoom-image="{$media.media_path}big_{$media.media_code}{$media.media_ext}" class="product-gallery-item">
											<img src="{$media.media_path}big_{$media.media_code}{$media.media_ext}" alt="{$catalogData.catalog_name} - R {$catalogData.price_amount}" title="{$catalogData.catalog_name} - R {$catalogData.price_amount}" />
										</a>
										{/foreach}
									</div><!-- End .product-gallery -->
								</div><!-- End .product-gallery-wrapper -->
							</div><!-- End .product-gallery-container -->
							<div class="product-details">
								<h2 class="product-title">{$catalogData.catalog_name}</h2>
								<div class="product-meta-row">
									<div class="product-price-container">
										<span class="product-price">R {$catalogData.price_amount}</span>
									</div><!-- Endd .product-price-container -->
									<div class="product-ratings-wrapper">
										<div class="ratings-container">
											<div class="product-ratings">
												<span class="ratings" style="width:{$catalogData.rate_percent}%"></span><!-- End .ratings -->
											</div><!-- End .product-ratings -->
										</div><!-- End .ratings-container -->
										<a class="ratings-link" href="#" alt="{$catalogData.brand_name} - {$catalogData.catalog_name} - {$catalogData.comment_count} reviews" title="{$catalogData.brand_name} - {$catalogData.catalog_name} - {$catalogData.comment_count} reviews">{$catalogData.comment_count} Review(s)</a>
									</div><!-- End .product-ratings-wrapper -->
								</div><!-- End .product-meta-row -->
								<div class="product-content">
									<p>{$catalogData.catalog_text}</p>
								</div><!-- End .product-content -->
								{if isset($featureMaterial)}
								<ul class="product-meta-list">
									<li><label>Material:</label></li>
									{section loop=$featureMaterial name=material}
									<li style="font-size: 13px;">{$featureMaterial[material]}</li>
									{/section}
								</ul>
								{/if}
								{if isset($featureGender)}
								<label>Gender:</label>
								<ul class="filter-size-list">
									{foreach from=$featureGender item=item name=gender}
									<li {if $smarty.foreach.gender.first}class="active"{/if}>
										<span class="filter-size">{$item.item_value}</span>
									</li>
									{/foreach}
								</ul>
								{/if}								
								{if isset($featureColour)}
								<label>Color:</label>
								<ul class="filter-color-list">
									{foreach from=$featureColour item=item name=colour}
									<li>
										<span class="filter-color" style="background-color: {$item.item_value};"></span>
									</li>
									{/foreach}
								</ul>
								{/if}
								{if isset($featureSize)}
								<label>Size ( Select size to check the price ):</label>
								<ul class="filter-size-list">
									{foreach from=$featureSize item=item name=size}
									<li {if $item.feature_primary eq '1'}class="active"{/if} id="{$item.feature_code}">
										<a href="javascript: void(0); return false;" onclick="showPrice('{$item.feature_code}', '{$item.price_code}', '{$item.price_amount}'); return false;">
											<span class="filter-size">{$item.feature_size}</span>
										</a>
									</li>
									{/foreach}
								</ul>
								{/if}
								<div class="product-action">
									{if in_array($catalogData.catalog_code, $basketlist)}
									<a href="/basket/empty/{$catalogData.catalog_code}" class="btn btn-accent btn-addtobag" title="Remove {$catalog.brand_name} - {$catalog.catalog_name} from basket" alt="Remove {$catalog.brand_name} - {$catalog.catalog_name} from basket">Remove</a>
									{else}
									<a href="javascript:addBasketItemModal('{$catalogData.catalog_code}', '{$catalogData.catalog_name}', '{$catalogData.price_code}', '{$catalogData.price_amount}', '{$catalogData.media_path}tmb_{$catalogData.media_code}{$catalogData.media_ext}');" class="btn btn-accent btn-addtobag" title="Add {$catalog.brand_name} - {$catalog.catalog_name} to basket" alt="Add {$catalog.brand_name} - {$catalog.catalog_name} to basket">Add to Bag</a>
									{/if}
								</div><!-- End .product-action -->
							</div><!-- End .product-details -->
						</div><!-- End .row -->
						<div class="product-details-tab">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active">
									<a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab" alt="{$catalogData.brand_name} - {$catalogData.catalog_name} - {$catalogData.comment_count} reviews" title="{$catalogData.brand_name} - {$catalogData.catalog_name} - {$catalogData.comment_count} reviews">Reviews ( {$catalogData.comment_count} )</a>
								</li>
							</ul>
							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="reviews">
									<p>{$catalogData.comment_count} reviews for this product.<br />Rate this product.</p>
									<form action="{$smarty.server.REQUEST_URI}" method="POST" name="commentPost" id="commentPost">
										<div class="form-group">
											<label>Rate</label>
											<select id="rate_number" name="rate_number" class="form-control" required="">
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
										</div>							
										<div class="form-group">
											<label>Message</label>
											<textarea id="comment_message" name="comment_message" rows="3" class="form-control"></textarea>
										</div>
										<!-- End .form-group -->
										<input type="submit" value="Rate Product" class="btn btn-block btn-accent btn-addtobag" />
										{if isset($commentError)}
										<p class="red">{$commentError}</p>
										{/if}										
										{if isset($commentsuccess)}
										<p class="green">Your rating has been added, it will be reviewed by the administrators first.</p>
										{/if}
									</form>
									<br />
									<p><b>Product reviews.</b></p>
									{if isset($commentsData)}
										{foreach from=$commentsData item=item name=comment}
										<div class="ratings-container">
											<div class="product-ratings">
												<span class="ratings" style="width:{$item.rate_percent}%"></span>
												<!-- End .ratings -->
											</div>
											<!-- End .product-ratings -->
										</div>
										{$item.comment_message}
										{/foreach}
									{else}
									There are currently no reviews for this product.
									{/if}
								</div><!-- End .tab-pane -->							
							</div>
						</div><!-- End .product-details-tab -->
						<div class="mb50"></div><!-- margin -->
					</div><!-- End .col-md-9 -->
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
				</div><!-- End .row -->
			</div><!-- End .container -->
		</div><!-- End .main -->
		{include_php file='includes/footer.php'}
	</div><!-- End #wrapper -->
	<a id="scroll-top" href="#top" title="Scroll top"><i class="fa fa-angle-up"></i></a>
	<!-- End -->
	<script src="/library/javascript/plugins.js"></script>
	<script src="/library/javascript/xzoom.min.js"></script>
	<script src="/library/javascript/main.js"></script>
	{literal}
	<script type="text/javascript">
	$(document).ready(function(){
		$('#price_product_code').val('{/literal}{$catalogData.price_code}{literal}');
		$('#price_product_amount').val('{/literal}{$catalogData.price_amount}{literal}');
	});

	function showPrice(featurecode, pricecode, displayamount) {
		$('.product-price').html('R '+displayamount);
		$('#price_product_code').val(pricecode);
		$('#price_product_amount').val(displayamount);
		$('.filter-size-list li').removeClass();
		$('#'+featurecode).addClass('active');
		return false;
	}
	</script>
	{/literal}
</body>
</html>