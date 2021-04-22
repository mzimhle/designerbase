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
		<h2 class="content-header-title">Suppliers</h2>
		<ol class="breadcrumb">
			<li><a href="/">Home</a></li>
			<li><a href="/dashboard/">Dashboard</a></li>
			<li class="active">Suppliers</li>
		</ol>
	</div>	
      <div class="row">
        <div class="col-sm-12">
		<button class="btn btn-secondary fr" type="button" onclick="link('/dashboard/supplier/details.php'); return false;">Add a new supplier</button><br/ ><br />
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					Suppliers
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/dashboard/supplier/" method="POST" data-validate="parsley" class="form parsley-form">			
				<p>Below is a list of all the suppliers in the designerbase system</p>
				<table class="table table-bordered">	
					<thead>
						<tr>
							<td>Name</td>
							<td>Email</td>
							<td>Number</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					{foreach from=$supplierData item=item}
						<tr class="{if $item.supplier_active eq '1'}success{else}error{/if}">
							<td><a href="/dashboard/supplier/details.php?code={$item.supplier_code}">{$item.supplier_name}</a></td>
							<td>{$item.supplier_email}</td>
							<td>{$item.supplier_number}</td>
							<td><button value="Delete" class="btn btn-danger" onclick="deleteModal('{$item.supplier_code}', '', 'default'); return false;">Delete</button></td>
						</tr>			     
					{foreachelse}
						<tr>
							<td align="center" colspan="4">There are currently no items</td>
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