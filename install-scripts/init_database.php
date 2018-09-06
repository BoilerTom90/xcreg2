<?php

require_once('connection_properties.inc.php');
require('../classes/passwordLib.php');

$server_conn = null;
$db_conn     = null;

function DoQuery($conn, $cmd)
{
   echo "$cmd";
   if ($conn->query($cmd) === TRUE) {
      echo "\n\t>>>\tSuccess\n";
   } else {
      echo "\n\t>>>\tFailure: $conn->error\n";
   }
}


function ConnectToServer()
{
   global $server_conn, $mysql_servername, $mysql_username, $mysql_password;
   
   $mysql_servername2 = "thoffmannet.fatcowmysql.com";
   $mysql_username2   = "xcreg_2016";
   $mysql_password2   = "xcreg_2016_123";
   
   // Attempt to connect locally first, and if that fails, try fatcows.
   $server_conn = new mysqli($mysql_servername, $mysql_username, $mysql_password);
   // Check connection
   if ($server_conn->connect_error) {
      echo "Failed via local host. Trying fatcow properties...";
      $server_conn = new mysqli($mysql_servername2, $mysql_username2, $mysql_password2);
      if ($server_conn->connect_error)
         die("Connection failed: " . $server_conn->connect_error);
   }
   return ($server_conn);
}

function ConnectToDB($db)
{
   global $db_conn, $mysql_servername, $mysql_username, $mysql_password;
   
   $mysql_servername2 = "thoffmannet.fatcowmysql.com";
   $mysql_username2   = "xcreg_2016";
   $mysql_password2   = "xcreg_2016_123";
   
   // Attempt to connect locally first, and if that fails, try fatcows.
   $db_conn = new mysqli($mysql_servername, $mysql_username, $mysql_password, $db);
   // Check connection
   if ($db_conn->connect_error) {
      echo "Failed via local host. Trying fatcow properties...";
      $db_conn = new mysqli($mysql_servername2, $mysql_username2, $mysql_password2, $db);
      if ($db_conn->connect_error)
         die("Connection failed: " . $db_conn->connect_error);
   }
   return ($db_conn);
}

echo "<pre>";

$server_conn = ConnectToServer();

// Attempt to drop the top-level (xcreg) database.
// $sqlCmd = "DROP DATABASE $mysql_dbname";
// echo "$sqlCmd";
// if ($server_conn->query($sqlCmd) === TRUE) {
//   echo "\n\t>>>\tSuccess\n";
//} else {
//   echo "\n\t>>>\tFailure: $server_conn->error\n";
//}


// Attempt to create the top-level (xcreg) database.
$sqlCmd = "CREATE DATABASE IF NOT EXISTS $mysql_dbname";
echo "$sqlCmd";
if ($server_conn->query($sqlCmd) === TRUE) {
   echo "\n\t>>>\tSuccess\n";
} else {
   echo "\n\t>>>\tFailure: $server_conn->error\n";
}




// Now, create the 'events' database inside the top-level (xcreg) database.

$sqlCmds = array(
   "CREATE TABLE IF NOT EXISTS events (
      event_id               INT NOT NULL,
      event_name             varchar(25),
      event_db               varchar(8),
      race_date              date,
      registration_open      TINYINT,
      collect_shirt_info     TINYINT,
      PRIMARY KEY (event_id),
      UNIQUE (event_name), UNIQUE(event_db));",
   
//   "replace into events (event_id, event_name, event_db, race_date, registration_open, collect_shirt_info)
//        values (1, \"FDM MS XC Invitational\", \"fdm2017\", \"2017-09-30\", 1, 0)",
   
   "replace into events (event_id, event_name, event_db, race_date, registration_open, collect_shirt_info)
        values (2, \"Lutheran National XC Meet\", \"luth2017\", \"2017-10-25\", 0, 0)"
);

$db_conn = ConnectToDB($mysql_dbname);
foreach ($sqlCmds as $sqlCmd) {
   echo "$sqlCmd";
   if ($db_conn->query($sqlCmd) === TRUE) {
      echo "\n\t>>>\tSuccess\n";
   } else {
      echo "\n\t>>>\tFailure: $db_conn->error\n";
   }
}


$admin_password = password_hash("admin@321", PASSWORD_DEFAULT);
// For admin user:
// school_id 0, user_id = 0

// note: foreign keys don't work on fatcows, so don't use them.
$sqlCmds = array(
   "CREATE TABLE IF NOT EXISTS schools (
      school_id              INT,
      school_name            varchar(30) NOT NULL,
      PRIMARY KEY (school_id),
      UNIQUE (school_name));",
   
   "replace into schools (school_id, school_name) 
    values (0, \"-- admin account --\")",
      
   "CREATE TABLE IF NOT EXISTS users (
      user_id          INT,
      email            varchar(100) not null,
      password         varchar(100),
      role             varchar(10) not null, 
      status           varchar(10), 
      school_id        INT,    -- each user is associated with a school
      pwd_reset_code   INT,    -- pwd reset code (php timestamp when code expires)
      primary key (user_id),
      unique (email));",
   
   "replace into users (user_id, email, password, role, status, school_id)
    values (0, \"admin@stpeterxc.org\", \"$admin_password\", \"admin\", \"open\", 0)",
   
   "CREATE TABLE IF NOT EXISTS runners (
      runner_id        INT NOT NULL,
      school_id        INT,
      first_name       varchar(25),
      last_name        varchar(25),
      grade            TINYINT,       -- valid set (3, 4, 5, 6, 7, 8)
      sex              varchar(1),       -- Valid Set (M, F)
      PRIMARY KEY (runner_id),
      UNIQUE(school_id, first_name, last_name));",
   
   "create table if not exists shirts (
      school_id int not null,
      num_youth_medium int,
      num_youth_large  int,
       num_adult_small  int,
       num_adult_medium int,
       num_adult_large  int,
       num_adult_xl     int,
       num_adult_xxl    int,
       primary key (school_id)
   );"
);

$event_dbs = array(
   "fdm2018"
);
foreach ($event_dbs as $evdb) {
   echo "\nCreating database $evdb and its tables!\n";
   // DoQuery($server_conn, "drop database if exists $evdb");
   DoQuery($server_conn, "create database if not exists $evdb");
   $db_conn = ConnectToDB($evdb);
   foreach ($sqlCmds as $cmd) {
      DoQuery($db_conn, $cmd);
   }
}

echo "</pre>";
?>