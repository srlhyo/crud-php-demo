<?php
// connect php to postgreSQL Database using PDO

class Database {
    private $host;
    private $db;
    private $username;
    private $password;
    private $conn;

    public function __construct($host, $dbname, $username, $password)
    {
        $this->host = $host;
        $this->db = $dbname;
        $this->username = $username;
        $this->password = $password;
        $this->conn = new PDO($this->dsn());
    }

    public function close($st) {
        $st->closeCursor();
    }

    public function execute($sql) {
        return $this->conn->query($sql);
    }

    private function dsn() {
        return "pgsql:host=$this->host;port=5432;dbname=$this->db;user=$this->username;password=$this->password";
    }
  
}