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
          $file = new FileUpload($_FILES['image']);
          if($file->to_public("upload")->move(50,0,800))
          {
               echo "<pre>";
               print_r($file->success());
          }
          else
          {
               print_r($file->error());
          }
     }

?>