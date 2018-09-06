<?php

require_once("classes/Constants.php");

class DBIntf {

   private $server_conn = null;
   private $db_conn     = null;

   // Localhost credentials
   const MYSQL_SERVERNAME_LOC  = "localhost";
   const MYSQL_USERNAME_LOC    = "root";
   const MYSQL_PASSWORD_LOC    = "";
   const MYSQL_DBNAME_LOC      = "xcreg3";

   const MYSQL_SERVERNAME_REM  = "thoffmannet.fatcowmysql.com";
   const MYSQL_USERNAME_REM    = "xcreg";
   const MYSQL_PASSWORD_REM    = "xcreg@xcreg";
   const MYSQL_DBNAME_REM      = "xcreg3";

   function __construct() {
      // print "In constructor\n";
   }

   function __destruct() {
      // print "In destructor\n";
   }

   public function ServerConn() {
      return($this->server_conn);
   }

   public function DBConn() {
      return($this->db_conn);
   }

   public function connectToServer() {
      // Attempt to connect locally first, and if that fails, try fatcows.
      $this->server_conn = new mysqli(
            self::MYSQL_SERVERNAME_LOC, 
            self::MYSQL_USERNAME_LOC,  
            self::MYSQL_PASSWORD_LOC);

      // Check connection
      if ($this->server_conn->connect_error) {
         $this->server_conn = new mysqli(
               self::MYSQL_SERVERNAME_REM, 
               self::MYSQL_USERNAME_REM, 
               self::MYSQL_PASSWORD_REM);
         if ($this->server_conn->connect_error) {
            die("Connect to Server failed: " . DBIntf::$server_conn->connect_error);
         }
      } 
      return($this->server_conn);
   }

   public function connectToDatabase() {
      // Attempt to connect locally first, and if that fails, try fatcows.
      $this->db_conn = new mysqli(
            self::MYSQL_SERVERNAME_LOC, 
            self::MYSQL_USERNAME_LOC, 
            self::MYSQL_PASSWORD_LOC,
            self::MYSQL_DBNAME_LOC);

      // Check connection
      if ($this->db_conn->connect_error) {
         $this->db_conn = new mysqli(
               self::MYSQL_SERVERNAME_REM, 
               self::MYSQL_USERNAME_REM, 
               self::MYSQL_PASSWORD_REM,
               self::MYSQL_DBNAME_REM);
         if ($this->db_conn->connect_error) {
            die("Connect to DB failed: " . DBIntf::$db_conn->connect_error);
         }
      } 
      return($this->db_conn);
   }
}



class TableBase {

   protected $con = null;
   protected $lastError = "";
   protected $tableName = "";

   function __construct($tableName) {
     $this->con = (new DBIntf())->connectToDatabase(); 
     $this->tableName = $tableName;
   } 

   function __destruct() {
   }

   protected function saveError() {
      $this->lastError = mysqli_error($this->con);
      error_log("DB Error(" . $this->tableName . "): " . $this->lastError);
   }

   public function LastError() {
      return($this->lastError);
   }

   public function Read($id) {
      $query = "select * from $this->tableName where id = $id";
      $result = $this->con->query($query);
      if ($result == FALSE) {
         $this->saveError();
         return(null);
      }
      return(mysqli_fetch_array($result, MYSQLI_ASSOC));
   }

   protected function ReadNonID($whereAttributes) {
      $query = "select * from $this->tableName where ";
      $numAttributes = count($whereAttributes);
      for ($i = 0; $i < $numAttributes; $i++) {
         if ($i != 0) {
            $query .= ", ";
         }
         $colName = $whereAttributes[$i]['colName'];
         $colValue = $whereAttributes[$i]['colValue'];
         $query .= "$colName = '$colValue'";
      }
      $retVal = [];
      $result = $this->con->query($query);
      if ($result == FALSE) {
         $this->saveError();
         return(null);
      }
      while ($dbRow = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
         $retVal[] = $dbRow;
      }
      
      return $retVal;
   } 

   public function ReadAll($sortColumn = 'id desc') {
      $retVal = [];
      $query = "select * from $this->tableName order by $sortColumn";
      $result = $this->con->query($query);
      if ($result == FALSE) {
         $this->saveError();
         return(null);
      }
      while ($dbRow = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
         $retVal[] = $dbRow;
      }
      return $retVal;
   }

   public function Delete($id) {
      $retVal = array();
      $query = "delete from $this->tableName where id = $id";
      $query_result = $this->con->query($query);
      if ($query_result !== TRUE) {
         $this->saveError();
      }

      $num_rows = mysqli_affected_rows($this->con);
      return($num_rows);
   }

   protected function DeleteNonID($attributes) {
      $query = "delete from $this->tableName where ";
      $numAttributes = count($attributes);
      for ($i = 0; $i < $numAttributes; $i++) {
         if ($i != 0) {
            $query .= ", ";
         }
         $colName = $attributes[$i]['colName'];
         $colValue = $attributes[$i]['colValue'];
         $query .= "$colName = '$colValue'";
      }
   
      $result = $this->con->query($query);
      $this->saveError();
      return $retVal;
   }

   public function MaxID() {
      $maxID = -1;
      $con = (new DBIntf())->connectToDatabase(); 
      $query = "select max(id) as id from $this->tableName";
      $result = $con->query($query);
      if ($row = mysqli_fetch_array($result)) {
         $maxID = $row['id'];
      }
      return $maxID;
   }

   protected function InsertBase($id, $attributes) {

      $insertClause = "INSERT INTO $this->tableName (";
      $numAttributes = count($attributes);
      for ($i = 0; $i < $numAttributes; $i++) {
         if ($i != 0) {
            $insertClause .= ", ";
         }
         $colName = $attributes[$i]['colName'];
         $insertClause .= "$colName";
      }
      $insertClause .= ") VALUES (";
      for ($i = 0; $i < $numAttributes; $i++) {
         if ($i != 0) {
            $insertClause .= ", ";
         }
         $colValue = $attributes[$i]['colValue'];
         $insertClause .= "'$colValue'";
      }
      $insertClause .= ")";

      $query = $insertClause;
      //print $query;
      $result = $this->con->query($query);
      $num_rows = mysqli_affected_rows($this->con);
      if ($num_rows < 1) {
         $this->saveError();
      }
      return($num_rows);
   }

   protected function ReplaceBase($id, $attributes) {

      $insertClause = "REPLACE INTO $this->tableName (";
      $numAttributes = count($attributes);
      for ($i = 0; $i < $numAttributes; $i++) {
         if ($i != 0) {
            $insertClause .= ", ";
         }
         $colName = $attributes[$i]['colName'];
         $insertClause .= "$colName";
      }
      $insertClause .= ") VALUES (";
      for ($i = 0; $i < $numAttributes; $i++) {
         if ($i != 0) {
            $insertClause .= ", ";
         }
         $colValue = $attributes[$i]['colValue'];
         $insertClause .= "'$colValue'";
      }
      $insertClause .= ")";

      $query = $insertClause;
      //print $query;
      $result = $this->con->query($query);
      $num_rows = mysqli_affected_rows($this->con);
      if ($num_rows < 1) {
         $this->saveError();
      }
      return($num_rows);
   }

   protected function ModifyBase($id, $setAttributes) {

      $setClause = ' ';
      $numAttributes = count($setAttributes);
      for ($i = 0; $i < $numAttributes; $i++) {
         if ($i != 0) {
            $setClause .= ", ";
         }
         $colName = $setAttributes[$i]['colName'];
         $colValue = $setAttributes[$i]['colValue'];
         $setClause .= "$colName = '$colValue'";
      }

      $query = "update $this->tableName set $setClause where id = $id";
            // var_dump($query); exit;
      $result = $this->con->query($query);
      $num_rows = mysqli_affected_rows($this->con);
      if ($num_rows < 1) {
         $this->saveError();
      }
      return($num_rows);
   }
}

class ComplexQueries extends TableBase {

   function __construct() {
      parent::__construct("");
   }

   function ReadRunnersByEventID($event_id) {
      $query = "select  events.id           as event_id,
                        events.ev_name      as event_name,
                        runners.id          as runner_id,
                        runners.school_id   as school_id,
                        schools.name        as school_name,  
                        runners.first_name  as first_name, 
                        runners.last_name   as last_name,
                        runners.grade       as grade,
                        runners.sex         as sex,
                        runners.race_id     as race_id,
                        races.distance      as race_distance,
                        races.description   as race_description
                  from runners
                  inner join schools on runners.school_id = schools.id
                  inner join races   on runners.race_id = races.id
                  inner join events  on races.event_id = events.id
                  where events.id = $event_id
                  order by events.id, schools.name, runners.first_name, runners.last_name";
      $result = $this->con->query($query);
      if ($result == FALSE) {
         $this->saveError();
         return($result);
      }
      $retVal = array();
      while ($dbRow = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
         $retVal[] = $dbRow;
      }
      return($retVal);
   }

   function ReadRunnersBySchoolIDEventID($school_id, $event_id ) {
      $query = "select  events.id           as event_id,
                        events.ev_name      as event_name,
                        runners.id          as runner_id,
                        runners.school_id   as school_id,
                        schools.name        as school_name,  
                        runners.first_name  as first_name, 
                        runners.last_name   as last_name,
                        runners.grade       as grade,
                        runners.sex         as sex,
                        runners.race_id     as race_id,
                        races.distance      as race_distance,
                        races.description   as race_description
                  from runners
                  inner join schools on runners.school_id = schools.id
                  inner join races   on runners.race_id = races.id
                  inner join events  on races.event_id = events.id
                  where events.id = $event_id and schools.id = $school_id
                  order by events.id, schools.name, runners.first_name, runners.last_name";
      $result = $this->con->query($query);
      if ($result == FALSE) {
         $this->saveError();
         return($result);
      }
      $retVal = array();
      while ($dbRow = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
         $retVal[] = $dbRow;
      }
      return($retVal);      
   }

   function ReadRunnerByRunnerID($runner_id) {

      $query = "select  runners.id,
                        runners.school_id,
                        schools.name,  
                        runners.first_name, 
                        runners.last_name,
                        runners.grade,
                        runners.sex,
                        runners.race_id,
                        races.distance,
                        races.description
                  from runners
                  inner join schools on runners.school_id = schools.id
                  inner join races   on runners.race_id = races.id
                  where runners.id = $runner_id";
      $result = $this->con->query($query);
      if ($result == FALSE) {
         $this->saveError();
         return($result);
      }
      $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
      if ($row) {
         $result = array(
            "runner_id"        => $row['id'],
            "school_id"        => $row['school_id'],
            "school_name"      => $row['name'],
            "first_name"       => $row['first_name'],
            "last_name"        => $row['last_name'],
            "grade"            => $row['grade'],
            "sex"              => $row['sex'],
            "race_id"          => $row['race_id'],
            "race_distance"    => $row['distance'],
            "race_description" => $row['description']
            );
         return($result);
      }
      return($row);
   }
}


class EventsTable extends TableBase {

   function __construct() {
      parent::__construct('events');
   } 

   function Modify($id, $name, $date, $reg_status, $contact_email, $contact_phone) {
      $setAttributes[] = array(
         'colName' => "ev_name",
         'colValue' => $this->con->real_escape_string($name)
      );
      $setAttributes[] = array(
         'colName' => "ev_date",
         'colValue' => $date
      );
      $setAttributes[] = array(
         'colName' => "ev_reg_status",
         'colValue' => $reg_status
      );
      $setAttributes[] = array(
         'colName' => "ev_contact_email",
         'colValue' => $this->con->real_escape_string($contact_email)
      );
      $setAttributes[] = array(
         'colName' => "ev_contact_phone",
         'colValue' => $this->con->real_escape_string($contact_phone)
      );

      // var_dump($setAttributes); exit;
      return(parent::ModifyBase($id, $setAttributes));
   }

   function Insert($id, $name, $date, $reg_status, $contact_email, $contact_phone) {
      $attributes[] = array(
         'colName' => "id",
         'colValue' => $id
      );
      $attributes[] = array(
         'colName' => "ev_name",
         'colValue' => $this->con->real_escape_string($name)
      );
      $attributes[] = array(
         'colName' => "ev_date",
         'colValue' => $date
      );
      $attributes[] = array(
         'colName' => "ev_reg_status",
         'colValue' => $reg_status
      );
      $attributes[] = array(
         'colName' => "ev_contact_email",
         'colValue' => $this->con->real_escape_string($contact_email)
      );
      $attributes[] = array(
         'colName' => "ev_contact_phone",
         'colValue' => $this->con->real_escape_string($contact_phone)
      );
      return(parent::InsertBase($id, $attributes));
   }

}

class RacesTable extends TableBase {

   function __construct() {
      parent::__construct('races');
   } 

   function ReadByEvent($event_id) {
      $attributes[] = array(
         'colName' => "event_id",
         'colValue' => $event_id
      );
      return(parent::ReadNonID($attributes));
   }

   function Modify($id, $event_id, $distance, $description) {
      $setAttributes[] = array(
         'colName' => "event_id",
         'colValue' => $event_id
      );
      $setAttributes[] = array(
         'colName' => "distance",
         'colValue' => $distance
      );
      $setAttributes[] = array(
         'colName' => "description",
         'colValue' => $this->con->real_escape_string($description)
      );
      return(parent::ModifyBase($id, $setAttributes));
   }

   function Insert($id, $event_id, $distance, $description) {
      $attributes[] = array(
         'colName' => "id",
         'colValue' => $id
      );
      $attributes[] = array(
         'colName' => "event_id",
         'colValue' => $event_id
      );
      $attributes[] = array(
         'colName' => "distance",
         'colValue' => $distance
      );
      $attributes[] = array(
         'colName' => "description",
         'colValue' => $this->con->real_escape_string($description)
      );
      return(parent::InsertBase($id, $attributes));
   }

   function DeleteByEvent($id) {
      $attributes[] = array(
         'colName' => "event_id",
         'colValue' => $id
      );
      return(parent::DeleteNonID($attributes));
   }
}

class UsersTable extends TableBase {

   function __construct() {
      parent::__construct('users');
   } 

   function ReadByEmail($email) {
      $attributes[] = array(
         'colName' => 'email',
         'colValue' => $this->con->real_escape_string($email)
      );
      return(parent::ReadNonID($attributes));
   }

   function ReadBySchoolID($school_id) {
      $attributes[] = array(
         'colName' => 'school_id',
         'colValue' => $school_id
      );
      return(parent::ReadNonID($attributes));
   }

   function ModifySchoolID($id, $school_id) {
      $attributes[] = array(
         'colName' => 'school_id',
         'colValue' => $school_id
      );
      return(parent::ModifyBase($id, $attributes));      
   }

   function ModifyRole($id, $role) {
      $attributes[] = array(
         'colName' => 'role',
         'colValue' => $role
      );
      return(parent::ModifyBase($id, $attributes));      
   }

   function ModifyStatus($id, $status) {
      $attributes[] = array(
         'colName' => 'status',
         'colValue' => $status
      );
      return(parent::ModifyBase($id, $attributes));      
   }

   function ModifyResetCode($id, $reset_code) {
      $attributes[] = array(
         'colName' => 'reset_code',
         'colValue' => $reset_code
      );
      return(parent::ModifyBase($id, $attributes));      
   }

   function ModifyPassword($id, $password) {
      $attributes[] = array(
         'colName' => 'password',
         'colValue' => $password
      );
      return(parent::ModifyBase($id, $attributes));      
   }

   function ModifyLastLoginInfo($id, $num_logins) {
      $attributes[] = array(
         'colName' => 'num_logins',
         'colValue' => $num_logins
      );
      // $attributes[] = array(
      //    'colName' => 'login_date',
      //    'colValue' => time()
      // );
      return(parent::ModifyBase($id, $attributes)); 
   }

   function Insert($id, $school_id, $role, $status, $email, $reset_code, $pwd) {
      $attributes[] = array(
         'colName' => "id",
         'colValue' => $id
      );
      $attributes[] = array(
         'colName' => "school_id",
         'colValue' => $school_id
      );
      $attributes[] = array(
         'colName' => "role",
         'colValue' => $role
      );
      $attributes[] = array(
         'colName' => "status",
         'colValue' => $status
      );
      $attributes[] = array(
         'colName' => "email",
         'colValue' => $email
      );
      $attributes[] = array(
         'colName' => "reset_code",
         'colValue' => $reset_code
      );
      $attributes[] = array(
         'colName' => "password",
         'colValue' => $pwd
      );
      $attributes[] = array(
         'colName' => "num_logins",
         'colValue' => 0
      );
      $attributes[] = array(
         'colName' => "login_date",
         'colValue' => 0
      );
      return(parent::InsertBase($id, $attributes));
   }

   function Replace($id, $school_id, $role, $status, $email, $reset_code, $pwd) {
      $attributes[] = array(
         'colName' => "id",
         'colValue' => $id
      );
      $attributes[] = array(
         'colName' => "school_id",
         'colValue' => $school_id
      );
      $attributes[] = array(
         'colName' => "role",
         'colValue' => $role
      );
      $attributes[] = array(
         'colName' => "status",
         'colValue' => $status
      );
      $attributes[] = array(
         'colName' => "email",
         'colValue' => $email
      );
      $attributes[] = array(
         'colName' => "reset_code",
         'colValue' => $reset_code
      );
      $attributes[] = array(
         'colName' => "password",
         'colValue' => $pwd
      );
      return(parent::ReplaceBase($id, $attributes));
   }
}

class PendingUsersTable extends TableBase {

   function __construct() {
      parent::__construct('pending_users');
   } 

   function Modify($id, $email, $school_name, $date) {
   }

   function ReadByEmail($email) {
      $attributes[] = array(
         'colName' => 'email',
         'colValue' => $this->con->real_escape_string($email)
      );
      return(parent::ReadNonID($attributes));
   }

   function Insert($id, $email, $school_name, $date = null) {
      $attributes[] = array(
         'colName' => "id",
         'colValue' => $id
      );
      $attributes[] = array(
         'colName' => "email",
         'colValue' => $email
      );
      $attributes[] = array(
         'colName' => "school_name",
         'colValue' => $school_name
      );
      // $attributes[] = array(
      //    'colName' => "req_date",
      //    'colValue' => $date
      // );
      return(parent::InsertBase($id, $attributes));
   }
}

// ---------------------------------------------------------------------------
// SchoolsTable
//
class SchoolsTable extends TableBase {

   function __construct() {
      parent::__construct('schools');
   } 

   function Modify($id, $name) {
      $setAttributes[] = array(
         'colName' => "name",
         'colValue' => $this->con->real_escape_string(strtoupper($name))
      );
      return(parent::ModifyBase($id, $setAttributes));
   }

   function ReadByName($name) {
      $attributes[] = array(
         'colName' => 'name',
         'colValue' => $this->con->real_escape_string($name)
      );
      return(parent::ReadNonID($attributes));
   }

   function Insert($id, $name) {
      $attributes[] = array(
         'colName' => "id",
         'colValue' => $id
      );
      $attributes[] = array(
         'colName' => "name",
         'colValue' => $this->con->real_escape_string(strtoupper($name))
      );
      return(parent::InsertBase($id, $attributes));
   }

   function Replace($id, $name) {
      $attributes[] = array(
         'colName' => "id",
         'colValue' => $id
      );
      $attributes[] = array(
         'colName' => "name",
         'colValue' => $this->con->real_escape_string(strtoupper($name))
      );
      return(parent::ReplaceBase($id, $attributes));
   }
}

// ---------------------------------------------------------------------------
// RunnersTable
//
class RunnersTable extends TableBase {

   function __construct() {
      parent::__construct('runners');
   } 

   function ReadBySchoolID($school_id) {
      $attributes[] = array(
         'colName' => 'school_id',
         'colValue' => $school_id
      );
      return(parent::ReadNonID($attributes));
   }

   function Modify($id, $name) {
      return(parent::ModifyBase($id, $setAttributes));
   }

   function ModifyAll($id, $school_id, $event_id, $race_id, $sex, 
                  $grade, $first_name, $last_name) {

      $attributes[] = array(
         'colName' => "school_id",
         'colValue' => $school_id
      );
      $attributes[] = array(
         'colName' => "event_id",
         'colValue' => $event_id
      );
      $attributes[] = array(
         'colName' => "race_id",
         'colValue' => $race_id
      );
      $attributes[] = array(
         'colName' => "sex",
         'colValue' => $sex
      );
      $attributes[] = array(
         'colName' => "grade",
         'colValue' => $grade
      );
      $attributes[] = array(
         'colName' => "first_name",
         'colValue' => $this->con->real_escape_string($first_name)
      );
      $attributes[] = array(
         'colName' => "last_name",
         'colValue' => $this->con->real_escape_string($last_name)
      );
      return(parent::ModifyBase($id, $attributes));
   }

   function Insert($id, $school_id, $event_id, $race_id, $sex, 
                  $grade, $first_name, $last_name) {
      $attributes[] = array(
         'colName' => "id",
         'colValue' => $id
      );
      $attributes[] = array(
         'colName' => "school_id",
         'colValue' => $school_id
      );
      $attributes[] = array(
         'colName' => "event_id",
         'colValue' => $event_id
      );
      $attributes[] = array(
         'colName' => "race_id",
         'colValue' => $race_id
      );
      $attributes[] = array(
         'colName' => "sex",
         'colValue' => $sex
      );
      $attributes[] = array(
         'colName' => "grade",
         'colValue' => $grade
      );
      $attributes[] = array(
         'colName' => "first_name",
         'colValue' => $this->con->real_escape_string($first_name)
      );
      $attributes[] = array(
         'colName' => "last_name",
         'colValue' => $this->con->real_escape_string($last_name)
      );
      return(parent::InsertBase($id, $attributes));
   }

   function ReadByRaceID($race_id) {
      $attributes[] = array(
         'colName' => 'race_id',
         'colValue' => $race_id
      );
      return(parent::ReadNonID($attributes));
   }

   function ReadByEventID($event_id) {
      $attributes[] = array(
         'colName' => 'event_id',
         'colValue' => $event_id
      );
      return(parent::ReadNonID($attributes));
   }

   function ReadBySchoolAndSex($school_id, $sex) {
      $attributes[] = array(
         'colName' => 'school_id',
         'colValue' => $school_id
      );
      $attributes[] = array(
         'colName' => 'sex',
         'colValue' => $sex
      );
      return(parent::ReadNonID($attributes));
   }

   function DeleteByEvent($id) {
      $attributes[] = array(
         'colName' => "event_id",
         'colValue' => $id
      );
      return(parent::DeleteNonID($attributes));
   }
}

function GetRunnerListing() 
{
   $event_id = PHPSession::Instance()->GetSessionVariable('event_id');
   $school_id = PHPSession::Instance()->GetSessionVariable('school_id');
   $runners = array();
   $cqObj = new ComplexQueries();

   if (PHPSession::Instance()->GetSessionVariable('role') == UserRoles::Admin) {
      $runners = $cqObj->ReadRunnersByEventID(PHPSession::Instance()->GetSessionVariable('event_id'));
   } else {
      $runners = $cqObj->ReadRunnersBySchoolIDEventID($school_id, $event_id );
   }

   return($runners);
}

function TestSchoolsTable() {
   $s = new SchoolsTable();
   $s->Insert(1, "TA'MU");
   $s->Insert(2, "TAMU");
   $s->Modify(3, "Purdue University, WL");
}


?>