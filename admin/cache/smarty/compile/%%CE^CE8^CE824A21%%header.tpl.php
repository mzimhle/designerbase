<?php /* Smarty version 2.6.20, created on 2018-09-11 22:44:07
         compiled from includes/header.tpl */ ?>
  <div class="navbar">
  <div class="container">
    <div class="navbar-collapse collapse">
	<div class="navbar-header">
		<a class="navbar-brand navbar-brand-image" href="/">
			<h2 style="margin-left: 15px; margin-top:10px;">DesignerBase System</h2>
		</a>	  
    </div>	
      <ul class="nav navbar-nav navbar-right">
		<li><a href="javascript:;"><?php if (isset ( $this->_tpl_vars['activeBrand']['brand_name'] )): ?><?php echo $this->_tpl_vars['activeBrand']['brand_name']; ?>
 <?php if (isset ( $this->_tpl_vars['activeBrand']['brand_name'] )): ?><?php endif; ?><?php else: ?>No Brand Selected<?php endif; ?></a></li>	  
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
		<li class="dropdown <?php if ($this->_tpl_vars['currentPage'] == ''): ?>active<?php endif; ?>">
			<a href="/" class="dropdown-toggle <?php if ($this->_tpl_vars['currentPage'] == 'social'): ?>active<?php endif; ?>" data-toggle="dropdown" data-hover="dropdown">
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
		<?php if (isset ( $this->_tpl_vars['activeBrand'] )): ?>
		<li <?php if ($this->_tpl_vars['currentPage'] == 'catalog'): ?>class="active"<?php endif; ?>>
		  <a href="/catalog/">
			<i class="fa fa-star"></i>
			Catalog
		  </a>
		</li>			 	
		<?php endif; ?>	
		<li <?php if ($this->_tpl_vars['currentPage'] == 'participant'): ?>class="active"<?php endif; ?>>
		  <a href="/participant/">
			<i class="fa fa-user"></i>
			Participants
		  </a>
		</li>
		<li <?php if ($this->_tpl_vars['currentPage'] == 'comment'): ?>class="active"<?php endif; ?>>
		  <a href="/comment/">
			<i class="fa fa-user"></i>
			Comments
		  </a>
		</li>		
		<li <?php if ($this->_tpl_vars['currentPage'] == 'social'): ?>class="active"<?php endif; ?>>
		  <a href="/social/">
			<i class="fa fa-user"></i>
			Social
		  </a>
		</li>
		<li <?php if ($this->_tpl_vars['currentPage'] == 'template'): ?>class="active"<?php endif; ?>>
		  <a href="/template/">
			<i class="fa fa-user"></i>
			Template
		  </a>
		</li>
		<li <?php if ($this->_tpl_vars['currentPage'] == 'advert'): ?>class="active"<?php endif; ?>>
		  <a href="/advert/">
			<i class="fa fa-user"></i>
			Advert
		  </a>
		</li>	
		<li <?php if ($this->_tpl_vars['currentPage'] == 'checkout'): ?>class="active"<?php endif; ?>>
		  <a href="/checkout/">
			<i class="fa fa-user"></i>
			Checkout
		  </a>
		</li>		
      </ul>
    </div> <!-- /.navbar-collapse -->   
  </div> <!-- /.container --> 
</div> <!-- /.mainbar -->