<?php
require_once('classes/PHPSession.php');
require_once('includes/status_msg.inc.php');
PHPSession::Instance()->StartSession();
PHPSession::Instance()->EndSession();
$msg = "<span style=\"color:red\">You no longer logged in!</span>";
header("location: index.php?status_msg=$msg");
?>