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
		<h2 class="content-header-title">Categories</h2>
		<ol class="breadcrumb">
			<li><a href="/">Home</a></li>
			<li><a href="#">Dashboard</a></li>
			<li class="active">Categories</li>
		</ol>
	</div>	
      <div class="row">
        <div class="col-sm-12">
		<button class="btn btn-secondary fr" type="button" onclick="link('/dashboard/category/details.php'); return false;">Add a new Category</button><br/ ><br />
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
				Categories
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/dashboard/category/" method="POST" data-validate="parsley" class="form parsley-form">			
				<table class="table table-bordered">	
					<thead>
						<tr>
							<td>Name</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					{foreach from=$itemData item=item}
						<tr>
							<td><a href="/dashboard/category/details.php?code={$item.item_code}">{$item.item_name}</a></td>
							<td><button value="Delete" class="btn btn-danger" onclick="deleteModal('{$item.item_code}', '', 'default'); return false;">Delete</button></td>
						</tr>			     
					{foreachelse}
						<tr>
							<td align="center" colspan="2">There are currently no items</td>
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