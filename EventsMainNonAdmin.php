<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');
require_once('includes/status_msg.inc.php');
require_once('classes/Constants.php');

?>

<body>

<?php 
require_once('includes/navbar.inc.php'); 
OutputNavBar("Events");
?>

<br/>


<div class="container">
   <div class="panel panel-primary">
      <div class="panel-heading">Please Ensure Correct Event is Selected with Green <span class="glyphicon glyphicon-ok" aria-hidden="true"></span></div>
         <div class="panel-body">
            <div class="row">
               <div class="col-xs-12">
                  <?php DisplayStatusMessage($status_msg); ?>
                  <div class="table-responsive">
                     <table class="table table-condensed table-bordered table-hover set-bg" id="sortable-table">
                        <thead>
                           <tr>
                              <th>Name</th>
                              <th>Date</th>
                              <th>Registration Status</th>
                              <th>Select</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                              $eventsObj = new EventsTable();
                              $events = $eventsObj->ReadAll();
                              if (!empty($events)) {
                                 foreach ($events as $ev) {
                                    $ev_id = $ev['id'];
                                    $ev_status = $ev['ev_reg_status'];
                                    if ($ev_status == EventRegStatus::RegOpen) {
             
                                       echo "<tr>";
                                       echo "<td>" . $ev['ev_name'] . "</td>";
                                       echo "<td>" . $ev['ev_date'] . "</td>";
                                       echo "<td>" . $ev_status . "</td>";

                                       // if the sessions "active" event is not set, set it 
                                       if (PHPSession::Instance()->GetSessionVariable('event_id') == NULL) {
                                          PHPSession::Instance()->SetSessionVariable('event_id', $ev_id);
                                       }

                                       if (PHPSession::Instance()->GetSessionVariable('event_id') == $ev_id) {
                                          echo "<td><span style=\"color: green\" class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span> (selected)</td>";
                                       } else {
                                          echo "<td>" . "<a class=\"btn btn-primary btn-xs\" href=\"EventsSelectEventHandler.php?event_id=$ev_id\">Select</a>" . "</td>";
                                       }                                       
                                       echo "</tr>";
                                    }
                                 }
                              }
                           ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div> <!-- panel-body -->
   </div> <!-- panel default -->
</div>

<?php 

require_once('includes/footer.inc.php'); 

?>