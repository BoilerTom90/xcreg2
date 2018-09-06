<?php 
require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('classes/database.php');
require_once('includes/head.inc.php');

ini_set("auto_detect_line_endings", true);


// the expected information from the form is in the $_REQUEST variable
// 

//var_dump($_FILES);
//var_dump($_REQUEST);
//exit;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
   header("location: RunnersMain.php");
   exit;
}


function validateName($name) {
   // A-Z, a-z, 0-9, ., -, space
   $pattern = "#^[A-Za-z0-9 .\-]+$#";
   $result = preg_match($pattern, $name);
   return($result);
}

?>

<?php 
require_once('includes/navbar.inc.php'); 
OutputNavBar("Runners");
?>

<br/>
<div class="container">
    <div class="row">
        
        <div class="col-xs-10 col-xs-offset-1 pull-left">
            <div class="btn-group">
                <a class="btn btn-primary" href="RunnersImportForm.php">Back</a>
            </div>
        </div>
    </div>
    <div class="row"></br></div>
</div>

<div class="container">
    <div class="row">
       <div class="col-xs-10 col-xs-offset-1">
         <div class="panel panel-primary">
            <div class="panel-heading">
               <strong class="">Import Results</strong>
            </div>
            <div class="panel-body">
               <textarea style="padding: 8px; width: 100%; max-width: 100%; height: 500px; max-height: 500px; overflow:scroll;"><?php HandleRequest(); ?></textarea>
            </div>
       </div>
   </div>
</div>



<?php


function HandleRequest() {

   if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $event_db       = PHPSession::Instance()->GetSessionVariable('event_db');
      $school_id      = $_REQUEST['school_id'];
      $csvfile_name   = $_FILES['csvfile']['tmp_name'];
      $first_name_col = $_REQUEST['first_name_col'];
      $last_name_col  = $_REQUEST['last_name_col'];
      $grade_col      = $_REQUEST['grade_col'];
      $sex_col        = $_REQUEST['sex_col'];
      $last_error     = "";

      // Attempt to open the CSV file for processing:
      $rosterFileHandle = fopen($csvfile_name, "r") or exit("Unable to open file: " . $csvfile_name);
      $numErrors = 0;
      $lineNum = 0;
      $entriesProcessed = 0;

      DeleteRunnersBySchoolID($event_db, $school_id, $last_error);   

      while (($arr = fgetcsv($rosterFileHandle, 1000, ",")) !== FALSE)
      {
         $lineNum++;

         // skip the heading row
         if ($lineNum == 1) {
            continue; 
         } 

         $entriesProcessed++; 
         
         if (count($arr) < 4) {
            printf("[line: %d] skipped. no data found\n", $lineNum);
            $numErrors++;
         }
         
         if (count($arr) < max($first_name_col, $last_name_col, $grade_col, $sex_col)) {
            printf("[line: %d] Error. Requested column size > than columns found in row\n", $lineNum);
            $numErrors++;
            continue; 
         }

         $tFirstName = str_replace(",", "", strtoupper(trim($arr[$first_name_col-1])));
         $tLastName  = str_replace(",", "", strtoupper(trim($arr[$last_name_col-1])));
         $tGrade     = intval(str_replace(",", "", trim($arr[$grade_col-1])));
         $tSex       = str_replace(",", "", strtoupper(trim($arr[$sex_col-1])));


         if (($tFirstName == "") || !validateName($tFirstName)) {
            printf("[line: %d] Error! Unsupported characters found in First Name: %s\n", $lineNum, trim($arr[$first_name_col-1]));
            $numErrors++;
            continue;
         }

         if (($tLastName == "") || !validateName($tLastName)) {
            printf("[line: %d] Error! Unsupported characters found in Last Name: %s\n", $lineNum, trim($arr[$last_name_col-1]));
            $numErrors++;
            continue;
         }

         if (($tGrade < 3) || ($tGrade > 8)) {
            printf("[line: %d] Error! Invalid Grade: %s\n", $lineNum, trim($arr[$grade_col-1]));
            $numErrors++;
            continue;
         }

         if (($tSex == "F") || ($tSex == "FEMALE") || ($tSex == "G") || ($tSex == "GIRL")) {
            $tSex = "F";
         } else if (($tSex == "M") || ($tSex == "MALE") || ($tSex == "B") || ($tSex == "BOY")) {
            $tSex = "M";
         } else {
            printf("[line: %d] Error! Invalid Sex Value: %s\n", $lineNum, trim($arr[$sex_col-1]));
            $numErrors++;
            continue;
         }

         $num_rows_affected = AddRunner($event_db, $school_id, $tFirstName, $tLastName, $tGrade, $tSex, $last_error);
         if ($num_rows_affected >= 0) {
            // printf("[line: %d] Added Runner: %s, %s, %d, %s\n", $lineNum, $tFirstName, $tLastName, $tGrade, $tSex);
         } else { 
            $numErrors++;
            printf("[line: %d] Error Adding Runner: %s, %s, %d, %s\n", $lineNum, $tFirstName, $tLastName, $tGrade, $tSex);
            printf("%s\n", $last_error);
            $numErrors++;
         }   
      }
   }
   
   if ($numErrors > 0) {
      printf("*** Errors Found: %d\n\n", $numErrors);
      printf("\n\nPlease fix the errors in your CSV file and import the entire file again!\n\n");
      printf("First and Last Names must be alpha numeric characters (A-Z and 0-9).\n");
      printf("The Grade value must be between 3 and 8 inclusive\n");
      printf("The Sex valuse must be one of the following: F, M, Female, Male, G, B, Girl, Boy\n");
   } else {
      printf("No errors were found!\n");
      printf("Number of runners processed: %d\n", $entriesProcessed);
   }
}

?>

<?php 
require_once('includes/footer.inc.php'); 
?>