<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');
require_once('includes/adminusercheck.inc.php');
require_once('includes/status_msg.inc.php');

?>

<body>

<?php 
require_once('includes/navbar.inc.php'); 
OutputNavBar("Schools");
?>

<br/>
<div class="container">
   <div class="row">
      <div class="col-xs-12">
         <?php DisplayStatusMessage($status_msg); ?>   
         <div class="btn-group">
               <a class="btn btn-primary"href="SchoolsPrintHandler.php">Printable Listing</a>
         </div>
      </div>
   </div>
   <div class="row"></br>
   </div>
</div>

<div class="container">
   <div class="row">
      <div class="col-xs-12 col-md-7">
         <div class="panel panel-primary">
            <div class="panel-heading">
               School Listing for All Events
            </div>
            <div class="panel-body">
               <div class="row">
                  <div class="col-xs-12">
                        <div class="table-responsive">
                           <table class="table table-condensed table-bordered table-hover set-bg" id="sortable-table">
                              <thead>
                                    <tr>
                                       <th>School ID</th>
                                       <th>School Name</th>
                                       <th>#Users </br><span id="total_users" class="badge">?</span></th>
                                       <th>#Runners </br><span id="total_runners" class="badge">?</span></th>
                                       <th>Change</th>
                                       <th>Delete</th>
                                    </tr>
                              </thead>
                              <tbody>
                                    <?php
                                       $usersObj = new UsersTable();
                                       $runnersObj = new RunnersTable();
                                       
                                       $schoolObj = new SchoolsTable();
                                       $schools = $schoolObj->ReadAll();
                                       $total_runners = 0;
                                       $total_users = 0;
                                       foreach ($schools as $school) {
                                          $school_id = $school['id'];
                                          
                                          $user_recs = $usersObj->ReadBySchoolID($school_id);
                                          $num_users = count($user_recs);

                                          $runners_recs = $runnersObj->ReadBySchoolID($school_id);
                                          $num_runners = count($runners_recs);

                                          $total = $num_users + $num_runners; 
                                          $total_users   += $num_users;
                                          $total_runners += $num_runners;
                                          echo "<tr>";
                                          echo "<td>" . $school['id']   . "</td>";
                                          echo "<td>" . $school['name'] . "</td>";
                                          echo "<td>" . $num_users . "</span></td>";
                                          echo "<td>" . $num_runners . "</td>";
                                          echo "<td>" . "<a class=\"btn btn-primary btn-xs\" href=\"SchoolsModifyForm.php?school_id=$school_id\">Change</a>" . "</td>";
                                          echo "<td>";
                                          if ($total == 0) 
                                          {
                                             echo "<a class=\"btn btn-primary btn-xs\" href=\"SchoolsDeleteHandler.php?school_id=$school_id\">Delete</a>"; 
                                          }
                                          else
                                          {
                                             echo "<span class=\"badge label label-danger\">Disabled: $total</span>";
                                          }
                                          echo "</td>";
                                          echo "</tr>";
                                       }
                                    ?>
                              </tbody>
                              <script>
                                    /* Update the total user and runner counts in the table header */
                                    span = document.getElementById("total_users");
                                    txt_node = document.createTextNode("<?php echo 'Total: ' . $total_users;?>");
                                    span.innerText = txt_node.textContent;

                                    span = document.getElementById("total_runners");
                                    txt_node = document.createTextNode("<?php echo 'Total: ' . $total_runners;?>");
                                    span.innerText = txt_node.textContent;
                              </script>
                           </table>
                        </div>
                  </div>
               </div>
            </div> <!-- panel-body -->
         </div> <!-- panel default -->
      </div>
      <div class="col-xs-12 col-md-5">
         <div class="panel panel-primary">
            <div class="panel-heading">
               <strong class="">Add School</strong>
            </div>
            <div class="panel-body">         
               <form class="form-horizontal" role="form" method="post" action="SchoolsAddHandler.php">
                  <div class="form-group">
                     <label for="school_name" class="col-sm-3 control-label">School Name</label>
                     <div class="col-sm-9">
                        <input type="text" class="form-control" maxlength="50"
                              id="school_name" name="school_name" 
                              placeholder="Unique School Name (50 chars max)"
                              pattern="[A-Za-z0-9 -\.,']{1,50}"
                              required>
                     </div>
                  </div>
                  <hr/>
                  <div class="form-group last">
                     <div class="col-xs-offset-3 col-xs-3">
                        <button type="submit" name="button" value="add" class="btn btn-primary btn-md">Submit</button>
                     </div>
                     <div class="col-xs-4 pull-right">
                        <input type="reset" class="form-control" name="reset_form" id="reset_form">
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

<?php 
require_once('includes/footer.inc.php'); 
?>