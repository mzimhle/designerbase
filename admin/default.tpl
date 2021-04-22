<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<title>Management System</title>
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
      <div class="row">
        <div class="col-md-12">
          <div class="portlet">
            <div class="portlet-header">
              <h3><i class="fa fa-calendar"></i>Administration</h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">
				<p>Please select an brand  before before we continue.</p>
				{if isset($activeBrand)}<p>Select brand is: <span class="success">{$activeBrand.brand_name}</span></p>{/if}
                <div class="form-group">
					<label for="brand_code">Select an supplier</label>
					<select id="brand_code" name="brand_code" class="form-control">
						<option value=""> ---- </option>
						{html_options options=$brandPairs selected=$brand}
					</select>
					{if isset($errorArray.brand_code)}<br /><span class="error">{$errorArray.brand_code}</span>{/if}
                </div>			
				<div class="form-group"><button type="submit" class="btn btn-primary">Select brand</button></div>				
			  </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col-md-8 -->
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
{include_php file='includes/footer.php'}
{include_php file='includes/javascript.php'}
</html>
