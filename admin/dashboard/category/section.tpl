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
			<li><a href="/dashboard/category/">Categories</a></li>
			<li>{$itemData.item_name}</li>
			<li class="active">Section</li>
		</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					Sections
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/dashboard/category/section.php?code={$itemData.item_code}" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">			
				<p>Below is a list of sections for the category <b>{$itemData.item_name}</b>.</p>
				<table class="table table-bordered">	
					<thead>
						<tr>
							<td>Name</td>
							<td>Code</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					{foreach from=$sectionData item=item}
					<tr>
						<td>{$item.item_name}</td>
						<td>{$item.item_cipher}</td>
						<td>
							<button value="Delete" class="btn btn-danger" onclick="deleteModal('{$item.item_code}', '{$itemData.item_code}', 'section'); return false;">Delete</button>
						</td>
					</tr>			     
					{foreachelse}
						<tr>
							<td align="center" colspan="3">There are currently no items</td>
						</tr>					
					{/foreach}
					</tbody>					  
				</table>
				<p>Add a new section below</p>		
				<div class="form-group">
					<label for="item_name">Name</label>
					<input type="text" id="item_name" name="item_name" class="form-control" data-required="true" value="" />
					{if isset($errorArray.item_name)}<span class="error">{$errorArray.item_name}</span>{else}<span class="smalltext">Full name of the item as it will be seen on the website</span>{/if}					  
				</div>
				<div class="form-group">
					<label for="item_cipher">Code</label>
					<input type="text" id="item_cipher" name="item_cipher" class="form-control" data-required="true" value="" />
					{if isset($errorArray.item_cipher)}<span class="error">{$errorArray.item_cipher}</span>{else}<span class="smalltext">Please add the code for when adding price with sizes. Only use one word as a code</span>{/if}					  
				</div>				
                <div class="form-group"><button type="submit" class="btn btn-primary">Upload and Save</button></div>
              </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->		
		<div class="col-sm-3">
			<div class="list-group">  
				<a href="/dashboard/category/" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;List
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a href="/dashboard/category/details.php?code={$itemData.item_code}" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;Details
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a href="/dashboard/category/media.php?code={$itemData.item_code}" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;Images
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a href="#" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;Sections
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>				
			</div> <!-- /.list-group -->
		</div>		
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
{include_php file='includes/footer.php'}
{include_php file='includes/javascript.php'}
</html>