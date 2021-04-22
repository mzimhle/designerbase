<?php /* Smarty version 2.6.20, created on 2018-09-11 22:28:24
         compiled from login.tpl */ ?>
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

</head>
<body class="account-bg">
<div class="account-wrapper">
    <div class="account-body">
      <h3 class="account-body-title">DesignerBase Account</h3>
      <form class="form account-form" method="POST" action="login.php">
        <div class="form-group">
          <label for="username" class="placeholder">Email Address</label>
          <input type="text" class="form-control" id="username" name="username" placeholder="Email Address" tabindex="1" />
        </div> <!-- /.form-group -->
        <div class="form-group">
          <label for="password" class="placeholder">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Password" tabindex="2" />
        </div> <!-- /.form-group -->
        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-block btn-lg" tabindex="3">
            Signin &nbsp; <i class="fa fa-play-circle"></i>
          </button>
        </div> <!-- /.form-group -->
		<span class="error"><?php echo $this->_tpl_vars['loginmessage']; ?>
</span>
      </form>
    </div> <!-- /.account-body -->
  </div> <!-- /.account-wrapper -->
	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/js.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</body>
</html>