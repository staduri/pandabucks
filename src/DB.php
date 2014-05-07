<!---->
<!--Example Usage: In another file-->
<!---->
<?php
//require_once('classes/DB.class.php');
//
//class SomeClass {
//    private $db;
//
//    public function __construct() {
//        $this->db = new DB();
//    }
//
//    public function getDestinationUrl($campaign_name) {
//        $sql = "select destination_url from campaign_index where campaign_name='$campaign_name'";
//        $result = pg_fetch_result($this->db->query($sql),0);
//        return $result;
//    }
//}
//
?>

<?php
//DB.class.php

class DB {

    protected $db_name = 'pandabucks';
    protected $db_user = 'ec2-user';
    protected $db_pass = '';
    protected $db_host = 'localhost';
    protected $db_port = '5432';

    private $connection;

    function __construct() {
        $this->connection = $this->connect();
    }

    public function connect() {
        $connection = pg_connect ("host=$this->db_host port=$this->db_port dbname=$this->db_name user=$this->db_user password=$this->db_pass");
        return $connection;
    }

    public function processRowSet($rowSet, $singleRow=false)
    {
        $resultArray = array();
        while($row = pg_fetch_assoc($rowSet)) {
            array_push($resultArray, $row);
        }

        if($singleRow === true) {
            return $resultArray[0];
        }

        return $resultArray;
    }

    public function select($table, $where) {
        $sql = "SELECT * FROM $table WHERE $where";
        $result = pg_query($this->connection, $sql);
        if(pg_num_rows($result) == 1) {
            return $this->processRowSet($result, true);
        }

        return $this->processRowSet($result);
    }

    public function update($data, $table, $where) {
        foreach ($data as $column => $value) {
            $sql = "UPDATE $table SET $column = $value WHERE $where";
            pg_query($sql) or die(pg_error());
        }
        return true;
    }

    public function insert($data, $table) {
        $columns = "";
        $values = "";

        foreach ($data as $column => $value) {
            $columns .= ($columns == "") ? "" : ", ";
            $columns .= $column;
            $values .= ($values == "") ? "" : ", ";
            $values .= $value;
        }

        $sql = "insert into $table ($columns) values ($values)";

        pg_query($sql) or die(pg_error());

        //return the ID of the user in the database.
        return 1; //pg_insert_id();
    }

    public function query($sql) {
        $result = pg_query($sql);
        return $result;
    }
}
?>