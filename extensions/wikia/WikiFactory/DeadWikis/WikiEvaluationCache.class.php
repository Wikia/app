<?php
/**
 * NOTE: PLEASE TAKE CARE WHILE EDITING THIS FILE.
 *       BAD CHANGE AND WE CAN CLOSE MANY WIKIS BY ACCIDENT.
 */


class WikiEvaluationCache {

	const TABLE_NAME = "`noreptemp`.`dead_wiki_stats`";

	protected $slaveDb = null;
	protected $masterDb = null;

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

	/**
	 * @param DatabaseMysqli $db
	 * @param $tableName
	 * @param $keys
	 * @param $data
	 * @return string
	 */
	protected function getInsertUpdateSql($db, $tableName, $keys, $data ) {
		$tableName = $db->tableName($tableName);
		$tableKeys = array_merge(array_keys($keys),array_keys($data));
		$tableKeys = $db->makeList($tableKeys,LIST_NAMES);
		$tableValues = array_merge(array_values($keys),array_values($data));
		$tableValues = $db->makeList($tableValues,LIST_COMMA);
		$tableUpdate = $db->makeList($data,LIST_SET);
		return sprintf("INSERT INTO %s (%s) VALUES (%s) ON DUPLICATE KEY UPDATE %s;",
			$tableName, $tableKeys, $tableValues, $tableUpdate );
	}

	/**
	 * @param array $data
	 * @return bool
	 */
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
		$sql = $this->getInsertUpdateSql($db, self::TABLE_NAME, $keys, $data);
		$db->query($sql, __METHOD__);
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
