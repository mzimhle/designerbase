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
		<li><a href="/dashboard/suppliers/">Suppliers</a></li>
		<li>{if isset($supplierData.supplier_code)}{$supplierData.supplier_name}{else}Add a supplier{/if}</li>
		<li class="active">Details</li>
	</ol>
	</div>	
      <div class="row">
        <div class="col-sm-12">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					{if isset($supplierData.supplier_code)}Edit a supplier{else}Add a supplier{/if}
              </h3>
            </div> <!-- /.portlet-header --> 
            <div class="portlet-content">
              <form id="validate-basic" action="/dashboard/supplier/details.php{if isset($supplierData.supplier_code)}?code={$supplierData.supplier_code}{/if}" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">
                <div class="form-group">
					<label for="supplier_name">Name</label>
					<input type="text" id="supplier_name" name="supplier_name" class="form-control" data-required="true" value="{$supplierData.supplier_name}" />
					{if isset($errorArray.supplier_name)}<span class="error">{$errorArray.supplier_name}</span>{else}<span class="smalltext">Supplier's full name</span>{/if}					  
                </div>							
                <div class="form-group">
					<label for="supplier_email">Email Address</label>
					<input type="text" id="supplier_email" name="supplier_email" class="form-control" data-required="true" value="{$supplierData.supplier_email}" />
					{if isset($errorArray.supplier_email)}<span class="error">{$errorArray.supplier_email}</span>{else}<span class="smalltext">Supplier's email address</span>{/if}					  
                </div>				
                <div class="form-group">
					<label for="supplier_number">Number</label>
					<input type="text" id="supplier_number" name="supplier_number" class="form-control" data-required="true" value="{$supplierData.supplier_number}" />
					{if isset($errorArray.supplier_number)}<span class="error">{$errorArray.supplier_number}</span>{else}<span class="smalltext">Telephone number or cellphone number of the supplier</span>{/if}					  
                </div>				
				<hr />			
                <div class="form-group"><button type="submit" class="btn btn-primary">Validate and Submit</button></div>
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
