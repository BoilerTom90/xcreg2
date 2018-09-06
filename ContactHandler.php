<?php 


require_once('classes/PHPSession.php');
require_once('sendmail.php');

PHPSession::Instance()->StartSession();



// the expected information from the form is in the $_REQUEST variable
//var_dump($_REQUEST); 
//var_dump($_POST);
//exit;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $email   = trim($_POST['email']);
   $email2  = trim($_POST['email2']);
   $school = htmlspecialchars($_POST['school']);
   $city = htmlspecialchars($_POST['city']);
   $state = htmlspecialchars($_POST['state']);
   $message = htmlspecialchars($_POST['message']);
   
   if ($email != $email2) {
      $msg = "<span style=\"color:red\">The two email values much match!</span>";
      header("location: ContactMain.php?status_msg=$msg");
      exit;
   }
   
   if ($message === "") {
      $msg = "<span style=\"color:red\">You must supply a message!</span>";
      header("location: ContactMain.php?status_msg=$msg");
      exit;
   }
   
   
   $to = "purduetom90@gmail.com";
   $content  = "Email:   " . $email   . "\r\n";
   $content .= "School:  " . $school  . "\r\n";
   $content .= "City:    " . $city    . "\r\n";
   $content .= "State:   " . $state   . "\r\n";
   $content .= "Message: " . $message . "\r\n";
   if (SendMail($to, "XCReg Contact Request", $content)) {
      $msg = "<span style=\"color:black\">Your message has been sent to the administrator!</span>";
      header("location: ContactMain.php?status_msg=$msg");
      exit;
   }
   
   $msg = "<span style=\"color:red;\">Your message could not be sent!</span>";
   header("location: ContactMain.php?status_msg=$msg");
   exit;
}

header("location: index.php");
exit;
?>