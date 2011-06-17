<?php

/**
 * Script converts local mediawiki database
 * to use UTF-8 character set (with collation utf8_bin)
 *
 * By default script outputs on stdout SQL which needs to be executed.
 * You can use --force to actually run these queries immediately.
 *
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * @author Władysław Bodzek
 */

ini_set( "include_path", dirname(__FILE__)."/../../maintenance/" );

$optionsWithArgs = array(
	'database',
);


require_once( "commandLine.inc" );

class Utf8DbConvert {

	protected $force = false;

	public function __construct( $options ) {
		// load command line options
		$this->options = $options;
		
		global $wgDBname;
		$this->force = isset($options['force']);
		$this->databaseName = isset($options['database']) ? $options['database'] : $wgDBname;
	}

	protected function getDb() {
		if (!isset($this->db)) {
			$this->db = wfGetDb(DB_SLAVE,array(),$this->databaseName);
		}
		return $this->db;
	}

	protected function query( $sql ) {
		echo $sql . "\n";
		if ($this->force) {
			$this->getDb()->query($sql);
		}
	}

	protected function getDatabases() {
		$db = $this->getDb();
		$set = $db->select("`information_schema`.`schemata`",'*',array(
			'schema_name' => $this->databaseName,
		),__METHOD__);
		
		$data = array();
		while ($row = $db->fetchObject($set)) {
			$data[] = $row;
		}
		return $data;
	}

	protected function getFields() {
		$db = $this->getDb();
		$set = $db->select("`information_schema`.`columns`",'*',array(
			'table_schema' => $this->databaseName,
		),__METHOD__);
		
		$data = array();
		while ($row = $db->fetchObject($set)) {
			$data[] = $row;
		}
		return $data;
	}

	protected function getTables() {
		$db = $this->getDb();
		$set = $db->select("`information_schema`.`tables`",'*',array(
			'table_schema' => $this->databaseName,
		),__METHOD__);
		
		$data = array();
		while ($row = $db->fetchObject($set)) {
			$data[] = $row;
		}
		return $data;
	}

	protected function processDatabases() {
		$sqlList = array();
		$databases = $this->getDatabases();
		foreach ($databases as $database) {
			if ($database->DEFAULT_COLLATION_NAME !== 'utf8_bin') {
				$sqlList[] = "ALTER DATABASE `{$database->SCHEMA_NAME}` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;";
			}
		}
		
		foreach ($sqlList as $sql) {
			$this->query($sql);
		}
	}

	protected function processTables() {
		$sqlList = array();
		$tables = $this->getTables();
		foreach ($tables as $table) {
			if ($table->TABLE_COLLATION !== 'utf8_bin') {
				$sqlList[] = "ALTER TABLE `{$table->TABLE_NAME}` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;";
			}
		}
		
		foreach ($sqlList as $sql) {
			$this->query($sql);
		}
	}

	protected function getIntermediateFieldType( $type, &$baseType = null ) {
		list( $baseType ) = explode( '(', $type, 2 );
		$typeExtra = substr( $type, strlen($baseType) );
		$baseType = strtolower($baseType);
		$matrix = array(
			'tinytext' => 'tinyblob',
			'text' => 'blob',
			'mediumtext' => 'mediumblob',
			'longtext' => 'longblob',
			'char' => 'binary',
			'varchar' => 'varbinary',
		);
		if (isset($matrix[$baseType])) {
			return $matrix[$baseType] . $typeExtra;
		}
		return false;
	}

	protected function dumpTable( $tableName ) {
		static $lastTableName = null;
		if ($tableName == $lastTableName) return false;
		$lastTableName = $tableName;
		$db = $this->getDb();
		$set = $db->query("SHOW CREATE TABLE `{$tableName}`;");
		while ($row = $db->fetchRow($set)) {
			$sqlLines = preg_split("/\r?\n/",$row[1]);
			foreach ($sqlLines as $k => $line) {
				$sqlLines[$k] = "-- {$line}";
			}
			$sql = implode("\n",$sqlLines);
			return $sql;
		}
	}

	protected function processFields() {
		$sqlList = array();
		$fields = $this->getFields();
		foreach ($fields as $field) {
			if (!is_null($field->COLLATION_NAME) && $field->COLLATION_NAME !== 'utf8_bin') {
				if (!$this->force) {
					$tableDump = $this->dumpTable($field->TABLE_NAME);
					if ($tableDump) {
						$sqlList[] = $tableDump;
					}
				}
				$rest = ($field->IS_NULLABLE == 'YES' ? "NULL" : "NOT NULL")
					. (!is_null($field->COLUMN_DEFAULT) ? " DEFAULT '{$field->COLUMN_DEFAULT}'" : "");
				$baseType = null;
				$transColumnType = $this->getIntermediateFieldType( $field->COLUMN_TYPE, $baseType );
				if ($transColumnType) {
					$sqlList[] = "ALTER TABLE `{$field->TABLE_NAME}` MODIFY {$field->COLUMN_NAME} {$transColumnType} $rest;";
					$sqlList[] = "ALTER TABLE `{$field->TABLE_NAME}` MODIFY {$field->COLUMN_NAME} {$field->COLUMN_TYPE} CHARACTER SET utf8 COLLATE utf8_bin {$rest};";
				} else if ($baseType == 'enum') {
					$sqlList[] = "ALTER TABLE `{$field->TABLE_NAME}` MODIFY {$field->COLUMN_NAME} {$field->COLUMN_TYPE} CHARACTER SET utf8 COLLATE utf8_bin {$rest};";
				} else {
					$sqlList[] = "--{$field->TABLE_NAME}.{$field->COLUMN_NAME} -- could not find intermediate type for {$field->COLUMN_TYPE}\n";
				}
			}
		}
		
		foreach ($sqlList as $sql) {
			$this->query($sql);
		}
	}

	public function execute() {
		$this->processDatabases();
		$this->processTables();
		$this->processFields();
	}

}

/**
 * used options:
 */
$maintenance = new Utf8DbConvert( $options );
$maintenance->execute();
