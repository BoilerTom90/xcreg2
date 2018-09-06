<?php


// function OutputEventOptions(&$error_string) 
// {
//    $error_string = "";
//    $evt = new EventsTable();
//    $events = $evt->ReadAll();
//    foreach ($events as $ev) {
//       $label = $ev['ev_name'] . " (" . $ev['ev_date'] . ")";
//       echo "<option value=\"" . $ev['id'] . "\">" . $label . "</option>";
//    }
// }

?>
<div class="panel panel-primary">
   <div class="panel-heading">
      <strong class="">Your Login Credentials</strong>
   </div>
   <div class="panel-body">
      <form class="form-horizontal" role="form" action="Logout.php">
        <?php DisplayStatusMessage($status_msg); ?>

         <!-- Only display the school info for NonAdmins -->

         <?php if (PHPSession::Instance()->GetSessionVariable('event_id')) { ?>
            <div class="form-group">
                  <label for="event" class="col-sm-3 control-label">Event</label>
                  <div class="col-sm-9">
                     <input type="event" class="form-control" name="event" 
                        value="<?php echo PHPSession::Instance()->GetSessionVariable('event_name'); ?>" 
                        id="event" 
                        disabled>
                  </div>
            </div>
         <?php } ?>

         <?php if (UserRoles::NonAdmin == PHPSession::Instance()->GetSessionVariable('role')) { ?>
            <div class="form-group">
                  <label for="school" class="col-sm-3 control-label">School</label>
                  <div class="col-sm-9">
                     <input type="school" class="form-control" name="school" 
                        value="<?php echo PHPSession::Instance()->GetSessionVariable('school_name'); ?>" 
                        id="school" 
                        disabled>
                  </div>
            </div>
         <?php } ?>

        <div class="form-group">
            <label for="email" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-9">
               <input type="email" class="form-control" name="email" 
                    value="<?php echo PHPSession::Instance()->GetSessionVariable('email'); ?>" 
                    id="email" disabled>
            </div>
         </div>
         <div class="form-group last">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
               <button type="submit" class="btn btn-primary btn-md" name="button" value="logout">logout</button>
            </div>
         </div>
      </form>
   </div>
</div>
