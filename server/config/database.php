<?php

class Database
{
  //DB params
  private $host;
  private $dbname;
  private $username;
  private $password;

  public function __construct()
  {
    $this->host = "";
    $this->dbname = "";
    $this->username = "";
    $this->password = "";
  }
  //Preparation of data
  public function execute($query)
  {

    $conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->username, $this->password);
    $result = $conn->query($query);
    $conn = null;
    return $result;
  }

  public function prepareAndExecute($query, array $params)
  {

    $conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->username, $this->password);
    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $result = $stmt;
    $conn = null;
    return $result;
  }
}
