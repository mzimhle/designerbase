<?php /* Smarty version 2.6.20, created on 2018-01-16 15:22:35
         compiled from advert/details.tpl */ ?>
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
	<h2 class="content-header-title">Advert</h2>
	<ol class="breadcrumb">
	<li><a href="/">Home</a></li>
	<li><a href="/advert/">Advert</a></li>
	<li><?php if (isset ( $this->_tpl_vars['advertData'] )): ?><?php echo $this->_tpl_vars['advertData']['advert_code']; ?>
<?php else: ?>Add a advert<?php endif; ?></li>
	<li class="active">Details</li>
	</ol>
	</div>	
      <div class="row">
        <div class="col-sm-12">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
				<?php if (isset ( $this->_tpl_vars['advertData'] )): ?><?php echo $this->_tpl_vars['advertData']['advert_code']; ?>
<?php else: ?>Add a advert<?php endif; ?>
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/advert/details.php<?php if (isset ( $this->_tpl_vars['advertData'] )): ?>?code=<?php echo $this->_tpl_vars['advertData']['advert_code']; ?>
<?php endif; ?>" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">
                <div class="form-group">
					<label for="advert_type">Type</label>
					<select id="advert_type" name="advert_type" class="form-control">
						<option value=""> ------ </option>
						<option value="BANNER" <?php if ($this->_tpl_vars['advertData']['advert_type'] == 'BANNER'): ?>selected<?php endif; ?>> BANNER </option>
						<option value="SQUARE" <?php if ($this->_tpl_vars['advertData']['advert_type'] == 'SQUARE'): ?>selected<?php endif; ?>> SQUARE </option>
						<option value="RECTHORIZONTAL" <?php if ($this->_tpl_vars['advertData']['advert_type'] == 'RECTHORIZONTAL'): ?>selected<?php endif; ?>> HORIZONTAL RECTANGLE </option>
						<option value="RECTVERTICAL" <?php if ($this->_tpl_vars['advertData']['advert_type'] == 'RECTVERTICAL'): ?>selected<?php endif; ?>> VERTICAL RECTANGLE </option>
						<option value="SLIDER" <?php if ($this->_tpl_vars['advertData']['advert_type'] == 'SLIDER'): ?>selected<?php endif; ?>> SLIDER </option>
						<option value="PRODUCT" <?php if ($this->_tpl_vars['advertData']['advert_type'] == 'PRODUCT'): ?>selected<?php endif; ?>> PRODUCT </option>
					</select>
					<?php if (isset ( $this->_tpl_vars['errorArray']['advert_type'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['advert_type']; ?>
</span><?php else: ?><span class="smalltext">The type of advert this is.</span><?php endif; ?>					  
                </div>
                <div class="form-group">
					<label for="advert_position">Position</label>
					<select id="advert_position" name="advert_position" class="form-control">
						<option value=""> ------ </option>
						<option value="TOP" <?php if ($this->_tpl_vars['advertData']['advert_position'] == 'TOP'): ?>selected<?php endif; ?>> TOP </option>
						<option value="SIDEBAR" <?php if ($this->_tpl_vars['advertData']['advert_position'] == 'SIDEBAR'): ?>selected<?php endif; ?>> SIDEBAR </option>
						<option value="FOOTER" <?php if ($this->_tpl_vars['advertData']['advert_position'] == 'FOOTER'): ?>selected<?php endif; ?>> FOOTER </option>
						<option value="PAGE" <?php if ($this->_tpl_vars['advertData']['advert_position'] == 'PAGE'): ?>selected<?php endif; ?>> PAGE </option>
						<option value="FEATURED" <?php if ($this->_tpl_vars['advertData']['advert_position'] == 'FEATURED'): ?>selected<?php endif; ?>> FEATURED </option>
					</select>
					<?php if (isset ( $this->_tpl_vars['errorArray']['advert_position'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['advert_position']; ?>
</span><?php else: ?><span class="smalltext">Position of the advert on the page</span><?php endif; ?>					  
                </div>				
                <div class="form-group">
					<label for="advert_page">Page</label>
					<input id="advert_page" name="advert_page" class="form-control" type="text" value="<?php echo $this->_tpl_vars['advertData']['advert_page']; ?>
"/>
					<?php if (isset ( $this->_tpl_vars['errorArray']['advert_page'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['advert_page']; ?>
</span><?php else: ?><span class="smalltext">Add a page this should be showing on, e.g. HOME, CATALOG, etc..</span><?php endif; ?>					  
                </div>
                <div class="form-group">
					<label for="advert_text">Text</label>
					<textarea id="advert_text" name="advert_text" class="form-control wysihtml5" type="text" value="<?php echo $this->_tpl_vars['advertData']['advert_text']; ?>
" rows="5"></textarea>
					<?php if (isset ( $this->_tpl_vars['errorArray']['advert_text'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['advert_text']; ?>
</span><?php else: ?><span class="smalltext">Text message of the advert</span><?php endif; ?>					  
                </div>				
                <div class="form-group">
					<label for="advert_url">URL</label>
					<input id="advert_url" name="advert_url" class="form-control" type="text" value="<?php echo $this->_tpl_vars['advertData']['advert_url']; ?>
"/>
					<?php if (isset ( $this->_tpl_vars['errorArray']['advert_url'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['advert_url']; ?>
</span><?php else: ?><span class="smalltext">Add a url link of the advert</span><?php endif; ?>					  
                </div>	
                <div class="form-group">
					<label for="advert_date_start">Date: Start</label>
					<input id="advert_date_start" name="advert_date_start" class="form-control" type="text" value="<?php echo $this->_tpl_vars['advertData']['advert_date_start']; ?>
"/>
					<?php if (isset ( $this->_tpl_vars['errorArray']['advert_date_start'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['advert_date_start']; ?>
</span><?php else: ?><span class="smalltext">Add start date of the advert</span><?php endif; ?>					  
                </div>
                <div class="form-group">
					<label for="advert_date_end">Date: End</label>
					<input id="advert_date_end" name="advert_date_end" class="form-control" type="text" value="<?php echo $this->_tpl_vars['advertData']['advert_date_end']; ?>
"/>
					<?php if (isset ( $this->_tpl_vars['errorArray']['advert_date_end'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['advert_date_end']; ?>
</span><?php else: ?><span class="smalltext">Add end date of the advert</span><?php endif; ?>					  
                </div>
                <div class="form-group"><button type="submit" class="btn btn-primary">Validate and Submit</button></div>
            </div>				
            </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
		  <?php if (isset ( $this->_tpl_vars['advertData'] ) && $this->_tpl_vars['advertData']['advert_type'] == 'PRODUCT'): ?>
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
				Add product codes
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/advert/details.php<?php if (isset ( $this->_tpl_vars['advertData'] )): ?>?code=<?php echo $this->_tpl_vars['advertData']['advert_code']; ?>
<?php endif; ?>" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">			
                <div class="form-group">
					<label for="catalog_code">Product code</label>
					<input id="catalog_code" name="catalog_code" class="form-control" type="text" value=""/>
					<?php if (isset ( $this->_tpl_vars['errorArray']['catalog_code'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['catalog_code']; ?>
</span><?php else: ?><span class="smalltext">Product this item is linked to</span><?php endif; ?>					  
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Validate and Submit</button>
                    <input type="hidden" value="1" name="catalog_link" id="catalog_link" />  
                </div>
                <div class="form-group">
				<p>Below is a list of advert products to be on featured lists.</p>
				<table class="table table-bordered">	
					<thead>
						<tr>
							<td></td>
							<td>Name - Description</td>
							<td>Price</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					<?php $_from = $this->_tpl_vars['linkData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['catalog']):
?>
    					<tr>
    						<td>
    							<a href="<?php echo $this->_tpl_vars['config']['site']; ?>
<?php echo $this->_tpl_vars['catalog']['media_path']; ?>
big_<?php echo $this->_tpl_vars['catalog']['media_code']; ?>
<?php echo $this->_tpl_vars['catalog']['media_ext']; ?>
" target="_blank">
    								<img src="<?php echo $this->_tpl_vars['config']['site']; ?>
<?php echo $this->_tpl_vars['catalog']['media_path']; ?>
tny_<?php echo $this->_tpl_vars['catalog']['media_code']; ?>
<?php echo $this->_tpl_vars['catalog']['media_ext']; ?>
" width="60" />
    							</a>
    						</td>	
    						<td><?php echo $this->_tpl_vars['catalog']['catalog_name']; ?>
 - <?php echo $this->_tpl_vars['catalog']['catalog_text']; ?>
</td>
    						<td>R <?php echo $this->_tpl_vars['catalog']['price_amount']; ?>
</td>
    						<td>
    						    <button value="Delete" class="btn btn-danger" onclick="deleteFeatureModal('<?php echo $this->_tpl_vars['catalog']['link_code']; ?>
'); return false;">Delete</button>
    						</td>
    					</tr>			     
					<?php endforeach; else: ?>
    					<tr>
    						<td align="center" colspan="4">There are currently no products added</td>
    					</tr>					
					<?php endif; unset($_from); ?>
					</tbody>					  
				</table>
                </div>				
              </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->	
		<?php endif; ?>          
		  <?php if (isset ( $this->_tpl_vars['advertData'] ) && $this->_tpl_vars['advertData']['advert_type'] != 'PRODUCT'): ?>
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
				Upload image(s) and their texts
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/advert/details.php<?php if (isset ( $this->_tpl_vars['advertData'] )): ?>?code=<?php echo $this->_tpl_vars['advertData']['advert_code']; ?>
<?php endif; ?>" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">			
                <div class="form-group">
					<label for="mediafiles">Image Upload</label>
					<input type="file" id="mediafiles" name="mediafiles" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['mediafiles'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['mediafiles']; ?>
</span><?php endif; ?>
					<span>N.B.: Only .gif, .jpg, .jpeg or .png</span>
                </div>	
                <div class="form-group">
					<label for="media_url">URL</label>
					<input id="media_url" name="media_url" class="form-control" type="text" value="<?php echo $this->_tpl_vars['advertData']['media_url']; ?>
"/>
					<?php if (isset ( $this->_tpl_vars['errorArray']['media_url'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['media_url']; ?>
</span><?php else: ?><span class="smalltext">URL linking of this image as an advert will be linking to</span><?php endif; ?>					  
                </div>				
                <div class="form-group">
					<label for="media_text">Image Text</label>
					<textarea id="media_text" name="media_text" class="form-control wysihtml5" type="text" value="<?php echo $this->_tpl_vars['advertData']['media_text']; ?>
" rows="5"></textarea>
					<?php if (isset ( $this->_tpl_vars['errorArray']['media_text'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['media_text']; ?>
</span><?php else: ?><span class="smalltext">Optionally add a message for this particular image, will also be used for alt and title</span><?php endif; ?>					  
                </div>				
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Validate and Submit</button>
                    <input type="hidden" value="1" name="image_link" id="image_link" />
                </div>
                <div class="form-group">
				<p>Below is a list of advert images linked to this advert.</p>
				<table class="table table-bordered">	
					<thead>
						<tr>
							<td>Image</td>
							<td>Text</td>
							<td></td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					<?php $_from = $this->_tpl_vars['mediaData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['advert']):
?>
						<tr>
							<td>
								<a href="<?php echo $this->_tpl_vars['config']['site']; ?>
<?php echo $this->_tpl_vars['advert']['media_path']; ?>
<?php echo $this->_tpl_vars['advert']['media_code']; ?>
<?php echo $this->_tpl_vars['advert']['media_ext']; ?>
" target="_blank">
									<img src="<?php echo $this->_tpl_vars['config']['site']; ?>
<?php echo $this->_tpl_vars['advert']['media_path']; ?>
<?php echo $this->_tpl_vars['advert']['media_code']; ?>
<?php echo $this->_tpl_vars['advert']['media_ext']; ?>
" width="60" />
								</a>
							</td>	
							<td><?php echo $this->_tpl_vars['advert']['media_text']; ?>
</td>							
							<td>
								<?php if ($this->_tpl_vars['advert']['media_primary'] == '0'): ?>
									<button value="Make Primary" class="btn btn-danger" onclick="statusSubModal('<?php echo $this->_tpl_vars['advert']['media_code']; ?>
', '1', 'details', '<?php echo $this->_tpl_vars['advertData']['advert_code']; ?>
'); return false;">Primary</button>
								<?php else: ?>
									<b>Primary</b>
								<?php endif; ?>
							</td>
							<td>
								<?php if ($this->_tpl_vars['advert']['media_primary'] == '0'): ?>
									<button value="Delete" class="btn btn-danger" onclick="deleteModal('<?php echo $this->_tpl_vars['advert']['media_code']; ?>
', '<?php echo $this->_tpl_vars['advertData']['advert_code']; ?>
', 'details'); return false;">Delete</button>
								<?php else: ?>
									<b>Primary</b>
								<?php endif; ?>
							</td>
						</tr>			     
					<?php endforeach; else: ?>
						<tr>
							<td align="center" colspan="3">There are currently no adverts</td>
						</tr>					
					<?php endif; unset($_from); ?>
					</tbody>					  
				</table>
                </div>				
              </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->	
		<?php endif; ?>		  
        </div> <!-- /.col -->
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<script type="text/javascript" src="/library/javascript/plugins/wysihtml5/wysihtml5-0.3.js"></script>
<script type="text/javascript" src="/library/javascript/plugins/wysihtml5/bootstrap-wysihtml5.js"></script>
<?php echo '
<script type="text/javascript" language="javascript">
$(document).ready(function(){

	$(\'.wysihtml5\').wysihtml5();
	
    var dateFormat = "yy-mm-dd",
      from = $( "#advert_date_start" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
		  dateFormat: "yy-mm-dd",
          numberOfMonths: 3
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#advert_date_end" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
		dateFormat: "yy-mm-dd",
        numberOfMonths: 3
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
      return date;
    }
	});
	function deleteFeature() {
		$.ajax({
			type: "GET",
			url: "details.php?deletefeature=1",
			data: "featurecode="+$(\'#catalogcode\').val(),
			dataType: "json",
			success: function(data){
				if(data.result == 1) {
                    window.location.href = window.location.href;
				} else {
					$(\'#deleteFeatureModal\').modal(\'hide\');
					$.howl ({
					  type: \'danger\'
					  , title: \'Error Message\'
					  , content: data.error
					  , sticky: $(this).data (\'sticky\')
					  , lifetime: 7500
					  , iconCls: $(this).data (\'icon\')
					});					
				}
			}
		});
		return false;
	}

	function deleteFeatureModal(code) {
		$(\'#catalogcode\').val(code);
		$(\'#deleteFeatureModal\').modal(\'show\');
		return false;
	}
	
  </script>
'; ?>

<!-- Modal -->
<div class="modal fade" id="deleteFeatureModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Delete Item</h4>
			</div>
			<div class="modal-body">Are you sure you want to delete this featured product?</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
				<button class="btn btn-warning" type="button" onclick="javascript:deleteFeature();">Delete Feature</button>
				<input type="hidden" id="catalogcode" name="catalogcode" value=""/>
			</div>
		</div>
	</div>
</div>
<!-- modal -->

</html>