<?php

require_once("classes/Constants.php");

function DisplayLoggedOffNavBar($requestingPageName) 
{
   	$pageHomeClass = "class='active'";
	print <<< EOT
		<nav class="navbar navbar-inverse" style="margin-bottom:0">  
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=#myNavbar>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand $pageHomeClass" href="index.php">XC Reg</a>
				</div>
		   	</div>
		</nav>
EOT;
}

// Adminstrators have more capability than non-admins. 
// If the session's EventID is not set, they get to see the following menus:
//    Home, Pending Users, Users, and Schools.
// If the session's EventID is set, they get to see the following menus:
//    Home, Pending Users, Users, Schools, & Runners.
//    (This is because runners are register against a specific event)

function DisplayAdminLevelNavBar($requestingPageName)
{
   	$pageHomeClass = $pageEventsClass = $pageRacesClass = $pagePendingUsersClass = $pageUsersClass = 
         $pageSchoolsClass = $pageRunnersClass = "";
         

   	switch ($requestingPageName) {
   		case "Home":
   			$pageHomeClass = "class='active'";
   			break;

         case "Events":
   			$pageEventsClass = "class='active'";
            break;

         case "Races":
   			$pageRacesClass = "class='active'";
            break;

         case "PendingUsers":
   			$pagePendingUsersClass = "class='active'";
            break;
            
   		case "Users":
   			$pageUsersClass = "class='active'";
            break;
            
   		case "Schools":
   			$pageSchoolsClass = "class='active'";
            break;
            
   		case "Runners":
   			$pageRunnersClass = "class='active'";
            break;
            
   		default: 
   			echo "Invalid Page Name $requestingPageName passed to DisplayAdminLevelNavBar()!\n";
   			exit;
   			$pageHomeClass = "class='active'";
   			break;
   	}

   	$email = PHPSession::Instance()->GetSessionVariable('email');
      $role = PHPSession::Instance()->GetSessionVariable('role');
      $event_id = PHPSession::Instance()->GetSessionVariable('event_id');
      // var_dump($event_id); exit;
      $runnersNavItem = "";
      $ev_name = "NO EVENT SELECTED";
      if (isset($event_id)) {
         $evObj = new EventsTable();
         $event = $evObj->Read($event_id);
         $ev_name = $event['ev_name'];
      }
   	print <<< EOT
		<nav class="navbar navbar-inverse" style="margin-bottom:0">  
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=#myNavbar>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand $pageHomeClass" href="index.php">XC Reg<br><small>$ev_name</small></a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
               <ul class="nav navbar-nav navbar-left">
                  <li $pageEventsClass><a href="EventsMain.php">Events</a></li>
                  <li $pageRacesClass><a href="RacesMainForm.php">Races</a></li>
                  <li $pagePendingUsersClass><a href="PendingUsersForm.php">PendingUsers</a></li>
						<li $pageUsersClass><a href="UsersMain.php">Users</a></li>
                  <li $pageSchoolsClass><a href="SchoolsMain.php">Schools</a></li>
                  <li $pageRunnersClass><a href="RunnersMain.php">Runners</a></li>
						$runnersNavItem;
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="navbar-right"><a href="Logout.php">Logout</a></li>
						<li class="navbar-right"><a href="#"><small>$email<br>$role</small></a></li>
					</ul>
				</div>
		   	</div>
		</nav>
EOT;
}

// Adminstrators get to see all of the pages
function DisplayUserLevelNavBar($requestingPageName)
{
   	$pageHomeClass = $pageEventsClass = $pageUsersClass = $pageSchoolsClass = 
   		$pageRunnersClass = $pageShirtsClass = "";
   	$pageChangePasswordClass = "class='navbar-right'";

   	switch ($requestingPageName) {
   		case "Home":
   			$pageHomeClass = "class='active'";
            break;

		case "Runners":
   			$pageRunnersClass = "class='active'";
   			break;
      case "ChangePassword":
         $pageChangePasswordClass = "class='navbar-right active'";
         break;
      default: 
         echo "Invalid Page Name $requestingPageName passed to DisplayUserLevelNavBar()!\n";
         exit;
         $pageHomeClass = "class='active'";
         break;
   	}

   	$email = PHPSession::Instance()->GetSessionVariable('email');
   	$school_name = PHPSession::Instance()->GetSessionVariable('school_name');
      $school_id = PHPSession::Instance()->GetSessionVariable('school_id');
      $event_name = "None Selected";
      $event_color = "red";
      if (PHPSession::Instance()->GetSessionVariable('event_id') != NULL) {
         $eventsObj = new EventsTable();
         $eventRec = $eventsObj->Read(PHPSession::Instance()->GetSessionVariable('event_id'));
         $ev_name = $eventRec['ev_name'];
         $event_color = "green";
      }
   	// $role = PHPSession::Instance()->GetSessionVariable('role');
   	print <<< EOT
<nav class="navbar navbar-inverse" style="margin-bottom:0">  
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=#myNavbar>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand $pageHomeClass" href="index.php">XC Reg<br><small>$ev_name</small></a>
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
         <ul class="nav navbar-nav navbar-left">
				<li $pageRunnersClass><a href="RunnersMain.php">Runners</a> </li>
			</ul>		
			<ul class="nav navbar-nav navbar-right">
				<li class="navbar-right"><a href="Logout.php">Logout</a></li>
				<li $pageChangePasswordClass><a href="UserChangePasswordForm.php">Change</br>Password</a></li>
      			<li class="navbar-right"><a href="#"><small>$email<br>$school_name</small></a></li>
			</ul>
		</div>
   	</div>
</nav>
EOT;
}


function OutputNavBar($requestingPageName)
{
	// var_dump(PHPSession::Instance()->GetAllSessionVariables());

	$role = PHPSession::Instance()->GetSessionVariable('role');
	if ($role == NULL) 
	{
		DisplayLoggedOffNavBar($requestingPageName);
	} 
	else if (UserRoles::Admin == $role) 
	{
		DisplayAdminLevelNavBar($requestingPageName);
	} 
	else if (UserRoles::NonAdmin == $role)
	{
		DisplayUserLevelNavBar($requestingPageName);
	}
	// no navbar... signifies a major issue with this application
}

?>