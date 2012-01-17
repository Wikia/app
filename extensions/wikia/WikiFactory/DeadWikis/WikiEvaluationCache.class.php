<?php

class WikiEvaluationCache {

	const TABLE_NAME = "`noreptemp`.`dead_wiki_stats`";

	protected $slaveDb = null;
	protected $masterDb = null;
	
	public function __construct() {
		
	}
	
	protected function getSlaveDb() {
		return $this->getMasterDb();
		/* // database noreptemp isn't replicated to slaves
		global $wgStatsDB;
		if (empty($this->slaveDb)) {
			$this->slaveDb = wfGetDB(DB_SLAVE,array(),$wgStatsDB);
		}
		return $this->slaveDb;
		*/
	}

	protected function getMasterDb() {
		global $wgStatsDB;
		if (empty($this->masterDb)) {
			$this->masterDb = wfGetDB(DB_MASTER,array(),$wgStatsDB);
		}
		return $this->masterDb;
	}
	
	protected function insertUpdateSql( $db, $tableName, $keys, $data ) {
		$tableName = $db->tableName($tableName);
		$tableKeys = array_merge(array_keys($keys),array_keys($data));
		$tableKeys = $db->makeList($tableKeys,LIST_NAMES);
		$tableValues = array_merge(array_values($keys),array_values($data));
		$tableValues = $db->makeList($tableValues,LIST_COMMA);
		$tableUpdate = $db->makeList($data,LIST_SET);
		return sprintf("INSERT INTO %s (%s) VALUES (%s) ON DUPLICATE KEY UPDATE %s;",
			$tableName, $tableKeys, $tableValues, $tableUpdate );
	}
	
	public function get( $id ) {
		$db = $this->getSlaveDb();
		return $db->selectRow( 
			self::TABLE_NAME, 
			'*', 
			array(
				'city_id' => intval($id)
			),
			__METHOD__
		);
	}
	
	public function find( $conds, $fields = '*' ) {
		$db = $this->getSlaveDb();
		$set = $db->select(
			self::TABLE_NAME,
			$fields,
			$conds,
			__METHOD__
		);
		$data = array();
		while ($row = $set->fetchRow()) {
			$data[] = $row;
		}
		$db->freeResult($set);
		return $data;
	}
	
	public function update( $data ) {
		$id = intval($data['city_id']);
		if ($id <= 0) {
			return false;
		}
		
		unset($data['city_id']);
		$keys = array(
			'city_id' => $id,
		);
		$db = $this->getMasterDb();
		$sql = $this->insertUpdateSql($db, self::TABLE_NAME, $keys, $data);
		$db->query($sql);
		return $db->affectedRows() > 0;
	}
	
	public function delete( $id ) {
		$db = $this->getMasterDb();
		$db->delete(
			self::TABLE_NAME,
			array(
				'city_id' => $id,
			),
			__METHOD__
		);
	}
	
}
