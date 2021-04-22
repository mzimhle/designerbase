<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<title>DesignerBase Account Management System</title>
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
			<li>{if isset($itemData.item_code)}{$itemData.item_name}{else}Add a item{/if}</li>
			<li class="active">Media</li>
		</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					Media list
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/dashboard/category/media.php?code={$itemData.item_code}" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">			
				<p>Below is a list of item images.</p>
				<table class="table table-bordered">	
					<thead>
						<tr>
							<td>Image</td>
							<td>Type</td>
							<td></td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					{foreach from=$mediaData item=item}
						<tr>
							<td>
								<a href="{$config.site}{$item.media_path}/big_{$item.media_code}{$item.media_ext}" target="_blank">
									<img src="{$config.site}{$item.media_path}/tny_{$item.media_code}{$item.media_ext}" width="60" />
								</a>
							</td>
							<td>{$item.media_category}</td>							
							<td>
								{if $item.media_primary eq '0'}
									<button value="Make Primary" class="btn btn-danger" onclick="statusSubModal('{$item.media_code}', '1', 'media', '{$itemData.item_code}'); return false;">Primary</button>
								{else}
								<b>Primary</b>
								{/if}
							</td>
							<td>
								{if $item.media_primary eq '0'}
									<button value="Delete" class="btn btn-danger" onclick="deleteModal('{$item.media_code}', '{$itemData.item_code}', 'media'); return false;">Delete</button>
								{else}
									<b>Primary</b>
								{/if}
							</td>
						</tr>			     
					{foreachelse}
						<tr>
							<td align="center" colspan="4">There are currently no items</td>
						</tr>					
					{/foreach}
					</tbody>					  
				</table>
				<p>Add new image below</p>		
                <div class="form-group">
					<label for="media_category">Type</label>
					<select id="media_category" name="media_category" class="form-control" >
						<option value=""> ---- </option>
						<option value="IMAGE">IMAGE</option>
						<option value="BANNER">BANNER</option>
					</select>
					{if isset($errorArray.media_category)}<span class="error">{$errorArray.media_category}</span>{/if}
                </div>				
                <div class="form-group">
					<label for="mediafiles">Image Upload</label>
					<input type="file" id="mediafiles[]" name="mediafiles[]" multiple />
					{if isset($errorArray.mediafiles)}<span class="error">{$errorArray.mediafiles}</span>{/if}
					<br /><span>N.B.: If your media are too big and being cropped, please use the windows software "Paint" or "Microsoft Office Picture Manager" to resize them to at least be 430px in width and 590px in height at least.</span>
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
				<a href="#" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;Images
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a href="/dashboard/category/section.php?code={$itemData.item_code}" class="list-group-item">
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