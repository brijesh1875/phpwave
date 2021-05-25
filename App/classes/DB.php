<?php
namespace App\classes;
class DB
{
     /* 
          private data memebers start
      */
     private $field_name;
     private $field_value;
     private $set;
     private $where;
     private $select;
     private $query;
     private $order;
     private $limit;
     private $join='';

     /* 
          protected data members
     */
     protected $host;
     protected $user;
     protected $pass;
     protected $db;

     /* 
          public data members
     */
	public $con;

    /**
      * constructor method
      **/

     function __construct($db,$host='localhost',$user='root', $pass='')
	{
          $this->host = $host;
          $this->user = $user;
          $this->pass = $pass;
		$this->con = new \mysqli($host,$user,$pass,$db);
          if(!$this->con)
          {
               echo "ERROR: ".$this->con->connect_error;
          }
	}
	
     /* 
          Helper methods
     */
     private function real_values($fields)
     {
          $values = '';
          foreach ($fields as $key => $value) {
               $values.="'".$this->con->real_escape_string($value)."', ";
          }
          $values = rtrim($values, ", ");
          return $values;
     }
     private function get_field_value($divider,$fields)
     {
          $return  = '';
          foreach ($fields as $key => $value) {
               $return .=$key. " = '".$this->con->real_escape_string($value)."' $divider";
          }
          $return = rtrim($return, " $divider");
          return $return;
     }
     private function get_fields($fields)
     {
          $field = '';
          foreach ($fields as $key => $value) {
               $field .= $key.", ";
          }
          $field = rtrim($field, ', ');
          return $field;
     }

     private function execute_query($query, $id=false)
     {
          $return = '';
          $select=false;
          if(stristr($query,"select") == true)
          {
               $select = true;
          }
          if($select === true)
          {
               $result=[];
               $res = $this->con->query($query);
               while($row = $res->fetch_assoc())
               {
                    $result[] = $row;
               }
               $return = $result;
          }
          else
          {
               if($this->con->query($query))
               {
                    if($id!=true)
                    {
                         $return = true;
                    }
                    else
                    {
                         $last_id = $this->con->insert_id;
                         $return = $last_id;
                    }
               }
               else
               {
                    echo "ERROR : ".$this->con->error;
                    $return = false;
               }
          }

          return $return;
     }


	/*
		**
			Functionality Methods
		**
	*/
	public function insert($table, $fields)
	{
          $this->field_name = $this->get_fields($fields);
          $this->field_value = $this->real_values($fields);
		$this->query = "INSERT INTO `$table` ($this->field_name) VALUES ($this->field_value)";
		return $this->execute_query($this->query);
	}
	
	public function get_insert_id($table, $fields)
	{
          $this->field_name = $this->get_fields($fields);
          $this->field_value = $this->real_values($fields);
		$this->query = "INSERT INTO `$table` ($this->field_name) VALUES ($this->field_value)";
		return $this->execute_query($this->query,true);
	}
	
	public function delete($table,$id)
	{
          $this->query = "DELETE FROM `$table` WHERE id = ";
          $return = true;
          if(is_array($id))
          {
               for($i = 0; $i < count($id); $i++)
               {
                    $this->query .= $id[$i];
                    if(!$this->execute_query($this->query))
                    {
                         $return = false;
                         break;
                    }
                    $this->query = rtrim($this->query, $id[$i]);
               }
          }
          else
          {
               $this->query .= $id;
               if(!$this->execute_query($this->query))
               {
                    $return = false;
               }

          }
          return $return;
	}

     public function set($fields)
     {
          $this->set = " SET ".$this->get_field_value(", ",$fields);
          return $this;

     }
     public function where($cond)
     {
          $this->where = " WHERE ".$this->get_field_value(" AND ", $cond);
          return $this;
     }
     public function where_or($fields)
     {
          $this->where = ' WHERE '.$this->get_field_value(" OR ", $fields);
          return $this;
     }
     public function update($table)
     {
          $this->query = "UPDATE `$table`".$this->set.$this->where;
          return $this->execute_query($this->query);
     }

     public function group_update($table, $fields, $id)
     {
          $return = true;
          $this->set = ' SET '.$this->get_field_value(", ",$fields);
          $this->query = "UPDATE `$table` ".$this->set." WHERE id = ";
          if(is_array($id))
          {
               for($i=0; $i<count($id); $i++)
               {
                    $this->query.=$id[$i];
                    if(!$this->execute_query($this->query))
                    {
                         $return = false;
                         break;
                    }
                    $this->query = rtrim($this->query, $id[$i]);
               }
          }
          else
          {
               $this->query.=$id;
               if(!$this->execute_query($this->query))
               $return = false;
          }
          
          return $return;

     }

     public function select($field='*')
     {
          $this->select = "SELECT $field ";
          return $this;
     }
     
     public function get($table)
     {
          if($this->select == '')
          {
               $this->query="SELECT * FROM $table $this->join $this->where $this->order $this->limit";
          }
          else
          {
               $this->query=$this->select." FROM $table $this->join $this->where $this->order $this->limit";
          }
          return $this->execute_query($this->query);
     }

     public function order_by($field,$method='ASC')
     {   
          $this->order = " ORDER BY $field $method";
          return $this;
     }
     public function limit($limit,$offset='')
     {
          $this->limit = " LIMIT ";
          if($offset!='')
          {
               $this->limit.="$limit OFFSET $offset";
          }
          else
          {
               $this->limit.=$limit;
          }
          return $this;
     }
     public function join($join, $table, $fields)
     {
          $join = strtoupper($join);
          $this->join .= " $join JOIN $table ON $fields ";
          // echo $this->join;
          return $this;
     }

     #use id = true for getting last_inserted id;

     public function query($query,$id=false)
     {
          $return = '';
          $return = $this->execute_query($query,$id);
          return $return;
     }
	/**
      * Destructor method
      */
	function __destruct()
	{
		$this->con->close();
	}
}

