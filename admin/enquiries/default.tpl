<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<title>Administration</title>
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
	<h2 class="content-header-title">My Enquiries</h2>
	<ol class="breadcrumb">
	<li><a href="/">Home</a></li>
	<li><a href="#">{$activeAccount.account_name}</a></li>
	<li class="active"><a href="#">Enquiries</a></li>
	</ol>
	</div>
      <div class="row">
        <div class="col-sm-12">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					Previous Enquiries
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/enquiries/" method="POST" data-validate="parsley" class="form parsley-form">			
				<p>Below is a list of your services.</p>
				<table class="table table-bordered">	
					<thead>
						<tr>
							<td>Added</td>
							<td>Name</td>
							<td>Email</td>							
							<td>Message</td>							
						</tr>
					</thead>
					<tbody>
					{foreach from=$enquiryData item=item}
						<tr>
							<td>{$item.enquiry_added}</td>
							<td><a href="/enquiries/details.php?code={$item.enquiry_code}">{$item.enquiry_code}</a></td>
							<td>{$item.enquiry_email}</td>
							<td>{$item.enquiry_message}</td>
						</tr>			     
					{foreachelse}
						<tr><td align="center" colspan="3">There are currently no items</td></tr>					
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
