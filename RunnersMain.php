<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');
require_once('includes/status_msg.inc.php');
require_once('classes/Constants.php');
require_once('includes/event_id.inc.php');  

$event_id = PHPSession::Instance()->GetSessionVariable('event_id');
$evObj = new EventsTable();
$event = $evObj->Read($event_id);
$ev_name = $event['ev_name'];


?>

<body>

<?php 
require_once('includes/navbar.inc.php'); 
OutputNavBar("Runners");
?>

<br>
<div class="container">
    <div class="row">
        <div class="col-xs-6">
           <div>
               <a class="btn btn-primary" href="RunnersAddForm.php">Add Runner</a>
               <!-- <a class="btn btn-primary btn-md" href="RunnersImportForm.php">Import Runners From CSV File</a> -->
           </div>
         </div>
         <div class="col-xs-6">
           <div class="pull-right">
               <a class="btn btn-primary" href="RunnersPrintForm.php">Printable Listing</a>
            </div>
        </div>
    </div>
    <div class="row"></br></div>
</div>



<!-- Display a table with all of the runners in them. 
     For admin users, list all runners.
     For non-admin users, list runners just for their school
-->

<div class="container">
<div class="panel panel-primary">
<div class="panel-heading">Runner Listing for Event: <span style="color:red; font-weight:bold; font-size:larger"><?php echo $ev_name; ?></span>
   <br>
      <em>Any runner listed below is a confirmed runner for the event!</em>
</div>
<div class="panel-body">
    <div class="row">
        <div class="col-xs-12">
            <?php DisplayStatusMessage($status_msg); ?>
            <a href="#" data-toggle="tooltip" data-placement="right" title="Click on column heading to sort by that column!">Sorting Tip</a><br/>
            <div class="table-responsive">
                <table class="table table-condensed table-bordered table-hover set-bg" id="sortable-table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>School</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Grade</th>
                        <th>Sex</th>
                        <th>Race</th>
                        <th>Change</th>
                        <th>Delete</th>
                    </tr>
   	                </thead>
                    <tbody>
                     <?php 
                        $racesObj = new RacesTable();
                        $eventsObj = new EventsTable();
                        $schoolsObj = new SchoolsTable();

                        $runners = GetRunnerListing();
                        $count = 0;
                        foreach ($runners as $runner) 
                        {
                           $runner_id = $runner['runner_id'];
                           $race_id = $runner['race_id'];
                           $school_id = $runner['school_id'];

                           $schoolRec = $schoolsObj->Read($school_id);
                           $schoolName = $schoolRec['name'];

                           $raceRec = $racesObj->Read($race_id);
                           $raceDistance = $raceRec['distance'];
                           $race_description = $raceRec['description'];
                        
                           $event_id = $raceRec['event_id'];
                           $eventRec = $eventsObj->Read($event_id);
                           $eventName = $eventRec['ev_name'];

                           $count++;
                           echo "<tr>";
                           echo "<td>" . $count . "</td>";
                           echo "<td>" . $schoolName . "</td>";
                           echo "<td>" . $runner['first_name'] . "</td>";
                           echo "<td>" . $runner['last_name'] . "</td>";
                           echo "<td>" . $runner['grade'] . "</td>";
                           echo "<td>" . $runner['sex'] . "</td>";
                           echo "<td>" . $race_description . "</td>";
                           
                           echo "<td>" . "<a class=\"btn btn-primary btn-xs\" href=\"RunnersModifyForm.php?runner_id=$runner_id\"><span>Change</span></a>" . "</td>";
                           echo "<td>" . "<a class=\"btn btn-primary btn-xs\" href=\"RunnersDeleteForm.php?runner_id=$runner_id\"><span>Delete</span></a>" . "</td>";
                           echo "</tr>";
                        }
                     ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php 
require_once('includes/footer.inc.php'); 
?>