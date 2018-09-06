<?php

$botURL = "https://www.google.com/recaptcha/api/siteverify";
$secretKey = '6LfrwG0UAAAAAAUX_DUZXoSleeahPY3w342S6GOc';

class UserRoles { 
   CONST Admin = 'Admin'; 
   CONST NonAdmin = 'NonAdmin'; 
} 

class UserStatus {
   CONST Active = 'Active';
   CONST InActive = 'InActive';
}

class EventRegStatus {
   CONST RegOpen = "Open";
   CONST RegClosed = "Closed";
   CONST RegUnknown = "Unknown";
}

class RunnerSexValues {
   CONST Boy = "B";
   CONST Girl = "G";
}

function OutputRoleChoices($selectedRole = UserRoles::NonAdmin) 
{
   $roles = array(UserRoles::Admin, UserRoles::NonAdmin);
   foreach ($roles as $r) {
      $selected = "";
      if ($r == $selectedRole) {
         $selected = "selected=\"selected\"";
      }
      echo "<option name=\"role\" value=\"" . $r . "\" $selected>" . $r . "</option>";
   }
}

function OutputUserStatusChoices($selectedStatus = UserStatus::Active)
{
   $status = array(UserStatus::Active, UserStatus::InActive);
   foreach ($status as $s) {
      $selected = "";
      if ($s == $selectedStatus) {
         $selected = "selected=\"selected\"";
      }
      echo "<option name=\"status\" value=\"" . $s . "\" $selected>" . $s . "</option>";
   }
}

function OutputRegStatusChoices($activeOne = EventRegStatus::RegOpen)
{
   $status = array(EventRegStatus::RegOpen, EventRegStatus::RegClosed);
   foreach ($status as $as)
   {
      $selected = "";
      if ($as == $activeOne) {
         $selected = "selected=\"selected\"";
      }
      echo "<option name=\"status\" value=\"" . $as . "\"" . $selected . ">" . $as . "</option>";
   }
}

function OutputEventOptions() {
   $eventsObj = new EventsTable();
   $events = $eventsObj->ReadAll();
   foreach ($events as $event) {
      $selected = "";
      if ($event['ev_reg_status'] == EventRegStatus::RegOpen) {
         $selected = "selected=\"selected\"";
      }
      echo "<option name=\"event_id\" value=\"" . $event['id'] . "\"" . $selected . ">" . $event['ev_name'] . "</option>";
   }

}

function OutputSchoolChoices($current_school_id = null, $addNoSchool = 0)
{
   $role = PHPSession::Instance()->GetSessionVariable('role');
   $schoolsObj = new SchoolsTable();
   $schools = $schoolsObj->ReadAll('name asc');
   if ($addNoSchool) {
      echo "<option name=\"school_id\" value=\"0\" >No School</option>";
   }

   if ($role == UserRoles::Admin) { 
      foreach ($schools as $s)
      {
         $school_id = $s['id'];
         $school_name = $s['name'];
         $selected = "";
         if (($current_school_id != null) && ($current_school_id == $school_id)) {
            $selected = "selected=\"selected\"";
         }
         echo "<option name=\"school_id\" value=\"" . $school_id . "\"" . $selected . ">" . $school_name . "</option>";
      }
   } else {
      foreach ($schools as $s)
      {
         $school_id = $s['id'];
         $school_name = $s['name'];
         $selected = "";
         if (($current_school_id != null) && ($current_school_id == $school_id)) {
            $selected = "selected=\"selected\"";
            echo "<option name=\"school_id\" value=\"" . $school_id . "\"" . $selected . ">" . $school_name . "</option>";
         }  
      }
   }
}

function OutputRaceChoices($event_id)
{
   $racesObj = new RacesTable(); 
   $races = $racesObj->ReadByEvent($event_id);
   asort($races);
   foreach ($races as $r) {
      $race_id = $r['id'];
      $race_name = $r['description'];
      echo "<option name=\"race_id\" value=\"" . $race_id . "\">" . $race_name . "</option>";
   }
}

function OutputEventChoices()
{
   $eventsObj = new EventsTable(); 
   $events = $eventsObj->ReadAll();
   foreach ($events as $e) {
      $ev_id = $e['id'];
      $ev_name = $e['ev_name'];
      $ev_date = $e['ev_date'];
      $ev_reg_status = $e['ev_reg_status'];
      echo "<option name=\"event_id\" value=\"" . $ev_id . "\">" . $ev_name . " on " . $ev_date . ", Registration is currently " . $ev_reg_status . "</option>";
   }
}

?>