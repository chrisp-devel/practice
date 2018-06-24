<?php

class Database{

    public $conn;
    public $port_set;


    
    public function connect($host, $user, $password, $db_name, $port=NULL, $charset = 'utf8'){
        
        if(isset($port)){
            $this->conn = new mysqli($host, $user, $password, $db_name, $port);
          
        } else {
            $this->conn = new mysqli($host, $user, $password, $db_name);
            
        }
        
        // Check for errors in the connection and throw an Exception if one.
        // TODO: Remove it on production or point it to a log file.
        if ($this->conn->connect_error) {
            throw new Exception('Connect Error ' . $this->conn->connect_errno . ': ' . $this->conn->connect_error, $this->conn->connect_errno);
        } else {
            //echo "Connection successfull!" . PHP_EOL;
        }

        // Set the default charset for this connection
        mysqli_set_charset($this->conn, $charset);   
    }
    
    public function prepare($query) {

    }





}