<?php 
     namespace App\classes;
     include_once($_SERVER['DOCUMENT_ROOT']."/phpwave/App/config/constant.php");
     class FileUpload
     {
          /* Data members */
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
          private $remove_space;

          # Constant data members #
          const KB = 1024;
          const MB = 1024*1024;

          public function __construct($remove_space = true)
          {
               $this->remove_space = $remove_space;
               $this->file_name = '';
               $this->tmp_name = '';
               $this->file_size = '';
               $this->img_height = '';
               $this->img_width = '';
               $this->file_type = '';
               $this->file_ext = '';
               $this->error = array();
               $this->upload_path = '';
               $this->success = array();
          }

          public function file_detail($file)
          {
               if(is_array($file['name']))
               {
                  $count = count($file['name']);
                  for($i=0;$i<$count;$i++)
                  {
                    if($this->remove_space === true)
                    {
                         $this->file_name[$i] = str_replace(" ", "_", $file['name'][$i]);
                    }
                    else
                    {
                    $this->file_name[$i] = $file['name'][$i];
                    }
                    $this->tmp_name[$i] = $file['tmp_name'][$i];
                    $this->file_size[$i] = $file['size'][$i]/self::KB;
                    $type_arr = explode("/",$file['type'][$i]);
                    $this->file_type[$i] = $type_arr[0];
                    $this->file_ext[$i] = $type_arr[1];
                    if($this->file_type[$i] == 'image')
                    {
                         $img = getimagesize($this->tmp_name[$i]);
                         $this->img_width[$i] =  $img[0];
                         $this->img_height[$i] =  $img[1];
                    }
                    echo $this->file_name[$i];
                  }
                  print_r($this->file_name);
               }
               else
               {
                    if($this->remove_space === TRUE)
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
               }
               return $this;
          }

          public function get_file_details()
          {
               $file_attr=[];
                    if(is_array($this->file_name))
                    {
                         echo "hello";
                    }
                    else
                    {
                         $file_attr = [
                              "name" => $this->file_name,
                              "type" => $this->file_type."/".$this->file_ext,
                              "size" => $this->file_size,
                              "width" => $this->img_width,
                              "height" => $this->img_height
                         ];
                    }
               return $file_attr;
          }
          public function get_file_name()
          {
               return $this->file_name;
          }
          public function set_file_name($filename)
          {
               if(is_array($filename))
               {
                    for($i=0;$i<count($filename);$i++)
                    {
                         if($this->remove_space === TRUE)
                         {
                              // $this->file_name
                         }
                    }
               }
               else
               {
                    if($this->remove_space === TRUE)
                    {
                         $this->file_name = str_replace(" ","_",$file['name']);
                    }
                    else
                    {
                         $this->file_name = $file['name'];
                    }
               }
          }

          public function __destruct()
          {

          }



     }
/*
          public function __construct($file,$remove_space = TRUE)
          {
               // echo "<pre>";
               // print_r($file);
               // die();
               if(!is_array($file['name']))
               {
                    if($remove_space === TRUE)
                    {
                         $this->remove_space = TRUE;
                         $this->file_name = str_replace(" ","_",$file['name']);
                    }
                    else
                    {
                         $this->remove_space = FALSE;
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
               else
               {
                   for($i=0; $i<count($file['name']); $i++)
                   {
                         if($remove_space === TRUE)
                         {
                              $this->remove_space = TRUE;
                              $this->file_name[$i] = str_replace(" ","_",$file['name'][$i]);
                         }
                         else
                         {
                              $this->remove_space = FALSE;
                              $this->file_name[$i] = $file['name'][$i];
                         }
                         $this->tmp_name[$i] = $file['tmp_name'][$i];
                         $this->file_size[$i] = $file['size'][$i]/self::KB;
                         $type_arr = explode("/",$file['type'][$i]);
                         $this->file_type[$i] = $type_arr[0];
                         $this->file_ext[$i] = $type_arr[1];
                         if($this->file_type[$i] == 'image')
                         {
                              $img = getimagesize($this->tmp_name[$i]);
                              $this->img_width[$i] =  $img[0];
                              $this->img_height[$i] =  $img[1];
                         }
                         else
                         {
                              $this->img_width[$i] =  '';
                              $this->img_height[$i] =  '';
                         }
                         $this->error = array();
                         $this->success = array();
                         $this->upload_path[$i] = '';
                   }
               //     echo "<pre>";
               //     print_r($this);
               //     exit;
               }
          }

          ##
               /* Member Methods 
          ##
          public function get_original_name()
          {
               return $this->file_name;
          }
          public function filename($filename)
          {
               if(is_array($filename))
               {
                    for($i=0; $i<count($filename); $i++)
                    {
                         if($this->remove_space === TRUE)
                         {
                              $this->file_name[$i] = str_replace(" ","_",$filename[$i]); 
                         }
                         else
                         {
                              $this->file_name[$i] = $filename[$i]; 
                         }
                    }
               }
               else
               {
                    $this->file_name = $filename;
               }
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
               if(is_array($this->file_name))
               {
                    for($i=0;$i<count($this->filename); $i++)
                    {
                         if(($max_size>0 && $this->file_size[$i] <= $max_size) || $max_size == 0)
                         {
                              $size_error[$i] = false;
                         }
                         else
                         {
                              $size_error[$i] = true;
                              echo "ERROR : SIZE ERROR = size is greater than $max_size or invalid";
                         }
                         if(($max_height > 0 && $this->img_height[$i] <= $max_height)  || $max_height == 0)
                         {
                              $height_error = false;
                         }
                         else
                         {
                              $height_error = true;
                              echo "ERROR : HEIGHT ERROR = exceeds the maximum height limit";
                         }
                         if(($max_width > 0 && $this->img_width[$i] <= $max_width)  || $max_width == 0)
                         {
                              $width_error = false;
                         }
                         else
                         {
                              $width_error = true;
                              echo "ERROR : WIDTH ERROR = exceeds the maximum widht limit";
                         }
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
               }
               else
               {
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
     }*/
?>