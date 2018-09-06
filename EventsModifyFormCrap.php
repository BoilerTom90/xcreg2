<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');
require_once('includes/adminusercheck.inc.php');
require_once('includes/status_msg.inc.php');

$event_id = $_REQUEST['event_id'];
$event_info = ReadEvent($event_id, $last_error);
if (empty($event_info)) {
    $msg = "Event has been removed from the system!"; 
    header("location: index.php?status_msg=$msg");
    exit;
}



require_once('includes/navbar.inc.php'); 
OutputNavBar("Events");



$event_name = $event_info['event_name'];
$event_db = $event_info['event_db'];
$race_date = $event_info['race_date'];
$registration_open = $event_info['registration_open'];
$collect_shirt_info = $event_info['collect_shirt_info'];


?>



<br/>
<div class="container">
    <div class="row">
        <div class="col-xs-2"></div>
        <div class="col-xs-10">
            <div class="btn-group">
                <a class="btn btn-primary" href="EventsMain.php">Cancel</a>
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
                <div class="panel-heading"> <strong class="">Modify Event</strong>
                </div>
                <div class="panel-body">
                    <?php DisplayStatusMessage($status_msg); ?>
                    <form class="form-horizontal" role="form" method="post" action="#">
                    <div class="form-group">
                        <label for="event_name" class="col-sm-3 control-label">Event Name</label>
                        <div class="col-sm-6">
                               <input type="text" class="form-control" 
                                      id="event_name" name="event_name" placeholder="Event Name"
                                      maxlength="25"
                                      value=<?php echo "$event_name" ?> 
                                      >
                        </div>
                    </div>
                    </form>
                    <hr/>

                    <form class="form-horizontal" role="form" method="post" action="UsersModifyHandler.php">
                        <input type="hidden" id="user_id" name="user_id" 
                               value=<?php echo "$user_id" ?> >

                        <div class="form-group">
                            <label for="school_id" class="col-sm-3 control-label">School</label>
                            <div class="col-sm-6">
                                <select id="school_id" name="school_id" class="form-control" required>
                                    <?php OutputSchoolChoices($event_db, $school_id); ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" name="button" value="setschool" 
                                        class="btn btn-primary btn-md">Submit</button>
                            </div>
                        </div>
                    </form>
                    <hr/>

  
                    <form class="form-horizontal" role="form" method="post" action="UsersModifyHandler.php">
                        <input type="hidden" id="user_id" name="user_id" 
                               value=<?php echo "\"" . $user_id . "\"" ?> >

                        <div class="form-group">
                            <label for="role" class="col-sm-3 control-label">Role</label>
                            <div class="col-sm-6">
                                <select id="role" name="role" class="form-control" required>
                                    <?php OutputRoleChoices($local_role); ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" name="button" value="setrole" 
                                        class="btn btn-primary btn-md">Submit</button>
                            </div>
                        </div>
                    </form>
                    <hr/>

                    <form class="form-horizontal" role="form" method="post" action="UsersModifyHandler.php">
                        <input type="hidden" id="user_id" name="user_id" 
                               value=<?php echo "$user_id" ?> >

                        <div class="form-group">
                            <label for="status" class="col-sm-3 control-label">Status</label>
                            <div class="col-sm-6">
                                <select id="status" name="status" class="form-control" required>
                                    <?php OutputStatusChoices($status); ?>
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
                                    <label for="password" class="control-lable">&nbsp; Email New Password
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