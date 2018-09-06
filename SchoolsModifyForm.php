<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');
require_once('includes/adminusercheck.inc.php');
require_once('includes/status_msg.inc.php');



// make sure the school_id is set
if (!isset($_REQUEST) || !isset($_REQUEST['school_id']))
{
    $status_msg = "Internal Error. Unable to  modify school!";
    header("location: SchoolsMain.php?status_msg=$status_msg");
    exit;
}

$school_id = $_REQUEST['school_id']; 
$schoolsObj = new SchoolsTable();
$schoolRec = $schoolsObj->Read($school_id);
if (empty($schoolRec)) {
    $status_msg = "Read Error. Unable to  find/read school record in the DB!: " . $schoolsObj->LastError();
    header("location: SchoolsMain.php?status_msg=$status_msg&alert_category=alert-danger");
    exit;
}

$school_name = $schoolRec['name'];

?>


<body>

<?php 
require_once('includes/navbar.inc.php'); 
OutputNavBar("Schools");
?>


<br>
<div class="container-fluid"></div><div class="container">
    <div class="row">
        <div class="col-xs-3"></div>
        <div class="col-xs-6 col-md-offsetx-7">
            <div class="panel panel-primary">
                <div class="panel-heading"> <strong class="">Modify School Name: <em><?php echo $school_name ?></em></strong>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="SchoolsModifyHandler.php">
                        <?php DisplayStatusMessage($status_msg); ?>
                    	<input type="hidden" id="school_id" name="school_id" 
                    	       value=<?php echo "\"" . $school_id . "\"" ?> >

                        <div class="form-group">
                            <label for="school_name" class="col-sm-2 control-label">School<br>Name</label>
                            <div class="col-sm-10">
								<input type="text" class="form-control" maxlength="50" 
										id="school_name" name="school_name" placeholder="Unique School Name (50 chars max)"
										value=<?php echo "\"" . $school_name . "\""; ?> 
                    					autofocus required>
                            </div>
                        </div>

                		<hr/>
                        <div class="form-group last">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" name="button" value="modify" class="btn btn-primary btn-md">Submit</button>
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