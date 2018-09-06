<?php 

require_once('classes/PHPSession.php');
require_once('includes/head.inc.php');
require_once('includes/status_msg.inc.php');
require_once('classes/Constants.php');


PHPSession::Instance()->StartSession();
// var_dump(session_status()); 
// var_dump(session_get_cookie_params());
// var_dump(PHPSession::Instance()->GetAllSessionVariables());exit;
//var_dump(PHPSession::Instance()->GetAllSessionVariables());exit;

?> 

<body>

<?php 
require_once('includes/navbar.inc.php'); 
OutputNavBar("Home");
?>

<div class="container" style="padding-top:20px">
	<div class="jumbotron" >
		<h2>Cross Country Registration <?php /* echo $_SERVER['HTTP_HOST']; */ ?></h2>
		This site is used by coaches and athletic directors to register their team's runners for MS Cross Country Meets. 
      
      
      <?php if (!PHPSession::Instance()->GetSessionVariable('role')) { ?>
         You need an account to login and register your runners.
         <ul>
            <li>Need an account? <a class="btn btn-info btn-xs" href="RequestAccount.php">click here.</a></li>
            <li>Forgot your password? <a class="btn btn-info btn-xs" href="ForgotPasswordForm.php">click here.</a></li>
         </ul>
      <?php } ?>     
       <ul>
         <li>Contact the administrator: <a class="btn btn-info btn-xs" href="ContactMain.php">click here.</a></li>
      </ul> 
      <strong><span style="color:red">New this year!</span> When registering your runners, you must indicate which race the runner will compete in!</strong>
	</div>
</div>

<div class="container">
    <div class="row">
        <div class="col-xs-7">
        	<!-- if not logged in, present the login form, else present the user's login information including their school -->
           <?php 
           
            $role = PHPSession::Instance()->GetSessionVariable('role');
            //var_dump($role); exit;
        	   if ($role == NULL) {   
               require_once('includes/LoginForm.inc.php');
            } else {
               require_once('includes/LoginCredentials.inc.php');
            }
        	?>
        </div>
       <div class="col-sm-5 col-xs-12">
          <img src="carousel_images/jpg5.jpg" class="img-rounded img-responsive" style="width:100%; border:1px solid gray" alt="running quote" />
       </div>
    </div>
</div>


<?php require_once('includes/footer.inc.php') ?>