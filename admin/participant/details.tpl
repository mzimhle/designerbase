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
	<link href="/css/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css"  />
</head>
<body>
{include_php file='includes/header.php'}
<div class="container">
  <div class="content">
    <div class="content-container">
	<div class="content-header">
	<h2 class="content-header-title">Participants</h2>
	<ol class="breadcrumb">
		<li><a href="/">Home</a></li>
		<li><a href="/participant/">Participants</a></li>
		<li><a href="#">{if isset($participantData)}{$participantData.participant_name}{else}Add a participant{/if}</a></li>
		<li class="active">Details</li>
	</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					{if isset($participantData)}{$participantData.participant_name}{else}Add a participant{/if}
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/participant/details.php{if isset($participantData)}?code={$participantData.participant_code}{/if}" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">
                <div class="form-group">
					<label for="participant_name">Name</label>
					<input type="text" id="participant_name" name="participant_name" class="form-control" data-required="true" value="{$participantData.participant_name}" />
					{if isset($errorArray.participant_name)}<span class="error">{$errorArray.participant_name}</span>{else}<span class="smalltext">Full name of the participant</span>{/if}					  
                </div>	
                <div class="form-group">
					<label for="participant_email">Email</label>
					<input type="text" id="participant_email" name="participant_email" class="form-control" value="{$participantData.participant_email}" />
					{if isset($errorArray.participant_email)}<span class="error">{$errorArray.participant_email}</span>{else}<span class="smalltext">Add email address of the participant</span>{/if}					  
                </div>
                <div class="form-group">
					<label for="participant_number">Number</label>
					<input type="text" id="participant_number" name="participant_number" class="form-control" value="{$participantData.participant_number}" />
					{if isset($errorArray.participant_number)}<span class="error">{$errorArray.participant_number}</span>{else}<span class="smalltext">Telephone number of the participant</span>{/if}					  
                </div>		
                <div class="form-group">
					<label for="participant_password">Password</label>
					<input type="text" id="participant_password" name="participant_password" class="form-control" data-required="true" value="{$participantData.participant_password}" />
					{if isset($errorArray.participant_password)}<span class="error">{$errorArray.participant_password}</span>{else}<span class="smalltext">Password of the participant</span>{/if}					  
                </div>
               <div class="form-group">
					<label for="participant_address">Address</label>
					<textarea cols="15" rows="3" id="participant_address" name="participant_address" class="form-control" data-required="true">{$participantData.participant_address}</textarea>
					{if isset($errorArray.participant_password)}<span class="error">{$errorArray.participant_password}</span>{else}<span class="smalltext">Password of the participant</span>{/if}					  
                </div>                
                <div class="form-group">
					<label for="areapost_name">Location</label>
					<input type="text" id="areapost_name" name="areapost_name" class="form-control" data-required="true" value="{$participantData.areapost_name}" />
					<input type="hidden" id="areapost_code" name="areapost_code" class="form-control" value="{$participantData.areapost_code}" />
					{if isset($errorArray.areapost_code)}<span class="error">{$errorArray.areapost_code}</span>{else}<span class="smalltext">Location of the participant</span>{/if}					  
                </div>                
                <div class="form-group"><button type="submit" class="btn btn-primary">Validate and Submit</button></div>
              </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->	
		<div class="col-sm-3">
			<div class="list-group">  
				<a href="/participant/" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;List
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				{if isset($participantData)}
				<a href="/participant/details.php?code={$participantData.participant_code}" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;Details
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				{/if}
			</div> <!-- /.list-group -->
		</div>
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
{include_php file='includes/footer.php'}
{include_php file='includes/javascript.php'}
{literal}
<script type="text/javascript" language="javascript">
    $(document).ready(function(){
		$( "#areapost_name" ).autocomplete({
			source: "/feeds/areapost.php",
			minLength: 2,
			select: function( event, ui ) {
				if(ui.item.id == '') {
					$('#areapost_name').html('');
					$('#areapost_code').val('');					
				} else {
					$('#areapost_name').html('<b>' + ui.item.value + '</b>');
					$('#areapost_code').val(ui.item.id);	
				}
				$('#areapost_name').val('');										
			}
		});			
    });
</script>
{/literal} 
</html>
