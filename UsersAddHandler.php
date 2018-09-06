<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('classes/DBAccess.php');
require_once('includes/adminusercheck.inc.php');



// the expected information from the form is in the $_REQUEST variable
// 
// var_dump($_REQUEST); exit;


$email  = trim(strtolower($_REQUEST['email'])); 
$school_id = $_REQUEST['school_id'];
$role   = $_REQUEST['role'];
$status = $_REQUEST['status'];
$status_msg = "";

if (($role == UserRoles::NonAdmin) && ($school_id == 0)) {
   $status_msg = "User not added. You must select a school for NonAdmin users!";
   $alert = "alert_category=alert-danger";
   header("location: UsersMain.php?status_msg=$status_msg&$alert");
   exit;
}

if (($role == UserRoles::Admin) && ($school_id != 0)) {
   $status_msg = "User not added. You must NOT select a school for Admin users!";
   $alert = "alert_category=alert-danger";
   header("location: UsersMain.php?status_msg=$status_msg&$alert");
   exit;
}

$reset_code = 0;

$hashed_password = password_hash("coach@123", PASSWORD_DEFAULT); 
$encPwd = htmlentities($hashed_password, ENT_QUOTES);

$usersObj = new UsersTable();
$nextID = $usersObj->MaxID() + 1;
$num_rows_affected = $usersObj->Insert($nextID, $school_id, $role, $status, $email, $reset_code, $encPwd);
if ($num_rows_affected >= 0) {
   $status_msg = "User successfully added.";
   $alert = "alert_category=alert-success";
} else { 
   $status_msg = "User NOT added: " . $usersObj->LastError();
   $alert = "alert_category=alert-danger";
}
header("location: UsersMain.php?status_msg=$status_msg&$alert");
exit;

?>