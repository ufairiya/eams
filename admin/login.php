<?php
	include_once 'ApplicationHeader.php';
	
	if(isset($_REQUEST['username']) && isset($_REQUEST['password']))
	{
	  include_once ADMIN_LIB_PATH.'/LoginMgr.php';
	  if($isLogin == 1 && $isAdmin == 1 )
	  {
	    header("Location: index.php");
	  }
	}  

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>

  <meta charset="utf-8" />

  <title>EAMS| Admin Login</title>

  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <meta content="" name="description" />

  <meta content="" name="author" />

  <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

  <link href="../assets/css/metro.css" rel="stylesheet" />

  <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

  <link href="../assets/css/style.css" rel="stylesheet" />

  <link href="../assets/css/style_responsive.css" rel="stylesheet" />

  <link href="../assets/css/style_default.css" rel="stylesheet" id="style_color" />

  <link rel="stylesheet" type="text/css" href="../assets/uniform/css/uniform.default.css" />

  <link rel="shortcut icon" href="favicon.ico" />

</head>

<!-- END HEAD -->

<!-- BEGIN BODY -->

<body class="login">

  <!-- BEGIN LOGO -->

  <div class="logo">

    <img src="../assets/img/logo-big.png" alt="" /> 

  </div>

  <!-- END LOGO -->

  <!-- BEGIN LOGIN -->

  <div class="content">

    <!-- BEGIN LOGIN FORM -->

    <form class="form-vertical login-form" action="login.php" method="post">

      <h3 class="form-title">WELCOME TO AMS </h3>

      <div class="alert alert-error hide">

        <button class="close" data-dismiss="alert"></button>

        <span>Enter any username and passowrd.</span>

      </div>

      <div class="control-group">

        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->

        <label class="control-label visible-ie8 visible-ie9">Username</label>

        <div class="controls">

          <div class="input-icon left">

            <i class="icon-user"></i>

            <input class="m-wrap placeholder-no-fix" type="text" placeholder="Username" name="username" value="" />

          </div>

        </div>

      </div>

      <div class="control-group">

        <label class="control-label visible-ie8 visible-ie9">Password</label>

        <div class="controls">

          <div class="input-icon left">

            <i class="icon-lock"></i>

            <input class="m-wrap placeholder-no-fix" type="password" placeholder="Password" name="password" value=""/>

          </div>

        </div>

      </div>

      <div class="form-actions">

        <label class="checkbox">

        <input type="checkbox" name="remember" value="1"/> Remember me

        </label>

        <input type="submit" name="Login" value="Login" class="btn green pull-right">

         <i class="m-icon-swapright m-icon-white"></i>

                   

      </div>

    <?php /*?>  <div class="forget-password">

        <h4>Forgot your password ?</h4>

        <p>

          no worries, click <a href="javascript:;" class="" id="forget-password">here</a>

          to reset your password.

        </p>

      </div>

      <div class="create-account">

        <p>

          Don't have an account yet ?&nbsp; 

          <a href="javascript:;" id="register-btn" class="">Create an account</a>

        </p>

      </div>
<?php */?>
    </form>

  <?php /*?>  <!-- END LOGIN FORM -->        

    <!-- BEGIN FORGOT PASSWORD FORM -->

    <form class="form-vertical forget-form" action="login.php" method="post">

      <h3 class="">Forget Password ?</h3>

      <p>Enter your e-mail address below to reset your password.</p>

      <div class="control-group">

        <div class="controls">

          <div class="input-icon left">

            <i class="icon-envelope"></i>

            <input class="m-wrap placeholder-no-fix" type="text" placeholder="Email" name="email" />

          </div>

        </div>

      </div>

      <div class="form-actions">

        <button type="button" id="back-btn" class="btn">

        <i class="m-icon-swapleft"></i> Back

        </button>

        <input type="submit" class="btn green pull-right">

        Submit <i class="m-icon-swapright m-icon-white"></i>

        

      </div>

    </form>

    <!-- END FORGOT PASSWORD FORM -->

    <!-- BEGIN REGISTRATION FORM -->

    <form class="form-vertical register-form" action="login.php" method="post">

      <h3 class="">Sign Up</h3>

      <p>Enter your account details below:</p>

      <div class="control-group">

        <label class="control-label visible-ie8 visible-ie9">Username</label>

        <div class="controls">

          <div class="input-icon left">

            <i class="icon-user"></i>

            <input class="m-wrap placeholder-no-fix" type="text" placeholder="Username" name="username"/>

			<input name="loginsubmit" type="hidden" value="loginsubmit">

          </div>

        </div>

      </div>

      <div class="control-group">

        <label class="control-label visible-ie8 visible-ie9">Password</label>

        <div class="controls">

          <div class="input-icon left">

            <i class="icon-lock"></i>

            <input class="m-wrap placeholder-no-fix" type="password" id="register_password" placeholder="Password" name="password"/>

          </div>

        </div>

      </div>

      <div class="control-group">

        <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>

        <div class="controls">

          <div class="input-icon left">

            <i class="icon-ok"></i>

            <input class="m-wrap placeholder-no-fix" type="password" placeholder="Re-type Your Password" name="rpassword"/>

          </div>

        </div>

      </div>

      <div class="control-group">

        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->

        <label class="control-label visible-ie8 visible-ie9">Email</label>

        <div class="controls">

          <div class="input-icon left">

            <i class="icon-envelope"></i>

            <input class="m-wrap placeholder-no-fix" type="text" placeholder="Email" name="email"/>

          </div>

        </div>

      </div>

      <div class="control-group">

        <div class="controls">

          <label class="checkbox">

          <input type="checkbox" name="tnc"/> I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>

          </label>  

          <div id="register_tnc_error"></div>

        </div>

      </div>

      <div class="form-actions">

        <button id="register-back-btn" type="button" class="btn">

        <i class="m-icon-swapleft"></i>  Back

        </button>

        <input type="submit" id="register-submit-btn" class="btn green pull-right">

        Sign Up <i class="m-icon-swapright m-icon-white"></i>

        

      </div>

    </form>

    <!-- END REGISTRATION FORM --><?php */?>

  </div>

  <!-- END LOGIN -->

  <!-- BEGIN COPYRIGHT -->

  <div class="copyright">

    <?php echo date('Y'); ?> &copy; EnterpriseAMS

  </div>

  <!-- END COPYRIGHT -->

  <!-- BEGIN JAVASCRIPTS -->

  <script src="../assets/js/jquery-1.8.3.min.js"></script>

  <script src="../assets/bootstrap/js/bootstrap.min.js"></script>  

  <script src="../assets/uniform/jquery.uniform.min.js"></script> 

  <script src="../assets/js/jquery.blockui.js"></script>

  <script type="text/javascript" src="../assets/jquery-validation/dist/jquery.validate.min.js"></script>

  <script src="../assets/js/app.js"></script>

  <script>

    jQuery(document).ready(function() {     

     App.initLogin();

    });

  </script>

  <!-- END JAVASCRIPTS -->

</body>

<!-- END BODY -->

</html>