<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('classes/DBAccess.php');
require_once('includes/adminusercheck.inc.php');

// the expected information from the form is in the $_REQUEST variable
// 
// var_dump($_REQUEST); exit;


$email  = trim(strtolower($_REQUEST['email'])); 
$user_id = $_REQUEST['user_id'];


if ($_REQUEST['button'] == "delete") {
   $usersObj = new UsersTable();
   $result = $usersObj->Delete($user_id);
	if ($result == 1) {
		$status_msg = "User [$email] Deleted!";
	} else {
		$status_msg = "User [$email] not deleted: $usersObj->LastError()";
	} 
	header("location: UsersMain.php?status_msg=$status_msg");
	exit;
}


$status_msg="Uh Oh Shaggy. How did I get here?";
header("location: UsersMain.php?status_msg=$status_msg");
exit;

?>