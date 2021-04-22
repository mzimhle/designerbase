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
	<h2 class="content-header-title">Socials</h2>
	<ol class="breadcrumb">
		<li><a href="/">Home</a></li>
		<li><a href="/social/">Socials</a></li>
		<li><a href="#">{if isset($socialData)}{$socialData.social_message}{else}Add a social{/if}</a></li>
		<li class="active">Details</li>
	</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					{if isset($socialData)}{$socialData.social_message}{else}Add a social{/if}
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/social/details.php{if isset($socialData)}?code={$socialData.social_code}{/if}" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">
				<div class="form-group">
					<label for="social_message">Message</label>
					<textarea id="social_message" name="social_message" class="form-control">{$socialData.social_message}</textarea>
					<p id="social_count">0 characters entered.</p>					
					<p>N.B.: If you are uploading an media, the text needs to be at least maximum 100 characters, otherwise twitter wont upload it.</p>
					{if isset($errorArray.social_message)}<span class="error">{$errorArray.social_message}</span>{/if}	
				</div>	
				<div class="form-group">
				  <label for="social_date">Date</label>
				  <input type="text" id="social_date" name="social_date" class="form-control" value="{$socialData.social_date}" />
				</div>					
                <div class="form-group">
					<label for="mediafile">Upload</label>
					<input type="file" id="mediafile" name="mediafile" />
					{if isset($errorArray.mediafile)}<br /><span class="error">{$errorArray.mediafile}</span>{/if}					  
					<br /><span>Allowed files are png, jpg, jpeg.</span>
                </div>
				{if $socialData.media_path neq ''}
                <div class="form-group">
					<img src="{$config.site}{$socialData.media_path}{$socialData.media_code}{$socialData.media_ext}" width="550px" />
                </div>
				{/if}
				<div class="form-group">
					<button class="btn btn-warning" type="submit">Add social</button>		
				</div>				
				<hr />
				<div class="form-group">
					<label for="bit">Create Bit</label>
					<input type="text" id="bit" name="bit" class="form-control" />
					<br />
					<p class="socialbiturl"></p>
					<br />
					<button class="btn" type="button" onclick="javascript:createBit('bit');">Create bit</button>
				</div>
              </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col --> 
		<div class="col-sm-3">
			<div class="list-group">  
				<a class="list-group-item" href="/social/">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;List
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>				
				<a class="list-group-item" href="#">
				  <i class="fa fa-book"></i> &nbsp;&nbsp;Details
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
<script type="text/javascript" 
{literal}
<script type="text/javascript" language="javascript">
	$(document).ready(function(){
		$("#social_message").keyup(function () {
			var i = $("#social_message").val().length;
			$("#social_count").html(i+' characters entered.');
			if (i > 140) {
				$('#social_count').removeClass('success');
				$('#social_count').addClass('error');
			} else if(i == 0) {
				$('#social_count').removeClass('success');
				$('#social_count').addClass('error');
			} else {
				$('#social_count').removeClass('error');
				$('#social_count').addClass('success');
			} 
		});
		$('#social_date').datetimepicker({
			timeFormat: "hh:mm:ss",
			defaultDate: "+1w",
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			numberOfMonths: 1
		});		
	});
	 
	function createBit(idtext) {

		var url	= $('#'+idtext).val();
 
		$.ajax({
			type: "GET",
			url: "/social/details.php{/literal}{if isset($socialData)}?code={$socialData.social_code}{/if}{literal}",
			data: "create_bit="+encodeURI(url),
			dataType: "html",
			success: function(data){
				$('.socialbiturl').removeClass('error');
				$('.socialbiturl').removeClass('success');
				if(data != '') {
					$('.socialbiturl').html(data);
					$('.socialbiturl').addClass('success');
				} else {
					$('.socialbiturl').html('Not created, please try again.');
					$('.socialbiturl').addClass('error');
				}
			}
		});								

		return false;
	}
	
</script>
{/literal}

</body>
</html>
