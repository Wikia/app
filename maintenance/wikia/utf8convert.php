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

require_once( "commandLine.inc" );

class Utf8DbConvert {

	protected $force = false;

	public function __construct( $options ) {
		// load command line options
		$this->options = $options;
		
		$this->force = isset($options['force']);
	}

	protected function getDb() {
		if (!isset($this->db)) {
			$this->db = wfGetDb(DB_MASTER);
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
		global $wgDBname;
		$db = $this->getDb();
		$set = $db->select("`information_schema`.`schemata`",'*',array(
			'schema_name' => $wgDBname,
		),__METHOD__);
		
		$data = array();
		while ($row = $db->fetchObject($set)) {
			$data[] = $row;
		}
		return $data;
	}

	protected function getFields() {
		global $wgDBname;
		$db = $this->getDb();
		$set = $db->select("`information_schema`.`columns`",'*',array(
			'table_schema' => $wgDBname,
		),__METHOD__);
		
		$data = array();
		while ($row = $db->fetchObject($set)) {
			$data[] = $row;
		}
		return $data;
	}

	protected function getTables() {
		global $wgDBname;
		$db = $this->getDb();
		$set = $db->select("`information_schema`.`tables`",'*',array(
			'table_schema' => $wgDBname,
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

	protected function processFields() {
		$sqlList = array();
		$fields = $this->getFields();
		foreach ($fields as $field) {
			if (!is_null($field->COLLATION_NAME) && $field->COLLATION_NAME !== 'utf8_bin') {
				$rest = ($field->IS_NULLABLE == 'YES' ? "NULL" : "NOT NULL")
					. (!is_null($field->COLUMN_DEFAULT) ? " DEFAULT '{$field->COLUMN_DEFAULT}'" : "");
				$sqlList[] = "ALTER TABLE `{$field->TABLE_NAME}` MODIFY {$field->COLUMN_NAME} {$field->COLUMN_TYPE} BINARY $rest;";
				$sqlList[] = "ALTER TABLE `{$field->TABLE_NAME}` MODIFY {$field->COLUMN_NAME} {$field->COLUMN_TYPE} CHARACTER SET utf8 COLLATE utf8_bin {$rest};";
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
