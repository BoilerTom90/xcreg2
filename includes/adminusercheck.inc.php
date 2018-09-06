<?php 

require_once('classes/PHPSession.php');
require_once('classes/Constants.php');

// Only admin's have access to this page
PHPSession::Instance()->StartSession();
if (PHPSession::Instance()->GetSessionVariable ('role') != UserRoles::Admin)
{
    $status_msg = "User not authorized to access that page!";
    header("location: index.php?status_msg=$status_msg");
    exit;
}

?>