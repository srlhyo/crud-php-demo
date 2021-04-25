<?php
// connect php to postgreSQL Database using PDO

class Database {
    private $host='localhost';
    private $db = 'weathersafe';
    private $username = 'postgres';
    private $password = '';
    private $conn;
    public $showError;
    public $errorMessage;

    public function __construct($host, $dbname, $username, $password)
    {
        $this->host = $host;
        $this->db = $dbname;
        $this->username = $username;
        $this->password = $password;

        try {
            $this->conn = new PDO($this->dsn());
        
        } catch (PDOException $e) {
            $this->setError($e->getMessage());
        }
    }

    public function close($st) {
        $st->closeCursor();
    }

    public function execute($sql) {
        
        try{
            $statement = $this->conn->query($sql);
            if(!$statement) {
                $this->setError("Database error");
                return null;
            } else {
                return $statement;
            }

        }catch (PDOException $e){
            $this->setError($e->getMessage());
            return null;
        }
    }

    private function setError($message) {
        $this->showError = true;
        $this->errorMessage = $message;
    }

    private function dsn() {
        return "pgsql:host=$this->host;port=5432;dbname=$this->db;user=$this->username;password=$this->password";
    }
  
}