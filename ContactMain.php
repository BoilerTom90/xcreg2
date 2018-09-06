<?php 

require_once('classes/PHPSession.php');
require_once('includes/head.inc.php');
require_once('includes/status_msg.inc.php');

PHPSession::Instance()->StartSession();

?>

<body>

<?php 
require_once('includes/navbar.inc.php'); 
OutputNavBar("Home");
?>
<br/>

<div class="container">
    <div class="row">
       <div class="col-xs-8 col-xs-offset-2">
            <?php DisplayStatusMessage($status_msg); ?>
            <div class="panel panel-primary">
                <div class="panel-heading"> 
                   <strong class="">Contact Administrator</strong>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" 
                          role="form" 
                          method="post" 
                          enctype="multipart/form-data" 
                          action="ContactHandler.php">
                       
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Your Email </label>
                            <div class="col-sm-10">
                                <input type="email" name="email" class="form-control" id="email" placeholder="your email" required>
                            </div>
                        </div>
                       <div class="form-group">
                            <label for="email2" class="col-sm-2 control-label">Your Email (confirmed)</label>
                            <div class="col-sm-10">
                                <input type="email" name="email2" class="form-control" id="email2" placeholder="your email (confirmed)" required>
                            </div>
                       </div>
                       
                       
                       <div class="form-group">
                            <label for="school" class="col-sm-2 control-label">School Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="school" class="form-control" id="school" placeholder="School Name (e.g. St. Mark)" required>
                            </div>
                       </div>
                       
                       <div class="form-group">
                            <label for="city" class="col-sm-2 control-label">School City</label>
                            <div class="col-sm-10">
                                <input type="text" name="city" class="form-control" id="city" placeholder="City (e.g. Decatur)" required>
                            </div>
                       </div>
                       
                       <div class="form-group">
                            <label for="state" class="col-sm-2 control-label">School State</label>
                            <div class="col-sm-10">
                                <input type="text" maxlength="2" size="2" name="state" class="form-control" id="state" placeholder="State (e.g. IN)" required>
                            </div>
                       </div>

                       <div class="form-group">
                           <label for="message" class="col-sm-2 control-label">Your Message</label>
                          <div class="col-sm-10">
                              <textarea style="resize:none; overflow:scroll;" id="message" class="form-control" rows="5" name="message" placeholder="Enter your message here..." ></textarea>
                          </div>
                       </div>
                       
                        <div class="form-group last">
                            <div class="col-sm-offset-2 col-sm-8">
                                <button type="submit" name="button" value="add" class="btn btn-primary btn-md">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once('includes/footer.inc.php') ?>