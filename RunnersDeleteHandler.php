<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('classes/DBAccess.php');


// the expected information from the form is in the $_REQUEST variable
// 
//var_dump($_REQUEST); exit;

if (!isset($_REQUEST) || !isset($_REQUEST['runner_id']) || !isset($_REQUEST['button']) || ($_REQUEST['button'] != 'delete')) {
   $sts = "something wonky... delete runner denied";
   header("location: RunnersMain.php?status_msg=$sts");
   exit;
}

$runner_id  = $_REQUEST['runner_id'];
$runnersObj = new RunnersTable();
$num_rows_affected = $runnersObj->Delete($runner_id);
if ($num_rows_affected > 0) {
   $sts = "Runner successfully deleted.";
   $alt = "alert-success";
} else { 
   $sts = "Runner not deleted: " . $runnersObj->LastError();
   $alt = "alert-danger";
}
	
header("location: RunnersMain.php?status_msg=$sts&alert_category=$alt");
exit;

?>