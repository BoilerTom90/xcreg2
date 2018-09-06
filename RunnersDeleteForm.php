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

<div class="container">
    <div class="row">
        <div class="col-xs-3"></div>
        <div class="col-xs-6 col-md-offsetx-7">
            <div class="panel panel-primary">
                <div class="panel-heading"> <strong class="">Confirm Delete Runner</strong>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="RunnersDeleteHandler.php">
                    	
                        <input type="hidden" id="runner_id" name="runner_id" 
                    	       value=<?php echo "\"" . $runner_id . "\"" ?> >

                        <div class="form-group">
                            <label for="school_name" class="col-sm-3 control-label">School Name</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" 
                                		id="school_name" name="school_name" 
                                		value=<?php echo "\"" . $school_name . "\"" ?> 
                    					disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="first_name" class="col-sm-3 control-label">First Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" 
                                		id="first_name" name="first_name"
                                		value=<?php echo "\"" . $first_name . "\"" ?> 
                    					disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="last_name" class="col-sm-3 control-label">Last Namme</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" 
                                		id="last_name" name="last_name"
                                		value=<?php echo "$last_name" ?> 
                    					disabled>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="grade" class="col-sm-3 control-label">Grade</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" 
                                		id="grade" name="grade"
                                		value=<?php echo "\"" . $grade . "\"" ?> 
                    					disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="gender" class="col-sm-3 control-label">Sex</label>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    <input type="radio" name="sex" value="M" disabled
                                        <?php echo $maleSelected ?> >Male
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="sex" value="F" disabled
                                        <?php echo $femaleSelected ?> >Female
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="race" class="col-sm-3 control-label">Race</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" 
                                		id="race" name="race"
                                		value=<?php echo "\"" . $race_description . "\"" ?> 
                    					disabled>
                            </div>
                        </div>

                		<hr/>
                        <div class="form-group last">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" name="button" value="delete" class="btn btn-primary btn-md">Delete Runner</button>
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