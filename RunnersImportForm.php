<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');
//require_once('includes/adminusercheck.inc.php');



// $is_admin_user = (PHPSession::Instance()->GetSessionVariable('role') == "admin") ? true : false;


function OutputSchoolOptions()
{
    if (PHPSession::Instance()->GetSessionVariable('role') == "admin") 
    {
	   $event_db = PHPSession::Instance()->GetSessionVariable('event_db');
      $schools = ReadAllSchools($event_db, $last_error); 
	   foreach ($schools as $s) 
	   {
            $school_id = $s['school_id'];
            if ($school_id > 0) // School ID 0 is the default admin school, which no runners should be part of.
            {
		      $label = $s['school_name'];	
		      echo "<option name=\"school_id\" value=\"" . $school_id . "\">" . $label . "</option>";	
            }
	   }
    }
    else
    {
        $label = PHPSession::Instance()->GetSessionVariable('school_name');
        $school_id = PHPSession::Instance()->GetSessionVariable('school_id');
        echo "<option name=\"school_id\" value=\"" . $school_id . "\">" . $label . "</option>";
    }
}

?>

<?php 
require_once('includes/navbar.inc.php'); 
OutputNavBar("Runners");
?>

<br/>
<div class="container">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="btn-group">
                <a class="btn btn-primary" href="RunnersMain.php">Cancel</a>
            </div>
        </div>
    </div>
    <div class="row"></br></div>
</div>

<div class="container-fluid"></div>
<div class="container">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading"> <strong class="">Import Runners from CSV file</strong>
                   <div class="btn-group">
                      <a class="btn btn-success" href="./roster_template.xlsx">Download Excel Template</a>
                   </div>
                </div>
               <div class="panel-body">
                  <strong><em>Only use this Import ability to import, or re-import, your entire roster. During an Import, <span style="text-decoration: underline; color: red"> all runners for your school will first be removed from the system,</span> then the entries in your CSV file will be added. Be sure your CSV file contains all of your runners, and not a partial listing!</em></strong>
               </div>
                <div class="panel-body">
                    <form class="form-horizontal" 
                          role="form" 
                          method="post" 
                          enctype="multipart/form-data" 
                          action="RunnersImportHandler.php">
                        
                        <div class="form-group">
                            <label for="school_id" class="col-sm-3 control-label">School</label>
                            <div class="col-sm-6">
                                <select id="school_id" name="school_id" 
                                        class="form-control" required>
                                    <?php OutputSchoolOptions(); ?>
                                </select>
                            </div>
                        </div>

                       <div class="form-group">
                           <label for="csvfile" class="col-sm-3 control-label">Select File</label>
                          <div class="col-sm-6">
                              <input type="file" name="csvfile" placeholder="Select CSV File" style="width:100%; border:none;" data-trigger="focus"
                                     accept=".csv" required>
                          </div>
                       </div>
                       <hr>
                       <div class="panel-body">                        
                          <p><em>Use the inputs below to indicate which columns in the CSV file contain the
                             specified fields.  Do not change if your CSV file conforms to the suggested format!</em></p>
                       </div>
                       
                        <div class="form-group">
                            <label for="first_name_col" class="col-sm-3 control-label">First Name Column</label>
                            <div class="col-sm-6">
								       <input type="number" class="form-control" 
										  id="first_name_col" name="first_name_col" 
                                 placeholder="Column in CSV file where First Name is"
                                 min=1 value=1 step=1 required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="last_name_col" class="col-sm-3 control-label">Last Name Column</label>
                            <div class="col-sm-6">
                              <input type="number" class="form-control" 
										  id="last_name_col" name="last_name_col" 
                                 placeholder="Column in CSV file where Last Name is"
                                 min=1 value=2 step=1 required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="grade_col" class="col-sm-3 control-label">Grade Column</label>
                            <div class="col-sm-6">
								       <input type="number" class="form-control" min="3" max="8"
										     id="grade_col" name="grade_col" 
                                        placeholder="grade (3-8)"
                                        title="Enter Grade" 
                                        data-toggle="popover" data-trigger="focus" 
                                        data-content="Accepts a number between 3 and 8"
                                        value=3 required>
                            </div>
                        </div>   

                        <div class="form-group">
                            <label for="sex" class="col-sm-3 control-label">Sex Column</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" min="1" value="4"
										     id="sex_col" name="sex_col" 
                                 required>
                            </div>
                        </div>                     
                		<hr/>
                        <div class="form-group last">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" name="button" value="add" class="btn btn-primary btn-md">Submit</button>
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