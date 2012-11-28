<?php

/**
 * Generic data source class with database connection validation
 * @author Robert Elwell
 */
class WikiDataSource {

	protected $id;
	/**
	 * @var Database
	 */
	protected $db = null;
	protected $dbname = null;
	
	public function __construct( $id = null ) {
		global $wgCityId, $wgDBname;
		
		if (is_null($id)) {
			$id = $wgCityId;
		}
		$this->id = $id;

		if ($wgCityId == $id) {
			$this->db = wfGetDB(DB_SLAVE);
			$this->dbname = $wgDBname;
		} else {
			// find db name
			$dbname = WikiFactory::IDtoDB($this->id);
			if ( empty($dbname) ) {
				throw new Exception("Could not find wiki with ID {$this->id}");
			}
	
			// open db connection (and check if db really exists)
			$db = wfGetDB(DB_SLAVE, array(), $dbname);
			if ( !is_object($db) ) {
				throw new Exception("Could not connect to wiki database {$dbname}");
			}
			
			$this->db = $db;
			$this->dbname = $dbname;
		}
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getDbName() {
		return $this->dbname;
	}
	
	public function getDB() {
		return $this->db;
	}
	
}