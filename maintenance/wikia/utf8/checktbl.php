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
		$this->list = $this->walker->getTables();
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
		foreach ($this->list as $table) {
			$tableName = $table->TABLE_NAME;
			list($charset) = explode('_',strtolower($table->TABLE_COLLATION));
			if ($charset == 'utf8') {
				echo "-- {$this->databaseName}.{$tableName}\n";
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
