<?php 
     namespace App\classes;
     class Session
     {
          // private $session_name;
          // private $session_value;
          public function __construct()
          {
               session_start();
          }

          public function put_session($name,...$val)
          {
               if(count($val) > 1)
               {
                    echo "ERROR : Count of argument not matched";
                    exit;
               }
               else if(is_array($name) && count($val) > 0)
               {
                    echo "ERROR : Invalid Parameter count, One parameter expected";
                    exit;
               }
               else if(!is_array($name) && count($val) == 0)
               {
                    echo "ERROR : Invalid Parameter Count, Two parameter expected";
                    exit;
               }
               else
               {
                    if(is_array($name))
                    {
                         foreach ($name as $key => $value) {
                              $_SESSION[$key] = $value;
                         }
                    }
                    else
                    {
                         $_SESSION[$name] = $val[0];
                    }
               }
               return true;
          }
          public function session($name)
          {
               if(isset($_SESSION[$name]))
               {
                    $return = $_SESSION[$name]; 
               }
               else
               {
                    echo "ERROR: Undefiend index $name in session";
                    exit;
               }
               return $return;
          }
          public function has_session($name)
          {
               if(isset($_SESSION[$name]))
               {
                    $return = true;
               }
               else
               {
                    $return = false;
               }
               return $return;
          }

          public function delete_session(...$name)
          {
               if(count($name)==0)
               {
                    echo "ERROR : Atleast one parameter expected";
                    exit;
               }
               else
               {
                    for($i=0;$i<count($name);$i++)
                    {
                         if(isset($_SESSION[$name[$i]]))
                         {
                              unset($_SESSION[$name[$i]]);
                         }
                         else
                         {
                              echo "ERROR : Undefiend index ".$name[$i]." in session";
                              exit;
                         }
                    }
               }
               return true;
          }

          public function clear_all_session()
          {
               session_unset();
          }

          public function __destruct()
          {}

     }

     
?>