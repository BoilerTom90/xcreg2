

<div class="panel panel-primary">
   <div class="panel-heading">
      <strong class="">Login to register your team</strong>
   </div>
   <div class="panel-body">
      <form class="form-horizontal" role="form" action="LoginFormHandler.php">
        <?php DisplayStatusMessage($status_msg); ?>
                
         <div class="form-group">
               <label for="event_id" class="col-sm-3 control-label">Event</label>
               <div class="col-sm-9">
                  <select id="event_id" name="event_id" class="form-control">
                     <?php OutputEventChoices(); ?>
                  </select>
               </div>
         </div>

        <div class="form-group">
            <label for="email" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-9">
               <input type="email" class="form-control" name="email" value="" id="email" placeholder="Email" required="required">
            </div>
         </div>
         <div class="form-group">
            <label for="password" class="col-sm-3 control-label">Password</label>
            <div class="col-sm-9">
               <input type="password" class="form-control" name="password" value="" id="password" placeholder="enter password" required="required">
            </div>
         </div>
         <div class="form-group last">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
               <button type="submit" class="btn btn-primary btn-md" name="button" value="login">login</button>
            </div>
         </div>
      </form>
   </div>
   
   <div class="panel-footer">
      <div>
         <a class="btn btn-link btn-xs" href="ForgotPasswordForm.php">Forgot Password</a>&nbsp;|&nbsp;
         <a class="btn btn-link btn-xs" href="RequestAccount.php">Request Account</a>
      </div>
      
   </div>
</div>
