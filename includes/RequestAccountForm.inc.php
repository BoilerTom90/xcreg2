<?php

$status_msg = "";
if (isset($_REQUEST['status_msg']))
{
  $status_msg = $_REQUEST['status_msg'];
}

function DisplayStatusMessage($status_msg) 
{ 
  if (isset($status_msg) && strlen($status_msg)) 
  {
    echo "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">";
    echo "<span aria-hidden=\"true\">&times;</span></button>";
    echo $status_msg;
    echo "</div>";
  }
}

function OutputEventOptions(&$error_string) 
{
  $error_string = "";
  $events = ReadAllEvents($error_string);
  foreach ($events as $ev)
  {
    $label = $ev['event_name'] . " (" . $ev['race_date'] . ")";
    echo "<option value=\"" . $ev['event_id'] . "\">" . $label . "</option>";
  }
}

function OutputSchoolOptions()
{
    if (PHPSession::Instance()->GetSessionVariable('role') == "admin") 
    {
	   $event_db = PHPSession::Instance()->GetSessionVariable('event_db');
      $schools = ReadAllSchools($event_db, $last_error); 
	   foreach ($schools as $s) 
	   {
            $school_id = $s['school_id'];
            if ($school_id > 0) // School ID 0 is the default admin school, which no runners should be part of.
            {
		      $label = $s['school_name'];	
		      echo "<option name=\"school_id\" value=\"" . $school_id . "\">" . $label . "</option>";	
            }
	   }
    }
    else
    {
        $label = PHPSession::Instance()->GetSessionVariable('school_name');
        $school_id = PHPSession::Instance()->GetSessionVariable('school_id');
        echo "<option name=\"school_id\" value=\"" . $school_id . "\">" . $label . "</option>";
    }
}

?>

<br/>
<div class="panel panel-primary">
   <div class="panel-heading">
      <strong class="">Request Account</strong>
   </div>
   <div class="panel-body">
      <form class="form-horizontal" role="form" action="RequestAccountFormHandler.php">
        <?php DisplayStatusMessage($status_msg); ?>
        
        <div class="form-group">
          <label for="event_id" class="col-sm-3 control-label">Select Event</label>
          <div class="col-sm-9">
            <select id="event_id" name="event_id" class="form-control" required>
              <?php OutputEventOptions($error_strin); ?>
            </select>
          </div>
        </div>
         
        <div class="form-group">
          <label for="school_id" class="col-sm-3 control-label">Select School</label>
          <div class="col-sm-9">
            <select id="school_id" name="school_id" class="form-control" required>
              <?php OutputSchoolOptions(); ?>
            </select>
          </div>
        </div>
        
        <div class="form-group">
            <label for="email" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-9">
               <input type="email" class="form-control" name="email" value="" id="email" placeholder="Email" required="required">
            </div>
         </div>
         <div class="form-group">
            <label for="email2" class="col-sm-3 control-label">Confirm Email</label>
            <div class="col-sm-9">
               <input type="email" class="form-control" name="email2" value="" id="email2" placeholder="Email" required="required">
            </div>
         </div>
         <div class="form-group">
            <label for="password" class="col-sm-3 control-label">Password</label>
            <div class="col-sm-9">
               <input type="password" class="form-control" name="password" value="" id="password" placeholder="enter password" required="required">
            </div>
         </div>
         <div class="form-group">
            <label for="password2" class="col-sm-3 control-label">
               Confirm Password</label>
            <div class="col-sm-9">
               <input type="password" class="form-control" name="password2" value="" id="password2" placeholder="enter password" required="required">
            </div>
         </div>
         <div class="form-group last">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
               <button type="submit" class="btn btn-primary btn-md" name="button" value="login">Submit</button>
            </div>
         </div>
      </form>
   </div>
   <div class="panel-footer"><a href="index.php">Cancel</a>
   </div>
</div>
