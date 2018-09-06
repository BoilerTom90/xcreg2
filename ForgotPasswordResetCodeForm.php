<?php 
 
// require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');
require_once('includes/status_msg.inc.php');
require_once('classes/PHPSession.php');
PHPSession::Instance()->StartSession();

if (!isset($_REQUEST) || !isset($_REQUEST['email']) || !isset($_REQUEST['reset_code'])) {
   $status_msg = "Invalid navigation to prior page.";
   $alertCategory = "alert-danger";
   header("location: index.php?status_msg=$status_msg" . "&alert_category=$alertCategory");  
   exit;
}

$email = trim(strtolower($_REQUEST['email']));
$reset_code = trim($_REQUEST['reset_code']);

?>

<body>

<?php 
require_once('includes/navbar.inc.php'); 
OutputNavBar("Home");
?>



<br/>
<div class="container">
    <div class="row">
        <div class="col-xs-2">
        </div>
        <div class="col-xs-8 col-md-offsetx-7">
            <div class="panel panel-primary">
                <div class="panel-heading"> 
                  <strong class="">Reset Your Password <em>[<?php echo $email; ?>]</em></strong>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="ForgotPasswordResetCodeHandler.php">
                        
                        <?php DisplayStatusMessage($status_msg) ?>

                        <input type="hidden" id="email" name="email" 
                               value="<?php echo "$email" ?>" >

                        <div class="form-group">
                            <label for="reset_code" class="col-sm-3 control-label">Reset Code</label>
                            <div class="col-sm-6">
                                <input type="number" name="reset_code" 
                                    class="form-control" id="reset_code"
                                    value="<?php echo "$reset_code" ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new_password" class="col-sm-3 control-label">New Password</label>
                            <div class="col-sm-6">
                                <input type="password" name="new_password" 
                                    class="form-control" id="new_password"
                                    value="" pattern="[A-Za-z0-9@#$%^]{4,10}" 
                                    title="4 to 10 alphanumeric characters, incuding @, #, $, %, ^"
                                    required>
                            </div>
                        </div>  

                        <div class="form-group">
                            <label for="new_password_confirm" class="col-sm-3 control-label">Confirm New Password</label>
                            <div class="col-sm-6">
                                <input type="password" name="new_password_confirm" 
                                    class="form-control" id="new_password_confirm"
                                    value="" pattern="[A-Za-z0-9@#$%^]{4,10}" 
                                    title="4 to 10 alphanumeric characters, incuding @, #, $, %, ^"
                                    required>
                            </div>
                        </div>    
                        <hr>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" name="button" value="reset_password" 
                                        class="btn btn-primary btn-md">Reset Password</button>
                            </div>
                        </div
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xs-2"></div>
    </div>
</div>


<?php 
require_once('includes/footer.inc.php'); 
?>