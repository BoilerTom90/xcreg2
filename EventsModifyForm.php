<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');
require_once('includes/adminusercheck.inc.php');
require_once('includes/status_msg.inc.php');
require_once('includes/event_id.inc.php');

$event_id = PHPSession::Instance()->GetSessionVariable('event_id');
$evObj = new EventsTable();
$event = $evObj->Read($event_id);
if (empty($event)) {
    $msg = "Event has been removed from the system!"; 
    $alert_category = "alert-danger";
    header("location: EventsMain.php?status_msg=$msg" . "&alert_category=$alert_category");
    exit;
}

// var_dump($event); exit;
// ["ev_name"]=> string(8) "FDM 2018" 
// ["ev_date"]=> string(10) "2018-10-01" 
// ["ev_reg_status"]=> string(4) "Open" 
// ["ev_contact_email"]=> string(21) "purduetom90@gmail.com" 
// ["ev_contact_phone"]=> string(10) "2243555077" 

$ev_id = $event_id;
$ev_name = $event['ev_name'];
$ev_date = $event['ev_date'];
$ev_reg_status = $event['ev_reg_status'];
$ev_contact_email = $event['ev_contact_email'];
$ev_contact_phone = $event['ev_contact_phone'];

?>

<body>

<?php 
require_once('includes/navbar.inc.php'); 
OutputNavBar("Events");
?>

<br>

<div class="container">
    <div class="row">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-8">
            <a class="btn btn-primary" href="EventsMain.php">Cancel</a>
        </div>
        <div class="col-sm-2">
        </div>
    </div>
</div>
<br>
<div class="container">
    <div class="row">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-8">
            <div class="panel panel-primary">
                <div class="panel-heading"> <strong class="">Manage Event</strong>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="EventsModifyHandler.php">
                    	
                        <input type="hidden" id="ev_id" name="ev_id" 
                    	       value=<?php echo "\"" . $ev_id . "\"" ?> >

                        <div class="form-group">
                            <label for="ev_name" class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" 
                                        id="ev_name" name="ev_name" placeholder="Event Name"
                                        value=<?php echo "\"" . $ev_name . "\"" ?> 
                                        title="Enter Event Name" 
                                        data-toggle="popover" data-trigger="focus" 
                                        data-content="Accepts up to 25 characters."
                                        required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ev_date" class="col-sm-3 control-label">Date</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" 
                                		id="ev_date" name="ev_date" placeholder="Date"
                                		value=<?php echo "$ev_date" ?> 
                    					   title="Pick race date" 
                                    data-trigger="focus">
                            </div>
                        </div>

                        <div class="form-group">
                           <label for="ev_reg_status" class="col-sm-3 control-label">Registration Status</label>
                           <div class="col-sm-9">
                              <select id="ev_reg_status" name="ev_reg_status" class="form-control" required>
                                 <?php OutputRegStatusChoices($ev_reg_status); ?>
                              </select>
                           </div>
                           </div>

                        <div class="form-group">
                            <label for="ev_contact_email" class="col-sm-3 control-label">Contact Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" 
                                		id="ev_contact_email" name="ev_contact_email" placeholder="contact email"
                                		value=<?php echo "$ev_contact_email" ?> 
                    					   title="Pick Event Date" 
                                    data-trigger="focus">     
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ev_contact_phone" class="col-sm-3 control-label">Contact Phone</label>
                            <div class="col-sm-9">
                                <input type="tel" class="form-control" 
                                		id="ev_contact_phone" name="ev_contact_phone" placeholder="contact phone"
                                		value=<?php echo "$ev_contact_phone" ?> 
                    					   title="Enter Contact's Phone" 
                                    data-trigger="focus">     
                            </div>
                        </div>

                        <div class="form-group">
                           <label for="delete" class="col-sm-3 control-label">Delete (Event, Races, Runners)</label>
                           <div class="col-sm-9">
                              <input type="text" class="form-control" maxlength="25"
                                 id="delete" name="delete" 
                                 placeholder="Enter DELETE to delete Event, and Races and Runners for Event"
                                 title="Enter the word DELETE to delete Event, Races, and Runners from System!" 
                                 data-toggle="popover" data-trigger="focus" 
                                 data-content="">
                           </div>
                        </div>

                		<hr/>
                        <div class="form-group last">
                           <div class="col-sm-offset-3 col-sm-3">
                              <button type="submit" name="button" value="modify" class="btn btn-primary btn-md">Modify Event</button>
                           </div>
                           <div class="col-sm-offset-3 col-sm-3">
                              <button type="submit" name="button" value="delete" class="btn btn-danger btn-md ">Delete Event</button>
                           </div>
                        </div>
                    </form>
                </div>
        </div>
        </div>
    </div>
</div>

        <script type="text/javascript">
            $(function () {
                $('.race_date').datetimepicker();
            });
        </script>


<?php 
require_once('includes/footer.inc.php'); 
?>