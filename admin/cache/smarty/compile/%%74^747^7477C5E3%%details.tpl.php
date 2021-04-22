<?php /* Smarty version 2.6.20, created on 2018-01-11 09:34:55
         compiled from participant/details.tpl */ ?>
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
	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/css.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
	
	<link href="/css/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css"  />
</head>
<body>
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<div class="container">
  <div class="content">
    <div class="content-container">
	<div class="content-header">
	<h2 class="content-header-title">Participants</h2>
	<ol class="breadcrumb">
		<li><a href="/">Home</a></li>
		<li><a href="/participant/">Participants</a></li>
		<li><a href="#"><?php if (isset ( $this->_tpl_vars['participantData'] )): ?><?php echo $this->_tpl_vars['participantData']['participant_name']; ?>
<?php else: ?>Add a participant<?php endif; ?></a></li>
		<li class="active">Details</li>
	</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					<?php if (isset ( $this->_tpl_vars['participantData'] )): ?><?php echo $this->_tpl_vars['participantData']['participant_name']; ?>
<?php else: ?>Add a participant<?php endif; ?>
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/participant/details.php<?php if (isset ( $this->_tpl_vars['participantData'] )): ?>?code=<?php echo $this->_tpl_vars['participantData']['participant_code']; ?>
<?php endif; ?>" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">
                <div class="form-group">
					<label for="participant_name">Name</label>
					<input type="text" id="participant_name" name="participant_name" class="form-control" data-required="true" value="<?php echo $this->_tpl_vars['participantData']['participant_name']; ?>
" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['participant_name'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['participant_name']; ?>
</span><?php else: ?><span class="smalltext">Full name of the participant</span><?php endif; ?>					  
                </div>	
                <div class="form-group">
					<label for="participant_email">Email</label>
					<input type="text" id="participant_email" name="participant_email" class="form-control" value="<?php echo $this->_tpl_vars['participantData']['participant_email']; ?>
" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['participant_email'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['participant_email']; ?>
</span><?php else: ?><span class="smalltext">Add email address of the participant</span><?php endif; ?>					  
                </div>
                <div class="form-group">
					<label for="participant_number">Number</label>
					<input type="text" id="participant_number" name="participant_number" class="form-control" value="<?php echo $this->_tpl_vars['participantData']['participant_number']; ?>
" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['participant_number'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['participant_number']; ?>
</span><?php else: ?><span class="smalltext">Telephone number of the participant</span><?php endif; ?>					  
                </div>		
                <div class="form-group">
					<label for="participant_password">Password</label>
					<input type="text" id="participant_password" name="participant_password" class="form-control" data-required="true" value="<?php echo $this->_tpl_vars['participantData']['participant_password']; ?>
" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['participant_password'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['participant_password']; ?>
</span><?php else: ?><span class="smalltext">Password of the participant</span><?php endif; ?>					  
                </div>
               <div class="form-group">
					<label for="participant_address">Address</label>
					<textarea cols="15" rows="3" id="participant_address" name="participant_address" class="form-control" data-required="true"><?php echo $this->_tpl_vars['participantData']['participant_address']; ?>
</textarea>
					<?php if (isset ( $this->_tpl_vars['errorArray']['participant_password'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['participant_password']; ?>
</span><?php else: ?><span class="smalltext">Password of the participant</span><?php endif; ?>					  
                </div>                
                <div class="form-group">
					<label for="areapost_name">Location</label>
					<input type="text" id="areapost_name" name="areapost_name" class="form-control" data-required="true" value="<?php echo $this->_tpl_vars['participantData']['areapost_name']; ?>
" />
					<input type="hidden" id="areapost_code" name="areapost_code" class="form-control" value="<?php echo $this->_tpl_vars['participantData']['areapost_code']; ?>
" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['areapost_code'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['areapost_code']; ?>
</span><?php else: ?><span class="smalltext">Location of the participant</span><?php endif; ?>					  
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
				<?php if (isset ( $this->_tpl_vars['participantData'] )): ?>
				<a href="/participant/details.php?code=<?php echo $this->_tpl_vars['participantData']['participant_code']; ?>
" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;Details
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<?php endif; ?>
			</div> <!-- /.list-group -->
		</div>
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php echo '
<script type="text/javascript" language="javascript">
    $(document).ready(function(){
		$( "#areapost_name" ).autocomplete({
			source: "/feeds/areapost.php",
			minLength: 2,
			select: function( event, ui ) {
				if(ui.item.id == \'\') {
					$(\'#areapost_name\').html(\'\');
					$(\'#areapost_code\').val(\'\');					
				} else {
					$(\'#areapost_name\').html(\'<b>\' + ui.item.value + \'</b>\');
					$(\'#areapost_code\').val(ui.item.id);	
				}
				$(\'#areapost_name\').val(\'\');										
			}
		});			
    });
</script>
'; ?>
 
</html>