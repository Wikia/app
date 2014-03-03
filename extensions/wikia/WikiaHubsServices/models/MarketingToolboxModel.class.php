<?php

class MarketingToolboxModel extends AbstractMarketingToolboxModel {
	const CACHE_KEY = 'HubsV2v1.02';
	const CACHE_KEY_LAST_PUBLISHED_TIMESTAMP = 'lastPublishedTimestamp';

	public function __construct($app = null) {
		parent::__construct($app);
	}

	/**
	 * Gets modules statuses for given language and vertical between selected dates
	 *
	 * @param Array $params contains
	 * 		- string langCode
	 * 		- int verticalId
	 * @param $beginTimestamp
	 * @param $endTimestamp
	 * @return array
	 */
	public function getCalendarData($params, $beginTimestamp, $endTimestamp) {
		global $wgExternalSharedDB;
		$sdb = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
		$conds = array(
			'lang_code' => $params['langCode'],
			'vertical_id' => $params['verticalId'],
			'city_id' => 0
		);

		$conds = $sdb->makeList($conds, LIST_AND);
		$conds .= ' AND hub_date >= ' . $sdb->timestamp($beginTimestamp)
			. ' AND hub_date <= ' . $sdb->timestamp($endTimestamp);

		$table = $this->getTablesBySectionId(self::SECTION_HUBS);
		$fields = array('hub_date', 'module_status');

		$options = array(
			'GROUP BY' => array(
				'hub_date',
				'module_status'
			)
		);

		$results = $sdb->select($table, $fields, $conds, __METHOD__, $options);

		$out = array();
		while ($row = $sdb->fetchRow($results)) {
			$out[$row['hub_date']] = $row['module_status'];
		}

		return $out;

	}

	/**
	 * Get list of modules for selected lang/vertical/date
	 * applying translation for module name
	 *
	 * @param Array $params contains
	 * 		- string langCode
	 * 		- int sectionId
	 * 		- int verticalId
	 * @param int $timestamp
	 * @param int $activeModule
	 *
	 * @return array
	 */
	public function getModulesData($params, $timestamp, $activeModule = MarketingToolboxModuleSliderService::MODULE_ID) {
		$moduleList = $this->getModuleList($params, $timestamp);

		$modulesData = array(
			'lastEditor' => null,
			'moduleList' => array()
		);

		$userClass = $this->getUserClass();
		foreach ($moduleList as $moduleId => &$module) {
			if ($moduleId == $activeModule) {
				$userName = null;
				if ($module['lastEditorId']) {
					$user = $userClass::newFromId($module['lastEditorId']);
					if ($user instanceof User) {
						$userName = $user->getName();
					}
				}
				$modulesData['lastEditor'] = $userName;
				$modulesData['lastEditTime'] = $module['lastEditTime'];
				$modulesData['activeModuleName'] = $this->getModuleName($moduleId);
			}
			$module['name'] = $this->getModuleName($moduleId);
			$module['href'] = $this->getModuleUrl($params, $timestamp, $moduleId);
		}
		$modulesData['moduleList'] = $moduleList;

		return $modulesData;
	}

	/**
	 * Get modules data for last published hub before selected timestamp
	 *
	 * @param Array $params contains
	 * 		- string langCode
	 * 		- int sectionId
	 * 		- int verticalId
	 * @param int    $timestamp
	 * @param int    $moduleId
	 *
	 * @return array
	 */
	public function getPublishedData($params, $timestamp = null, $moduleId = null) {
		$lastPublishTimestamp = $this->getLastPublishedTimestamp($params, $timestamp);
		return $this->getModulesDataFromDb($params, $lastPublishTimestamp, $moduleId);
	}

	public function getModuleUrl($params, $timestamp, $moduleId) {
		$specialPage = $this->getSpecialPageClass();
		return $specialPage::getTitleFor('MarketingToolbox', 'editHub')->getLocalURL(
			array(
				'moduleId' => $moduleId,
				'date' => $timestamp,
				'region' => $params['langCode'],
				'verticalId' => $params['verticalId'],
				'sectionId' => $params['sectionId']
			)
		);
	}

	/**
	 * Get list of modules for selected lang/vertical/timestamp
	 *
	 * @param Array $params contains
	 * 		- string langCode
	 * 		- int sectionId
	 * 		- int verticalId
	 * @param int $timestamp
	 *
	 * @return array
	 */
	protected function getModuleList($params, $timestamp) {
		$lastPublishTimestamp = $this->getLastPublishedTimestamp($params, $timestamp);

		if ($lastPublishTimestamp) {
			$out = $this->getModulesDataFromDb($params, $lastPublishTimestamp);
		} else {
			$out = $this->getDefaultModuleList();
		}

		$actualData = $this->getModulesDataFromDb($params, $timestamp);
		$out = $actualData + $out;
		ksort($out);

		return $out;
	}

	/**
	 * TODO: confirm this is UNUSED
	 *
	 * @param $moduleId
	 * @param Array $params contains
	 * 		- string langCode
	 * 		- int sectionId
	 * 		- int verticalId
	 * @param $timestamp
	 * 
	 * @return array
	 */
	public function getModuleDataFromDb($params, $timestamp, $moduleId) {
		$data = $this->getModulesDataFromDb($params, $timestamp, $moduleId);
		return isset($data[$moduleId]) ? $data[$moduleId] : array();
	}

	/**
	 * Check if all modules in current hub (lang, vertical and date) are filled and saved
	 *
	 * @param Array $params contains
	 * 		- string langCode
	 * 		- int verticalId
	 * @param int $timestamp
	 */
	public function checkModulesSaved($params, $timestamp) {
		global $wgExternalSharedDB;
		$sdb = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

		$hubDate = date('Y-m-d', $timestamp);

		$fields = array('count(module_id)');
		$conds = array(
			'lang_code' => $params['langCode'],
			'vertical_id' => $params['verticalId'],
			'hub_date' => $hubDate,
			'city_id' => 0
		);

		$result = $sdb->select(self::HUBS_TABLE_NAME, $fields, $conds);

		$row = $sdb->fetchRow($result);

		return ($row[0] == $this->modulesCount) ? true : false;
	}

	/**
	 * Main method to publish hub page of specific vertical in specific language and on specific day
	 * 
	 * @param Array $params contains
	 * 		- string langCode
	 * 		- int sectionId
	 * 		- int verticalId
	 * @param $timestamp
	 * 
	 * @return stdClass (properties: boolean $success, string $errorMsg)
	 */
	public function publish($params, $timestamp) {
		wfProfileIn(__METHOD__);
		
		$results = new stdClass();
		$results->success = null;
		$results->errorMsg = null;
		
		if( wfReadOnly() ) {
			$results->success = false;
			$results->errorMsg = wfMsg('marketing-toolbox-module-publish-error-read-only');

			wfProfileOut(__METHOD__);
			return $results;
		}
		
		switch($params['sectionId']) {
			case self::SECTION_HUBS:
				$this->publishHub($params, $timestamp, $results);
				break;
		}

		wfProfileOut(__METHOD__);
		return $results;
	}

	/**
	 * @param Array $params contains
	 * 		- string langCode
	 * 		- int verticalId
	 * @param $timestamp
	 * @param stdClass $results
	 * 
	 * @return stdClass (properties: boolean $success, string $errorMsg)
	 */
	protected function publishHub($params, $timestamp, &$results) {
		global $wgExternalSharedDB;
		wfProfileIn(__METHOD__);
		if( !$this->checkModulesSaved($params, $timestamp) ) {
			$results->success = false;
			$results->errorMsg = wfMsg('marketing-toolbox-module-publish-error-modules-not-saved');

			wfProfileOut(__METHOD__);
			return;
		}

		$mdb = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
		$hubDate = date('Y-m-d', $timestamp);

		$changes = array(
			'module_status' => $this->statuses['PUBLISHED']
		);

		$conditions = array(
			'lang_code' => $params['langCode'],
			'vertical_id' => $params['verticalId'],
			'hub_date' => $hubDate,
			'city_id' => 0
		);

		$dbSuccess = $mdb->update(self::HUBS_TABLE_NAME, $changes, $conditions, __METHOD__);

		if( $dbSuccess ) {
			$mdb->commit(__METHOD__);
			$results->success = true;
		} else {
			$results->success = false;
			$results->errorMsg = wfMsg('marketing-toolbox-module-publish-error-db-error');
		}

		$actualPublishedTimestamp = $this->getLastPublishedTimestamp($params);
		if ($actualPublishedTimestamp < $timestamp && $timestamp < time()) {
			$this->purgeLastPublishedTimestampCache($params);
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Get data for module list from DB
	 *
	 * @param Array $params contains
	 * 		- string langCode
	 * 		- int sectionId
	 * 		- int verticalId
	 * @param int $timestamp
	 * @param int $moduleId (optional) returns data only for specified module
	 *
	 * @return array
	 */
	protected function getModulesDataFromDb($params, $timestamp, $moduleId = null) {
		global $wgExternalSharedDB;
		$sdb = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
		$conds = array(
			'lang_code' => $params['langCode'],
			'vertical_id' => $params['verticalId'],
			'hub_date' => $sdb->timestamp($timestamp),
			'city_id' => 0
		);
		
		if( is_int($moduleId) ) {
			$conds['module_id'] = $moduleId; 
		}
		
		$table = $this->getTablesBySectionId($params['sectionId']);
		$fields = array('module_id', 'module_status', 'module_data', 'last_edit_timestamp', 'last_editor_id');

		$results = $sdb->select($table, $fields, $conds, __METHOD__);

		$out = array();
		while ($row = $sdb->fetchRow($results)) {
			$out[$row['module_id']] = array(
				'status' => $row['module_status'],
				'lastEditTime' => $row['last_edit_timestamp'],
				'lastEditorId' => $row['last_editor_id'],
				'data' => json_decode($row['module_data'], true)
			);
		}
		
		return $out;
	}



	/**
	 * Save module
	 *
	 * @param Array $params
	 * 			- string $langCode
	 * 			- int $sectionId
	 * 			- int $verticalId
	 * @param int $timestamp
	 * @param int $moduleId
	 * @param array $data
	 * @param int $editorId
	 *
	 */
	public function saveModule($params, $timestamp, $moduleId, $data, $editorId) {
		global $wgExternalSharedDB;
		$mdb = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
		$sdb = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

		$updateData = array(
			'module_data' => json_encode($data),
			'last_editor_id' => $editorId,
		);

		$table = $this->getTablesBySectionId($params['sectionId']);

		$conds = array(
			'lang_code' => $params['langCode'],
			'vertical_id' => $params['verticalId'],
			'module_id' => $moduleId,
			'hub_date' => $mdb->timestamp($timestamp),
			'city_id' => 0
		);

		$result = $sdb->selectField($table, 'count(1)', $conds, __METHOD__);

		if ($result) {
			$mdb->update($table, $updateData, $conds, __METHOD__);
		} else {
			$insertData = array_merge($updateData, $conds);

			$mdb->insert($table, $insertData, __METHOD__);
		}

		$mdb->commit();
	}

	/**
	 * Get last timestamp when vertical was published (before selected timestamp)
	 *
	 * @param Array $params contains
	 * 		- string langCode
	 * 		- int sectionId
	 * 		- int verticalId
	 * @param int $timestamp - max timestamp that we should search for published hub
	 *
	 * @return int timestamp
	 */
	public function getLastPublishedTimestamp($params, $timestamp = null, $useMaster = false) {
		if ($timestamp === null) {
			$timestamp = time();
		}
		$timestamp = strtotime(self::STRTOTIME_MIDNIGHT, $timestamp);

		if ($timestamp == strtotime(self::STRTOTIME_MIDNIGHT)) {
			$lastPublishedTimestamp = WikiaDataAccess::cache(
				$this->getMKeyForLastPublishedTimestamp($params, $timestamp),
				6 * 60 * 60,
				function () use ($params, $timestamp, $useMaster) {
					return $this->getLastPublishedTimestampFromDB($params, $timestamp, $useMaster);
				}
			);
		} else {
			$lastPublishedTimestamp = $this->getLastPublishedTimestampFromDB($params, $timestamp, $useMaster);
		}

		return $lastPublishedTimestamp;
	}

	public function getLastPublishedTimestampFromDB($params, $timestamp, $useMaster = false) {
		global $wgExternalSharedDB;
		$sdb = wfGetDB(
			($useMaster) ? DB_MASTER : DB_SLAVE,
			array(),
			$wgExternalSharedDB
		);

		$table = $this->getTablesBySectionId($params['sectionId']);

		$conds = array(
			'lang_code' => $params['langCode'],
			'vertical_id' => $params['verticalId'],
			'module_status' => $this->statuses['PUBLISHED'],
			'city_id' => 0
		);

		$conds = $sdb->makeList($conds, LIST_AND);
		$conds .= ' AND hub_date <= ' . $sdb->timestamp($timestamp);

		$result = $sdb->selectField($table, 'unix_timestamp(max(hub_date))', $conds, __METHOD__);

		return $result;
	}

	protected function getMKeyForLastPublishedTimestamp($params, $timestamp) {
		return wfSharedMemcKey(
			self::CACHE_KEY,
			$params['langCode'],
			$params['sectionId'],
			$params['verticalId'],
			$timestamp,
			self::CACHE_KEY_LAST_PUBLISHED_TIMESTAMP
		);
	}

	/**
	 * Get table name by section Id
	 *
	 * @param int $sectionId
	 *
	 * @return string
	 */
	protected function getTablesBySectionId($sectionId) {
		switch ($sectionId) {
			case self::SECTION_HUBS:
				$table = self::HUBS_TABLE_NAME;
				break;
		}

		return $table;
	}
}
