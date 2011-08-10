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
	'cluster',
	'database',
);


require_once( "commandLine.inc" );
require_once "utils.php";


class Utf8DbConvert {

	protected $verbose = false;
	protected $force = false;
	protected $short = false;
	protected $quick = false;

	public function __construct( $options ) {
		// load command line options
		$this->options = $options;
		
		global $wgDBname;
//		$this->force = isset($options['force']);
//		$this->quick = isset($options['quick']);
		$this->short = isset($options['short']);
		$this->verbose = isset($options['verbose']);
		$this->databaseName = isset($options['database']) ? $options['database'] : $wgDBname;
		$this->clusterName = isset($options['cluster']) ? $options['cluster'] : $this->databaseName;
		
		$this->db = wfGetDb(DB_SLAVE,array(),$this->clusterName);
		if ( !$this->db->selectDB($this->databaseName) ) {
			$this->db = false;
		}
		$this->walker = new DatabaseWalker_UsingShow($this->db);
		
		$this->script = new SqlScript();
	}
	
	protected function getDb() {
		return $this->db;
	}

	protected function query( $sql ) {
		$t = microtime(true);
		$timestamp = gmdate( 'Y-m-d H:i:s.', (int)$t ) . sprintf("%06d",($t - floor($t)) * 1000000);
		if ($this->verbose) {
			echo "-- $timestamp\n";
			echo $sql . "\n";
		}
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
	
	public function dbQuote( $data ) {
		if (is_array($data)) {
			return array_map(array($this,'dbQuote'),$data);
		} else {
			return "`{$data}`";
		}
	}
	
	protected function checkData() {
		foreach ($this->list as $tableName => $columns) {
			$columnNames = array_keys($columns);
			$res = $this->db->select(" " . $this->dbQuote($tableName),$this->dbQuote($columnNames));
			$badColumns = array();
			while ($row = $this->db->fetchRow($res)) {
				foreach ($columns as $columnName => $column) {
					if (strlen($row[$columnName]) > 0) {
						$original = $row[$columnName];
						$converted = $original;
						/*
						if (substr($column->COLLATION_NAME,0,5) == 'utf8_') {
							$converted = iconv('utf8','latin1',$converted);
						}
						*/
						$converted = iconv('utf8','utf8',$converted);
						if ($original !== $converted) {
							$text = !$this->short ? $original : "";
							if (strlen($original) > strlen($converted)) {
								$len = strlen($original);
								$pos = strlen($converted);
								$text .= "//error at offset {$pos}/{$len} near [" . substr($original,$pos,4) . "]";
							} else {
								$text .= "//string length matches, but contents changed";
							}
							
							if ($this->verbose) {
								$badColumns[$columnName][] = $text;
							} else {
								if ( !isset($badColumns[$columnName]) )
									$badColumns[$columnName] = array( 0 => 0 );
								$badColumns[$columnName][0]++;
							}
						}
					}
				}
			}
			$this->db->freeResult($res);
			
			// show bad columns
			if ($this->verbose) {
				echo "-- TABLE {$tableName}\n";
				foreach ($columnNames as $columnName) {
					echo "--   " . (isset($badColumns[$columnName])?"[FAIL]":"[ok  ]") . " "
						. $columnName
						. (isset($badColumns[$columnName]) ? " (" . count($badColumns[$columnName]) . ")": "") 
						. "\n";
					if (isset($badColumns[$columnName])) {
						echo "--   [????] " . $this->showBadValues($badColumns[$columnName]) . "\n";
					}
				}
			} else {
				foreach ($badColumns as $columnName => $badList) {
					echo "-- {$this->databaseName}.{$tableName}.{$columnName} (" . $badList[0] . ")\n";
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
