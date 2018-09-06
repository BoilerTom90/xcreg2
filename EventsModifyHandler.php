<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('classes/DBAccess.php');
require_once('includes/adminusercheck.inc.php');
require_once('includes/status_msg.inc.php');

// the expected information from the form is in the $_REQUEST variable
//  ["ev_id"]=> string(1) "2" 
//  ["ev_name"]=> string(14) "ST. PETER OPEN" 
//  ["ev_date"]=> string(10) "2018-10-10" 
//  ["ev_reg_status"]=> string(4) "Open" 
//  ["ev_contact_email"]=> string(25) "purduetom90@gmail.com.com" 
//  ["ev_contact_phone"]=> string(3) "911" 
//  ["button"]=> string(6) "modify"
// var_dump($_REQUEST); exit;

$ev_id = $_REQUEST['ev_id'];
$ev_name = trim(strtoupper($_REQUEST['ev_name']));
$ev_date = $_REQUEST['ev_date'];
$ev_reg_status = $_REQUEST['ev_reg_status'];
$ev_contact_email = trim($_REQUEST['ev_contact_email']);
$ev_contact_phone = trim($_REQUEST['ev_contact_phone']);
$button = $_REQUEST['button'];
$delete_text = null;
if (isset($_REQUEST['delete'])) {
   $delete_text = $_REQUEST['delete'];
}

if ($button === "modify") {

   $evObj = new EventsTable();
   $num_rows_affected = $evObj->Modify($ev_id, $ev_name, $ev_date, $ev_reg_status, $ev_contact_email, $ev_contact_phone);
   if ($num_rows_affected >= 0) {
      $status_msg = "Event successfully updated.";
      $alert_category = "alert-success";
   } else { 
      $status_msg = "Event NOT updated. Error: " . $evObj->LastError();
      $alert_category = "alert-danger";
   }
} else if ($button == "delete") {
   if ($delete_text !== "DELETE") {
      $status_msg = "Event not deleted. Incorrect text entered into field";
      $alert_category = "alert-danger";
   } else {
      // Delete all runners for event
      $runnersObj = new RunnersTable();
      $result = $runnersObj->DeleteByEvent($ev_id);

      // delete all races for event
      $racesObj = new RacesTable();
      $result = $racesObj->DeleteByEvent($ev_id);

      // delete event
      $evObj = new EventsTable();
      $result = $evObj->Delete($ev_id);
      
      $status_msg = "All Runners, Races and Event deleted for Event";
      $alert_category = "alert-success";
   }
} else {
   $status_msg = "Invalid command $button requested!";
   $alert_category = "alert-danger";
}
	
header("location: EventsMain.php?status_msg=$status_msg" . "&alert_category=$alert_category");
exit;

?>