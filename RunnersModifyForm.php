<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');
require_once('classes/Constants.php');

// given the runner ID, retrieve the most recent information
$runner_id = $_REQUEST['runner_id']; 
$runnersObj = new ComplexQueries();
$runner = $runnersObj->ReadRunnerByRunnerID($runner_id);
//var_dump($runner); exit;

if (empty($runner)) {
    $sts = "Runner no longer exists in system <br>" . $runnersObj->LastError();
    header("location: RunnersMain.php?status_msg=$sts&alert_category=alert-danger");
    exit;
} 

$school_id   = $runner['school_id'];
$school_name = $runner['school_name'];
$first_name  = $runner['first_name'];
$last_name   = $runner['last_name'];
$grade       = $runner['grade'];
$sex         = $runner['sex'];
$race_id     = $runner['race_id'];
$race_description = $runner['race_description'];

$maleSelected   = ($sex == RunnerSexValues::Boy) ? "checked" : "";
$femaleSelected = ($sex == RunnerSexValues::Girl) ? "checked" : "";

?>


<body>

<?php 
require_once('includes/navbar.inc.php'); 
OutputNavBar("Runners");
?>

<br>
<div class="container">
    <div class="row">
        <div class="col-xs-3"></div>
        <div class="col-xs-9">
            <div class="btn-group">
                <a class="btn btn-primary" href="RunnersMain.php">Cancel</a>
            </div>
        </div>
    </div>
    <div class="row"></br></div>
</div>

<div class="container-fluid"></div><div class="container">
    <div class="row">
        <div class="col-xs-3"></div>
        <div class="col-xs-6 col-md-offsetx-7">
            <div class="panel panel-primary">
                <div class="panel-heading"> <strong class="">Modify Runner</strong>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="RunnersModifyHandler.php">
                    	
                        <input type="hidden" id="runner_id" name="runner_id" 
                    	       value=<?php echo "\"" . $runner_id . "\"" ?> >

                        <div class="form-group">
                            <label for="school" class="col-sm-3 control-label">School</label>
                            <div class="col-sm-9">
                                <select id="school" name="school_id" class="form-control" required autofocus>
                                    <?php OutputSchoolChoices($school_id); ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="first_name" class="col-sm-3 control-label">First</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" 
                                		id="first_name" name="first_name" placeholder="First Name"
                                		value=<?php echo "\"" . $first_name . "\"" ?> 
                    					   title="Enter First Name" 
                                    pattern="[A-Za-z0-9 -\.]{1,25}"
                                    data-toggle="popover" data-trigger="focus" 
                                    data-content="Accepts up to 25 characters: alphanumeric, space, hyphen, or period."
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="last_name" class="col-sm-3 control-label">Last</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" 
                                		id="last_name" name="last_name" placeholder="Last Name"
                                		value=<?php echo "$last_name" ?> 
                    					   title="Enter Last Name" 
                                    pattern="[A-Za-z0-9 -\.]{1,25}"
                                    data-toggle="popover" data-trigger="focus" 
                                    data-content="Accepts up to 25 characters: alphanumeric, space, hyphen, or period."
                                    required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="grade" class="col-sm-3 control-label">Grade</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control"  min="3" max="8"
                                		id="grade" name="grade" placeholder="8"
                                		value=<?php echo "\"" . $grade . "\"" ?> 
                    					title="Enter Grade" 
                                        data-toggle="popover" data-trigger="focus" 
                                        data-content="Accepts a number between 3 and 8"
                                        required> 
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="gender" class="col-sm-3 control-label">Sex</label>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    <input type="radio" name="sex" value="<?php echo RunnerSexValues::Boy ?>" required <?php echo $maleSelected ?> >Boy
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="sex" value="<?php echo RunnerSexValues::Girl ?>" required <?php echo $femaleSelected ?> >Girl
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                           <label for="race_id" class="col-sm-3 control-label">Race</label>
                           <div class="col-sm-9">
                              <select id="race_id" name="race_id" class="form-control" required>
                                    <?php echo OutputRaceChoices(PHPSession::Instance()->GetSessionVariable('event_id')); ?>
                              </select>
                           </div>
                        </div>

                		<hr/>
                        <div class="form-group last">
                            <div class="col-sm-offset-3 col-sm-3">
                                <button type="submit" name="button" value="modify" class="btn btn-primary btn-md">Modify Runner</button>
                            </div>
                            <div class="col-sm-offset-3 col-sm-3">
                               <input type="reset" class="form-control" name="reset_form" id="reset_form">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xs-3"></div>
    </div>
</div>


<?php 
require_once('includes/footer.inc.php'); 
?>