<?php
    //yay db connection class using proceedural php -> mysqli

    class Database
    {
      private $host;
      private $user;
      private $password;
      private $dbName;
      private $dbC;
      function __construct($host, $user, $password, $dbName){
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->dbName = $dbName;
        @$this->dbC = mysqli_connect($this->host,$this->user,$this->password,$this->dbName);

        if (!$this->dbC) {
          die("We were not able to connect to the database " . $this->dbName . "@" . $this->host . " with the given crudentials. Please verify and check all information and retry.");
        }
      }
      //getters
      public function getDBConnection(){return $this->dbC;}
      //check connection
      public function checkDBC(){return @mysqli_ping($this->dbC);}
      //close the current connection
      protected function dbCClose($connection){return mysqli_close($connection);}
    }
?>
