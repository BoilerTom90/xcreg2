<?php

require_once('classes/passwordLib.php');  // this really shouldn't be needed in this file!!

class DB {
  public static $server_conn = null;
  public static $db_conn     = null;

  // Localhost credentials
  public static $mysql_servername  = "localhost";
  public static $mysql_username    = "root";
  public static $mysql_password    = "";
  public static $mysql_dbname      = "xcreg2";

  // Fat Cow Credentials
  // server: thoffmannet.fatcowmysql.com
  // username: xcreg_2015
  // pwd: xcreg_2015_123

  public static $mysql_servername2 = "thoffmannet.fatcowmysql.com";
  public static $mysql_username2   = "xcreg";
  public static $mysql_password2   = "user@xcreg";
}

function ConnectToServer()
{
  // Attempt to connect locally first, and if that fails, try fatcows.
  DB::$server_conn = new mysqli(DB::$mysql_servername, DB::$mysql_username, DB::$mysql_password);
  // Check connection
  if (DB::$server_conn->connect_error) {
    DB::$server_conn = new mysqli(DB::$mysql_servername2, DB::$mysql_username2, DB::$mysql_password2);
    if (DB::$server_conn->connect_error)
      die("Connection failed: " . DB::$server_conn->connect_error);
  } 
  return(DB::$server_conn);
}

function ConnectToDB($db)
{
  // Attempt to connect locally first, and if that fails, try fatcows.
  DB::$db_conn = new mysqli(DB::$mysql_servername, DB::$mysql_username, DB::$mysql_password, $db);
  // Check connection
  if (DB::$db_conn->connect_error) {
    DB::$db_conn = new mysqli(DB::$mysql_servername2, DB::$mysql_username2, DB::$mysql_password2, $db);
    if (DB::$db_conn->connect_error)
      die("Connection failed: " . DB::$db_conn->connect_error);
  }
  return(DB::$db_conn);
}

// -- access functions 
function ReadAllEvents(&$error_string) 
{
  $con = ConnectToDB(DB::$mysql_dbname);
  $allEvents = array();
  $q = "select event_id, event_name, event_db, race_date, registration_open, collect_shirt_info 
          from events
          order by event_id desc";
  $r = $con->query($q);
  if ($r == FALSE)
  {
    $error_string = mysqli_error($con);
    return($allEvents);
  }
   
  while ($row = mysqli_fetch_array($r)) 
  {
    $line = array(
        "event_id"           => $row['event_id'],
        "event_name"         => $row['event_name'],
        "event_db"           => $row['event_db'],
        "race_date"          => $row['race_date'],
        "registration_open"  => $row['registration_open'],
        "collect_shirt_info" => $row['collect_shirt_info']
        );
    $allEvents[] = $line;
   }
   return $allEvents;
}

// -- access functions 
function ReadEvent($event_id, &$last_error) 
{
  $con = ConnectToDB(DB::$mysql_dbname);
  $event = array();
  $q = "select event_id, event_name, event_db, race_date, registration_open, collect_shirt_info 
          from events 
          where event_id = \"$event_id\"";
  $r = $con->query($q);
  if ($r == FALSE)
  {
    $last_error = mysqli_error($con);
    return($event);
  }
   
  if ($row = mysqli_fetch_array($r)) 
  {
    $event = array(
          "event_id"           => $row['event_id'],
          "event_name"         => $row['event_name'],
          "event_db"           => $row['event_db'],
          "race_date"          => $row['race_date'],
          "registration_open"  => $row['registration_open'],
          "collect_shirt_info" => $row['collect_shirt_info']
          );
  }
  return $event;
}


function ModifyEent($event_id, $event_name, $registration_open, $collect_shirt_info, &$last_error)
{
  $con = ConnectToDB(DB::$mysql_dbname); 
  $protected_event_name = htmlentities($event_name, ENT_QUOTES);
  $query = "update events 
              set event_name = \"$protected_event_name\",
                  registration_open = $registration_open,
                  collect_shirt_info = $collect_shirt_info 
              where event_id = $event_id";
  // echo $query; exit;
  $query_result = $con->query($query);
  $num_rows = mysqli_affected_rows($con);
  if ($num_rows < 0)
  {
    $last_error = mysqli_error($con);
  }
  return($num_rows);
}




// --------------------------------------------------------------------------------
function ReadAllSchools($event_db, &$last_error) 
{
  $last_error = "";
  $con = ConnectToDB($event_db);
  $schools = array();
  $q = "select school_id, school_name from schools";
  $r = $con->query($q);
  if ($r == FALSE)
  {
    $last_error = "Query of Schools Tabled Failed:" . mysql_error($con) . "\n";
    return($schools);
  }
   
  while ($row = mysqli_fetch_array($r)) 
  {
    $line = array(
        "school_id"     => $row['school_id'],
        "school_name"   => $row['school_name'],
        );
    $schools[] = $line;
   }
   return $schools;
}


// --------------------------------------------------------------------------------
function LookupUser($event_record, $email, &$last_error)
{
  $event_db = $event_record['event_db'];
  $con = ConnectToDB($event_db);
  $user_info = array();

  $q = "select user_id, email, password, role, status, u.school_id, s.school_name 
          from users u
          inner join schools s on u.school_id = s.school_id
          where email = \"$email\"";
  $r = $con->query($q); 
  $num_rows = mysqli_affected_rows($con);
  if ($r == FALSE || $num_rows != 1)
  {
    $last_error = "User not found in database </br>" . mysqli_error($con);
    return $user_info;
  }
   
  $row = mysqli_fetch_array($r);
  $user_info = array(
    'user_id'     => $row['user_id'],
    'email'       => $row['email'],
    'password'    => $row['password'],
    'role'        => $row['role'],
    'status'      => $row['status'],
    'school_id'   => $row['school_id'],
    'school_name' => $row['school_name']
    );

  return($user_info);
}

// --------------------------------------------------------------------------------
function LookupUserById($event_db, $user_id, &$last_error)
{
  
  $con = ConnectToDB($event_db);
  $user_info = array();

  $q = "select user_id, email, password, role, status, u.school_id, s.school_name 
          from users u
          inner join schools s on u.school_id = s.school_id
          where u.user_id = \"$user_id\"";
  $r = $con->query($q); 
  $num_rows = mysqli_affected_rows($con);
  if ($r == FALSE || $num_rows != 1)
  {
    $last_error = "User not found in database </br>" . mysqli_error($con);
    return $user_info;
  }
   
  $row = mysqli_fetch_array($r);
  $user_info = array(
    'user_id'     => $row['user_id'],
    'email'       => $row['email'],
    'password'    => $row['password'],
    'role'        => $row['role'],
    'status'      => $row['status'],
    'school_id'   => $row['school_id'],
    'school_name' => $row['school_name']
    );

  return($user_info);
}

function CountUsersBySchoolID($event_db, $school_id)
{
  $count = 0;
  $con = ConnectToDB($event_db); 
  $q = "select count(*) as count from users where school_id = $school_id";
  $qr = $con->query($q);
  if ($row = mysqli_fetch_array($qr)) 
  {
    $count = $row['count'];
  }
  return $count;
}

function CountRunnersBySchoolID($event_db, $school_id)
{
  $count = 0;
  $con = ConnectToDB($event_db); 
  $q = "select count(*) as count from runners where school_id = $school_id";
  $qr = $con->query($q);
  if ($row = mysqli_fetch_array($qr)) 
  {
    $count = $row['count'];
  }
  return($count);
}


function CountRunnersBySexBySchoolID($event_db, $school_id)
{

  $count = array();
  $con = ConnectToDB($event_db); 
  // $q = "select count(*) as count from runners where school_id = $school_id";

  $q = "select SUM(sex = 'M') as 'num_males', 
               SUM(sex = 'F') as 'num_females'
         from runners
         where school_id = $school_id
         group by school_id";

  $qr = $con->query($q);
  $count['num_males'] = 0;
  $count['num_females'] = 0;
  if ($row = mysqli_fetch_array($qr)) 
  {
    $count['num_males'] = $row['num_males'];
    $count['num_females'] = $row['num_females'];
  }
  return $count;
}

// --------------------------------------------------------------------------------
function GetNextSchoolIDValue($con) 
{
  $retVal = 1;
  $q = "select max(school_id) val from schools";
  $qr = $con->query($q);
  if ($row = mysqli_fetch_array($qr)) 
  {
    $value = $row['val'];
    $retVal = $value + 1;
  }
  return $retVal;
}


// --------------------------------------------------------------------------------
function AddSchool($event_db, $school_name, &$last_error)
{
  $last_error = "";
  $con = ConnectToDB($event_db);
  $protected_school_name = htmlentities($school_name, ENT_QUOTES);
  $school_id = GetNextSchoolIDValue($con);
  $query = "insert into schools (school_id, school_name) values ($school_id, \"$protected_school_name\")";
  $query_result = $con->query($query);
  $num_rows = mysqli_affected_rows($con); // should be 1
  if ($num_rows <= 0)
  {
    $last_error = mysqli_error($con);
  }
  //var_dump($query_result, $num_rows);
  return($num_rows);
}

function ReadSchoolByID($event_db, $school_id, &$last_error)
{
  $last_error = "";
  $con = ConnectToDB($event_db);
  $school = array();

  $q = "select school_id, school_name 
          from schools
          where school_id = $school_id";
  $r = $con->query($q); 
  $num_rows = mysqli_affected_rows($con);
  if ($r == FALSE || $num_rows != 1)
  {
    $last_error = "School not found in database </br>" . mysqli_error($con);
    return $school;
  }

  $row = mysqli_fetch_array($r);
  if ($row)
  {
    $school = array(
      'school_id'     => $row['school_id'],
      'school_name'   => $row['school_name'],
      );
  }
  return($school);
}

function DeleteSchoolByID($event_db, $school_id, &$last_error)
{
  $last_error = "";
  $con = ConnectToDB($event_db);
  $school = array();

  $q = "delete from schools where school_id = $school_id";
  $r = $con->query($q); 
  $num_rows = mysqli_affected_rows($con);
  if ($r == FALSE || $num_rows != 1)
  {
    $last_error = "School not deleted</br>" . mysqli_error($con);
  }
  return($school);
}

// This function should update exactly one row. It returns the number of rows affected by the query.
function UpdateSchool($event_db, $school_id, $school_name, &$last_error)
{
  $last_error = "";
  $con = ConnectToDB($event_db);

  // The only field that can be updated on the SCHOOLS table is the name of the school. 
  $protected_school_name = htmlentities($school_name, ENT_QUOTES);
  $query = "update schools set school_name = \"$protected_school_name\" where school_id = $school_id";
  $query_result = $con->query($query);

  $num_rows = mysqli_affected_rows($con);
  if ($num_rows < 0)
  {
    $last_error = mysqli_error($con);
  }
  return($num_rows);
}


// --------------------------------------------------------------------------------
function ReadAllUsers($event_db, &$last_error) 
{
  $last_error = "";
  $con = ConnectToDB($event_db);
  $users = array();
  $q = "select user_id, email, password, role, status, u.school_id, s.school_name
            from users u
            inner join schools s on s.school_id = u.school_id
            order by email";
  $r = $con->query($q);
  if ($r == FALSE)
  {
    $last_error = "Query of users tabled failed:" . mysql_error($con) . "\n";
    return($schools);
  }
   
  while ($row = mysqli_fetch_array($r)) 
  {
    $line = array(
        "user_id"     => $row['user_id'],
        "email"       => $row['email'],
        "password"    => $row['password'],
        "role"        => $row['role'],
        "status"      => $row['status'],
        "school_name" => $row['school_name'],
        "school_id"   => $row['school_id']

        );
    $users[] = $line;
   }
   return $users;
}


// --------------------------------------------------------------------------------
function GetNextUserIDValue($con) 
{
  $retVal = 1;
  $q = "select max(user_id) val from users";
  $qr = $con->query($q);
  if ($row = mysqli_fetch_array($qr)) 
  {
    $value = $row['val'];
    $retVal = $value + 1;
  }
  return $retVal;
}


function AddUser($event_db, $email, $role, $status, $school_id, &$last_error)
{ 
  $last_error = "";
  $con = ConnectToDB($event_db);
  $user_id = GetNextUserIDValue($con);

  $query = "insert into users (user_id, email, password, role, status, school_id) 
            values ($user_id, \"$email\", \"\", \"$role\", \"$status\", $school_id)";
  $query_result = $con->query($query);
  $num_rows = mysqli_affected_rows($con); // should be 1
  if ($num_rows <= 0)
  {
    $last_error = mysqli_error($con);
  }
  // var_dump($query_result, $num_rows);
  return($num_rows);
}

function ReadUserById($event_db, $user_id, &$last_error)
{
  $last_error = "";
  $con = ConnectToDB($event_db);
  $user = array();

  $q = "select user_id, email, password, role, status, u.school_id, s.school_name 
          from users u
          inner join schools s on s.school_id = u.school_id
          where user_id = $user_id";
  $r = $con->query($q); 
  $num_rows = mysqli_affected_rows($con);
  if ($r == FALSE || $num_rows != 1)
  {
    $last_error = "User not found in database </br>" . mysqli_error($con);
    return $user;
  }

  $row = mysqli_fetch_array($r);
  if ($row)
  {
    $user = array(
      'user_id'     => $row['user_id'],
      'email'       => $row['email'],
      'password'    => $row['password'],
      'role'        => $row['role'],
      'status'      => $row['status'],
      'school_id'   => $row['school_id'],
      'school_name' => $row['school_name'],
      );
  }
  return($user);
}


function DeleteUserById($event_db, $user_id, &$last_error)
{
  $last_error = "";
  $con = ConnectToDB($event_db);
  $user = array();

  $q = "delete from users where user_id = \"$user_id\"";
  $r = $con->query($q); 
  $num_rows = mysqli_affected_rows($con);
  if ($r == FALSE || $num_rows != 1)
  {
    $last_error = mysqli_error($con);
    return $num_rows;
  }
  return($num_rows);
}


function UpdateUsersSchoolID($event_db, $user_id, $new_school_id, &$status_msg)
{
  $con = ConnectToDB($event_db);

  $query = "update users set school_id = $new_school_id where user_id = $user_id";
  $query_result = $con ->query($query);

  $num_rows = mysqli_affected_rows($con);
  if ($num_rows < 0)
  {
    $status_msg = mysqli_error($con);
  }
  else
  {
    $status_msg = "User's School Updated Successfully!";
  }
  return($num_rows);  
}



function UpdateUsersRole($event_db, $user_id, $new_role, &$status_msg) 
{
  $con = ConnectToDB($event_db);

  $query = "update users set role = \"$new_role\" where user_id = $user_id";
  $query_result = $con->query($query);

  $num_rows = mysqli_affected_rows($con);
  if ($num_rows < 0)
  {
    $status_msg = mysqli_error($con);
  }
  else
  {
    $status_msg = "User's Role Updated Successfully!";
  }
  return($num_rows);
}


function UpdateUsersStatus($event_db, $user_id, $new_status, &$status_msg) 
{

  $con = ConnectToDB($event_db);

  $query = "update users set status = \"$new_status\" where user_id = $user_id";
  $query_result = $con->query($query);

  $num_rows = mysqli_affected_rows($con);
  if ($num_rows < 0)
  {
    $status_msg = mysqli_error($con);
  }
  else
  {
    $status_msg = "User's Status Updated Successfully!";
  }
  return($num_rows);
}

function UpdateUsersPassword($event_db, $user_id, $new_hashed_password, &$status_msg) 
{
  $con = ConnectToDB($event_db);

  $query = "update users set password = \"$new_hashed_password\" where user_id = $user_id";
  $query_result = $con->query($query);

  $num_rows = mysqli_affected_rows($con);
  if ($num_rows < 0)
  {
    $status_msg = mysqli_error($con);
  }
  else
  {
    $status_msg = "User's Password Updated Successfully!";
  }
  return($num_rows);
}


function ReadAllRunners($event_db, &$last_error) 
{
  $con = ConnectToDB($event_db);
  $result = array();
  $q = "select  r.runner_id,
                r.school_id,
                s.school_name,  
                r.first_name, 
                r.last_name,
                r.grade,
                r.sex
        from runners r
        inner join schools s on r.school_id = s.school_id
        order by s.school_name, r.last_name, r.first_name";

  $r = $con->query($q);
  if ($r == FALSE)
  {
    $last_error =  mysqli_error($con);
    return;
  }
   
  while ($row = mysqli_fetch_array($r)) 
  {
    $line = array(
        "runner_id"   => $row['runner_id'],
        "school_id"   => $row['school_id'],
        "school_name" => $row['school_name'],
        "first_name"  => $row['first_name'],
        "last_name"   => $row['last_name'],
        "grade"       => $row['grade'],
        "sex"         => $row['sex']
        );
    $result[] = $line;
   }
   return $result;
}

function ReadAllRunnersBySchoolId($event_db, $school_id, &$last_error) 
{
  $con = ConnectToDB($event_db);
  $result = array();
  $q = "select  r.runner_id,
                r.school_id,
                s.school_name,  
                r.first_name, 
                r.last_name,
                r.grade,
                r.sex
        from runners r
        inner join schools s on r.school_id = s.school_id
        where r.school_id = $school_id
        order by r.last_name, r.first_name";

  $r = $con->query($q);
  if ($r == FALSE)
  {
    $last_error =  mysqli_error($con);
    return;
  }
   
  while ($row = mysqli_fetch_array($r)) 
  {
    $line = array(
        "runner_id"   => $row['runner_id'],
        "school_id"   => $row['school_id'],
        "school_name" => $row['school_name'],
        "first_name"  => $row['first_name'],
        "last_name"   => $row['last_name'],
        "grade"       => $row['grade'],
        "sex"         => $row['sex']
        );
    $result[] = $line;
   }
   return $result;
}

function ReadRunnerByRunnerID($event_db, $runner_id, &$last_error) 
{
  $con = ConnectToDB($event_db);
  $result = array();
  $last_error = "";
  $q = "select  r.runner_id,
                r.school_id,
                s.school_name,  
                r.first_name, 
                r.last_name,
                r.grade,
                r.sex
        from runners r
        inner join schools s on r.school_id = s.school_id
        where r.runner_id = $runner_id";

  $r = $con->query($q);
  if ($r == FALSE)
  {
    $last_error =  mysqli_error($con);
    return;
  }
   
  if ($row = mysqli_fetch_array($r)) 
  {
    $result = array(
        "runner_id"   => $row['runner_id'],
        "school_id"   => $row['school_id'],
        "school_name" => $row['school_name'],
        "first_name"  => $row['first_name'],
        "last_name"   => $row['last_name'],
        "grade"       => $row['grade'],
        "sex"         => $row['sex']
        );
   }
   return $result;
}

function GetNextRunnerIDValue($con) 
{
  $retVal = 1;
  $q = "select max(runner_id) val from runners";
  $qr = $con->query($q);
  if ($row = mysqli_fetch_array($qr)) 
  {
    $value = $row['val'];
    $retVal = $value + 1;
  }
  return $retVal;
}


function AddRunner($event_db, $school_id, $first_name, $last_name, $grade, $sex, &$last_error)
{ 
  $con = ConnectToDB($event_db);
  $runner_id = GetNextRunnerIDValue($con);
  $last_error = "";

  $p_firt_name = htmlentities($first_name, ENT_QUOTES);
  $p_last_name = htmlentities($last_name, ENT_QUOTES);
  
  $query = "insert into runners (runner_id, school_id, first_name, last_name, grade, sex) 
            values ($runner_id, $school_id, \"$first_name\", \"$last_name\", $grade, \"$sex\")";
  $query_result = $con->query($query);
  $num_rows = mysqli_affected_rows($con); // should be 1
  if ($num_rows <= 0)
  {
    $last_error = mysqli_error($con);
  }
  // var_dump($query_result, $num_rows, $last_error);
  return($num_rows);
}



function ModifyRunner($event_db, $runner_id, $school_id, $first_name, $last_name, $grade, $sex, &$last_error)
{ 

  $con = ConnectToDB($event_db);

  $p_firt_name = htmlentities($first_name, ENT_QUOTES);
  $p_last_name = htmlentities($last_name, ENT_QUOTES);

  $last_error = "";
  $query = "update runners set
              school_id  = $school_id,
              first_name = \"$first_name\",
              last_name  = \"$last_name\",
              grade      = $grade,
              sex        = \"$sex\"
            where runner_id  = $runner_id";
  $query_result = $con->query($query);
  $num_rows = mysqli_affected_rows($con); // should be 1
  if ($num_rows <= 0)
  {
    $last_error = mysqli_error($con);
  }
  //var_dump($query_result, $num_rows);exit;
  return($num_rows);
}

function DeleteRunner($event_db, $runner_id, &$last_error)
{
  $con = ConnectToDB($event_db);

  $last_error = "";
  $query = "delete from runners where runner_id = $runner_id";
  $query_result = $con->query($query);
  $num_rows = mysqli_affected_rows($con); // should be 1
  if ($num_rows <= 0)
  {
    $last_error = mysqli_error($con);
  }
  //var_dump($query_result, $num_rows);exit;
  return($num_rows);  
}

function DeleteRunnersBySchoolID($event_db, $school_id, &$last_error)
{
  $con = ConnectToDB($event_db);

  $last_error = "";
  $query = "delete from runners where school_id = $school_id";
  $query_result = $con->query($query);
  $num_rows = mysqli_affected_rows($con);
  if ($num_rows <= 0)
  {
    $last_error = mysqli_error($con);
  }
  //var_dump($query_result, $num_rows);exit;
  return($num_rows);  
}

function ReadShirtsAllSchools($event_db, &$last_error) 
{
  $con = ConnectToDB($event_db);
  $result = array();
  $q = "select  s.school_id,
                s.school_name,
                t.num_youth_medium,
                t.num_youth_large,
                t.num_adult_small,
                t.num_adult_medium,
                t.num_adult_large,
                t.num_adult_xl,
                t.num_adult_xxl
        from schools s
        left join shirts t 
        on s.school_id = t.school_id
        order by s.school_name";

  $r = $con->query($q);
  if ($r == FALSE)
  {
    $last_error =  mysqli_error($con);
    return $result;
  }
   
  while ($row = mysqli_fetch_array($r)) 
  {
    $line = array(
        "school_id"         => $row['school_id'],
        "school_name"       => $row['school_name'],
        "num_youth_medium"  => $row['num_youth_medium'],
        "num_youth_large"   => $row['num_youth_large'],
        "num_adult_small"   => $row['num_adult_small'],
        "num_adult_medium"  => $row['num_adult_medium'],
        "num_adult_large"   => $row['num_adult_large'],
        "num_adult_xl"      => $row['num_adult_xl'],
        "num_adult_xxl"     => $row['num_adult_xxl']

        );
    $result[] = $line;
   }
   return $result;
}

function ReadShirtsBySchoolId($event_db, $school_id, &$last_error) 
{
  $con = ConnectToDB($event_db);
  $last_error = "";
  $shirts = array();
  $q = "select  school_id,
                num_youth_medium,
                num_youth_large,
                num_adult_small,
                num_adult_medium,
                num_adult_large,
                num_adult_xl,
                num_adult_xxl
        from shirts
        where school_id = $school_id
        order by school_id";

  $r = $con->query($q);
  if ($r == FALSE)
  {
    $last_error =  mysqli_error($con);
    return $shirts;
  }
   
  if ($row = mysqli_fetch_array($r)) 
  {
    $shirts = array(
        "school_id"        => $row['school_id'],
        "num_youth_medium" => $row['num_youth_medium'],
        "num_youth_large"  => $row['num_youth_large'],
        "num_adult_small"  => $row['num_adult_small'],
        "num_adult_medium" => $row['num_adult_medium'],
        "num_adult_large"  => $row['num_adult_large'],
        "num_adult_xl"     => $row['num_adult_xl'],
        "num_adult_xxl"    => $row['num_adult_xxl']
        );
  }
  return $shirts;
}

function UpdateShirtsBySchoolId($event_db, $school_id, 
            $num_youth_medium, $num_youth_large,
            $num_adult_small, $num_adult_medium,
            $num_adult_large, $num_adult_xl, $num_adult_xxl,
            &$last_error) 
{
  $con = ConnectToDB($event_db);
  $last_error = "";
  $q = "replace into shirts
         (school_id, num_youth_medium, num_youth_large, 
          num_adult_small, num_adult_medium,
          num_adult_large, num_adult_xl, num_adult_xxl)
        values ($school_id, 
                $num_youth_medium, $num_youth_large,
                $num_adult_small, $num_adult_medium,
                $num_adult_large, $num_adult_xl, $num_adult_xxl)";
  if (($qr = $con->query($q)) == false) {
    $last_error = mysqli_error($con);
  } else {
    $num_rows = 1; 
  }
  //var_dump($qr); exit;
  return($num_rows);
}


?>