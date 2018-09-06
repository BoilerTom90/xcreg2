<?php 
 
require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('classes/DBAccess.php');
require_once('includes/adminusercheck.inc.php');
require_once('includes/status_msg.inc.php');

//var_dump($_REQUEST);exit;
/* $_REQUEST { 
   ["ev_name"]=> string(12) "Cobra Invite" 
   ["ev_date"]=> string(10) "2019-10-01" 
   ["reg_status"]=> string(4) "Open" 
   ["ev_contact_email"]=> string(20) "purduetom90@gmailcom" 
   ["ev_contact_phone"]=> string(10) "2243555077" 
   ["button"]=> string(3) "add" } 
*/
 
$ev_name = trim(strtoupper($_REQUEST['ev_name']));
$ev_date = trim($_REQUEST['ev_date']);
$reg_status = $_REQUEST['reg_status'];
$ev_contact_email = trim(strtolower($_REQUEST['ev_contact_email']));
$ev_contact_phone = trim($_REQUEST['ev_contact_phone']);


// If the button pressed was the add Button, 

if ($_REQUEST['button'] == "add")
{
   $evObj = new EventsTable();
   $nextID = $evObj->MaxID() + 1;
   $result = $evObj->Insert($nextID, $ev_name, $ev_date, $reg_status, $ev_contact_email, $ev_contact_phone);
	if ($result >= 0) {
      $status_msg = "Event added to DB";
      $alert_category = "alert-success";
	} else { 
      $status_msg = "Event not added. Error: " . $evObj->LastError();
      $alert_category = "alert-danger";
	}
	header("location: EventsMain.php?status_msg=$status_msg" . "&alert_category=$alert_category");
	exit; 
}

$status_msg = "Internal Error. No action taken!";
header("location: EventsMain.php?status_msg=$status_msg");
exit;
?>