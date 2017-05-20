<?php

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
  protected function getDBConnection(){return $this->dbC;}
  //check connection
  public function checkDBC(){return @mysqli_ping($this->dbC);}
  //close the current connection
  protected function dbCClose($connection){return mysqli_close($connection);}
}

/**
 * API File generator and reader
 */
class  JsonifyMySQLRequests extends Database
{

    private $queryString;
    private $filename;
    private $filepath;
    private $data;
    private $DBC;

  /**
  * Constructor
  * @$myQuery string of db query details
  * @$filename string of the name of the file
  * @$filepath string of where thefile resides, Default '.'
  * Includes connection to parent class (database) and needs its required fields
  * @$host is the host of the database
  * @$user is the user that has access to the database
  * @$password is the password for the user
  * @$database is the database where you wish to access (name)
  **/
  function __construct($myQuery, $fileName, $filepath = ".",$host,$user,$password,$database)
  {

    parent::__construct($host,$user,$password,$database);
    //$combinedFN = $fileName .
    $this->DBC = parent::getDBConnection();
    $this->queryString = $myQuery;
    $this->filename = $fileName . ".json";
    $this->filepath = $filepath;
  }

  //getters
  public function getQuery(){return $this->queryString;}
  public function getFilename(){return $this->filename . '.json';}
  public function getFilePath(){return $this->filepath;}
  public function getData(){return $this->data;}

  //setters
  public function setQuery($newQuery){$this->queryString = $newQuery;}
  public function setFileName($newFileName){$this->filename = $newFileName . ".json";}
  public function setFilePath($newFilePath){$this->filepath = $newFilePath;}

  /**
  ** Purpose: Parses return data into an array of values to be returned to caller or chained
  ** @$queryString preformatted and bound string query to be processed by the database.
  **/
  public function parseRequests(){
    $parseData = [];

    //$query = mysqli_prepare($this->DBC,$this->queryString);
    $retVal = mysqli_query($this->DBC, $this->queryString);

    while ($data = mysqli_fetch_assoc($retVal))
    {
      $parseData[] = $data;
    }
    $this->data = $parseData;
    return $this;
  }

  /**
  ** Purpose: returns a formatted JSON object array with the array passed to it
  ** @$data Array to be formatted and returned as a JSON array or written to a file
  **/
  public function jsonifyResults(){
    $value = $this->data;
    $this->data = json_encode($value, JSON_NUMERIC_CHECK);
    return $this;
  }

  /**
  ** Purpose: processes json and outputs to a file
  ** @$writeType is the file open for type: ACCEPTS ONLY REITE VALUES!
  ** Accepted write values are : a and a+
  **/
  public function writeJSON($writeType){
    if ($writeType == "a" || $writeType == "a+"){
      //set Vars
      $fp = "";
      // $wholejson;

      //check if path is given
      if ($this->filepath == "."){
        $fp = $this->filename;
      }else{
        $fp = $this->filepath . "/" . $this->filename;
      }

      if (file_exists($fp)) {
        unlink($fp);
      }
    // var_dump($fp);
      //open file for writing data to json file.
      $newFile = fopen($fp, $writeType) or die("Error: The specified file (".$fp.") could not be opened. Please verify that the file is correctly set up to be modifies and or that the file path is valid.");
      // foreach ($this->data as $value) {
      //   $wholejson += $value;
      // }
      //$wholejson = json_encode($wholejson);
      fwrite($newFile,$this->data);
      fclose($newFile);
      return $this;
    } else {
      // an invalid option was used and we will throw an exception
      throw new Exception("Error Processing Request: Invalid type was passed for this function. Accepted values are a, and a+.", 1);
    }
  }

  /**
  * Purpose: opens and reads a json file into memory for access
  **/
  public function readJSONFile(){
    //assumes read only.
    //set Vars
    $fp = "";

    //check if path is given
    if ($this->filepath == ""){
      $fp = $this->filename;
    }else{
      $fp = $this->filepath . "/" . $this->filename;
    }

    //open file for writing data to json file.
    $newFile = fopen($fp, "r") or die("Error: The specified file (".$fp.") could not be opened. Please verify that the file is correctly set up to be modifies and or that the file path is valid.");
    $this->data = json_decode(fread($newFile,filesize($fp)));
    fclose($newFile);
    return $this;
  }

  public function closeConnection(){
    $retVal = parent::dbCClose($this->DBC);
    return $this;
  }
}
?>
