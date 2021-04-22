<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>DesignerBase - We provide a premium service to all designers of clothing, footware, cosmetics, jewwelery and art.</title>
    <!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">	
	<meta name="keywords" content="online store, fashion, designers, clothing, art, footware, jewwelery">
	<meta name="description" content="Designer Base - We provide a premium service to all designers of clothing, footware, cosmetics, jewwelery and art.">         
	<meta name="robots" content="index, follow">
	<meta name="revisit-after" content="21 days">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta property="og:title" content="DesignerBase">
	<meta property="og:image" content="http://www.designerbase.co.za/images/logo.png">  
	<meta property="og:url" content="http://www.designerbase.co.za">
	<meta property="og:site_name" content="DesignerBase">
	<meta property="og:type" content="website">
	<meta property="og:description" content="DesignerBase - We provide a premium service to all designers of clothing, footware, cosmetics, jewwelery and art.">
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
						{if isset($advertBanner.media)}
                        <div id="rev_slider_wrapper" class="slider-container rev_slider_wrapper fullwidthbanner-container">
                            <div id="rev_slider" class="rev_slider fullwidthabanner" style="display:none;">
                                <ul>
									{foreach from=$advertBanner.media item=media}
									{literal}
                                    <!-- SLIDE  -->
                                    <li data-transition="fade">
                                        <!-- Background Image -->
                                        <img src="/images/transparent.png" class="rev-slidebg" style="background-color: #eeebe7;" alt="Slider bg">
                                        <div class="tp-caption tp-resizeme rs-parallaxlevel-0 text-primary" data-x="['left','left','left','left']" data-hoffset="['68','50','45','30']"
                                            data-y="['center','center','center','center']" data-voffset="['-44','-36','-30','-24']"
                                            data-fontsize="['26','24','22','20']" data-fontweight="400" data-lineheight="['36','34','32','30']"
                                            data-width="none" data-height="none" data-whitespace="nowrap" data-frames='[{"delay":600,"speed":800,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:[100%];s:inherit;e:inherit;","to":"o:1;","ease":"Power2.easeInOut"},{"delay":"wait","speed":600,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'
                                            data-responsive_offset="on" data-elementdelay="0" style="z-index: 5; white-space: nowrap; letter-spacing: 0.08em; text-transform: uppercase; font-family:'Oswald', sans-serif;">
                                            {/literal}{$media.media_text}{literal}
                                        </div>
                                        <a class="tp-caption tp-resizeme rs-parallaxlevel-0 action-link" data-x="['left','left','left','left']" data-hoffset="['68','50','45','30']"
                                            data-y="['center','center','center','center']" data-voffset="['40','36','32','30']"
                                            data-width="none" data-height="none" data-fontsize="['13','12','11','10']" data-fontweight="400"
                                            data-lineheight="['21','20','18','16']" data-color="#ffffff" data-whitespace="nowrap"
                                            data-frames='[{"delay":500,"speed":800,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:[100%];s:inherit;e:inherit;","to":"o:1;","ease":"Power2.easeInOut"},{"delay":"wait","speed":600,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'
                                            data-responsive_offset="on" style="z-index: 7; letter-spacing: 0.075em; text-transform: uppercase; text-decoration: none; background-color: #e41f3b; padding: 8px 10px 5px 10px; color: #fff; font-size: 13px; line-height: 1.5; font-weight: 500;"
                                            href="{/literal}{$media.media_url}{literal}">
                                                Shop Now
                                        </a>
                                        <div class="tp-caption tp-resizeme" data-frames='[{"delay":600,"speed":1000,"frame":"0","from":"x:right;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":600,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'
                                            data-type="image" data-x="['right','right','right','right']" data-hoffset="['110','90','80','60']"
                                            data-y="['bottom','bottom','bottom','bottom']" data-voffset="['0','0','0','0']" data-width="none"
                                            data-height="none"><img src="{/literal}{$media.media_path}{$media.media_code}{$media.media_ext}{literal}" alt="Item" width="452" height="428" data-ww="['452px', '380px', '300px', '240px']"
                                                data-hh="['428px', '359px', '331px', '227px']"></div>
                                    </li>
									{/literal}
									{/foreach}
                                </ul>
                                <div class="tp-bannertimer tp-bottom" style="display:none; height: 2px; background-color: rgba(0, 0, 0, 0.2);"></div>
                            </div>
                            <!-- End #rev_slider -->
                        </div>
                        <!-- END REVOLUTION SLIDER -->
						{/if}
						{if isset($featuredProduct)}
                        <h3 class="carousel-title">Featured Products</h3>
                        <div class="owl-data-carousel owl-carousel" data-owl-settings='{literal}{ "items":4, "nav": true, "dots":false }' data-owl-responsive='{ "480": {"items": 2}, "768": {"items": 3}, "992": {"items": 3}, "1200": {"items": 4} }{/literal}'>
							{foreach from=$featuredProduct.product item=feature}
							<div class="product">
								<figure class="product-image-container">
                                    {if $feature.price_discount neq '0'}
                                    <span class="product-label">-{$feature.price_discount}%</span>
                                    {/if}
                                    
									<a href="/catalog/{$feature.brand_url}/{$feature.item_url}-{$feature.catalog_url}/{$feature.catalog_code|lower}" title="{$feature.brand_name} - {$feature.catalog_name} - {$feature.price_amount}" alt="{$feature.brand_name} - {$feature.catalog_name} - {$feature.price_amount}">
										<img src="{$feature.media_path}tmb_{$feature.media_code}{$feature.media_ext}" title="{$feature.brand_name} - {$feature.catalog_name} - {$feature.price_amount}" alt="{$feature.brand_name} - {$feature.catalog_name} - {$feature.price_amount}" />
									</a>
									<!--<a href="#" class="btn-quick-view">{$feature.item_name}</a>-->
									<div class="product-action">
										{if in_array($feature.catalog_code, $basketlist)}
										<a href="/basket/empty/{$feature.catalog_code}" class="btn-product btn-remove-cart" alt="Remove {$feature.brand_name} - {$feature.catalog_name} from Bag" title="Remove {$feature.brand_name} - {$feature.catalog_name} from Bag">
											<i class="icon-product icon-bag"></i>
											<span>Remove</span>
										</a>
										{else}
										<a href="javascript:addBasketItemModal('{$feature.catalog_code}', '{$feature.catalog_name}', '{$feature.price_code}', '{$feature.price_amount}', '{$feature.media_path}tmb_{$feature.media_code}{$feature.media_ext}');" class="btn-product btn-add-cart"  alt="Add {$feature.brand_name} - {$feature.catalog_name} to Bag" title="Add {$feature.brand_name} - {$feature.catalog_name} to Bag">
											<i class="icon-product icon-bag"></i>
											<span>Add to basket</span>
										</a>
										{/if}
									</div><!-- End .product-action -->											
								</figure>
								<div class="ratings-container">
									<div class="product-ratings">
										<span class="ratings" style="width:0%"></span>
										<!-- End .ratings -->
									</div>
									<!-- End .product-ratings -->
								</div>
								<h3 class="product-title">
									<a href="/catalog/{$feature.brand_url}/{$feature.item_url}-{$feature.catalog_url}/{$feature.catalog_code|lower}" title="{$feature.brand_name} - {$feature.catalog_name} - {$feature.price_amount}" alt="{$feature.brand_name} - {$feature.catalog_name} - {$feature.price_amount}" >{$feature.catalog_name}</a>
								</h3>
								<div class="product-price-container">
									<span class="product-price">R {$feature.price_amount}</span>
								</div><!-- Endd .product-price-container -->
							</div><!-- End .product -->
							{/foreach}
                        </div>
                        <!-- End .owl-data-carousel -->						
                        <!-- margin -->
						{/if}
						{if isset($advertHorizontal)}
						{foreach from=$advertHorizontal.media item=advertHorizont}
						<div class="mb30 mb10-xs"></div>
                        <div class="banner banner-fullwidth">
                            <div class="banner-image-wrapper">
                                <a href="{$media.media_url}" alt="{$advertHorizont.media_text}" title="{$advertHorizont.media_text}">
									<img src="{$advertHorizont.media_path}{$advertHorizont.media_code}{$advertHorizont.media_ext}" alt="{$advertHorizont.media_text}" title="{$advertHorizont.media_text}" />
								</a>
                            </div>
                            <!-- End .banner-image-wrapper -->
                        </div>
						{/foreach}
						<!-- end .banner -->
						{/if}                        
                        <div class="mb50 visible-sm visible-xs"></div>
                        <!-- margin -->
                    </div>
                    <!-- End .col-md-9 -->
                    <aside class="col-md-3 col-md-pull-9 sidebar sidebar-shop">
                        <div class="widget widget-box widget-shop-category active">
                            <!-- <h3 class="widget-title">Categories</h3> -->
                            <ul class="shop-category-list accordion">
								{foreach from=$categoryData item=category}
                                <li><a href="/catalog/?filter_category={$category.item_code}">{$category.item_name}</a> <span class="accordion-icon"></span></li>
								{/foreach}
                            </ul>
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
                        <!-- End .widget -->						
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
    <!-- REVOLUTION JS FILES -->
    <script type="text/javascript" src="/library/javascript/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="/library/javascript/jquery.themepunch.revolution.min.js"></script>
    <!-- SLIDER REVOLUTION 5.0 EXTENSIONS  
        (Load Extensions only on Local File Systems !  
        The following part can be removed on Server for On Demand Loading) -->
    <script type="text/javascript" src="/library/javascript/extensions/revolution.extension.actions.min.js"></script>
    <script type="text/javascript" src="/library/javascript/extensions/revolution.extension.carousel.min.js"></script>
    <script type="text/javascript" src="/library/javascript/extensions/revolution.extension.kenburn.min.js"></script>
    <script type="text/javascript" src="/library/javascript/extensions/revolution.extension.layeranimation.min.js"></script>
    <script type="text/javascript" src="/library/javascript/extensions/revolution.extension.migration.min.js"></script>
    <script type="text/javascript" src="/library/javascript/extensions/revolution.extension.navigation.min.js"></script>
    <script type="text/javascript" src="/library/javascript/extensions/revolution.extension.parallax.min.js"></script>
    <script type="text/javascript" src="/library/javascript/extensions/revolution.extension.slideanims.min.js"></script>
    <script type="text/javascript" src="/library/javascript/extensions/revolution.extension.video.min.js"></script>
	{literal}
    <script type="text/javascript">
        jQuery(document).ready(function () {
            "use strict";

            var revapi;
            if ($("#rev_slider").revolution == undefined) {
                revslider_showDoubleJqueryError("#rev_slider");
            } else {
                revapi = $("#rev_slider").show().revolution({
                    sliderType: "standard",
                    jsFileLocation: "/library/javascript/",
                    sliderLayout: "auto",
                    dottedOverlay: "none",
                    delay: 15000,
                    navigation: {
                        mouseScrollNavigation: "off",
                        onHoverStop: "off",
                        touch: {
                            touchenabled: "on"
                        },
                        arrows: {
                            style: "custom",
                            enable: true,
                            hide_onmobile: false,
                            hide_under: 768,
                            hide_onleave: false,
                            tmp: '',
                            left: {
                                h_align: "left",
                                v_align: "bottom",
                                h_offset: 63,
                                v_offset: 48
                            },
                            right: {
                                h_align: "left",
                                v_align: "bottom",
                                h_offset: 85,
                                v_offset: 48
                            }
                        },
                        bullets: {
                            enable: false
                        }
                    },
                    responsiveLevels: [1200, 992, 768, 480],
                    gridwidth: [870, 679, 640, 480],
                    gridheight: [468, 400, 360, 300],
                    lazyType: "smart",
                    spinner: "spinner2",
                    parallax: {
                        type: "off"
                    },
                    debugMode: false
                });
            }
        });
    </script>
	{/literal}
</body>
</html>