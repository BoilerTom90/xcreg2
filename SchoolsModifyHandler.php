<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('classes/DBAccess.php');
require_once('includes/adminusercheck.inc.php');

// the expected information from the form is in the $_REQUEST variable
// 
// var_dump($_REQUEST); 

// make sure the school_id is set
if (!isset($_REQUEST) || !isset($_REQUEST['school_id']) || !isset($_REQUEST['school_name']))
{
    $status_msg = "Internal Error. Unable to  modify school!";
    header("location: SchoolsMain.php?status_msg=$status_msg");
    exit;
}

$school_id = $_REQUEST['school_id']; 
$school_name = $_REQUEST['school_name']; 

// Make sure the school name only has the allowed characters:
// A-Z, a-z, 0-9, ., -, space
$pattern = "#^[A-Za-z0-9 .,'\-]+$#";
$result = preg_match($pattern, $school_name);
if (!$result) {
	$status_msg = "School Name contains invalid characters. Only alphanumeric, space, period, comma, ', and - are allowed";
	header("location: SchoolsMain.php?status_msg=$status_msg&alert_category=alert-danger");
	exit;
}

$schoolsObj = new SchoolsTable();

// $protected_school_name = htmlentities($school_name, ENT_QUOTES);
$num_rows_affected = $schoolsObj->Replace($school_id, $school_name);
if ($num_rows_affected >= 0) {
   $status_msg = "School Name Updated.";
} else if ($num_rows_affected == 0) {
   $status_msg = "School Name was not changed!";
} else { 
   $status_msg  = "School Name Updating failed: " . $schoolsObj->LastError();
}
header("location: SchoolsMain.php?status_msg=$status_msg");
exit;

?>