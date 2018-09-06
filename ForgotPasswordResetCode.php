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

// in the request should be
// email, reset_code, and optionally a status_msg

$email = "fubar@fubar.com";
$reset_code = '';

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
                <div class="panel-heading"> <strong class="">Enter Password Reset Code</strong><br>
                <em style="font-size:smaller">Enter your email and password reset code in the form below and click Submit.</em>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="ForgotPasswordResetCodeHandler.php">
                        <?php DisplayStatusMessage($status_msg); ?>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" class="form-control" id="email" value="<?php echo $email; ?>" placeholder="email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="reset_code" class="col-sm-2 control-label">Reset Code</label>
                            <div class="col-sm-10">
                                <input type="number" value=<?php echo $reset_code; ?> name="reset_code" class="form-control" id="reset_code" placeholder="reset code" required>
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
                                <button id="submitButton" type="submit" name="button" value="fgtpwd" 
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
   
   var siteKey = '6Lds-mcUAAAAAAoOoz1jA7XNm88G-dMs60Ub7OZe';

   var verifyCallback = function(response) {

         document.getElementById('captcha-response').value = response;
         document.getElementById('submitButton').disabled = false;         
      };

   var onloadCallback = function() {
      grecaptcha.render('captcha_element', {
         'sitekey' : '6Lds-mcUAAAAAAoOoz1jA7XNm88G-dMs60Ub7OZe',
         'callback': verifyCallback
      });
   };
</script>

<?php 
require_once('includes/footer.inc.php'); 
?>