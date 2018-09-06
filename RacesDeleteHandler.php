<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');
require_once('includes/adminusercheck.inc.php');
require_once('includes/status_msg.inc.php');



// make sure the school_id is set
if (!isset($_REQUEST) || !isset($_REQUEST['race_id']) || !isset($_REQUEST['event_id']))
{
    $status_msg = "Internal Error. Unable to process Delete Race Request!";
    header("location: index.php?status_msg=$status_msg" . "&alert_category=alert-danger");
    exit;
}

$eventID = $_REQUEST['event_id'];
$raceID = $_REQUEST['race_id'];
$raceObj = new RacesTable();
$result = $raceObj->Delete($raceID);
if ($result < 1) {
   $status_msg = "Error Deleting Race: " . $raceObj->LastError();
   header("location: RacesMainForm.php?event_id=$eventID&status_msg=$status_msg" . "&alert_category=alert-danger");
   exit;
}

$status_msg = "Race Deleted!";
header("location: RacesMainForm.php?event_id=$eventID&status_msg=$status_msg");
exit;


?>
