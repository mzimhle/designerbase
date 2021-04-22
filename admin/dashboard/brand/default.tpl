<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<title>DesignerBase System</title>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	{include_php file='includes/css.php'}
</head>
<body>
{include_php file='includes/header.php'}
<div class="container">
  <div class="content">
    <div class="content-container">
	<div class="content-header">
		<h2 class="content-header-title">Brands</h2>
		<ol class="breadcrumb">
			<li><a href="/">Home</a></li>
			<li><a href="/dashboard/">Dashboard</a></li>
			<li class="active">Brands</li>
		</ol>
	</div>	
      <div class="row">
        <div class="col-sm-12">
		<button class="btn btn-secondary fr" type="button" onclick="link('/dashboard/brand/details.php'); return false;">Add a new Brand</button><br/ ><br />
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
				Brands
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/dashboard/brand/" method="POST" data-validate="parsley" class="form parsley-form">			
				<table class="table table-bordered">	
					<thead>
						<tr>
							<td></td>
							<td>Profile</td>
							<td>Name</td>
							<td>Email</td>
							<td>Number</td>
							<td>Delivery Time</td>
							<td>Twitter</td>
							<td>Instagram</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					{foreach from=$brandData item=item}
						<tr>
							<td>
								{if $item.media_path eq ''}<img src="/images/avatar.jpg" width="80" />{else}<img src="{$config.site}{$item.media_path}tny_{$item.media_code}{$item.media_ext}" width="80" />{/if}
							</td>
							<td><a href="https://www.designerbase.co.za/{$item.brand_url}" target="_blank">{$item.brand_url}</a></td>
							<td><a href="/dashboard/brand/details.php?code={$item.brand_code}">{$item.brand_name}</a></td>
							<td>{$item.brand_email}</td>
							<td>{$item.brand_number}</td>
							<td>{$item.brand_delivery}</td>
							<td>{$item.brand_social_twitter}</td>
							<td>{$item.brand_social_instagram}</td>
							<td><button value="Delete" class="btn btn-danger" onclick="deleteModal('{$item.brand_code}', '', 'default'); return false;">Delete</button></td>
						</tr>			     
					{foreachelse}
						<tr>
							<td align="center" colspan="8">There are currently no items</td>
						</tr>					
					{/foreach}
					</tbody>					  
				</table>
              </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->				
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
{include_php file='includes/footer.php'}
{include_php file='includes/javascript.php'}
</html>