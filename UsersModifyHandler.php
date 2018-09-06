<?php 

require_once('includes/checkLogin.inc.php');
require_once('classes/DBAccess.php');
require_once('classes/passwordLib.php');
require_once('sendmail.php');
require_once('includes/adminusercheck.inc.php');
require_once('includes/status_msg.inc.php');


// the expected information from the form is in the $_REQUEST variable
// 
// var_dump($_REQUEST); exit;

$user_id = $_REQUEST['user_id'];
$userObj = new UsersTable();
$user = $userObj->Read($user_id);

// Fields in the user record from the database
//  id
//  school_id
//  role
//  status
//  email
//  reset_code
//  password


if (empty($user)) {
	$msg = "User has been removed from the system!"; 
   header("location: UsersMain.php?status_msg=$msg&alert_category=\"alert-danger\"");
	exit;
}

// XXXX START HERE XXXX
$button = $_REQUEST['button'];

if ($button == "setschool") {
   $new_school_id = $_REQUEST['school_id'];
   if (($user['role'] == UserRoles::Admin) && ($new_school_id > 0)) {
      $status_msg = "School Update failed. Do not assign a school for Admin Users!";
      header("location: UsersModifyForm.php?user_id=$user_id&status_msg=$status_msg&alert_category=alert-danger");
	   exit;
   }
   if (($user['role'] == UserRoles::NonAdmin) && ($new_school_id == 0)) {
      $status_msg = "School Update failed. You must assign a school for Admin Users!";
      header("location: UsersModifyForm.php?user_id=$user_id&status_msg=$status_msg&alert_category=alert-danger");
	   exit;
   }
   $status_msg = "School Updated";
   if ($userObj->ModifySchoolID($user_id, $new_school_id) < 0) {
      $status_msg = "Error Updating School ID: " . $userObj->LastError();
   }
	header("location: UsersModifyForm.php?user_id=$user_id&status_msg=$status_msg");
	exit;
}

if ($button == "setrole") {
	$new_role = $_REQUEST['role'];
   $status_msg = "Role Updated";
   if ($userObj->ModifyRole($user_id, $new_role) < 0) {
      $status_msg = "Error Updating Role: " . $userObj->LastError();
   }
	header("location: UsersModifyForm.php?user_id=$user_id&status_msg=$status_msg&alert_category=alert-danger");
	exit;
}

if ($button == "setstatus") {
   $new_status = $_REQUEST['status'];
   $status_msg = "Status Updated";
   if ($userObj->ModifyStatus($user_id, $new_status) < 0) {
      $status_msg = "Error Updating Status: " . $userObj->LastError();
   }
	header("location: UsersModifyForm.php?user_id=$user_id&status_msg=$status_msg");
	exit;
}

//var_dump($_REQUEST); exit;
if ($button == "setpassword") {
	// var_dump($_REQUEST); exit;
	$new_password = $_REQUEST['password'];
	$pattern = "#^[A-Za-z0-9 @\#\$\%]+$#";
	if ((strlen($new_password) < 6) || !preg_match($pattern, $new_password)) {
		$status_msg = "Password does not meet the minimal requirements: ". htmlentities("[A-Za-z0-9 @#$%]+", ENT_QUOTES);
	} else {
		$status = "Password Updated";
      $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT); 
		$result = $userObj->ModifyPassword($user_id, $new_hashed_password);
		if ($result < 0) {
         $status_msg = "Error updating password: " . $userObj->LastError();
      } else {
			$to = $user['email'];
			$encPwd = htmlentities($new_password, ENT_QUOTES);
			$status_msg = "Password for $to has been updated to $encPwd";
			if ($_REQUEST['emailpassword'] == 'emailpassword') {
				$emailMsg = "Your password to access http://stpeterxc.org/xcreg has been set to $new_password";
            if (SendMail($to, "XCReg Password", $emailMsg))
				{
					$status_msg .= "</br>New Password ($encPwd) sent to users email address: $to";
				}
			}
		}
	}
	header("location: UsersModifyForm.php?user_id=$user_id&status_msg=$status_msg");
	exit;
}

header("location: UsersMain.php?$status_msg=\"Invalid Command for Modify\"");
exit;

?>