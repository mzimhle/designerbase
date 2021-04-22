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
		<h2 class="content-header-title">Advert</h2>
		<ol class="breadcrumb">
			<li><a href="/">Home</a></li>
			<li><a href="#">Advert</a></li>
			<li class="active">List</li>
		</ol>
	</div>	
      <div class="row">
        <div class="col-sm-12">
		<button class="btn btn-secondary fr" type="button" onclick="link('/advert/details.php'); return false;">Add a new advert</button><br/ ><br />
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					Advert list
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/dashboard/brand/" method="POST" data-validate="parsley" class="form parsley-form">			
				<table class="table table-bordered">	
					<thead>
						<tr>
							<td>Type</td>
							<td>Page</td>
							<td></td>
							<td>Date Start</td>
							<td>Date End</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					{foreach from=$advertData item=item}
						<tr>
							<td>{$item.advert_type}</td>
							<td>{$item.advert_page}</td>
							<td>
								<a href="/advert/details.php?code={$item.advert_code}">
									{if $item.media_path neq ''} 
									<img src="{$config.site}{$item.media_path}{$item.media_code}{$item.media_ext}" width="30px" target="_blank" />
									{else}
									<img src="/images/avatar.jpg" width="30px" target="_blank" />
									{/if}
								</a>
							</td>	
							<td>{$item.advert_date_start}</td>	
							<td>{$item.advert_date_end}</td>		
							<td>
								<button value="Delete" class="btn btn-danger" onclick="deleteModal('{$item.advert_code}', '', 'default'); return false;">Delete</button>
							</td>
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