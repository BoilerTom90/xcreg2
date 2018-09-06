<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');
require_once('includes/adminusercheck.inc.php');
require_once('includes/status_msg.inc.php');


?>

<body>
<?php 
require_once('includes/navbar.inc.php'); 
OutputNavBar("PendingUsers");
?>


<!-- Display a table with all of the Pending Users in them. 
     Only admin users see this panel
-->
<br/>
<!-- <div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="btn-group">
                <a class="btn btn-primary" href="UsersAddForm.php">Add User</a>
                <a class="btn btn-primary"href="UsersPrintHandler.php">Print Emails</a>
            </div>
        </div>
    </div>
    <div class="row"></br></div>
</div> -->

<div class="container">
<div class="panel panel-primary">
<div class="panel-heading">Pending User Listing</div>
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
                            <th>School (From User)</th>
                            <th>Request Date</th>
                            <th>Grant</th>
                            <th>Deny</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $last_error;
                            $p = new PendingUsersTable();
                            $pendingUsers = $p->ReadAll(); 
                            if (empty($pendingUsers)) {
                               echo "<tr>";
                               echo "<td colspan=8>No Pending Users</td>";
                               echo "</tr>";
                            } else {
                              foreach ($pendingUsers as $pendingUser) {
                                 $id = $pendingUser['id'];
                                 $email = $pendingUser['email'];
                                 $school = $pendingUser['school_name'];
                                 $requestDate = $pendingUser['req_date'];

                                 echo "<tr>";
                                 echo "<td>" . $id . "</td>";
                                 echo "<td>" . $email . "</td>";
                                 echo "<td>" . $school . "</td>";
                                 echo "<td>" . $requestDate . "</td>";

                                 echo "<td>" . "<a class=\"btn btn-primary btn-xs\" href=\"PendingUsersHandler.php?pending_user_id=$id&req_type=Grant\">Grant</a>" . "</td>";
                                 echo "<td>" . "<a class=\"btn btn-primary btn-xs\" href=\"PendingUsersHandler.php?pending_user_id=$id&req_type=Deny\">Deny</a>" . "</td>";
                                 echo "</tr>";
                              }
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
