<?php 

$status_msg = "";
if (isset($_REQUEST['status_msg']) && strlen($_REQUEST['status_msg'])) 
{
    $status_msg = $_REQUEST['status_msg'];
}

$alertCategory = "alert-success";
if (isset($_REQUEST['alert_category'])) {
   $alertCategory = $_REQUEST['alert_category'];
}

function DisplayStatusMessage($status_msg) 
{	
	if (isset($status_msg) && strlen($status_msg)) 
	{
 		echo "<div class=\"alert " . $GLOBALS['alertCategory'] . " alert-dismissible\" role=\"alert\">";
 		echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">";
 		echo "<span aria-hidden=\"true\">&times;</span></button>";
 		echo $status_msg;
 		echo "</div>";
 	}
}

?>