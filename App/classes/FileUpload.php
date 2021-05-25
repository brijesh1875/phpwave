<?php 
     namespace App\classes;
     include_once($_SERVER['DOCUMENT_ROOT']."/phpwave/App/config/constant.php");
     class FileUpload
     {
          private $file_name;
          private $tmp_name;
          private $file_size;
          private $img_height;
          private $img_width;
          private $file_type;
          private $file_ext;
          private $error;
          private $upload_path;
          private $success;
          const KB = 1024;
          const MB = 1024*1024;
          ##
               // Constructor method
          ##

          public function __construct($file,$remove_space = TRUE)
          {
               if($remove_space === TRUE)
               {
                    $this->file_name = str_replace(" ","_",$file['name']);
               }
               else
               {
                    $this->file_name = $file['name'];
               }
               $this->tmp_name = $file['tmp_name'];
               $this->file_size = $file['size']/self::KB;
               $type_arr = explode("/",$file['type']);
               $this->file_type = $type_arr[0];
               $this->file_ext = $type_arr[1];
               if($this->file_type == 'image')
               {
                    $img = getimagesize($this->tmp_name);
                    $this->img_width =  $img[0];
                    $this->img_height =  $img[1];
               }
               else
               {
                    $this->img_width =  '';
                    $this->img_height =  '';
               }
               $this->error = array();
               $this->success = array();
               $this->upload_path = '';
          }

          ##
               /* Member Methods */
          ##
          public function get_original_name()
          {
               return $this->file_name;
          }
          public function filename($filename)
          {
               $this->file_name = $filename;
          }
          public function to_public($path)
          {
               $this->upload_path = FILE_PATH.ltrim($path,"/");
               return $this;
          }
          public function to_location($path)
          {
               $this->upload_path = $path;
               return $this;
          }
          public function move($max_size=0,$max_height=0,$max_width=0)
          {
               $return = false;
               $size_error = false;
               $height_error = false;
               $width_error = false;
               if(($max_size>0 && $this->file_size <= $max_size) || $max_size == 0)
               {
                    $size_error = false;
               }
               else
               {
                    $size_error = true;
               }
               if(($max_height > 0 && $this->img_height <= $max_height)  || $max_height == 0)
               {
                    $height_error = false;
               }
               else
               {
                    $height_error = true;
               }
               if(($max_width > 0 && $this->img_width <= $max_width)  || $max_width == 0)
               {
                    $width_error = false;
               }
               else
               {
                    $width_error = true;
               }
               if($size_error === false && $height_error === false && $width_error === false)
               {
                    // die($this->upload_path."/".$this->get_original_file_name());
                    if(file_exists($this->upload_path."/".$this->file_name))
                    {
                         $this->error['FILE_ALREADY_EXISTS'] = "File  $this->file_name is already exists";
                         $return =  false;
                    }
                    else
                    {
                         $pos = strpos($this->file_name,".");
                         $filename = str_split($this->file_name,$pos);
                         $filename =  $filename[0];
                         if(move_uploaded_file($this->tmp_name,$this->upload_path."/".$this->file_name))
                         {
                              $this->success = [
                                   "file_name" => $this->file_name,
                                   "file_name_no_ext" =>$filename,
                                   'upload_path' => $this->upload_path,
                                   'file_size' => $this->file_size,
                                   'file_ext' => $this->file_ext,
                                   'height' => $this->img_height,
                                   'width' => $this->img_width,
                                   'type' => $this->file_type,   
                              ];
                              $return = true;
                         }
                         else
                         {
                              $return = false;
                         }
                    }
               }

               else
               {
                    if($size_error === true)
                    {
                         $this->error['SIZE_ERROR'] = "File exceed the maximum upload limit $max_size kb";
                    }
                    if($height_error === true)
                    {
                         $this->error['HEIGHT_ERROR'] = "Image height exceed the maximum height limit $max_height px";
                    }
                    if($width_error === true)
                    {
                         $this->error['WIDTH_ERROR'] = "Image width exceed the maximum width limit $max_width px";
                    }
                    
               }

               return $return;
               
          }

          public function success()
          {
               return $this->success;
          }

          public function error()
          {
               return $this->error;
          }
          function __destruct()
          {

          }
     }
?>