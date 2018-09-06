<?php

/*
How to Use:

PHPSession::Instance()->StartSession ();
PHPSession::Instance()->EndSession ();
PHPSession::Instance()->GetSessionVariable();
PHPSession::Instance()->SetSessionVariable ($name, $value);


*/

class PHPSession
{
   private $SessionActiveM;

   //  Instance returns a reference to the sole instance of the PHPSession
   //  object.

   public static function &Instance ()
   {
      static $instance = NULL;

      if ($instance == NULL)
         $instance = new PHPSession ();

      return $instance;
   }

   //  The constructor initializes this object.

   private function __construct ()
   {
      $this->SessionActiveM = false;
   }

   //  StartSession enables PHP session support if not already initialized.

   public function StartSession ()
   {
      if ($this->SessionActiveM == false)
      {
         session_start ();
         $this->SessionActiveM = true;
      }
   }

   //  EndSession destroys the current PHP session if it has been enabled.

   public function EndSession ()
   {
      if ($this->SessionActiveM == true)
      {
         //  Unset all session variables, delete the session cookie, and destroy
         //  the session file.

         $_SESSION = array ();

         if (array_key_exists (session_name (), $_COOKIE))
         {
            setcookie (session_name (), "", time () - 42000, "/");
         }

         session_destroy ();
      }
   }
   //  GetSessionID returns the ID value assigned to the current session.

   public function GetSessionID ()
   {
      return session_id ();
   }

   //  GetSessionName returns the key name used for the current session.

   public function GetSessionName ()
   {
      return session_name ();
   }

   //  SetSessionVariable sets the specified session variable to the specified
   //  value. If the specified session variable doesn't already exist, it is
   //  created.

   public function SetSessionVariable ($name, $value)
   {
      $name = "_sess_" . $name;
      $_SESSION[$name] = $value;
   }

   //  GetSessionVariable returns the value of the specified session variable
   //  name. If the specified variable does not exist, the GetSessionVariable
   //  function returns NULL.

   public function GetSessionVariable ($name)
   {
      $name = "_sess_" . $name;
      if (array_key_exists ($name, $_SESSION))
      {
         return $_SESSION[$name];
      }
      else
      {
         return NULL;
      }
   }

   //  DeleteSessionVariable removes the specified session variable from the
   //  current session.

   public function DeleteSessionVariable ($name)
   {
      if (array_key_exists ($name, $_SESSION))
      {
         unset ($_SESSION[$name]);
      }
   }

   //  GetAllSessionVariables returns all session variables as an associative
   //  array. If no session exists, it returns NULL.


   public function GetAllSessionVariables ()
   {
      return $_SESSION;
   }

   public function WriteClose ()
   {
      session_write_close();
   }
}


?>