<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');
require_once('includes/adminusercheck.inc.php');
require_once('includes/status_msg.inc.php');



// make sure the school_id is set
if (!isset($_REQUEST) || !isset($_REQUEST['pending_user_id']))
{
    $status_msg = "Internal Error. Unable to process Pending User Request!";
    header("location: PendingUsersForm.php?status_msg=$status_msg" . "&alert_category=alert-danger");
    exit;
}

$pendingUserId = $_REQUEST['pending_user_id'];
$puObj = new PendingUsersTable();
$puRec = $puObj->Read($pendingUserId);
if (empty($puRec)) {
   $status_msg = "Unable to read record from Pending Users Table for ID: " . $pendingUserId;
   header("location: PendingUsersForm.php?status_msg=$status_msg" . "&alert_category=alert-danger");
   exit;
}

$reqType = $_REQUEST['req_type']; 
if ($reqType === "Deny") {
   $panelTitle = "Deny User Request";
   $postHandler = "PendingUsersDenyHandler.php";
} else {
   $panelTitle = "Grant User Request";
   $postHandler = "PendingUsersGrantHandler.php";
}
$email = $puRec['email'];
$school = $puRec['school_name'];

// function OutputSchoolChoices()
// {
//    $schoolObj = new SchoolsTable();
//    $schools = $schoolObj->ReadAll();

//    foreach ($schools as $s)
//    {
//       $school_id = $s['id'];
//       $school_name = $s['name'];
//       echo "<option name=\"school_id\" value=\"" . $school_id . "\">" . $school_name . "</option>";
//    }
// }


?>


<?php 
require_once('includes/navbar.inc.php'); 
OutputNavBar("PendingUsers");
?>


<br>
<div class="container">
    <div class="row">
        <div class="col-xs-3"></div>
        <div class="col-xs-6 col-md-offsetx-7">
            <div class="panel panel-primary">
                <div class="panel-heading"> 
                  <strong><?php echo $panelTitle; ?></strong>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="<?php echo $postHandler; ?>" >

                        <input type="hidden" id="pending_user_id" name="pending_user_id" 
                    	         value=<?php echo $pendingUserId; ?> >

                        <div class="form-group">
                            <label for="email" class="col-sm-4 control-label">Email</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" 
                                		id="email" name="email" placeholder="email"
                                		value=<?php echo $email ?> 
                    					   readonly=readonly>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="school" class="col-sm-4 control-label">School (from user)</label>
                            <div class="col-sm-8">
								      <input type="text" class="form-control"
										   id="school" name="school"
										   value=<?php echo "\"$school\""; ?> 
                    					readonly=readonly>
                            </div>
                        </div>

                        <?php if ($reqType == "Deny") { ?>

                           <div class="form-group">
                              <label for="deny_reason" class="col-sm-4 control-label">Deny Reason</label>
                              <div class="col-sm-8">
                                 <textarea class="form-control" rows="4" cols="50" style="resize:none"
                                    id="deny_reason" name="deny_reason" placeholder="Enter Deny Reason" 
                                    autofocus required></textarea>
                              </div>
                           </div>
                           
                        <?php } else { ?>

                           <div class="form-group">
                              <label for="school_id" class="col-sm-4 control-label">School (official)</label>
                              <div class="col-sm-8">
                                 <select id="role" name="school_id" class="form-control" required>
                                       <?php OutputSchoolChoices(); ?>
                                 </select>
                              </div>
                           </div>

                        <div class="form-group">
                            <label for="password" class="col-sm-4 control-label">Password</label>
                            <div class="col-sm-8">
								      <input type="text" class="form-control"
                                 id="password" name="password"
                                 value="coach@123"
										   placeholder="password" 
                    					autofocus required>
                            </div>
                        </div>
                           
                        <?php } ?>

                		   <div class="form-group">
                           <div class="col-sm-offset-4 col-sm-8">
                              <button type="submit" name="Submit" class="btn btn-primary btn-md">Submit</button>
                           </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xs-3"></div>
    </div>
</div>

<?php 
require_once('includes/footer.inc.php'); 
?>