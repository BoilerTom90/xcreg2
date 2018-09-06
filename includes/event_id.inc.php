<?php
// If the event_id is set, update the pHP Session Variable
if (isset($_REQUEST) && isset($_REQUEST['event_id'])) {
   $event_id = $_REQUEST['event_id'];
   PHPSession::Instance()->SetSessionVariable('event_id', $event_id);
} else if (PHPSession::Instance()->GetSessionVariable('event_id') == null) {
   $sts = "You must have selected an event to manage before using the prior page!";
   header("location: index.php?status_msg=$sts&alert_category='alert-danger'");
   exit;
}
?>