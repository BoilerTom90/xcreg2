<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');
require_once('includes/adminusercheck.inc.php');
require_once('includes/status_msg.inc.php');
 
$user_id = $_REQUEST['user_id'];
$usersObj = new UsersTable();
$user = $usersObj->Read($user_id);
if (empty($user)) {
    $msg = "User has been removed from the system!"; 
    header("location: UsersMain.php?status_msg=$msg&alert_category=\"alert-danger\"");
    exit;
}

// var_dump($user); exit;
// { ["id"]=> string(1) "1" 
//   ["school_id"]=> string(1) "1" 
//   ["role"]=> string(8) "NonAdmin" 
//   ["status"]=> string(6) "Active" 
//   ["email"]=> string(27) "thomas.hoffman@infinite.com" 
//   ["reset_code"]=> string(1) "0" 
//   ["password"]=> string(60) "$2y$10$cg.rixwejFUdpctd/g.WzOsCbGwKKTpUsef6X3/I7t7Gr5ST0P9QO" }

require_once('includes/navbar.inc.php'); 
OutputNavBar("Users");


$schoolID = $user['school_id'];
$schoolsObj = new SchoolsTable();
$schoolName = $schoolsObj->Read($schoolID)['name'];
$role = $user['role'];
$status = $user['status'];
$email = $user['email'];
$password = "";


?>

<body>

<br/>
<div class="container">
    <div class="row">
        <div class="col-xs-2"></div>
        <div class="col-xs-10">
            <div class="btn-group">
                <a class="btn btn-primary" href="UsersMain.php">Cancel</a>
            </div>
        </div>
    </div>
    <div class="row"></br></div>
</div>
<div class="container">
    <div class="row">
        <div class="col-xs-2">
        </div>
        <div class="col-xs-8 col-md-offsetx-7">
            <div class="panel panel-primary">
                <div class="panel-heading"> <strong class="">Modify User</strong>
                </div>
                <div class="panel-body">
                    <?php DisplayStatusMessage($status_msg); ?>
                    <form class="form-horizontal" role="form" method="post" action="#">
                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-6">
                               <input type="email" class="form-control" 
                                      id="email" name="email" placeholder="Email"
                                      value=<?php echo "$email" ?> 
                                      disabled>
                        </div>
                    </div>
                    </form>
                    <hr/>

                    <!-- 
                      -- Section to allow the school to be changed 
                      -->
                    <form class="form-horizontal" role="form" method="post" action="UsersModifyHandler.php">
                        <input type="hidden" id="user_id" name="user_id" 
                               value=<?php echo "$user_id" ?> >

                        <div class="form-group">
                            <label for="school_id" class="col-sm-3 control-label">School</label>
                            <div class="col-sm-6">
                                <select id="school_id" name="school_id" class="form-control" required>
                                    <?php OutputSchoolChoices($schoolID, 1); ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" name="button" value="setschool" 
                                        class="btn btn-primary btn-md">Submit</button>
                            </div>
                        </div>
                    </form>
                    <hr/>

                    <!-- 
                      -- Section to allow the Role to be changed 
                      -->  
                    <form class="form-horizontal" role="form" method="post" action="UsersModifyHandler.php">
                        <input type="hidden" id="user_id" name="user_id" 
                               value=<?php echo "\"" . $user_id . "\"" ?> >

                        <div class="form-group">
                            <label for="role" class="col-sm-3 control-label">Role</label>
                            <div class="col-sm-6">
                                <select id="role" name="role" class="form-control" required>
                                    <?php OutputRoleChoices($role); ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" name="button" value="setrole" 
                                        class="btn btn-primary btn-md">Submit</button>
                            </div>
                        </div>
                    </form>
                    <hr/>

                     <!-- 
                      -- Section to allow the Status to be changed 
                      --> 
                    <form class="form-horizontal" role="form" method="post" action="UsersModifyHandler.php">
                        <input type="hidden" id="user_id" name="user_id" 
                               value=<?php echo "$user_id" ?> >

                        <div class="form-group">
                            <label for="status" class="col-sm-3 control-label">Status</label>
                            <div class="col-sm-6">
                                <select id="status" name="status" class="form-control" required>
                                    <?php OutputUserStatusChoices($status); ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" name="button" value="setstatus" 
                                        class="btn btn-primary btn-md">Submit</button>
                            </div>
                        </div>
                    </form>
                    <hr/>

                    <form class="form-horizontal" role="form" method="post" action="UsersModifyHandler.php">
                        <input type="hidden" id="user_id" name="user_id" 
                               value=<?php echo "$user_id" ?> >

                        <div class="form-group">
                            <label for="password" class="col-sm-3 control-label">Password</label>
                            <div class="col-sm-6">
                                <input type="password" name="password" 
                                    class="form-control" id="password"
                                    value="" required>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" name="button" value="setpassword" 
                                        class="btn btn-primary btn-md">Submit</button>
                            </div></br>
                        </div>    
                        <div class="form-group">                               
                            <div class="col-sm-offset-3 col-sm-6">
                                <input type="checkbox" value="emailpassword" id="emailpassword" 
                                        name="emailpassword">
                                    <label for="emailpassword" class="control-lable">&nbsp; Email New Password
                                    </label>
                                </input>
                            </div>
                        </div>
                    </form>
                    <hr/>

                    <form class="form-horizontal" role="form" method="post" action="UsersMain.php">
                        <div class="col-sm-offset-5 col-svm-3">
                            <button type="submit" name="button" value="whocares" 
                                        class="btn btn-primary btn-md">Done</button>
                        </div>
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