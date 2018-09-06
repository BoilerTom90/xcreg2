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
    $status_msg = "Internal Error. Unable to process Grant Pending User Request!";
    header("location: PendingUsersForm.php?status_msg=$status_msg" . "&alert_category='alert-danger'");
    exit;
}

$email = $_REQUEST['email'];
$pendingUserId = $_REQUEST['pending_user_id'];
$schoolId = $_REQUEST['school_id'];
$plainTextPassword = $_REQUEST['password'];
$hashedPassword = password_hash($plainTextPassword, PASSWORD_DEFAULT);

$usersObj = new UsersTable();
$nextId = $usersObj->MaxID() + 1;
$result = $usersObj->Insert($nextId, $schoolId, UserRoles::NonAdmin, UserStatus::Active, $email, 0, $hashedPassword);
if ($result != 1) {
   $status_msg = "Internal Error. Unable to Add user to Users Table!";
   header("location: PendingUsersForm.php?status_msg=$status_msg" . "&alert_category='alert-danger'");
   exit;
}

// Delete the user from the Pending User's database!
$puObj = new PendingUsersTable();
$retVal = $puObj->Delete($pendingUserId);
if ($retVal != 1) {
   $status_msg = "Unable to delete Pending User from database for: " . $email;
   header("location: PendingUsersForm.php?status_msg=$status_msg" . "&alert_category='alert-danger'");
   exit;
}

// Email the user to let them know their request was denied:
$denyReason = "Your account request was accepted and your account is available. Your initial password is: " . $plainTextPassword;
SendMail($email, "XCReg: Your Account is Available for login", $denyReason);

$status_msg = "Pending User Grant Processed Successfully!";
header("location: PendingUsersForm.php?status_msg=$status_msg");
exit;


?>
