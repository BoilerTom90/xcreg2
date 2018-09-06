<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');
require_once('includes/adminusercheck.inc.php');
require_once('includes/status_msg.inc.php');
require_once('classes/Constants.php');


?>

<?php 
require_once('includes/navbar.inc.php'); 
OutputNavBar("Users");
?>


<br/>
<div class="container">
    <div class="row">
        <div class="col-xs-3"></div>
        <div class="col-xs-9">
            <div class="btn-group">
                <a class="btn btn-primary" href="UsersMain.php">Cancel</a>
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
                <div class="panel-heading"> <strong class="">Add User</strong>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="UsersAddHandler.php">
                        <?php DisplayStatusMessage($status_msg); ?>
                        <div class="form-group">
                            <label for="school_id" class="col-sm-2 control-label">School</label>
                            <div class="col-sm-10">
                                <select id="role" name="school_id" class="form-control" required>
                                    <?php OutputSchoolChoices(null, 1); ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" class="form-control" id="email" placeholder="email" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="role" class="col-sm-2 control-label">Role</label>
                            <div class="col-sm-10">
                                <select id="role" name="role" class="form-control" required>
                                    <?php OutputRoleChoices(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10">
                                <select id="status" name="status" class="form-control" required>
                                    <?php OutputUserStatusChoices(); ?>
                                </select>
                            </div>
                        </div>
                    
                		<hr/>
                        <div class="form-group last">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" name="button" value="add" 
                                        class="btn btn-primary btn-md">Submit</button>
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