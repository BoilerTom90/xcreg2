<?php

require_once("classes/DBAccess.php");
require_once("classes/Constants.php");
require_once("classes/passwordLibClass.php");

$s = new SchoolsTable();
$s->Replace(1, "St. Peter, Arlington Heights, IL");


// Add Admin User, with pwd: admin@123
$u = new UsersTable();
$pwd = password_hash("admin@123", PASSWORD_DEFAULT);
$retVal = $u->Replace(0, 0, UserRoles::Admin, UserStatus::Active, "admin@admin", 0, $pwd);

$pwd = password_hash("0810", PASSWORD_DEFAULT);
$retVal = $u->Replace(1, 1, UserRoles::NonAdmin, UserStatus::Active, "purduetom90@gmail.com", 0, $pwd);

?>