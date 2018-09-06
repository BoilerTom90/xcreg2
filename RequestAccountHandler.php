<?php 

require_once('classes/PHPSession.php');
require_once('classes/DBAccess.php');
require_once('classes/Constants.php');

PHPSession::Instance()->StartSession();

// //
// set_error_handler("warning_handler", E_WARNING);


// function warning_handler($errno, $errstr) { 
// // do something
// }




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
$check_result = file_get_contents($botURL, false, $context);
//var_dump($check_result); exit;
$result = json_decode($check_result, true);
if (!isset($result['success']) || $result['success'] != true) {
   $status_msg = "Your request failed BOT verification. Please try again!";
   header("location: RequestAccount.php?status_msg=$status_msg" . "&alert_category=alert-danger");
   exit;
} 


$email  = trim(strtolower($_REQUEST['email'])); 
$confirmedEmail = trim(strtolower($_REQUEST['confirmed-email'])); 
$school = $_REQUEST['school'];
$status_msg = "";

if ($email != $confirmedEmail) {
   $status_msg = "Emails do not match. Please try again!";
   header("location: RequestAccount.php?status_msg=$status_msg" . "&alert_category=alert-danger");
   exit;
}

$u = new UsersTable();
$rec = $u->ReadByEmail($email);
// var_dump($email, $rec); exit;
if (!empty($rec)) {
   $status_msg = "Request not accepted. There is already an account with this email address!";
   header("location: RequestAccount.php?status_msg=$status_msg" . "&alert_category=alert-danger");
   exit;
}


if ($_REQUEST['button'] == "add")
{
   $last_error = "";
   $p = new PendingUsersTable();
   $id = $p->MaxID() + 1;
   $num_rows_affected = $p->Insert($id, $email, $school);
	if ($num_rows_affected > 0) {
      $status_msg = "Request Accepted. You will be notified shortly when account is approved.";
      $alertCategory = "alert-success";
	} else { 
      $status_msg = "Request not accepted. Account request previously submitted!";
      $alertCategory = "alert-warning";
	}
	
	header("location: index.php?status_msg=$status_msg" . "&alert_category=$alertCategory");
	exit;
}

$status_msg = "Internal Error. No action taken!";
$alertCategory = "alert-danger";
header("location: login.php?status_msg=$status_msg" . "&alert_category=$alertCategory");
exit;
?>