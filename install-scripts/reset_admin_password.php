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

$admin_password = password_hash("admin@321", PASSWORD_DEFAULT);
// For admin user:
// school_id 0, user_id = 0

// note: foreign keys don't work on fatcows, so don't use them.
$sqlCmds = array(
   
   "replace into users (user_id, email, password, role, status, school_id)
    values (0, \"admin@stpeterxc.org\", \"$admin_password\", \"admin\", \"open\", 0)",
   
);

$event_dbs = array(
   "fdm2016",
   "luth2016"
);
foreach ($event_dbs as $evdb) {

   $db_conn = ConnectToDB($evdb);
   foreach ($sqlCmds as $cmd) {
      DoQuery($db_conn, $cmd);
   }
}

echo "</pre>";
?>