<?php 
     include_once("App/config/autoload.php");
     use \App\classes\session\Session;
     $session = new Session();
     $session->put_session("name","Brijesh");
     echo $session->session("name");
?>