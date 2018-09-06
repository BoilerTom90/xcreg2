<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');
require_once('includes/adminusercheck.inc.php');
require_once('includes/status_msg.inc.php');


?>


<body>

<?php 
require_once('includes/navbar.inc.php'); 
OutputNavBar("Home");
?>

<br>
<div class="container">
    <div class="row">
        <div class="col-xs-3"></div>
        <div class="col-xs-6">
            <div class="btn-group">
                <a class="btn btn-primary" href="EventsMain.php">Cancel</a>
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
                <div class="panel-heading"> <strong class="">Add Event</strong>
                    
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="EventsAddHandler.php">
                        <?php DisplayStatusMessage($status_msg); ?>
                        <div class="form-group">
                            <label for="ev_name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="ev_name"  
                                    id="ev_name" placeholder="Event Name" maxlength=25 autofocus required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ev_date" class="col-sm-2 control-label">Date</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="ev_date"  
                                    id="ev_date" value="" placeholder="Event Date" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="reg_status" class="col-sm-2 control-label">Registration Status</label>
                            <div class="col-sm-10">
                                <select id="reg_status" name="reg_status" class="form-control" required>
                                    <?php OutputRegStatusChoices(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ev_contact_email" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="ev_contact_email"  
                                    id="ev_contact_email" value="" placeholder="Email">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ev_contact_phone" class="col-sm-2 control-label">Phone</label>
                            <div class="col-sm-10">
                                <input type="tel" class="form-control" name="ev_contact_phone"  
                                    id="ev_contact_phone" value="" placeholder="Phone">
                            </div>
                        </div>

                		<hr/>
                        <div class="form-group last">
                           <div class="col-sm-offset-2 col-sm-6">
                                <button type="submit" name="button" value="add" class="btn btn-primary btn-md">Submit</button>
                           </div>
                           <div class="col-sm-4">
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