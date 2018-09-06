<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('classes/DBAccess.php');
require_once('includes/event_id.inc.php');

// the expected information from the form is in the $_REQUEST variable
// 
//var_dump($_REQUEST); exit;

$event_id = PHPSession::Instance()->GetSessionVariable('event_id'); 

$runner_id  = $_REQUEST['runner_id'];
$school_id  = $_REQUEST['school_id'];
$first_name = trim(strtoupper($_REQUEST['first_name']));
$last_name  = trim(strtoupper($_REQUEST['last_name']));
$grade      = $_REQUEST['grade'];
$sex        = trim(strtoupper($_REQUEST['sex']));
$race_id    = $_REQUEST['race_id'];
// var_dump($_REQUEST); exit;

// Make sure the school name only has the allowed characters:
// A-Z, a-z, 0-9, ., -, space
$pattern = "#^[A-Za-z0-9 .\-]+$#";
$result = preg_match($pattern, $first_name);
if (!$result) {
	$status_msg = "<span style=\"color:red\">First Name contains invalid characters.<br>Only alphanumeric, space, period, and - are allowed.</span>";
	header("location: RunnersMain.php?status_msg=$status_msg");
	exit;
}

$result = preg_match($pattern, $last_name);
if (!$result) {
	$status_msg = "<span style=\"color:red\">Last Name contains invalid characters.<br>Only alphanumeric, space, period, and - are allowed.</span>";
	header("location: RunnersMain.php?status_msg=$status_msg");	
	exit;
}

// If the button pressed was the add Button, 
// - Attempt to add event_id, school_name to the database. 
// - Set the error/status message appropriately
// - redirect the user back to SchoolsMain.php
if ($_REQUEST['button'] == "modify")
{
   $runnersObj = new RunnersTable();
   $rows_affected = $runnersObj->ModifyAll($runner_id, $school_id, $event_id, $race_id, $sex,
                                 $grade, $first_name, $last_name);
	if ($rows_affected > 0) {
		$status_msg = "<span style=\"color:blue\">Runner successfully updated.</span>";
	} else { 
      $last_error = $runnersObj->LastError();
		$status_msg = "<span style=\"color:red\">Runner NOT updated<br>$last_error.</span>";
	}
	
	header("location: RunnersMain.php?status_msg=$status_msg");
	exit;
}

$status_msg = "<span style=\"color:red\">Internal Error. No action taken!";
header("location: RunnersMain.php?status_msg=$status_msg");
exit;
?>