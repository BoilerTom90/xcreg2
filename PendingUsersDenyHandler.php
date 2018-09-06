<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');
require_once('includes/adminusercheck.inc.php');
require_once('includes/status_msg.inc.php');
require_once('sendmail.php');

//var_dump($_REQUEST); exit;

// make sure the school_id is set
if (!isset($_REQUEST) || !isset($_REQUEST['pending_user_id']))
{
    $status_msg = "Internal Error. Unable to process Pending User Request!";
    header("location: PendingUsersForm.php?status_msg=$status_msg" . "&alert_category=alert-danger");
    exit;
}

$email = $_REQUEST['email'];
$denyReason = $_REQUEST['deny_reason'];
$pendingUserId = $_REQUEST['pending_user_id'];
$puObj = new PendingUsersTable();
$puRec = $puObj->Read($pendingUserId);
if (empty($puRec)) {
   $status_msg = "Unable to read record from Pending Users Table for ID: " . $pendingUserId;
   header("location: PendingUsersForm.php?status_msg=$status_msg" . "&alert_category=alert-danger");
   exit;
}

// Delete the user from the database!
$retVal = $puObj->Delete($pendingUserId);
if ($retVal != 1) {
   $status_msg = "Unable to delete Pending User from database for: " . $email;
   header("location: PendingUsersForm.php?status_msg=$status_msg" . "&alert_category=alert-danger");
   exit;
}

// Email the user to let them know their request was denied:
$denyReason = "Your account request was denied for the following reason(s): " . $denyReason;
SendMail($email, "XCReg: Your Account Request was Denied", $denyReason);

$status_msg = "Pending User Deny Processed Successfully!";
header("location: PendingUsersForm.php?status_msg=$status_msg");
exit;


?>
