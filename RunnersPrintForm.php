<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');

?>

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
                <div class="panel-heading"> <strong class="">Print Runner Listing</strong><br>
                  <em>Any runner listed in the printed listing is a confirmed runner for the event!</em>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" target="_blank" action="RunnersPrintHandler.php">

                        <div class="form-group">
                            <label for="format" class="col-sm-2 control-label">Format</label>
                            <div class="col-sm-10">
                                <label class="radio-inline"><input type="radio" name="format" value="csv" required>CSV</label>
                                <label class="radio-inline"><input type="radio" name="format" value="table" required>Table</label>
                            </div>
                        </div>                     
                		
                        <hr/>

                        <div class="form-group last">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" name="button" value="print" class="btn btn-primary btn-md">Print</button>
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