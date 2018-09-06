<?php 
require_once('classes/DBAccess.php');
require_once('classes/Constants.php');
require_once('classes/passwordLib.php');
require_once('classes/PHPSession.php');
PHPSession::Instance()->StartSession();

$ua = array();
   $ua[] = array('email' => 'aarriazola@sbcglobal.net'	,	'school' => 'ST ANDREWS, PARK RIDGE, IL' );
   $ua[] = array('email' => 'amonkemeyer@concordiapeoria.com'	,	'school' => 'CONCORDIA, PEORIA, IL' );
   $ua[] = array('email' => 'amyshulfer@comcast.net'	,	'school' => 'IMMANUEL, CRYSTAL LAKE, IL' );
   $ua[] = array('email' => 'andreamcc@rocketmail.com'	,	'school' => 'CHRIST THE KING, SOUTHGATE, MI' );
   $ua[] = array('email' => 'arndtp@live.com'	,	'school' => 'ST PAUL, LAKE MILLS, WI' );
   $ua[] = array('email' => 'athletics@trinityct.org'	,	'school' => 'TRINITY, CLINTON TOWNSHIP,  MI' );
   $ua[] = array('email' => 'balbers@ccls-stlouis.org'	,	'school' => 'CHRIST COMMUNITY, KIRKWOOD, MO' );
   $ua[] = array('email' => 'ben@splco.org'	,	'school' => 'ST PAUL, OCONOMOWOC, WI' );
   $ua[] = array('email' => 'bknoeck5@hotmail.com'	,	'school' => 'PEACE, HARTFORD, WI' );
   $ua[] = array('email' => 'bonnie.wittman@allstate.com'	,	'school' => 'ST PETER, COLUMBUS, IN' );
   $ua[] = array('email' => 'brn@splco.org'	,	'school' => 'ST PAUL, OCONOMOWOC, WI' );
   $ua[] = array('email' => 'bwb4d@allstate.com'	,	'school' => 'ST PETER, COLUMBUS, IN' );
   $ua[] = array('email' => 'celia.shaughnessy@ascension.org'	,	'school' => 'ST PAUL, GRAFTON, WI' );
   $ua[] = array('email' => 'choeppner@stmichaelsrichville.org'	,	'school' => 'ST MICHAELS, RICHVILLE, MI' );
   $ua[] = array('email' => 'ckonieczny7@gmail.com'	,	'school' => 'OUR SAVIOR, LANSING, MI' );
   $ua[] = array('email' => 'cohara@stpaulannarbor.org'	,	'school' => 'ST PAUL, ANN ARBOR, MI' );
   $ua[] = array('email' => 'conlon30@aol.com'	,	'school' => 'MORNING STAR, JACKSON, WI' );
   $ua[] = array('email' => 'corneliuskarla@gmail.com'	,	'school' => 'ST PAUL, JACKSON, MO' );
   $ua[] = array('email' => 'dan.ebeling@wlc.edu'	,	'school' => 'ST JOHN, WAUWATOSA, WI' );
   $ua[] = array('email' => 'danjan9@frontier.com'	,	'school' => 'ST JOHN, CAMPBELLSPORT, WI' );
   $ua[] = array('email' => 'daveredden50@gmail.com'	,	'school' => 'TRINITY, EDWARDSVILLE, IL' );
   $ua[] = array('email' => 'dbloomquist@starofbethlehem.org'	,	'school' => 'STAR BETHLEHEM, NEW BERLIN, WI' );
   $ua[] = array('email' => 'dheck@trinityutica.com'	,	'school' => 'TRINITY, UTICA, MI' );
   $ua[] = array('email' => 'diane.hinck@luthed.org'	,	'school' => 'ZION, MARENGO, IL' );
   $ua[] = array('email' => 'dickerson2105@gmail.com'	,	'school' => 'ST JOHN, LOMBARD, IL' );
   $ua[] = array('email' => 'dkirchhoff@immlutheran.org'	,	'school' => 'IMMANUEL, MACOMB, MI' );
   $ua[] = array('email' => 'dladuevargas@msn.com'	,	'school' => 'TRINITY ACADEMY, HUDSON, WI' );
   $ua[] = array('email' => 'drkellywolf@gmail.com'	,	'school' => 'ST JOHN, MUKWONAGO, WI' );
   $ua[] = array('email' => 'drose@stjohnswestbend.org'	,	'school' => 'ST JOHN, WEST BEND, WI' );
   $ua[] = array('email' => 'eeverts@fils.org'	,	'school' => 'FIRST IMMANUEL, CEDARBURG, WI' );
   $ua[] = array('email' => 'erikabeck16@hotmail.com'	,	'school' => 'ST JOHN, CORCORAN, MN' );
   $ua[] = array('email' => 'f16ratt@mac.com'	,	'school' => 'OUR SAVIOR, SPRINGFIELD, IL' );
   $ua[] = array('email' => 'gmeier@abidingsaviorlutheran.org'	,	'school' => 'ABIDING SAVIOR, ST LOUIS, MO' );
   $ua[] = array('email' => 'grebernick@mountcalvarywaukesha.org'	,	'school' => 'MT CALVARY, WAUKESHA, WI' );
   $ua[] = array('email' => 'gundermanns@yahoo.com'	,	'school' => 'CENTRAL, ST PAUL, MN' );
   $ua[] = array('email' => 'iobserver0777@gmail.com'	,	'school' => 'TRINITY 1ST, MINNEAPOLIS, MN' );
   $ua[] = array('email' => 'jboldt@trinitylutheranmonroe.org'	,	'school' => 'TRINITY, MONROE, MI' );
   $ua[] = array('email' => 'jcschopper@yahoo.com'	,	'school' => 'LOVING SHEPHERD, MILWAUKEE, WI' );
   $ua[] = array('email' => 'jeffrey_rodgers@hotmail.com'	,	'school' => 'ST PETER, ARLINGTON HTS, IL' );
   $ua[] = array('email' => 'jenean.cherney@orlctosa.org'	,	'school' => 'OUR REDEEMER, WAUWATOSA, WI' );
   $ua[] = array('email' => 'jfrat974@gmail.com'	,	'school' => 'ST PETER, EASTPOINTE, MI' );
   $ua[] = array('email' => 'jgurgel.trinity@gmail.com'	,	'school' => 'TRINITY, STEWARDSON, IL' );
   $ua[] = array('email' => 'jhoard@tds.net'	,	'school' => 'ST LORENZ, FRANKENMUTH, MI' );
   $ua[] = array('email' => 'jjacob733@gmail.com'	,	'school' => 'BETHEL, MORTON, IL' );
   $ua[] = array('email' => 'jjelinski@gracemenomoneefalls.org'	,	'school' => 'GRACE, MENOMONEE FALLS, WI' );
   $ua[] = array('email' => 'jkfehr@htc.net'	,	'school' => 'ST JOHN, RED BUD, IL' );
   $ua[] = array('email' => 'jmatthies@tslwels.org'	,	'school' => 'TRINITY ST LUKE, WATERTOWN, WI' );
   $ua[] = array('email' => 'jsmith@esmeagles.com'	,	'school' => 'LUTHERRUN, FT WAYNE, IN' );
   $ua[] = array('email' => 'juanita.berdis@trinityroselle.com'	,	'school' => 'TRINITY, ROSELLE, IL' );
   $ua[] = array('email' => 'kcollins@orlcs.org'	,	'school' => 'OUR REDEEMER, DELAVAN, WI' );
   $ua[] = array('email' => 'kevinbecker@immanuel-ed.org'	,	'school' => 'IMMANUEL, EAST DUNDEE, IL' );
   $ua[] = array('email' => 'kgilbert@stjohnls.com'	,	'school' => 'ST JOHN, CHAMPAIGN, IL' );
   $ua[] = array('email' => 'kkaelberer@immanuelbrookfield.org'	,	'school' => 'IMMANUEL, BROOKFIELD, WI' );
   $ua[] = array('email' => 'kmay@splcs.net'	,	'school' => 'ST PETER, MACOMB, MI' );
   $ua[] = array('email' => 'kuhna001@gmail.com'	,	'school' => 'ST JOHN, ELK RIVER, MN' );
   $ua[] = array('email' => 'kurtbusse@trinluth.org'	,	'school' => 'TRINITY, BLOOMINGTON, IL' );
   $ua[] = array('email' => 'laura.stennes@tloschool.org'	,	'school' => 'TRINITY LONE OAK, EAGAN, MN' );
   $ua[] = array('email' => 'lbajus@excel.net'	,	'school' => 'BETHLEHEM, SHEBOYGAN, WI' );
   $ua[] = array('email' => 'linda.maxwell@bellin.org'	,	'school' => 'ST MARK, GREEN BAY, WI' );
   $ua[] = array('email' => 'mark.goerger@illinois.gov'	,	'school' => 'ZION, BELLEVILLE, IL' );
   $ua[] = array('email' => 'mdeines3@gmail.com'	,	'school' => 'IMMANUEL, ST CHARLES, MO' );
   $ua[] = array('email' => 'mfenrick@stpaulsjanesville.com'	,	'school' => 'ST PAUL, JANESVILLE, WI' );
   $ua[] = array('email' => 'millspaugh.jamie@gmail.com'	,	'school' => 'ST MATTHEW, WALLED LAKE, MI' );
   $ua[] = array('email' => 'mountainwille@gmail.com'	,	'school' => 'ST PAUL, GRAFTON, WI' );
   $ua[] = array('email' => 'nkelso@ourshepherd.net'	,	'school' => 'OUR SHEPHERD, BIRMINGHAM, MI' );
   $ua[] = array('email' => 'oettingat@yahoo.com'	,	'school' => 'IMMANUEL, BELVIDERE, IL' );
   $ua[] = array('email' => 'oslsad@oursaviorgrafton.org'	,	'school' => 'OUR SAVIOR, GRAFTON, WI' );
   $ua[] = array('email' => 'pastormaschke@gmail.com'	,	'school' => 'BETHLEHEM, CARSON, NV' );
   $ua[] = array('email' => 'paul.patterson@wlsracine.org'	,	'school' => 'WISCONSIN LUTHERAN, RACINE, WI' );
   $ua[] = array('email' => 'paulbmanning@yahoo.com'	,	'school' => 'WESTSIDE, MIDDLETON, WI' );
   $ua[] = array('email' => 'pdoherty@hcl.org'	,	'school' => 'HALES CORNERS LUTHERAN, WI' );
   $ua[] = array('email' => 'polosteph@hotmail.com'	,	'school' => 'IMMANUEL, SEYMOUR, IN' );
   $ua[] = array('email' => 'r2kumba@wowway.com'	,	'school' => 'BETHANY, NAPERVILLE, IL' );
   $ua[] = array('email' => 'rachel.burris4@gmail.com'	,	'school' => 'OUR SHEPHERD, AVON, IN' );
   $ua[] = array('email' => 'raddatbj@gmail.com'	,	'school' => 'OUR SAVIOR, GRAFTON, WI' );
   $ua[] = array('email' => 'reitzjay@gmail.com'	,	'school' => 'ZION, ST CHARLES, MO' );
   $ua[] = array('email' => 'rengelbrecht@oursaviorlansing.org'	,	'school' => 'OUR SAVIOR, LANSING, MI' );
   $ua[] = array('email' => 'richard.alan.brooks@gmail.com'	,	'school' => 'GRACE, RIVER FOREST, IL' );
   $ua[] = array('email' => 'rkknoll@yahoo.com'	,	'school' => 'ST LORENZ, FRANKENMUTH, MI' );
   $ua[] = array('email' => 'rob.e.hayes@gmail.com'	,	'school' => 'ST LORENZ, FRANKENMUTH, MI' );
   $ua[] = array('email' => 'robbandtp@hotmail.com'	,	'school' => 'KING OF KINGS, ROSEVILLE, MN' );
   $ua[] = array('email' => 'ronningfamily@rocketmail.com'	,	'school' => 'CROSS, YORKVILLE, IL' );
   $ua[] = array('email' => 'runningcoachamy@yahoo.com'	,	'school' => 'IMMANUEL, CRYSTAL LAKE, IL' );
   $ua[] = array('email' => 'schield.tfl@gmail.com'	,	'school' => 'TRINITY 1ST, MINNEAPOLIS, MN' );
   $ua[] = array('email' => 'smmeasner@yahoo.com'	,	'school' => 'TRINITY, WEST BEND, WI' );
   $ua[] = array('email' => 'snmoravec@gmail.com'	,	'school' => 'ST PAUL, WEST ALLIS, WI' );
   $ua[] = array('email' => 'spanose@ourshepherd.net'	,	'school' => 'OUR SHEPHERD, BIRMINGHAM, MI' );
   $ua[] = array('email' => 'spedtchr300@gmail.com'	,	'school' => 'IMMANUEL, PALATINE, IL' );
   $ua[] = array('email' => 'ssprung@mvr3.k12.mo.us'	,	'school' => 'IMMANUEL, WASHINGTON, MO' );
   $ua[] = array('email' => 'stenklyft@trinitysheboygan.org'	,	'school' => 'TRINITY, SHEBOYGAN, ,WI' );
   $ua[] = array('email' => 'tbauer@stjohnrochester.org'	,	'school' => 'ST JOHN, ROCHESTER, MI' );
   $ua[] = array('email' => 'the_mcevoys@sbcglobal.net'	,	'school' => 'ST JOHN, WAUWATOSA, WI' );
   $ua[] = array('email' => 'tkmorris@infin.net'	,	'school' => 'TRINITY, JEFFERSON CITY, MO' );
   $ua[] = array('email' => 'tsiekmann@trinityutica.com'	,	'school' => 'TRINITY, UTICA, MI' );
   $ua[] = array('email' => 'wertdl@gmail.com'	,	'school' => 'IMMANUEL, BATAVIA, IL' );
   $ua[] = array('email' => 'zionathletics@gmail.com'	,	'school' => 'ZION, MARENGO, IL' );


   echo "<pre>";
   $new_hashed_password = password_hash('coach@123', PASSWORD_DEFAULT);
   $encPwd = htmlentities($new_hashed_password, PASSWORD_DEFAULT);

   $numSuccess = $numFail = 0;
   $schoolObj = new SchoolsTable();
   $userObj = new UsersTable();
   foreach ($ua as $a) {
      $email = $a['email'];
      $school = $a['school'];


      $schoolRec = $schoolObj->ReadByName($school);
      if (empty($schoolRec)) {
         // echo "School $school not found, skipping $email";
         $numFail++;
      } else {
         // var_dump($schoolRec); exit;
         $school_id = $schoolRec[0]['id'];

	      $userRec = $userObj->ReadByEmail('email');
	      if (empty($userRec)) {
	         $nextID = $userObj->MaxID() + 1;
            $result = $userObj->Insert($nextID, $school_id, UserRoles::NonAdmin,
                UserStatus::Active, $email, 666, $encPwd);
            if (!$result) {
               echo "Adding $email failed.";
               $numFail++;
            } else {
               $numSuccess++;
            }
	      }
      }
   }
   //echo "NumFail: $numFail, NumSuccess: $numSuccess";
   echo "</pre>";
?>