<?php 
  class Database extends PDO{
    // DB Params
    private $host = '127.0.0.1:3306';
    private $db_name = 'myblog';
    private $username = 'root';
    private $password = '!QAZ2wsx';
    private $conn;
    // $username = "root";
    // $password = "!QAZ2wsx";
    // $serverName = "127.0.0.1";
    // $dbName = "maids";
    // $connection = new mysqli($serverName, $username, $password, $dbName);
   // DB Connect
    //$pdo = new PDO('mysql:host=localhost;dbname=myblog', $this->username, $this->password);

    public function connect() {
      try { 

        $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo 'Connection Error: ' . $e->getMessage();
      }

      return $this->conn;
    }
    // function connect()
    // {
    //     $username = "root";
    //     $password = "!QAZ2wsx";
    //     $serverName = "127.0.0.1";
    //     $dbName = "myblog";
    //     $connection = new mysqli($serverName, $username, $password, $dbName);
    //     if ($connection->connect_error) {
    //         die("Connection failed" . $connection->connect_error);
    //     }
    //     return $connection;
    // }
  }

