<html>
     <head>
          <title>Test </title>
     </head>
     <body>
          <form action='test.php' method='post' enctype="multipart/form-data">
               <input type = 'file' name = 'image[]' multiple>
               <input type = 'submit' name = 'submit' value='Upload'>
          </form>
     </body>
</html>

<?php 
     include_once("App/config/autoload.php");
     use \App\classes\FileUpload;
     use \App\classes\Session;
     if(isset($_POST['submit']))
     {
          $file = new FileUpload($_FILES['image']);
          
          

     }

?>