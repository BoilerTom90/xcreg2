<?php 
 
require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('classes/DBAccess.php');
require_once('includes/adminusercheck.inc.php');
require_once('includes/status_msg.inc.php');


// the expected information from the form is in the $_REQUEST variable
// 
// var_dump($_REQUEST); 

$school_name = trim(strtoupper($_REQUEST['school_name']));

// Make sure the school name only has the allowed characters:
// A-Z, a-z, 0-9, ., -, space
$pattern = "#^[A-Za-z0-9 .,'\-]+$#";
$result = preg_match($pattern, $school_name);
if (!$result) {
	$status_msg = "Name contains invalid characters. Only alphanumeric, space, period, comma, and - are allowed";
	header("location: SchoolsMain.php?status_msg=$status_msg");
	exit;
}

// If the button pressed was the add Button, 
// - Attempt to add event_id, school_name to the database. 
// - Set the error/status message appropriately
// - redirect the user back to SchoolsMain.php
if ($_REQUEST['button'] == "add") {
   $schoolsObj = new SchoolsTable();
   $nextID = $schoolsObj->MaxID() + 1;
	$protected_school_name = htmlentities($school_name, ENT_QUOTES);
	$result = $schoolsObj->Insert($nextID, $protected_school_name);
	if ($result >= 0) {
      $status_msg = "School added to DB to: $protected_school_name";
      $alert = "alert-success";
	} else { 
      $status_msg = "School $protected_school_name NOT added to DB: " . $schoolsObj->LastError();
      $alert = "alert-danger";
	}
	header("location: SchoolsMain.php?status_msg=$status_msg&alert_category=$alert");
	exit; 
}

$status_msg = "Internal Error. No action taken!";
header("location: SchoolsMain.php?status_msg=$status_msg");
exit;
?>