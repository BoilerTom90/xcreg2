<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');
require_once('includes/adminusercheck.inc.php');
require_once('includes/status_msg.inc.php');


// adding useless comment to test git

?>

<body>
<?php 
require_once('includes/navbar.inc.php'); 
OutputNavBar("Users");
?>


<!-- Display a table with all of the users in them. 
     Only admin users see this panel
-->
<br/>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="btn-group">
                <a class="btn btn-primary" href="UsersAddForm.php">Add User</a>
                <a class="btn btn-primary"href="UsersPrintHandler.php">Print Emails</a>
            </div>
        </div>
    </div>
    <div class="row"></br></div>
</div>

<div class="container">
<div class="panel panel-primary">
<div class="panel-heading">User Listing</div>
<div class="panel-body">
    <div class="row">
        <div class="col-xs-12">
            <?php DisplayStatusMessage($status_msg); ?>
            <div class="table-responsive">
                <table class="table table-condensed table-bordered table-hover set-bg" id="sortable-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>School</th>
                            <th>Password</th>
                            <th>Login Date (#times)</th>
                            <th>Reset Code </th>
                            <th>Role</th>   <!-- admin or user -->
                            <th>Account</th> <!-- open or closed -->
                            <th>Change</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $last_error;
                            $schoolObj = new SchoolsTable();
                            $usersObj = new UsersTable();
                            $users = $usersObj->ReadAll();
                            foreach ($users as $u) {
                                $userID = $u['id'];
                                $schoolID = $u['school_id'];
                                $schoolName = $schoolObj->Read($schoolID)['name'];
                                $role = $u['role'];
                                $status = $u['status'];
                                $email = $u['email'];
                                $resetCode = $u['reset_code'];
                                $num_logins = $u['num_logins'];
                                $login_date_str = "never";
                                if ($num_logins) {
                                   $login_date_str = $u['login_date'] . " (" . $num_logins . ")";
                                }
                                $expiresInString = "";
                                if ($resetCode != 0) {
                                   $expires = $resetCode - time();
                                   if ($expires <= 0) {
                                      $expiresInString = "Expired!";
                                   } else {
                                      $expiresInString = $expires . "s left";
                                   }
                                }
                                $password = $u['password']; 
                                
                                if (strlen($password)) {
                                    $password = "** set **";
                                } else {
                                    $password = "not set";
                                }
                                echo "<tr>";
                                echo "<td>" . $userID . "</td>";
                                echo "<td>" . $email . "</td>";
                                echo "<td>" . $schoolName . "</td>";
                                echo "<td>" . $password . "</td>";
                                echo "<td>" . $login_date_str . "</td>";
                                echo "<td>" . $resetCode . "<br>" . $expiresInString . "</td>";
                                echo "<td>" . $role . "</td>";
                                echo "<td>" . $status . "</td>";
                                
                                echo "<td>" . "<a class=\"btn btn-primary btn-xs\" href=\"UsersModifyForm.php?user_id=$userID\">Change</a>" . "</td>";
                                echo "<td>" . "<a class=\"btn btn-primary btn-xs\" href=\"UsersDeleteForm.php?user_id=$userID\">Delete</a>" . "</td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> <!-- panel-body -->
</div> <!-- panel default -->
</div>

<?php 
require_once('includes/footer.inc.php'); 
?>
