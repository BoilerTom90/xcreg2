<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('classes/DBAccess.php');
require_once('includes/adminusercheck.inc.php');

$usersObj = new UsersTable();

$users = $usersObj->ReadAll();
$fp = fopen('php://output', 'w');
fprintf($fp, "<pre>\n");
foreach ($users as $u) {
	$email = $u['email'];
	fprintf($fp, "%s\n", $email);
}
fprintf($fp, "</pre>");
fclose($fp);
return;

?>