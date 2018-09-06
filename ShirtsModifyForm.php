<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');

$event_db    = PHPSession::Instance()->GetSessionVariable('event_db'); 
$role        = PHPSession::Instance()->GetSessionVariable('role');
$school_name = PHPSession::Instance()->GetSessionVariable('school_name');
$school_id   = PHPSession::Instance()->GetSessionVariable('school_id');


if (!isset($_REQUEST))
{
    header("location: ShirtsMain.php?status_msg='Unauthorized'");
    exit;
}

// if this is not an admin user, the school_id in the request must match the school_id
// stored in the session
$request_school_id = $_REQUEST['school_id']; 
if (($role == "user") && ($school_id != $request_school_id))
{
    header("location: ShirtsMain.php?status_msg='You are not authorized to modify that information'");
    exit;
}

$shirts = ReadShirtsBySchoolId($event_db, $request_school_id, $last_error);
if (empty($shirts))
{
    $shirts['num_youth_medium'] = 0;
    $shirts['num_youth_large'] = 0;
    $shirts['num_adult_small'] = 0;
    $shirts['num_adult_medium'] = 0;
    $shirts['num_adult_large'] = 0;
    $shirts['num_adult_xl'] = 0;
    $shirts['num_adult_xxl'] = 0;
}  


function OutputSchoolOption($request_school_id)
{
    global $event_db;

    $school_info = ReadSchoolByID($event_db, $request_school_id, $last_error); // need school name
    $school_name = $school_info['school_name'];
    echo "<option name=\"school_id\" value=\"" . $school_name . "\">" . $school_name . "</option>";
}

$status_msg = "";
if (isset($_REQUEST['status_msg']) && strlen($_REQUEST['status_msg'])) 
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
                <a class="btn btn-primary" href="ShirtsMain.php">Back</a>
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
                <div class="panel-heading"> <strong class="">Modify Shirts</strong>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="ShirtsModifyHandler.php">
                        <?php DisplayStatusMessage($status_msg); ?>
                        <input type="hidden" id="school_id" name="school_id" 
                               value=<?php echo "\"" . $request_school_id . "\"" ?> >

                        <div class="form-group">
                            <!-- <label for="school" class="col-sm-6 control-label">School</label> -->
                            <div class="col-sm-12">
                                <select id="school_name" name="school_name" class="form-control" disabled>
                                    <?php OutputSchoolOption($request_school_id); ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="youth_medium" class="col-sm-6 control-label">Number Youth Medium</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" min="0"
                                		id="youth_medium" name="youth_medium" placeholder="Number Shirts of this size"
                                		value=<?php echo "\"" . $shirts['num_youth_medium'] . "\"" ?> 
                                        required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="youth_large" class="col-sm-6 control-label">Number Youth Large</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" min="0"
                                        id="youth_large" name="youth_large" placeholder="Number Shirts of this size"
                                        value=<?php echo "\"" . $shirts['num_youth_large'] . "\"" ?> 
                                        required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="adult_small" class="col-sm-6 control-label">Number Adult Small</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" min="0"
                                        id="adult_small" name="adult_small" placeholder="Number Shirts of this size"
                                        value=<?php echo "\"" . $shirts['num_adult_small'] . "\"" ?> 
                                        required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="adult_medium" class="col-sm-6 control-label">Number Adult Medium</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" min="0"
                                        id="adult_medium" name="adult_medium" placeholder="Number Shirts of this size"
                                        value=<?php echo "\"" . $shirts['num_adult_medium'] . "\"" ?> 
                                        required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="adult_large" class="col-sm-6 control-label">Number Adult Large</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" min="0"
                                        id="adult_large" name="adult_large" placeholder="Number Shirts of this size"
                                        value=<?php echo "\"" . $shirts['num_adult_large'] . "\"" ?> 
                                        required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="adult_xlarge" class="col-sm-6 control-label">Number Adult X-Large</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" min="0"
                                        id="adult_xlarge" name="adult_xlarge" placeholder="Number Shirts of this size"
                                        value=<?php echo "\"" . $shirts['num_adult_xl'] . "\"" ?> 
                                        required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="adult_xxlarge" class="col-sm-6 control-label">Number Adult XX-Large</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" min="0"
                                        id="adult_xxlarge" name="adult_xxlarge" placeholder="Number Shirts of this size"
                                        value=<?php echo "\"" . $shirts['num_adult_xxl'] . "\"" ?> 
                                        required>
                            </div>
                        </div>

                        <hr/>
                        <div class="form-group last">
                            <div class="col-sm-offset-6 col-sm-6">
                                <button type="submit" name="button" value="modify" class="btn btn-primary btn-md">Save</button>
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