<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Db{
    /** var $con PDO resource **/
    protected $con = "";
    
    /** var $host string**/
    protected $host = "";
    
    /** $user string **/
    protected $user = "";
    
    /** $pwd  string **/
    protected $pwd = "";
    
    /** $db string **/
    protected $db = "";
    
    /** $stmt  string**/
    protected $stmt = "";
    
    /** $exceptions array **/
    protected $exceptions = [];


    /**
     * constructor class, this initializes the database connection
     * setting the values reqiured for setting up a connection
     * @param string $dbtype - the database type e.g mysql, postgres e.t.c
     * @param string $host - the host, e.g localhost or an ip address
     * @param string $user - user for thr database with permissions
     * @param string $pwd  - password for the set user
     * @param string $db   - name for the database to connect to
     */
    protected function __construct($dbtype, $host, $user, $pwd, $db){
        $this->host = $host
             ->user = $user
             ->pwd = $pwd
             ->db = $db;
        
        $this->con = new PDO("$dbtype:host=>$this->host;dbname=$this->db", $this->user, $this->pwd);
    }
    
    /*
     * prepare an sql statement for data manipulation 
     * @param string $sql - valid sql statement
     * @return $this db object
     */
    public function prepare($sql){
        try{
         $this->stmt = $this->con->prepare($sql);
        }catch(PDOException $e){
            $this->exceptions = $e->getMessage() ." on Line ". $e->getLine();
            return false; 
        }
        return $this;
    }
    
    /**
     * bind each array value to an sql value position
     * @param array $values
     * @return $this db object
     */
    public function bindWithStatements(array $values){
        $count = count($values);
        for($i = 0; $i < $count; $i++){
            $this->stmt->bind($i, $values[$i]);
        }
        return $this;
    }
    
    /**
     * exceute sql statements and return true if nor errors <br />
     * return false if errors
     * @return boolean 
     */
    public function executeSql(){
        if($this->stmt->execute){
            return true;
        }
        return false;
    }
    
    /**
     * fetch exceptions caught 
     */
    
    public function getExceptions(){
        if($this->exceptions){
           return $this->exceptions;
        }
        return false;
    }
    
}

