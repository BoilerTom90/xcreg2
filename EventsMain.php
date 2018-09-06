<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');
require_once('includes/adminusercheck.inc.php');
require_once('includes/status_msg.inc.php');

?>

<body>

<?php 
require_once('includes/navbar.inc.php'); 
OutputNavBar("Events");
?>

<br/>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="btn-group">
                    <a class="btn btn-primary" href="EventsAddForm.php">Add Event</a>
            </div>
        </div>
    </div>
    <div class="row"></br></div>
</div>

<div class="container">
<div class="panel panel-primary">
<div class="panel-heading">Event Listing</div>
<div class="panel-body">
    <div class="row">
        <div class="col-xs-12">
            <?php DisplayStatusMessage($status_msg); ?>
            <div class="table-responsive">
                <table class="table table-condensed table-bordered table-hover set-bg" id="sortable-table">
                    <thead>
                        <tr>
                           <th>ID</th>
                           <th>Name</th>
                           <th>Date</th>
                           <th>Reg Status</th>
                           <th>Contact</th>
                           <th>Properties</th>
                           <th>Races</th>
                           <th>Runners</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                           $eventsObj = new EventsTable();
                           $events = $eventsObj->ReadAll();
                           if (!empty($events)) {
                              foreach ($events as $ev) {
                                 $ev_id = $ev['id'];
                                 $racesObj = new RacesTable();
                                 $races = $racesObj->ReadByEvent($ev_id); 
                                 $raceCount = empty($races) ? 0 : count($races);
                                 $cqObj = new ComplexQueries();
                                 $runnersForEvent = $cqObj->ReadRunnersByEventID($ev_id);
                                 $runnerCount = count($runnersForEvent);
                                 echo "<tr>";
                                 echo "<td>" . $ev_id . "</td>";
                                 echo "<td>" . $ev['ev_name'] . "</td>";
                                 echo "<td>" . $ev['ev_date'] . "</td>";
                                 echo "<td>" . $ev['ev_reg_status'] . "</td>";
                                 echo "<td>" . $ev['ev_contact_email'] . "</br>" . $ev['ev_contact_phone'] . "</td>";
                                 echo "<td>" . "<a class=\"btn btn-primary btn-xs\" href=\"EventsModifyForm.php?event_id=$ev_id\">Manage</a>" . "</td>";
                                 echo "<td>" . "<a class=\"btn btn-primary btn-xs\" href=\"RacesMainForm.php?event_id=$ev_id\">Manage <span class=\"badge\">$raceCount</span></a>" . "</td>";
                                 echo "<td>" . "<a class=\"btn btn-primary btn-xs\" href=\"RunnersMain.php?event_id=$ev_id\">Manage <span class=\"badge\">$runnerCount</span></a>" . "</td>";
                                 echo "</tr>";
                              }
                           }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> <!-- panel-body -->
</div> <!-- panel default -->
</div>

<?php 

require_once('includes/footer.inc.php'); 

?>