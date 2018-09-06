<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');
require_once('includes/adminusercheck.inc.php');
require_once('includes/status_msg.inc.php');
require_once('includes/event_id.inc.php');



$event_id = PHPSession::Instance()->GetSessionVariable('event_id');
$distance = $_REQUEST['distance'];
$description = strtoupper(trim($_REQUEST['description']));
$raceObj = new RacesTable();
$nextRaceID = $raceObj->MaxID() + 1;

$result = $raceObj->Insert($nextRaceID, $event_id, $distance, $description);
if ($result < 1) {
   $status_msg = "Error Adding Race to syste: " . $raceObj->LastError();
   header("location: RacesMainForm.php?status_msg=$status_msg" . "&alert_category=alert-danger");
   exit;
}

$status_msg = "Race Added!";
header("location: RacesMainForm.php?status_msg=$status_msg");
exit;


?>
