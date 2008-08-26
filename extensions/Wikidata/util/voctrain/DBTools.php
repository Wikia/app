<?php
# this is still very dirty, since I snarfed most of this from elsewhere. I wrote it, so it's mine :-P
# released under GPL v2 

	
/** provide a namespace for database tools (so we don't clutter up the main namespace with
 * all our utility and tool functions) All functions here are public+static.
 */
class DBTools {

	/** retrieve a single row from the database as an associative array
	 * @param $table	the name of the table (minus dataset prefix)
	 * @peram $where		the actual WHERE clause we need to uniquely find our row
	 * @returns an associative array, representing our row. \
	 *	keys=column headers, values = row contents
	 */
	public static function getRows( $table, $where) {
	#public static function getRows( $table, $where) {
		$target_table=mysql_real_escape_string("${dc}_${table}");
		$query="SELECT * FROM $target_table ".$where;
		return DBTools::doMultirowQuery($query);
	}

	/** connect to database using $mysql_info array
	 * possibly should be replaced with PEAR equivalent 
	 */
	public static function connect($mysql_info) {
		$server=$mysql_info["server"];
		$user=$mysql_info["user"];
		$password=$mysql_info["password"];
		$dbname=$mysql_info["dbname"];

		$connection=MySQL_connect($server,$user,$password);
		if (!$connection)die("Cannot connect to SQL server. Try again later.");
		MySQL_select_db($dbname)or die("Cannot open database");
		mysql_query("SET NAMES 'utf8'");
	}



	/** Performs an arbitrary SQL query and returns an associative array
	 * Assumes that only 1 row can be returned!
	 * @param $query	a valid SQL query
	 * @returns an associative array, representing our row. \
	 *	keys=column headers, values = row contents
	 *
	 */
	public static function doQuery($query) {
		#var_dump($query);
		$result = mysql_query($query);

		if (!$result) 
			throw new Exception("Mysql query failed: $query");

		if ($result===true) 
			return null;

		if (mysql_num_rows($result)==0) 
			return null;


		$data= mysql_fetch_assoc($result);
		return $data;
	}

	/** Perform an arbitrary SQL query
	 * 
	 * @param $query	a valid SQL query
	 * @returns an array of associative arrays, representing our rows.  \
	 *	each associative array is structured with:		\
	 *	keys=column headers, values = row contents
	 */

	public static function doMultirowQuery($query) {
		#var_dump($query);
		$result = mysql_query($query);
		if (!$result) 
			throw new Exception("Mysql query failed: $query with error".mysql_error());
		
		if ($result===true)
			return array();

		if (mysql_num_rows($result)==0) 
			return array();

		$items=array();
		while ($nextexp=mysql_fetch_assoc($result)) {
			$items[]=$nextexp;
		}
		return $items;
	}

	/** identical to the php function array_key_exists(), but eats dirtier input
	 * returns false (rather than an error) on somewhat invalid input. 
	 * (Namely, if either $key or $array is either null or false)
	 */
	public static function sane_key_exists($key, $array) {
		if (is_null($key) or $key==false){
			return false;
		}
		if (is_null($array) or $array==false) {
			return false;
		}
		return array_key_exists($key, $array);
	}

	/** insert (or update if exists) an array, all mysql_escaped */
	public static function safe_insert_assoc($my_table, $my_keyfield, $my_key, $my_array) {
		$safe_table=mysql_real_escape_string($my_table);
		$safe_keyfield=mysql_real_escape_string($my_keyfield);
		$safe_key=mysql_real_escape_string($my_key);

		
		$safe_array=array();
		foreach ($my_array as $akey=>$avalue) {
			$safe_akey=mysql_real_escape_string($akey);
			$safe_avalue=mysql_real_escape_string($avalue);
			$safe_array[$safe_akey]=$safe_avalue;
		}
		
		$exists=array();
		if ($safe_key!="") {
			$exists=DBTools::doMultirowQuery("SELECT $safe_keyfield FROM $safe_table WHERE $safe_keyfield=$safe_key");
		}
		if (sizeof($exists)>0) {
			DBTools::mysql_update_assoc($safe_table,$safe_array, "WHERE $safe_keyfield='$safe_key'");
		} else {
			DBTools::mysql_insert_assoc($safe_table, $safe_array);
		}

	}

	/** similar to above, except *nothing* is escaped.
	 * beware of all kinds of evil injection.
	 */
	public static function unsafe_insert_assoc($table, $keyfield, $key, $array) {
		
		$exists=array();
		if ($key!="") {
			$exists=DBTools::doMultirowQuery("SELECT $keyfield FROM $table WHERE $keyfield=$key");
		}
		if (sizeof($exists)>0) {
			DBTools::mysql_update_assoc($table,$array, "WHERE $keyfield='$key'");
		} else {
			DBTools::mysql_insert_assoc($table, $array);
		}

	}

	/**
	 * inverse of mysql_fetch_assoc
	 * takes an associative array as parameter, and inserts data
	 * into table as a single row (keys=column names, values = data to be inserted)
	 * see: http://www.php.net/mysql_fetch_assoc (Comment by R. Bradly, 14-Sep-2006)
	 */
	public static function mysql_insert_assoc ($my_table, $my_array) {
		
		// Find all the keys (column names) from the array $my_array

		// We compose the query
		$sql = "insert into `$my_table` set";
		// implode the column names, inserting "\", \"" between each (but not after the last one)
		// we add the enclosing quotes at the same time
		$sql_comma=$sql;
		foreach($my_array as $key=>$value) {
			$sql=$sql_comma;
			if (is_null($value)) {
				$value="DEFAULT";
			} else {
				$value='"'.mysql_real_escape_string($value).'"';
			}
			$sql.=" `$key`=$value";
			$sql_comma=$sql.",";
		}

		global $wdCopyDryRunOnly;	#skip writing to db
		if ($wdCopyDryRunOnly)
			return true;

		#var_dump($sql);
		$result = mysql_query($sql);
		if (!$result) 
			throw new Exception("Mysql query failed: $sql, with error message ".mysql_error());

		if ($result)
			return true;
		else
			return false;
	}

	/** similar to mysql_insert_assoc, except now we do an update (naturally) */
	public static function mysql_update_assoc ($my_table, $my_array, $where) {

		// Find all the keys (column names) from the array $my_array

		// We compose the query
		$sql = "update `$my_table` set";
		// implode the column names, inserting "\", \"" between each (but not after the last one)
		// we add the enclosing quotes at the same time
		$sql_comma=$sql;
		foreach($my_array as $key=>$value) {
			if (!is_null($value)) {
				$sql=$sql_comma;
				$value='"'.mysql_real_escape_string($value).'"';
				$sql.=" `$key`=$value";
				$sql_comma=$sql.",";
			}
		}
		$sql .= " ".$where;

		global $wdCopyDryRunOnly;	#skip writing to db
		if ($wdCopyDryRunOnly)
			return true;

		#var_dump($sql);
		$result = mysql_query($sql);

		if (!$result) 
			throw new Exception("Mysql query failed: $sql with error message ".mysql_error());
;

		if ($result)
			return true;
		else
			return false;
	}

}
?>
