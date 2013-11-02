<?

class Database {
	private $lastResult;
	private $connection;
    private $debug = true;
	
	public function __construct($host, $user, $pass, $db) {
		$this->lastResult = NULL;
		$this->connection = mysqli_connect ( $host, $user, $pass, $db ) or die ( 'HOST ERROR.' );
		mysqli_select_db ( $this->connection, $db ) or die ( 'DATABASE ERROR.' );
	}
	
	public function isConnected() {
		return $this->connection;
	}
	private function tableExists($tableName) {
		$this->query ( "SHOW TABLES LIKE '$tableName'" );
		$table_exists = $this->numRows () != 0;
		return $table_exists;
	}
	public function query($query) {
		//echo "this is the last query : $query <br />";
		$this->lastResult = mysqli_query ( $this->connection, $query );
                if ($this->lastResult == false && $this->debug)
                    echo "$query is a BAD QUERY!!!";
		return $this->lastResult;
	}
	
	/*the difference between execute and query is that query saves the last query
     *but execute does not*/
	public function execute($query) {
		return mysqli_query ( $this->connection, $query );
	}
	
	/* this function takes the name of the table, an array of the name of the fields that you want to insert
        * and also an array of values that you want to insert and insert it to the table*/
	
	public function insert($tableName, $columns, $values, $where = "") {
		$q = "INSERT INTO $tableName ($columns) VALUES ($values)";
		//echo $q;
		if ($where != "")
			$q .= "WHERE $where";
		$this->query ( $q );
		return mysqli_affected_rows ( $this->connection );
	}
	
    public function update($tableName, $set, $where="")
	{
		$q = "UPDATE $tableName SET $set WHERE $where";
		//echo $q . "<br />";
		return $this->query ( $q );
	}
    
	public function delete($tableName, $where = "") {
		$q = "DELETE FROM $tableName WHERE $where";
		//echo "<h1>$q</h1>";
		$this->query ( $q );
		return mysqli_affected_rows ( $this->connection );
	}
	
    public function select($tablesNames = "", $fields = "", $where = "", $groupby = "" , $sortby = "", $limit = "" ) {
		$q = "SELECT " . ($fields == "" ? "*" : "$fields ") . ($tablesNames == "" ? "" : "FROM $tablesNames ") . ($where == "" ? "" : "WHERE $where ") . ($groupby == "" ? "" : " GROUP BY $groupby ") . ($sortby == "" ? "" : " ORDER BY $sortby ") . ($limit == "" ? "" : " LIMIT $limit ") ;
		//echo $q . "<br />";
		$this->query ($q);
                
 //             return mysqli_fetch_array(MYSQLI_ASSOC);
		while ( $entry = $this->fetchNextObject () )
			$a [] = $entry;
		return $a;
	}
	
	public function fetchNextObject($result = NULL) {
		if ($result == NULL)
			$result = $this->lastResult;
		
		if ($result == NULL || mysqli_num_rows ( $result ) < 1)
			return NULL;
		else
            return mysqli_fetch_assoc($result);
			//return mysqli_fetch_object ( $result );
	}
	
	
	public function affectedRows($result = NULL) {
		if ($result == NULL)
			return mysqli_affected_rows ();
		return mysqli_affected_rows ();
	}
	public function numRows($result = NULL) {
		if ($result == NULL)
			return mysqli_num_rows ( $this->lastResult );
		else
			return mysqli_num_rows ( $result );
	}
	
	public function lastInsertedId() {
		return mysqli_insert_id ($connection);
		//return $connection.insert_id;
	}
	
	function __destruct() {
		mysqli_close ($this->connection);
        $this->connection = FALSE;
		
	}
}
?>