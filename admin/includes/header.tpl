  <div class="navbar">
  <div class="container">
    <div class="navbar-collapse collapse">
	<div class="navbar-header">
		<a class="navbar-brand navbar-brand-image" href="/">
			<h2 style="margin-left: 15px; margin-top:10px;">DesignerBase System</h2>
		</a>	  
    </div>	
      <ul class="nav navbar-nav navbar-right">
		<li><a href="javascript:;">{if isset($activeBrand.brand_name)}{$activeBrand.brand_name} {if isset($activeBrand.brand_name)}{/if}{else}No Brand Selected{/if}</a></li>	  
        <li class="dropdown navbar-profile">
          <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;">
            <i class="fa fa-caret-down"></i>
          </a>
          <ul class="dropdown-menu" role="menu">
            <li>
              <a href="/logout.php">
                <i class="fa fa-sign-out"></i> 
                &nbsp;&nbsp;Logout
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </div> <!--/.navbar-collapse -->
  </div> <!-- /.container -->
</div> <!-- /.navbar -->
<div class="mainbar">
  <div class="container">
    <button type="button" class="btn mainbar-toggle" data-toggle="collapse" data-target=".mainbar-collapse">
      <i class="fa fa-bars"></i>
    </button>
    <div class="mainbar-collapse collapse">
      <ul class="nav navbar-nav mainbar-nav">
		<li class="dropdown {if $currentPage eq ''}active{/if}">
			<a href="/" class="dropdown-toggle {if $currentPage eq 'social'}active{/if}" data-toggle="dropdown" data-hover="dropdown">
				<i class="fa fa-desktop"></i>
				Home
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu" role="menu">
				<li>
					<a href="/dashboard/brand/">
						Brands
					</a>
				</li>			
				<li>
					<a href="/dashboard/category/">
						Categories
					</a>
				</li>
				<li>
					<a href="/dashboard/feature/">
						Features
					</a>
				</li>
			</ul>
		</li>
		{if isset($activeBrand)}
		<li {if $currentPage eq 'catalog'}class="active"{/if}>
		  <a href="/catalog/">
			<i class="fa fa-star"></i>
			Catalog
		  </a>
		</li>			 	
		{/if}	
		<li {if $currentPage eq 'participant'}class="active"{/if}>
		  <a href="/participant/">
			<i class="fa fa-user"></i>
			Participants
		  </a>
		</li>
		<li {if $currentPage eq 'comment'}class="active"{/if}>
		  <a href="/comment/">
			<i class="fa fa-user"></i>
			Comments
		  </a>
		</li>		
		<li {if $currentPage eq 'social'}class="active"{/if}>
		  <a href="/social/">
			<i class="fa fa-user"></i>
			Social
		  </a>
		</li>
		<li {if $currentPage eq 'template'}class="active"{/if}>
		  <a href="/template/">
			<i class="fa fa-user"></i>
			Template
		  </a>
		</li>
		<li {if $currentPage eq 'advert'}class="active"{/if}>
		  <a href="/advert/">
			<i class="fa fa-user"></i>
			Advert
		  </a>
		</li>	
		<li {if $currentPage eq 'checkout'}class="active"{/if}>
		  <a href="/checkout/">
			<i class="fa fa-user"></i>
			Checkout
		  </a>
		</li>		
      </ul>
    </div> <!-- /.navbar-collapse -->   
  </div> <!-- /.container --> 
</div> <!-- /.mainbar -->