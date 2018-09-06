<?php 

require_once('classes/PHPSession.php');
require_once('classes/DBAccess.php');
require_once('classes/Constants.php');
require_once('sendmail.php');

PHPSession::Instance()->StartSession();

if (!isset($_REQUEST) || !isset($_REQUEST['email']) || !isset($_REQUEST['button']) || ($_REQUEST['button'] !== 'fgtpwd')) {
   $status_msg = "Invalid request to Forgot Password Handler!";
   header("location: ForgotPasswordForm.php?status_msg=$status_msg" . "&alert_category=alert-danger");
   exit;
}

// var_dump($_REQUEST); exit;



// the expected information from the form is in the $_REQUEST variable
// 
// var_dump($_REQUEST); 
$captchaResponse = $_REQUEST['captcha-response'];
$data = array('secret' => $secretKey, 'response' => $captchaResponse);
$options = array(
   'http' => array(
      'header' => "Content-type: application/x-www-form-urlencoded\r\n",
      'method' => 'POST',
      'content' => http_build_query($data)
   )
);
$context = stream_context_create($options);
$result = json_decode(file_get_contents($botURL, false, $context), true);
//var_dump($result); exit;
if (!isset($result['success']) || $result['success'] != true) {
   $status_msg = "Your request failed BOT verification. Please try again!";
   header("location: ForgotPasswordForm.php?status_msg=$status_msg" . "&alert_category=alert-danger");
   exit;
} 


$email  = trim(strtolower($_REQUEST['email'])); 
$status_msg = "";
$userObj = new UsersTable();
$rec = $userObj->ReadByEmail($email);
if (!$rec || empty($rec)) {
   $status_msg = "Request not accepted. No account found with this email address!";
   header("location: ForgotPasswordForm.php?status_msg=$status_msg" . "&alert_category=alert-danger");
   exit;
}

//var_dump($email); exit;
// reset code is current time + 30 minutes
$reset_code = time() + 30*60;
$num_rows_affected = $userObj->ModifyResetCode($rec[0]['id'], $reset_code);
if ($num_rows_affected <= 0) {
   $status_msg = "Failed to generated Password Reset Code!";
   $alertCategory = "alert-warning";
   header("location: ForgotPasswordForm.php?status_msg=$status_msg" . "&alert_category=$alertCategory");
   exit;
}

// Now, need to email the reset code to the user
$msg  = "Your pasword reset code is $reset_code and will be valid for at most 30 minutes.\n";
$msg .= "Please click on the following link, or copy and paste into your browser to proceed with reseting your pasword.\n\n";
$msg .= "   http://stpeterxc.org/xcreg/ForgotPasswordResetCodeForm.php?reset_code=$reset_code&email=$email \n   ";
SendMail($email, "XCReg: Password Reset Code", $msg);


$status_msg = "A Password Reset code was set to $email. </br>Please check your inbox and/or spam folder!";
$alertCategory = "alert-success";
// var_dump($status_msg); exit;
header("location: ForgotPasswordResetCodeForm.php?reset_code=0&email=$email&status_msg=$status_msg" . "&alert_category=$alertCategory");
exit;
?>