<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('classes/DBAccess.php');
require_once('includes/adminusercheck.inc.php');

// the expected information from the form is in the $_REQUEST variable
// 
// var_dump($_REQUEST); exit;
$school_id = $_REQUEST['school_id'];

$schoolsObj = new SchoolsTable();
$result = $schoolsObj->Delete($school_id);
if ($result) {
   $status_msg = "School Deleted!";
   $alert = "alert-success";
} else { 
   $status_msg  = "School not deleted: " . $schoolsObj->LastError();
   $alert = "alert-danger";
}
header("location: SchoolsMain.php?status_msg=$status_msg&alert_category=$alert");
exit;

?>