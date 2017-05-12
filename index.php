<?php 
  session_start();

  include('dbconfig.php');
?>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Easy Accounts | Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo HOMEURL; ?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo HOMEURL; ?>plugins/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"-->
  <link rel="stylesheet" href="<?php echo HOMEURL; ?>plugins/ionicons/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo HOMEURL; ?>dist/css/AdminLTE.min.css">

  <link rel="stylesheet" href="<?php echo HOMEURL; ?>dist/css/wizard.css">
  <link rel="stylesheet" href="<?php echo HOMEURL; ?>plugins/datatables/dataTables.bootstrap.css">
  <!--link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.0.1/css/bootstrap3/bootstrap-switch.css"-->
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <link rel="stylesheet" href="<?php echo HOMEURL; ?>dist/css/skins/skin-purple.min.css">
  <link rel="stylesheet" href="<?php echo HOMEURL; ?>plugins/datepicker/datepicker3.css">
  <!-- jQuery 2.2.0 -->
  <script src="<?php echo HOMEURL; ?>plugins/jQuery/jQuery-2.2.0.min.js"></script>
  <script type="text/javascript" src="<?php echo HOMEURL; ?>dist/js/wizard.js"></script>
  <!--script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
  <!script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.0.1/js/bootstrap-switch.js"></script-->

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href=""><b>Easy Accounts</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <!--  <p class="login-box-msg">Sign in to start your session</p> -->

    <form action="#" method="post" onsubmit="return false;">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Username" id="username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" id="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div> -->
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" onclick="login()">Log In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  

    <!-- <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div> -->
    <!-- /.social-auth-links -->

    <!-- <a href="#">I forgot my password</a><br> -->
    <!-- <a href="register.html" class="text-center">Register a new membership</a> -->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->



<!-- jQuery 2.2.0 -->
<script src="../../plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="../../plugins/iCheck/icheck.min.js"></script>

<script src="<?php echo HOMEURL; ?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo HOMEURL; ?>plugins/bootbox/bootbox-4.0.0.min.js"></script>

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });

  function login(){

    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var data = "username="+username+"&password="+password+"&action=login";
    $.ajax({
            url: "loginservices.php",
            type: "POST",
            data:  data,
            dataType: 'json',
            success: function(result){
              if(result.infocode == "LOGINSUCCESS"){
                window.location.href = result.message;
              } else {
                bootbox.alert(result.message);
              }
            },
            error: function(){
              bootbox.alert(result.message);}           
          });
  }

</script>
</body>
</html>
