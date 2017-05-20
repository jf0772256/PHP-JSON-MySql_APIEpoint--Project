# PHP-JSON-MySql_APIEpoint--Project
Uses php's mysqli lib to connect to a database, then creates a .json file that can be stored and accessed from the server.


Instructions:

There are two classes that must be present the Database class and the JsonifyMySQLRequests I have them in sepereate files for the time being but if you really wanted you can combine them.

You only however need to include the API file.

```
   $filename = "test_api";
   $filepath = "files/api";
   $myQuery = "SELECT * FROM categories";
   $newHost = "localhost";
   $newUser = "mgs_user";
   $newPassword = "pa55word";
   $dbName = "my_guitar_shop2";

   $api = new JsonifyMySQLRequests($myQuery,$filename,$filepath,$newHost,$newUser,$newPassword,$dbName);
```
			
This is the best way to instance the class, It will inturn instance a connection to the database with the given params, and then return the connection instance to the API.JsonifyMySQLRequests
This call will alos put all the params into the variables to be used. 
To gain access to these varsiables I have provided you with getters and setters:

```
//getters
  public function getQuery(){return $this->queryString;}
  public function getFilename(){return $this->filename . '.json';}
  public function getFilePath(){return $this->filepath;}
  public function getData(){return $this->data;}
	
//setters
  public function setQuery($newQuery){$this->queryString = $newQuery;}
  public function setFileName($newFileName){$this->filename = $newFileName . ".json";}
  public function setFilePath($newFilePath){$this->filepath = $newFilePath;}
```
You can get more data than you can set, the reason for this is simply because I don't see the need to have you have access to this information, $data for instance is an resource array / and later gets converted to an object array.
The methods I have given you access to are simple, but need to be given explination.

ALL accessable methods in this series of classes are able to be chained. (well with exceptioon to the get and set methods, I may add that later)

for the database class you have:
```
  //getters
      public function getDBConnection(){return $this->dbC;}
  //check connection
      public function checkDBC(){return @mysqli_ping($this->dbC);}
  //close the current connection
      protected function dbCClose($connection){return mysqli_close($connection);}
```
Where the getter returns the specific connection (not really to be used this way but can be if you really want to...) the checkDBC tests the connection to the database to test if the connection is still live, and returns the result to the calling function (is used in the example), and the closeConnection() closes the specific connection to the database... This call should only be called when you are done with the API.JsonifyMySQLRequests class methods. There is a close connection there as well that will close the connection directly and that is the perferred way to do it, but again you can do it this way as well...

The API.JsonifyMySQLRequests methods are pretty simple, they go in order, with the parseRequests() which runs the given query (when class is instanced) and fills an array with results and then returns after setting the results to $data.
The jsonifyResults() takes $this->data and converts it into json object, It also corrects for numbers so that they are parsed correctly.
The next function is the writeJSON() It has one parameter and it is not optional, you must give an 'a' or 'a+'for it to not throw an error to you. This is when teh file path and file name variables come into play... If you dont provide a path it will dump out to the root dir of the project. Otherwise give it a PREEXISTING dir path, as of now I dont have it making the dirs, You must have an directory that it can be placed or it will throw an exception. I may add the create dir ability later, but for now make sure that the path is good. If the file exists the file will be unlinked(deleted) and recreated, this is to help resolve some issues with the overall purpose of the class, If you would like comment out the :
```
   if (file_exists($fp)) {
     unlink($fp);
   }
```
and it will keep appending to the end of the file...
It then will open the file(creating it if it doesn't exist) , write to the file in a dump, and then close the file; then returns back to caller.

There is another function in here but It isnt really used and is not yet working... 

As far as usage goes, it's is pretty straight forward:
```
   //this is an example of how you can use setters to then create multiple .json files with different results
   //reather than create new $api instances... Note though that once you close conection it is done and thus important not to
   //run close connection until your done making files.
      $connectionTest = $api->checkDBC();
      if ($connectionTest == 1) {
        echo "Connected successfully!<br />";
        echo $api->getFilePath() . "/" . $api->getFilename();
        echo "<p id='demo'></p>";
      }
      $generatedAPI = $api->parseRequests()->jsonifyResults()->writeJSON('a');
      $api->setFileName('products');
      $api->setQuery("SELECT * FROM products");
      $generatedAPI = $api->parseRequests()->jsonifyResults()->writeJSON('a')->closeConnection();
      if ($api->checkDBC() == 0) {
        echo "API CLASS: I have closed successfully.";
      }
```
You can then use XHTML and Jquery to call in the data, locally or remote, Here is an example of the local jquery request to the json object files:
```
$.getJSON("files/api/test_api.json", function(json) {
    console.log(json); // this will show the info it in firebug console
    for (var i = 0; i < json.length; i++) {
      document.getElementById('demo').innerHTML += json[i].categoryName + "<br />";
    }
});

$.getJSON("files/api/products.json", function(json) {
    console.log(json); // this will show the info it in firebug console
    document.getElementById('demo').innerHTML += "<br />";
    for (var i = 0; i < json.length; i++) {
      document.getElementById('demo').innerHTML += json[i].productName + "<br />";
    }
});
```
This simply prints the code to the page but can be used to do so much more.

I hope that you like this and let me know if you use it, if you find a bug, or if anything else you would like seen added to the library
