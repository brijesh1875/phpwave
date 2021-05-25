<?php 
     spl_autoload_register(function($classname){
          if(file_exists($classname.".php"))
          {
               include_once str_replace("\\","/",$classname).".php";
          }
     });
?>