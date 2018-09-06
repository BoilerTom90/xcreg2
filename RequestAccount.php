<?php 

require_once('classes/PHPSession.php');
require_once('includes/head.inc.php');
require_once('classes/Constants.php');
require_once('includes/status_msg.inc.php');

PHPSession::Instance()->StartSession();

?>

<?php 
require_once('includes/navbar.inc.php'); 
OutputNavBar("Home");
?>


<br/>
<div class="container">
    <div class="row">
        <div class="col-xs-3"></div>
        <div class="col-xs-9">
            <div class="btn-group">
                <a class="btn btn-primary" href="index.php">Cancel</a>
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
                <div class="panel-heading"> <strong class="">Request Account</strong>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="RequestAccountHandler.php">
                        <?php DisplayStatusMessage($status_msg); ?>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" class="form-control" id="email" placeholder="email" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Confirm Email</label>
                            <div class="col-sm-10">
                                <input type="email" name="confirmed-email" class="form-control" id="confirmed-email" placeholder="email" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="role" class="col-sm-2 control-label">School</label>
                            <div class="col-sm-10">
                              <input type="text" name="school" class="form-control" id="school" minlength="12" maxlength="50" placeholder="school name and location" required>
                            </div>
                        </div>

                        <div class="form-group">
                        <input style="display:none" type="text" name="captcha-response" id="captcha-response" value="fdf">
                        </div>

                        <!-- captcha widget to stop bots -->
                        <div class="form-group">
                           <div class="col-sm-offset-2 col-sm-10">
                              <div id="captcha_element"></div>
                           </div>
                        </div>

                		<hr/>
                        <div class="form-group last">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button id="submitButton" type="submit" name="button" value="add" 
                                        class="btn btn-primary btn-md" disabled>Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xs-3"></div>
    </div>
</div>

<script  src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" 
         async 
         defer>
</script>

<script type="text/javascript">


   var verifyCallback = function(response) {

         document.getElementById('captcha-response').value = response;
         document.getElementById('submitButton').disabled = false;         
      };

   var onloadCallback = function() {
      grecaptcha.render('captcha_element', {
         'sitekey' : '6LfrwG0UAAAAACPLFc4VO6t0DlElZhF6_8VK0mQg',
         'callback': verifyCallback
      });
   };
</script>

<?php 
require_once('includes/footer.inc.php'); 
?>