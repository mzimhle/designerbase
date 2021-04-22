<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>DesignerBase - Catalog of designer products</title>
    <!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">	
	<meta name="keywords" content="online catalog, product list, designer fashion, accessories, foot wear, art">
	<meta name="description" content="DesignerBase - Catalog of designer products">         
	<meta name="robots" content="index, follow">
	<meta name="revisit-after" content="21 days">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta property="og:title" content="Designer Base">
	<meta property="og:image" content="http://www.designerbase.co.za/images/logo.png">  
	<meta property="og:url" content="http://www.designerbase.co.za">
	<meta property="og:site_name" content="Designer Base">
	<meta property="og:type" content="website">
	<meta property="og:description" content="DesignerBase - Catalog of designer products">
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
						<div class="category-header">
							<h1>Catalog</h1>
							<ol class="breadcrumb">
								<li><a href="/">Home</a> ></li>
								<li class="active">{$catagoryData.item_name|default:"All catalogs"}</li>
							</ol>
						</div>
						{if isset($filtering)}
							Searching for <span class="red">{$filtering.filter_category|default:"every"}</span> category. {if isset($filtering.filter_search)}Searching for the description '<span class="red">{$filtering.filter_search}</span>'. {/if}{if isset($filtering.filter_gender)}Searching for <span class="red">{$filtering.filter_gender}</span> items.{/if}{if isset($filtering.filter_colour)} Searching for the colours {section name=colour loop=$filtering.filter_colour}<span class="red">{$filtering.filter_colour[colour]}</span>{if $smarty.section.colour.last}{else}, {/if}{/section}.{/if}{if isset($filtering.filter_section)} Searching for the sub sections {section name=section loop=$filtering.filter_section}<span class="red">{$filtering.filter_section[section]}</span>{if $smarty.section.section.last}{else}, {/if}{/section}.{/if}
							</p>
						{else}
							<p>Below is a list of all the items we have in the catalog</p>
						{/if}
                        <div class="shop-row">
							<div class="shop-container max-col-4" data-layout="fitRows">
								{foreach from=$catalogItems item=catalog}
								<div class="product-item">
									<div class="product">
										<figure class="product-image-container">
											<a href="/catalog/{$catalog.brand_url}/{$catalog.item_url}-{$catalog.catalog_url}/{$catalog.catalog_code|lower}" title="{$catalog.brand_name} - {$catalog.catalog_name} - {$catalog.price_amount}" alt="{$catalog.brand_name} - {$catalog.catalog_name} - {$catalog.price_amount}">
												<img src="{$catalog.media_path}tmb_{$catalog.media_code}{$catalog.media_ext}" title="{$catalog.brand_name} - {$catalog.catalog_name} - {$catalog.price_amount}" alt="{$catalog.brand_name} - {$catalog.catalog_name} - {$catalog.price_amount}"/>
											</a>
											<a href="#" class="btn-quick-view">{$catalog.item_name}</a>	
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
											<a href="/catalog/{$catalog.brand_url}/{$catalog.item_url}-{$catalog.catalog_url}/{$catalog.catalog_code|lower}" title="{$catalog.brand_name} - {$catalog.catalog_name} - {$catalog.price_amount}" alt="{$catalog.brand_name} - {$catalog.catalog_name} - {$catalog.price_amount}">{$catalog.catalog_name}</a>
										</h3>
										<a href="/{$catalog.brand_url}" title="{$catalog.brand_name}" alt="{$catalog.brand_name}" style="color: #e41f3b !important; font-size: 11px;">{$catalog.brand_name}</a>
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
								<li {if $paginator->current eq $page}class="active"{/if}><a href="/catalog/?page={$page}{if $querystring neq ''}&{$querystring}{/if}">{$page}</a></li>
								{/foreach}
							</ul>
						</nav>
						{/if}
                    </div>
                    <!-- End .col-md-9 -->
                    <aside class="col-md-3 col-md-pull-9 sidebar sidebar-shop">
						<form id="form_filter" name="form_filter" action="/catalog/" method="GET">
                        <div class="widget widget-box widget-shop-filter active">
							<input type="hidden" id="filter_search" name="filter_search" value="{$filtering.filter_search}" />
							<div class="filter-box">
								<h5 class="filter-label">Category</h5>
								<div class="form-group" style="margin-bottom: 0 !important;">
									<select name="filter_category" id="filter_category" class="form-control" required onchange="getSubCategory(); return false;">
										<option value="" {if $parameter.filter_category eq ''}SELECTED{/if}> All </option>
										{foreach from=$categoryData item=category}
										<option value="{$category.item_code}" {if $parameter.filter_category eq $category.item_code}SELECTED{/if}> {$category.item_name} </option>
										{/foreach}
									</select>
								</div>
							</div>
                            <!-- End .filter-box -->
                            <br />
                            <div class="filter-box" style="display: none;" id="category_sub" name="category_sub">
                                <h5 class="filter-label">Sub sections</h5>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div id="category_sub_category" name="category_sub_category" class="clearfix form-more"></div>
                                    </div>
                                    <!-- End col-xs-6 -->
                                </div>
                                <!-- End row -->
                            </div>
                            <!-- End .filter-box -->	
							{if isset($featureGender)}
                            <div class="filter-box">
                                <h5 class="filter-label">Gender</h5>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <ul class="filter-color-list">
                                            <li>
												<span class="filter-color-box">
													<input type="radio" class="form-control" style="margin: auto !important; height: 20px !important;" value="" id="filter_gender" name="filter_gender" {if $parameter.filter_gender eq ''}checked{/if} />
												</span>
                                                <span class="filter-color-text">All</span>
                                            </li>										
											{foreach from=$featureGender item=gender}
                                            <li>
												<span class="filter-color-box">
													<input type="radio" class="form-control" style="margin: auto !important; height: 20px !important;" value="{$gender.item_code}" id="filter_gender" name="filter_gender" {if $gender.item_code eq $parameter.filter_gender}checked{/if} />
												</span>
                                                <span class="filter-color-text">{$gender.item_name}</span>
                                            </li>
											{/foreach}
                                        </ul>
                                    </div>
                                    <!-- End col-xs-6 -->
                                </div>
                                <!-- End row -->
                            </div>
                            <!-- End .filter-box -->
							{/if}	
							{if isset($featureColour)}
                            <div class="filter-box">
                                <h5 class="filter-label">Colour</h5>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="squares">
										{foreach from=$featureColour item=colour}
                                            <div class="checkbox pull-left">
                                                <label>
                                                    <input type="checkbox" value="{$colour.item_code}" id="filter_colour[]" name="filter_colour[]"  {if isset($parameter.filter_colour)}{if in_array($colour.item_code, $parameter.filter_colour)}CHECKED{/if}{/if}>
                                                    <span class="checkbox-box">
                                                        {if $colour.media_path eq ''} 
                                                        <span class="check" style="background: {$colour.item_value} !important;border:1px solid {$colour.item_value} !important;" alt="{$colour.item_name}" title="{$colour.item_name}"></span>
                                                        {else}
                                                        <span class="check" style="background-image: url('{$colour.media_path}min_{$colour.media_code}{$colour.media_ext}');background-size: cover;border:none !important;" alt="{$colour.item_name}" title="{$colour.item_name}"></span>
                                                        {/if}
                                                    </span>
                                                </label>
                                            </div>    										
										{/foreach}
										</div>
                                    </div>
                                    <!-- End col-xs-6 -->
                                </div>
                                <!-- End row -->
                            </div>
                            <!-- End .filter-box -->
							{/if}
							<br />
                            <a href="#" onclick="submitFilter(); return false;" class="btn btn-apply btn-block">Apply Filter</a>
							<a href="#" onclick="submitClear(); return false;" class="btn btn-clear btn-block">Clear</a>
                        </div>
						</form>
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
	{literal}
	<script type="text/javascript">
		$(document).ready(function(){
			getSubCategory();
		});
		function submitFilter() {
			document.forms.form_filter.submit();
			return false;
		}
		function submitClear() {
			window.location = "/catalog/";
		}
		function getSubCategory() {
			var category	= $('#filter_category').val();
			$.ajax({
					type: "GET",
					url: "/catalog/",
					data: "sub_category_filter="+category+"&{/literal}{$querystring}{literal}",
					dataType: "json",
					success: function(data){
						if(data.length > 0) {
							var html = '';
							var item = [];

							for(var i = 0; i < data.length; i++) {
								item = data[i];
								/*
								html += '<li>';
								html += '<span class="filter-color-box"><input type="checkbox" class="form-control" style="margin: auto !important; height: 20px !important;" value="'+item.item_code+'" id="filter_section[]" name="filter_section[]" '+(item.selected == 1 ? 'checked' : '')+'/></span>';
								html += '<span class="filter-color-text">'+item.item_name+'</span>';
								html += '</li>'; */
                                html += '<div class="checkbox pull-left"><label>';
                                html += '<input type="checkbox" value="'+item.item_code+'" id="filter_section[]" name="filter_section[]" '+(item.selected == 1 ? 'checked' : '')+'>';
                                html += '<span class="checkbox-box"><span class="check" alt="'+item.item_name+'" title="'+item.item_name+'"></span></span>'+item.item_name+'</label></div>';
														
							}
							$('#category_sub').fadeIn("slow");
							$('#category_sub_category').html(html);
						} else {
							$('#category_sub').fadeOut("slow");
						}
					}
			});
			return false;
		}
	</script>
	{/literal}
</body>
</html>