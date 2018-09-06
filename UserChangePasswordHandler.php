<?php 

require_once('includes/checkLogin.inc.php');
require_once('classes/DBAccess.php');
require_once('classes/passwordLib.php');
require_once('sendmail.php');
require_once('includes/status_msg.inc.php');

//   ["user_id"]=> string(1) "1" 
//   ["current_password"]=> string(4) "0810" 
//   ["new_password"]=> string(6) "081096" 
//   ["new_password_confirm"]=> string(6) "081096" 
//   ["emailpassword"]=> string(13) "emailpassword" 
//   ["button"]=> string(14) "changepassword" }
// var_dump($_REQUEST); exit;

// protect against direct calling without passing in a request variable
if (!isset($_REQUEST) || !isset($_REQUEST['user_id'])) {
   header("location: Logout.php");
	exit;
}

$user_id = $_REQUEST['user_id'];
$userObj = new UsersTable();
$user = $userObj->Read($user_id);
if (empty($user)) {
   header("location: Logout.php");
   exit;
}

//var_dump($user); exit;

$current_hashed_password = $user['password'];
$email = $user['email'];

$current_password = trim($_REQUEST['current_password']);
$new_password = trim($_REQUEST['new_password']);
$new_password_confirm = trim($_REQUEST['new_password_confirm']);
$email_password = isset($_REQUEST['emailpassword']) && ($_REQUEST['emailpassword'] == 'emailpassword');

// var_dump($current_hashed_password, $current_password);exit;
// First, make sure the hashed current password is verified against whats currently stored for user
if (!password_verify($current_password, $current_hashed_password)) {
	$last_error = "<span style=\"color:red\">Current Password is invalid. Try again!</span>";
	header("location: UserChangePasswordForm.php?user_id=$user_id&status_msg=$last_error");
	exit;
}

// 2nd make sure the two new passwords match and are at least 4 characters long
if ($new_password != $new_password_confirm) {
	$last_error = "<span style=\"color:red\">The two new passwords did not match. Try again!</span>";
	header("location: UserChangePasswordForm.php?user_id=$user_id&status_msg=$last_error");
	exit;
}

$pattern = "#^[A-Za-z0-9 @\#\$\%]+$#";
if ((strlen($new_password) < 4) || !preg_match($pattern, $new_password)) {
	$last_error = "<span style=\"color:red\">New password is not long enough or contains invalid characters!</span>";
	header("location: UserChangePasswordForm.php?user_id=$user_id&status_msg=$last_error");
	exit;
}

// Store the new password & Email the new password if requested
$new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
$result = $userObj->ModifyPassword($user_id, $new_hashed_password);
if ($result >= 0) {
	$to = $email;
	$encPwd = htmlentities($new_password, ENT_QUOTES);
	$status_msg = "New password $encPwd has been saved!";
	if ($email_password) {
		$msg = "Your password for http://stpeterxc.org/xcreg has been reset to: $new_password";
		if (SendMail($to, "XCReg Password", $msg)) {
			$status_msg .= "</br>New Password emailed to $to";
		}
   }
   $status_msg = "Pasword updated. Please login with new password!";
	header("location: logout.php?user_id=$user_id&status_msg=$status_msg");
	exit;
}

$status_msg = "Password not updated: " . $userObj->LastError();
header("location: UserChangePasswordForm.php?user_id=$user_id&status_msg=$status_msg");
exit;

?>