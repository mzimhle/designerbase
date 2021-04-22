<header class="header sticky-header">
	<div class="container">
		<a href="/" class="site-logo" title="Designer Base">
			<img src="/images/logo.png" alt="Logo">
			<span class="sr-only">Designer Base</span>
		</a>
		<div class="search-form-container">
			<a href="#" class="search-form-toggle" alt="Designer Base search for catalog items" title="Designer Base search for catalog items"><i class="fa fa-search"></i></a>
			<form action="/catalog/" method="GET" >
				<input type="search" class="form-control" placeholder="Search entire catalog" required id="filter_search" name="filter_search" value="{$header_search}" />
				<button type="submit" title="Search" class="btn"><i class="fa fa-search"></i></button>
			</form>
		</div>
		<!-- End .search-form-container -->
		{if !isset($participantData)}
		<ul class="top-links">			
			<li><a href="/login">Login</a></li>
			<li><a href="/register">Sign Up</a></li>			
		</ul>
		{/if}
		{if isset($participantData)}
		<div class="header-dropdowns">
			<div class="dropdown header-dropdown">
				<a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false">
					{$participantData.participant_name}
					<i class="fa fa-caret-down"></i>
				</a>
				<ul class="dropdown-menu">
					<li><a href="/account" title="My Account" alt="My Account">My Account</a></li>
					<li><a href="/account/purchases" title="Previous Purchases" alt="Previous Purchases">Previous Purchases</a></li>
					<li><a href="/logout" alt="Log Out" alt="Log Out">Logout</a></li>
				</ul>
			</div><!-- End .dropddown -->
		</div>	
		{/if}		
		<div class="dropdown cart-dropdown">
			<a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false">
				<span class="cart-icon">
					<img src="/images/bag.png" alt="Cart">
					<span class="cart-count">{$basket|@count|default:"0"}</span>
				</span>
				<i class="fa fa-caret-down"></i>
			</a>
			<div class="dropdown-menu dropdown-menu-right">
				<p class="dropdown-cart-info"><span class="green">{$basket|@count|default:"0"}</span> product(s) in your basket. 
				<br /><br /><a href="/basket/edit" class="btn btn-primary">View basket</a></p>
				<div class="dropdown-menu-wrapper">
					{if isset($basket)}
					{foreach from=$basket item=item}
					<div class="product">
						<figure class="product-image-container">
							<a href="/catalog/{$item.brand_url}/{$item.item_url}-{$item.catalog_url}/{$item.catalog_code|lower}" title="{$item.brand_name} - {$item.catalog_name} - R {$item.price_amount}" alt="{$item.brand_name} - {$item.catalog_name} - R {$item.price_amount}">
								<img src="{$item.media_path}" title="{$item.catalog_name} - R {$item.price_amount}" alt="{$item.catalog_name} - R {$item.price_amount}" />
							</a>
						</figure>
						<div>
							<a href="/basket/empty/{$item.catalog_code}" class="btn-delete" title="Remove {$item.brand_name} - {$item.catalog_name} - R {$item.price_amount}" alt="Remove {$item.brand_name} - {$item.catalog_name} - R {$item.price_amount}" role="button"></a>
							<h4 class="product-title">
								<a href="/catalog/{$item.brand_url}/{$item.item_url}-{$item.catalog_url}/{$item.catalog_code|lower}" title="{$item.brand_name} - {$item.catalog_name} - R {$item.price_amount}" alt="{$item.brand_name} - {$item.catalog_name} - R {$item.price_amount}">{$item.catalog_name}</a>
							</h4>
							<div class="product-price-container">
								<span class="product-price">R {$item.price_amount}</span>
							</div>
							<!-- End .product-price-container -->
							<div class="product-qty">x{$item.basket_quantity}</div>
							<div class="product-price-container">
								<span class="product-price red">R {$item.basket_total|number_format:2}</span>
							</div>					
							<!-- End .product-qty -->
						</div>
						<!-- End .product-image-container -->
					</div>
					{/foreach}
					<!-- End .product- -->
					{else}
					<span class="red">No items in the basket</span>
					{/if}
				</div>
				<!-- End .droopdowm-menu-wrapper -->
				<div class="cart-dropdowm-action">
					<div class="dropdowm-cart-total"><span>TOTAL:</span> R{$baskettotal|default:"0.00"|number_format}</div>
					<a href="/basket/empty" class="btn btn-primary">Empty basket</a>
				</div>
				<!-- End .cart-dropdown-action -->
			</div>
			<!-- End .dropdown-menu -->
		</div>
		<!-- End .cart-dropddown -->
		<a href="#" class="sidemenu-btn" title="Menu Toggle"><span></span><span></span><span></span></a>
	</div>
	<!-- End .container-fluid -->
</header>
<!-- End .header -->
<aside class="sidemenu">
	<div class="sidemenu-wrapper">
		<div class="sidemenu-header">
			<a href="/" class="sidemenu-logo">
				<img src="/images/logo.png" alt="DesignerBase" title="DesignerBase" />
			</a>
		</div>
		<!-- End .sidemenu-header -->
		<ul class="metismenu">
			<li><a href="/">Home</a></li>
			<li><a href="/catalog">Catalog</a></li>
			<li><a href="/basket">My Basket</a></li>
			{if !isset($participantData)}
			<li><a href="/login">Login</a></li>
			<li><a href="/register">Sign Up</a></li>
			{else}
			<li><a href="/account">Account</a></li>
			{/if}
			<li><a href="/contact">Contact Us</a></li>
		</ul>
	</div>
	<!-- End .sidemenu-wrapper -->
</aside>
<!-- End .sidemenu -->
<div class="sidemenu-overlay"></div>
<!-- End .sidemenu-overlay -->