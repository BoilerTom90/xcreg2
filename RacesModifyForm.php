<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');
require_once('includes/adminusercheck.inc.php');
require_once('includes/status_msg.inc.php');
require_once('includes/event_id.inc.php');

?>

<body>

<?php 
require_once('includes/navbar.inc.php'); 
OutputNavBar("Races");
?>

<?php

if (!isset($_REQUEST) || !isset($_REQUEST['race_id'])) {
   $sts = "Error! Invalid navigation to page.";
   header("location: RacesMainForm.php?status_msg=$sts&alert_category=alert-danger");
   exit;
}

$race_id = $_REQUEST['race_id'];
$raceObj = $raceObj = new RacesTable();
$race = $raceObj->Read($race_id);
if (empty($race)) {
   $sts = "Race is no longer in the system.";
   header("location: RacesMainForm.php?status_msg=$sts&alert_category=alert-danger");
   exit;
}
$distance = $race['distance'];
$description = $race['description'];

?>

<br/>

<!-- <div class="container">
   <div class="row">
      <div class="col-xs-6">
         <?php DisplayStatusMessage($status_msg); ?>
      </div>
   </div>
</div> -->

<div class="container">
   <div class="row">
      <div class="col-xs-12">
         <div class="container-fluid">
            <div class="row">
               <div class="col-xs-6 col-xs-offset-3">
                  <div class="panel panel-primary">
                     <div class="panel-heading"> 
                        <strong class="">Add Race</strong>     
                     </div>
                     <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="RacesModifyHandler.php">
                           <div class="form-group">

                              <input type="hidden" id="race_id" name="race_id" 
                    	               value=<?php echo "\"" . $race_id . "\"" ?> >

                              <label for="distance" class="col-sm-4 control-label">Distance</label>
                              <div class="col-sm-8">
                                 <input type="number" class="form-control" name="distance" value=<?php echo "\"" . $distance . "\"" ?>
                                    id="distance" placeholder="Distance" step=0.01 autofocus required>
                              </div>
                           </div>
                           <div class="form-group">
                              <label for="description" class="col-sm-4 control-label">Description</label>
                              <div class="col-sm-8">
                                 <input type="text" class="form-control" name="description" value=<?php echo "\"" . $description . "\"" ?>
                                    id="description" placeholder="Description (e.g. Boys 1.0 Mile)" maxlength=25 required>
                              </div>
                           </div>
                           <hr/>
                           <div class="form-group last">
                              <div class="col-sm-offset-4 col-sm-4">
                                 <button type="submit" name="button" value="add" class="btn btn-primary btn-md">Modify</button>
                              </div>
                              <div class="col-sm-4">
                                 <input type="reset" class="form-control" name="reset_form" id="reset_form">
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div> <!-- Outer Row -->
</div> <!-- Outer Container -->

<?php 

require_once('includes/footer.inc.php'); 

?>