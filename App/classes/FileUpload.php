<?php 
     namespace App\classes;
     class FileUpload
     {
          private $file_name;
          private $file_size;
          private $file_type;
          private $tmp_name;
          private $error;
          private $size;
          private $location;
          const KB = 1024;
          const MB = 1024*1024;
          public function __construct($file)
          {
               echo "<pre>";
               print_r($file);
               if(!isset($file['name'][1]))
               {
                    $this->file_name = $file['name'][0];
                    $this->file_size = $file['size'][0];
                    $this->file_type = $file['type'][0];
                    $this->tmp_name = $file['tmp_name'][0];
                    $this->error = '';
               }
               else
               {
                    $count = count($file['name']);
                    for($i=0;$i<$count;$i++)
                    {
                         $this->file_name[$i] = $file['name'][$i]; 
                         $this->file_size[$i] = $file['size'][$i];
                         $this->file_type[$i] = $file['type'][$i];
                         $this->tmp_name[$i] = $file['tmp_name'][$i];
                         $this->error = '';
                    }
               }
          }

          public static function upload($config)
          {
               echo "<pre>";
               print_r($config);
          }
     }
?>