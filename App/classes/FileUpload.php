<?php 
     namespace App\classes;
     include_once($_SERVER['DOCUMENT_ROOT']."/phpwave/App/config/constant.php");
     class FileUpload
     {
          private $file_name;
          private $file_size;
          private $file_type;
          private $tmp_name;
          private $error;
          private $prefrences;
          private $success;
          const KB = 1024;
          const MB = 1024*1024;
          public function __construct($file)
          {
               $this->prefrences = array(
                    "upload_path" => FILE_PATH,
                    "allowed_type" => '',
                    "file_name" => '',
                    "remove_spaces" => TRUE,
                    "max_size" => 0,
                    "max_height" => 0,
                    "max_width" => 0
               );
               $this->success = array();
               $this->error = [
                    "PREFRENCE_VALUE_NOT_NULL" => '',
               ];
               if(!is_array($file['name']))
               {
                    $this->file_name = str_replace(" ","_",$file['name']);
                    $this->file_size = $file['size'];
                    $this->file_type = $file['type'];
                    $this->tmp_name = $file['tmp_name'];
               }
               else
               {
                    if(!isset($file['name'][1]))
                    {
                         $this->file_name = $file['name'][0];
                         $this->file_size = $file['size'][0];
                         $this->file_type = $file['type'][0];
                         $this->tmp_name = $file['tmp_name'][0];
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
                         }
                    }
               }
          }

          public function do_upload($config)
          {
               if(array_key_exists("upload_path",$config))
               {
                    if(!is_array($this->file_name))
                    {
                         foreach($config as $pref_attr => $pref_value )
                         {
                              if(array_key_exists($pref_attr,$config) && $pref_value !='')
                              {
                                   if($pref_attr == "upload_path")
                                   {
                                        $this->prefrences['upload_path'] .= ltrim($config['upload_path'],'/');
                                   }
                                   else
                                   {
                                        $this->prefrences[$pref_attr] = $pref_value;
                                   }
                              }
                              else
                              {
                                   $this->error['PREFRENCE_VALUE_NOT_NULL'] .="$pref_attr, "; 
                              }
                         } 
                         if($this->error['PREFRENCE_VALUE_NOT_NULL'] != '')    
                              $this->error['PREFRENCE_VALUE_NOT_NULL'] = rtrim($this->error['PREFRENCE_VALUE_NOT_NULL'],", ")." cannot be null ";
                         if($this->prefrences['file_name'] == '')
                              $this->prefrences['file_name'] = $this->file_name;
                              // echo $this->prefrences['file_name'];
                         if(file_exists(basename(FILE_PATH.$this->prefrences['file_name'])))
                         {
                              echo "File already exists";
                         }
                         else
                         {
                              echo "not exists";
                         }
                    }
               }
               else
               {
                    $this->error['UPLOAD_PATH_MISSING'] = "Upload Path is empty";
               }
          }

          function upload_error()
          {
               // echo "<pre>";
               if(!empty($this->error))
               {
                    foreach($this->error as $error_type => $error_msg);
                    {
                         if($error_msg != '')
                              echo "Error -> $error_type : $error_msg";
                    }
               }
               exit;
          }
          function __destruct(){}
     }
?>