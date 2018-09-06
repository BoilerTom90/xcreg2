<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');
require_once('includes/adminusercheck.inc.php');
require_once('includes/status_msg.inc.php');
require_once('includes/event_id.inc.php');


if (!isset($_REQUEST) || !isset($_REQUEST['race_id']) ||
      !isset($_REQUEST['distance']) || !isset($_REQUEST['description'])) {
   $sts = "Error! Invalid navigation to page.";
   header("location: RacesMainForm.php?status_msg=$sts&alert_category=alert-danger");
   exit;
}

$event_id = PHPSession::Instance()->GetSessionVariable('event_id');
$race_id = $_REQUEST['race_id'];
$distance = $_REQUEST['distance'];
$description = strtoupper(trim($_REQUEST['description']));
$raceObj = new RacesTable();
$result = $raceObj->Modify($race_id, $event_id, $distance, $description);
if ($result < 1) {
   $status_msg = "Race Not Modified: " . $raceObj->LastError();
   header("location: RacesMainForm.php?status_msg=$status_msg" . "&alert_category=alert-danger");
   exit;
}

$status_msg = "Race Details Modified!";
header("location: RacesMainForm.php?status_msg=$status_msg");
exit;

?>
