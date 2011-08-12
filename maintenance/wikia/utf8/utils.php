<?php

/**
 * Database related classes
 *
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * @author Władysław Bodzek
 */

class SqlCommand {
	protected $command = '';
	protected $arguments = array();
	protected $comments = array();
	public function __construct( $command ) {
		$this->command = $command;
	}
	public function add( $argument, $priority = 0 ) {
		$this->arguments[] = array( $priority, $argument );
	}
	public function comment( $comment, $key = null ) {
		if (is_null($key)) {
			$this->comments[] = $comment;
		} else {
			$this->comments[$key] = $comment;
		}
	}
	public function getCommand() { return $this->command; }
	public function getArguments() { return $this->arguments; }
	public function getComments() { return $this->comments; }
}

class SqlScript {
	const MODE_DEFAULT = 0;
	const MODE_QUICK = 1;
	protected $commands = array();
	protected function get( $id, $command ) {
		if (!isset($this->commands[$id])) {
			$this->commands[$id] = new SqlCommand($command);
		}
		return $this->commands[$id];
	}
	public function database( $name ) {
		$name = strtolower($name);
		return $this->get("DATABASE:{$name}","ALTER DATABASE {$name}");
	}
	public function table( $name ) {
		$name = strtolower($name);
		return $this->get("TABLE:{$name}","ALTER TABLE {$name}");
	}
	public function getCommands() {
		return $this->commands;
	}
	public function getSql( $flags = self::MODE_DEFAULT ) {
		$sql = array();
		foreach ($this->commands as $command)
			$sql = array_merge( $sql, $this->getSqlFromCommand($command,$flags) );
		return $sql;
	}
	public function getSqlFromCommand( SqlCommand $commandObj, $flags = self::MODE_DEFAULT ) {
		$sql = array();
		
		$command = $commandObj->getCommand();
		$arguments = $commandObj->getArguments();
		$comments = $commandObj->getComments();
		foreach ($comments as $comment) {
			$sql[] = $comment;
		}
		if ($flags == self::MODE_QUICK) {
			$a = array();
			foreach ($arguments as $argument)
				$a[$argument[0]][] = $argument[1];
			ksort($a);
			foreach ($a as $priority => $list) {
//				var_dump("-------",$arguments,$priority,$list);
				$sql[] = "{$command}\n  ".implode(",\n  ",$list).";\n";
			}
		} else {
			foreach ($arguments as $argument)
				$sql[] = "{$command} {$argument[1]};\n";
		}
		
		return $sql;
	}
	
}

class DatabaseWalker {
	protected $connection = null;
	protected $name = '';
	protected $tables = array();
	public function __construct( $connection ) {
		$this->connection = $connection;
		$this->name = $this->connection->getDBname();
	}
	protected function getDb() {
		return $this->connection;
	}
	protected function parseSql( $sql ) {
		$tableRow = new stdClass;
		
		 
	}
	protected function getTable( $tableName ) {
		if (!array_key_exists($tableName,$this->tables)) {
			$this->tables[$tableName] = false;
			$row = $this->getDb()->query("SHOW CREATE TABLE `{$tableName}`;")->fetchRow();
			$sql = $row[1];
			$this->tables[$tableName] = $this->parseSql( $sql );
		}
		return $this->tables[$tableName];
	}
	public function getDatabases() {
		$db = $this->getDb();
		$set = $db->select("`information_schema`.`schemata`",'*',array(
			'schema_name' => $this->name,
		),__METHOD__);
		
		$data = array();
		while ($row = $db->fetchObject($set)) {
			$data[] = $row;
		}
		return $data;
	}
	public function getTables( $frmOnly = false ) {
		$fields = '*';
		if ($frmOnly)
			$fields = array( 'table_schema', 'table_name', 'table_collation' );
		$db = $this->getDb();
		$set = $db->select("`information_schema`.`tables`",'*',array(
			'table_schema' => $this->name,
		),__METHOD__);
		
		$data = array();
		while ($row = $db->fetchObject($set)) {
			$data[] = $row;
		}
		return $data;
	}
	public function getFields() {
		$db = $this->getDb();
		$set = $db->select("`information_schema`.`columns`",'*',array(
			'table_schema' => $this->name,
		),__METHOD__);
		
		$data = array();
		while ($row = $db->fetchObject($set)) {
			$data[] = $row;
		}
		return $data;
	}
}

class SqlParser {
	protected $db = null;
	protected $charsets = null;
	public function __construct( $db ) {
		$this->db = $db;
	}
	public function getCollation( $charset, $collation, $default = false ) {
		if ($collation) {
			return $collation;
		}
		if ($charset) {
			if (is_null($this->charsets)) {
				$charsets = array();
				$res = $this->db->query("SHOW CHARACTER SET;");
				while ($row = $this->db->fetchRow($res)) {
					$charsets[$row['Charset']] = $row['Default collation'];
				}
				$this->db->freeResult($res);
				$this->charsets = $charsets;
			}
			if (isset($this->charsets[$charset])) {
				return $this->charsets[$charset];
			}
		}
		return $default;
	}
	public function isTextualType( $type ) {
		$textualTypes = array( 'text' ,'tinytext', 'mediumtext', 'longtext', 'char', 'varchar' );
		list($type) = explode('(',strtolower($type));
		return in_array($type,$textualTypes);
	}
	public function parseColumn( $line, $defaults = array() ) {
		$field = false;
		$options = array(
			"(?<unsigned>unsigned)",
			"(?<zerofill>zerofill)",
			"(?<null>null)",
			"(?<notnull>not null)",
			"(?<autoincrement>auto_increment)",
			"(?<binary>binary)",
			"default (?<default>'(?<defaultv>[^']*)'|(?<defaulte>null|current_timestamp))",
			"comment '(?<comment>[^']*)'",
			"character set (?<charset>[^\s]*[^\s,])",
			"collate (?<collation>[^\s]*[^\s,])",
			"on update (?<onupdate>'(?<onupdatev>[^']*)'|(?<onupdatee>null|current_timestamp))",
		);
		$pattern = "/^\s+`(?<name>[^`]+)`\s(?<type>[^\s]+)"
			."(\s+(".implode("|",$options)."))*,?\$/i";
		if (preg_match($pattern,$line,$matches)) {
			$field = new stdclass;
			foreach ($defaults as $k => $v)
				$field->$k = $v;
			$field->COLUMN_NAME = $matches['name'];
			$field->COLUMN_TYPE = $matches['type'];
			if (!empty($matches['unsigned']))
				$field->COLUMN_TYPE .= " unsigned";
			if (!empty($matches['zerofill']))
				$field->COLUMN_TYPE .= " zerofill";
			$field->EXTRA = '';
			if (!empty($matches['autoincrement']))
				$field->EXTRA .= "auto_increment";
			$field->IS_NULLABLE = !empty($matches['notnull']) ? 'NO' : 'YES';
			$field->COLUMN_DEFAULT = isset($matches['defaultv']) ? $matches['defaultv'] : null;
			$field->COLUMN_DEFAULT_EXPR = !empty($matches['default']) ? $matches['default'] : null;
			if (!$this->isTextualType($matches['type'])) {
				$field->COLLATION_NAME = null;
			} else {
				$collation = $this->getCollation(@$matches['charset'],@$matches['collation'],$field->COLLATION_NAME);
				$field->COLLATION_NAME = isset($collation) ? $collation : null;
			}
			$field->COLUMN_COMMENT = isset($matches['comment']) ? $matches['comment'] : null;
			$field->COLUMN_ONUPDATE_EXPR = isset($matches['onupdate']) ? $matches['onupdate'] : null;
		}
		return $field;
	}
	public function parseTable( $sql ) {
		$lines = preg_split("/[\r\n]+/",$sql);
		$data = array(
			'sql' => $sql,
			'table' => new stdclass,
			'fields' => array(),
		);
		$mode = 0;
		$columns = array();
		foreach ($lines as $line) {
			// create table
			if ($mode == 0) {
				if (!preg_match("/^CREATE TABLE `([^`]+)`/i",$line,$matches))
					return false;
				$tableName = $matches[1];
				$data['table']->TABLE_NAME = $tableName;
				$mode = 1;
				continue;
			}
			// inside create table
			if ($mode == 1) {
				if (preg_match("/^\)/",$line)) {
					$mode = 2;
				} else {
					if (preg_match("/^\s+(primary |unique |fulltext )?key/i",$line,$matches)) {
						// index - ignore for now
					} else if (preg_match("/^\s+constraint/i",$line,$matches)) {
						// constraint - ignore for now
					} else {
						// column definition - save for future processing
						$columns[] = $line;
					}
				}
			}
			// closing line
			if ($mode == 2) {
				if (preg_match("/^\)\s*engine=(?<engine>[^\s]+)(\s+auto_increment=([^\s]+))?(\s+default charset=(?<charset>[^\s]+)(\s+collate=(?<collation>[^\s]+))?)?/i",$line,$matches)) {
					$data['table']->ENGINE = $matches['engine'];
					$data['table']->TABLE_COLLATION = $this->getCollation(@$matches['charset'],@$matches['collation']);
					$mode = 3;
				}
			}
		}
		$columnDefaults = array(
			'TABLE_NAME' => $data['table']->TABLE_NAME,
			'COLLATION_NAME' => $data['table']->TABLE_COLLATION,
		);
		foreach ($columns as $column) {
			$columnObj = $this->parseColumn($column,$columnDefaults);
			if (!$columnObj)
				throw new Exception("Could not parse column definiton: $column");
			$data['fields'][] = $columnObj;
		}
		return $data;
	}
}

class DatabaseWalker_UsingShow {
	protected $connection = null;
	protected $name = '';
	protected $tableList = false;
	protected $tables = array();
	protected $parser = null;
	public function __construct( $connection ) {
		$this->connection = $connection;
		$this->parser = new SqlParser($this->connection);
		$this->name = $this->connection->getDBname();
	}
	protected function getDb() {
		return $this->connection;
	}
	protected function getTableList() {
		if ($this->tableList === false) {
			$db = $this->getDb();
			$res = $db->query("SHOW TABLES;");
			$tables = array();
			while ($row = $db->fetchRow($res)) {
				$tables[] = $row[0];
			}
			$this->tableList = $tables;
		}
		return $this->tableList;
	}
	protected function getTable( $tableName ) {
		if (!array_key_exists($tableName,$this->tables)) {
			$this->tables[$tableName] = null;
			$row = $this->getDb()->query("SHOW CREATE TABLE `{$tableName}`;")->fetchRow();
			if ($row) {
				$sql = $row[1];
				$this->tables[$tableName] = $this->parser->parseTable($sql);
			}
		}
		return $this->tables[$tableName];
	}
	public function getDatabases() {
		$db = $this->getDb();
		$set = $db->select("`information_schema`.`schemata`",'*',array(
			'schema_name' => $this->name,
		),__METHOD__);
		
		$data = array();
		while ($row = $db->fetchObject($set)) {
			$data[] = $row;
		}
		return $data;
	}
	public function getTables( $frmOnly = false ) {
		$data = array();
		$tables = $this->getTableList();
		foreach ($tables as $tableName) {
			$table = $this->getTable($tableName);
			$data[] = $table['table'];
		}
		return $data;
	}
	public function getFields() {
		$data = array();
		$tables = $this->getTableList();
		foreach ($tables as $tableName) {
			$table = $this->getTable($tableName);
			$data = array_merge($data,$table['fields']);
		}
		return $data;
	}
	public function getFieldsFor( $tableName ) {
		$data = false;
		$table = $this->getTable($tableName);
		if ($table) {
			$data = $table['fields'];
		}
		return $data;
	}
	public function getCreateTable( $tableName ) {
		$table = $this->getTable($tableName);
		return $table ? $table['sql'] : false;
	}
}

