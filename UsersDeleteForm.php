<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');
require_once('includes/adminusercheck.inc.php');
require_once('includes/status_msg.inc.php');


$user_id = $_REQUEST['user_id'];
$usersObj = new UsersTable();
$user = $usersObj->Read($user_id);
if (empty($user)) {
    $status_msg = "User not deleted: $usersObj->LastError()"; 
    header("location: UsersMain.php?status_msg=$status_msg&alert_category=\"alert-danger\"");
    exit;
}
$schoolObj = new SchoolsTable();

$school_id = $user['school_id'];
$school_name = $schoolObj->Read($school_id)['school_name']; 
$role = $user['role'];
$status = $user['status'];
$email = $user['email'];
$reset_code = $user['reset_code'];
$password = $user['password'];


?>

<?php 
require_once('includes/navbar.inc.php'); 
OutputNavBar("Users");
?>


<br/>
<div class="container">
    <div class="row">
        <div class="col-xs-3"></div>
        <div class="col-xs-6">
            <div class="btn-group">
                <a class="btn btn-primary" href="UsersMain.php">Cancel</a>
            </div>
        </div>
    </div>
    <div class="row"></br></div>
</div>
<div class="container">
    <div class="row">
        <div class="col-xs-3">
        </div>
        <div class="col-xs-6 col-md-offsetx-7">
            <div class="panel panel-primary">
                <div class="panel-heading"> <strong class="">Confirm Delete User</strong>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="UsersDeleteHandler.php">            
                        <input type="hidden" id="user_id" name="user_id" 
                               value=<?php echo "\"" . $user_id . "\"" ?> >

                        <div class="form-group">
                            <label for="first_name" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" 
                                        id="email" name="email" placeholder="Email"
                                        value=<?php echo "\"" . $email . "\"" ?> 
                                        readonly=readonly>
                            </div>
                        </div>

                        <hr/>
                        <div class="form-group last">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" name="button" value="delete" class="btn btn-primary btn-md">Delete User</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>






<?php 
require_once('includes/footer.inc.php'); 
?>