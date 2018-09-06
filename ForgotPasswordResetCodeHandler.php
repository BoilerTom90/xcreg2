<?php 

require_once('classes/PHPSession.php');
require_once('classes/DBAccess.php');
require_once('classes/Constants.php');
require_once('sendmail.php');
require_once('classes/passwordLib.php');

PHPSession::Instance()->StartSession();

if (!isset($_REQUEST) || !isset($_REQUEST['email']) || !isset($_REQUEST['reset_code']) || 
    !isset($_REQUEST['new_password']) || !isset($_REQUEST['new_password_confirm']) ||
    !isset($_REQUEST['button']) || ($_REQUEST['button'] !== 'reset_password')) {
   $status_msg = "Invalid request to Reset Code Handler!";
   header("location: ForgotPasswordResetCodeForm.php?status_msg=$status_msg" . "&alert_category=alert-danger");
   exit;
}

// var_dump($_REQUEST); exit;



$email      = trim(strtolower($_REQUEST['email'])); 
$reset_code = trim($_REQUEST['reset_code']); 
$password1  = trim($_REQUEST['new_password']); 
$password2  = trim($_REQUEST['new_password_confirm']); 

if ($password1 != $password2) {
   $status_msg = "Your two passwords do not match! Please try again...";
   header("location: ForgotPasswordResetCodeForm.php?email=$email&reset_code=$reset_code&status_msg=$status_msg" . "&alert_category=alert-danger");
   exit;
}

$userObj = new UsersTable();
$rec = $userObj->ReadByEmail($email);
if (!$rec || empty($rec)) {
   $status_msg = "Request not accepted. No account found with this email address!";
   header("location: ForgotPasswordForm.php?status_msg=$status_msg" . "&alert_category=alert-danger");
   exit;
}

$cur_reset_code = $rec[0]['reset_code'];
if (($reset_code != $cur_reset_code) || ($cur_reset_code < time())) {
   $status_msg = "Either your reset code was invalid, or it has expired!";
   header("location: ForgotPasswordForm.php?status_msg=$status_msg" . "&alert_category=alert-danger");
   exit;   
}

// Update Password
$user_id = $rec[0]['id'];
$new_hashed_password = password_hash($password1, PASSWORD_DEFAULT);
$num_rows_affected = $userObj->ModifyPassword($user_id, $new_hashed_password);
if ($num_rows_affected < 0) {
   $status_msg = "Password not updated!";
   $alertCategory = "alert-warning";
   header("location: ForgotPasswordForm.php?status_msg=$status_msg" . "&alert_category=$alertCategory");
   exit;
}

$num_rows_affected = $userObj->ModifyResetCode($user_id, 0);

// Now, need to email the reset code to the user
$msg  = "Your pasword to access http://stpeterxc.org/xcreg has been reset.\nIf this was not done by you, please contact the sites admininstrator.";
SendMail($email, "XCReg: Password reset notification", $msg);

PHPSession::Instance()->EndSession();

$status_msg = "Your password has been reset! Please login with your new password";
$alertCategory = "alert-success";
header("location: index.php?status_msg=$status_msg" . "&alert_category=$alertCategory");
exit;
?>