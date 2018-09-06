<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('classes/database.php');

// the expected information from the form is in the $_REQUEST variable
// 
// var_dump($_REQUEST); exit;

$event_db = PHPSession::Instance()->GetSessionVariable('event_db'); 

if (!isset($_REQUEST) || 
	!isset($_REQUEST['school_id']) ||
	!isset($_REQUEST['youth_medium']) ||
	!isset($_REQUEST['youth_large']) ||
	!isset($_REQUEST['adult_small']) ||
	!isset($_REQUEST['adult_medium']) ||
	!isset($_REQUEST['adult_large']) ||
	!isset($_REQUEST['adult_xlarge']) ||
	!isset($_REQUEST['adult_xxlarge']))
{
	$status_msg = "Internal Error!";
	header("location: ShirtsMain.php?status_msg=$status_msg");
	exit;
}

$school_id     = $_REQUEST['school_id'];
$youth_medium  = $_REQUEST['youth_medium'];
$youth_large   = $_REQUEST['youth_large'];
$adult_small   = $_REQUEST['adult_small'];
$adult_medium  = $_REQUEST['adult_medium'];
$adult_large   = $_REQUEST['adult_large'];
$adult_xlarge  = $_REQUEST['adult_xlarge'];
$adult_xxlarge = $_REQUEST['adult_xxlarge'];


$last_error = "";
$num_rows_affected = UpdateShirtsBySchoolId($event_db, $school_id, $youth_medium, $youth_large,
            								$adult_small, $adult_medium, $adult_large, $adult_xlarge, 
            								$adult_xxlarge, $last_error);
if ($num_rows_affected == 1) {
		$status_msg = "<span style=\"color:blue\">School Shirt Order successfully updated.</span>";
} else { 
		$status_msg = "<span style=\"color:red\">School Shirt Order NOT updated<br>$last_error.</span>";
}
header("location: ShirtsModifyForm.php?school_id=$school_id&status_msg=$status_msg");
exit;	
?>