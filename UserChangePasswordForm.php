<?php 
 
require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');
require_once('includes/status_msg.inc.php');

$email = PHPSession::Instance()->GetSessionVariable ('email');
$userObj = new UsersTable();
$user = $userObj->ReadByEmail($email);
if (empty($user)) {
    header("location: index.php?status_msg='User not found in the system'");
    exit;
}

$user_id = $user[0]['id'];

?>

<body>

<?php 
require_once('includes/navbar.inc.php'); 
OutputNavBar("ChangePassword");
?>



<br/>
<div class="container">
    <div class="row">
        <div class="col-xs-2">
        </div>
        <div class="col-xs-8 col-md-offsetx-7">
            <div class="panel panel-primary">
                <div class="panel-heading"> <strong class="">Change Password</strong>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="UserChangePasswordHandler.php">
                        
                        <?php DisplayStatusMessage($status_msg) ?>

                        <input type="hidden" id="user_id" name="user_id" 
                               value="<?php echo "$user_id" ?>" >

                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-6">
                                <input type="email" name="email" 
                                    class="form-control" id="email"
                                    value="<?php echo "$email" ?>" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="current_password" class="col-sm-3 control-label">Current Password</label>
                            <div class="col-sm-6">
                                <input type="password" name="current_password" 
                                    class="form-control" id="current_password"
                                    value="" required>
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
                        <div class="form-group">                               
                            <div class="col-sm-offset-3 col-sm-6">
                                <input type="checkbox" value="emailpassword" id="emailpassword" 
                                        name="emailpassword">
                                    <label for="password" class="control-lable">&nbsp; Email New Password
                                    </label>
                                </input>
                            </div>
                        </div> <hr>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" name="button" value="changepassword" 
                                        class="btn btn-primary btn-md">Submit</button>
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