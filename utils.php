<?php
require_once('sendmail.php');

function EmailAdmin($subject, $message) {
   SendMail("purduetom90@gmail.com", $subject, $message);
}

?>