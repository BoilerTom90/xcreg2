<?php

require_once('classes/PHPSession.php');
PHPSession::Instance()->StartSession();

if (!PHPSession::Instance()->GetSessionVariable ('logged_on'))
{
	$last_error = "<span style=\"color:red\">Please Logon</span>";
	header("location: index.php?status_msg=$last_error");
    exit;
} 

?>
