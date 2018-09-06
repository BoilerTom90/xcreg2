<?php 

require_once('classes/passwordLib.php');
require_once('classes/DBAccess.php');
require_once('classes/PHPSession.php');
require_once('classes/Constants.php');
require_once('utils.php');

PHPSession::Instance()->StartSession();

// the expected information from the form is in the $_REQUEST variable
//var_dump($_REQUEST); exit;

$email = trim($_REQUEST['email']);
$password = trim($_REQUEST['password']);

$event_id = null;
if (isset($_REQUEST['event_id'])) {
   $event_id = $_REQUEST['event_id'];
}


if ($_REQUEST['button'] == "login")
{
   $last_error = "";
   $usersObj = new UsersTable();
   $user_info = $usersObj->ReadByEmail($email); 
	// var_dump($user_info[0]); exit;

	if (!empty($user_info)) {

      // Found the user. Verify the password
      $user_id = $user_info[0]['id'];
      $num_logins = $user_info[0]['num_logins'];
		$password_hash = $user_info[0]['password'];
		$status = $user_info[0]['status'];
		$role = $user_info[0]['role'];

      // var_dump($password, $password_hash); exit;
		if (!password_verify($password, $password_hash)) {
         EmailAdmin("XCREG: login failure", 
                    "Email: " . $email . ", pwd: " . $password . "\n\r");
         
			$last_error = "<span style=\"color:red\">User Authentication Failure - Incorrect password entered!</span>";
			header("location: index.php?status_msg=$last_error");
			exit;
      }

		if (UserStatus::Active != $status) {
         EmailAdmin("XCREG: login failure", 
                    "Email: " . $email . ", pwd: " . $password . "\n\r");
         
			$last_error = "<span style=\"color:red\">User Authentication Failure - Account is not active!</span>";
			header("location: index.php?status_msg=$last_error");
			exit;
      }
      
      // In most cases the event_id will be non-null. The only time it should be null is someone
      // removed all the events from the system. Admins are allowed to login and add Events. NonAdmins
      // are required to have specified an event, which applies for the entire login session.
      if (($event_id == null) && ($role == UserRoles::NonAdmin)) {
         $msg = "You must select an Event when logging in!";
         header("location: index.php?status_msg=$msg&alert_category='alert-danger'");
         exit;
      }

      // If the event is closed and this is a nonAdmin, fail the login 
      $event_name = null;
      $event_reg_status = EventRegStatus::RegUnknown;
      if ($event_id != null) {
         $evObj = new EventsTable();
         $event = $evObj->Read($event_id);
         if (empty($event)) {
            $msg = "Error reading event from system!";
            header("location: index.php?status_msg=$msg&alert_category='alert-danger'");
            exit;
         }

         $event_name = $event['ev_name'];
         $event_reg_status = $event['ev_reg_status'];
         if (($role == UserRoles::NonAdmin) && ($event_reg_status == EventRegStatus::RegClosed)) {
            $msg = "<span style=\"color:red\">Sorry, Registration for this event is now closed!</span>";
            header("location: index.php?status_msg=$msg");
            exit;
         }
      }


      EmailAdmin("XCREG: login success", 
                 "Email: " . $email . ", pwd: " . $password . "\n\r");
      
		// successful login, save information about the user.
		PHPSession::Instance()->SetSessionVariable ('logged_on',   true);
		PHPSession::Instance()->SetSessionVariable ('email',       $email);
		PHPSession::Instance()->SetSessionVariable ('role',        $user_info[0]['role']);
      PHPSession::Instance()->SetSessionVariable ('school_id',   $user_info[0]['school_id']);

      // User the school ID and read the school name. Admin user's aren't assigned to a school, so it may not exist.
      if (UserRoles::Admin == $user_info[0]['role']) {
         PHPSession::Instance()->SetSessionVariable ('school_name', 'n/a');
      } else {
         $s = new SchoolsTable();
         $schoolRec = $s->Read($user_info[0]['school_id']); 
         if (empty($schoolRec)) {
            PHPSession::Instance()->SetSessionVariable ('school_name', 'Error - no school found for user');
         } else {
            PHPSession::Instance()->SetSessionVariable ('school_name', $schoolRec['name']);
         }
      }
      
      if ($event_id != null) { 
         PHPSession::Instance()->SetSessionVariable ('event_id',    $event_id);	
         PHPSession::Instance()->SetSessionVariable ('event_name',  $event_name);
      }
    
      // Update the Users Table for the number of logins and last login date
      $num_logins++;
      $usersObj->ModifyLastLoginInfo($user_id, $num_logins);

      // var_dump(session_write_close()); exit;

	   // var_dump(PHPSession::Instance()->GetAllSessionVariables());exit;
		$last_error = "<span style=\"color:blue\">Login Successful!</span>";
		header("location: index.php?status_msg=$last_error");
		exit;
	} 
   
   EmailAdmin("XCREG: login failure", "Email: " . $email . " not found!\n\r");
   
	$last_error = "<span style=\"color:red\">Login Failed. User not found!</span>";
	header("location: index.php?status_msg=$last_error");
	exit;
}

$last_error = "Internal Error Detected in LoginFormHandler.php!";
header("location: index.php?status_msg=$last_error");
exit;
?>