<?php

/**
 * Script converts local mediawiki database
 * to use UTF-8 character set (with collation utf8_bin)
 *
 * By default script outputs SQL which needs to be executed to stdout.
 * You can use --force to actually run these queries immediately.
 *
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * @author Władysław Bodzek
 */

ini_set( "include_path", dirname(__FILE__)."/../../../maintenance/" );

$optionsWithArgs = array(
	'database',
);


require_once( "commandLine.inc" );
require_once "utils.php";


class Utf8DbConvert {

	protected $force = false;
	protected $quick = false;

	public function __construct( $options ) {
		// load command line options
		$this->options = $options;
		
		global $wgDBname;
//		$this->force = isset($options['force']);
//		$this->quick = isset($options['quick']);
		$this->databaseName = isset($options['database']) ? $options['database'] : $wgDBname;
		
		$this->db = wfGetDb(DB_SLAVE,array(),$this->databaseName);
		$this->walker = new DatabaseWalker_UsingShow($this->db);
		
		$this->script = new SqlScript();
	}
	
	protected function getDb() {
		return $this->db;
	}

	protected function query( $sql ) {
		$t = microtime(true);
		$timestamp = gmdate( 'Y-m-d H:i:s.', (int)$t ) . sprintf("%06d",($t - floor($t)) * 1000000);
		echo "-- $timestamp\n";
		echo $sql . "\n";
		if ($this->force) {
			$this->getDb()->query($sql);
		}
	}

	protected $list = array();
	
	protected function prepareScript() {
		$list = array();
		$tables = $this->walker->getTables();
		foreach ($tables as $table) {
			$tableList = array();
			$tableName = $table->TABLE_NAME;
			$columns = $this->walker->getFieldsFor($tableName);
			foreach ($columns as $column) {
				if (isset($column->COLLATION_NAME) && $column->COLLATION_NAME !== 'utf8_bin') {
					$tableList[$column->COLUMN_NAME] = $column;
				}
			}
			if (!empty($tableList)) {
				$list[$tableName] = $tableList;
			}
		}
		$this->list = $list;
	}
	
	protected function showBadValues( $badValues ) {
		foreach ($badValues as $k => $v)
			$badValues[$k] = "\"$v\"";
		return implode(", ",$badValues);
	}
	
	protected function checkData() {
		foreach ($this->list as $tableName => $columns) {
			$columnNames = array_keys($columns);
			$res = $this->db->select($tableName,$columnNames);
			$badColumns = array();
			while ($row = $this->db->fetchRow($res)) {
				foreach ($columnNames as $columnName)
					if (strlen($row[$columnName]) > 0)
						if ($row[$columnName] !== iconv('utf8','utf8',$row[$columnName]))
							$badColumns[$columnName][] = $row[$columnName];
			}
			$this->db->freeResult($res);
			
			// show bad columns
			echo "-- TABLE {$tableName}\n";
			foreach ($columnNames as $columnName) {
				echo "--   " . (isset($badColumns[$columnName])?"[FAIL]":"[ok  ]") . " "
					. $columnName . "\n";
				if (isset($badColumns[$columnName])) {
					echo "--   [????] " . $this->showBadValues($badColumns[$columnName]) . "\n";
				}
			}
		}
	}

	public function execute() {
		$this->query("-- READING SCHEMA");
		
		$this->prepareScript();
		$this->query("-- CHECKING TEXT DATA");
		
		$this->checkData();
		
		$this->query("-- ALL DONE");
	}

}

/**
 * used options:
 */
$maintenance = new Utf8DbConvert( $options );
$maintenance->execute();
