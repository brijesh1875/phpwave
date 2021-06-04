<html>
     <head>
          <title>Test </title>
     </head>
     <body>
          <form action='test.php' method='post' enctype="multipart/form-data">
               <input type = 'file' name = 'image'>
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
          // die(SITE_PATH);
          $file = new FileUpload();
          $file->file_detail($_FILES['image']);
          print_r($file->get_file_details());
     }


?>