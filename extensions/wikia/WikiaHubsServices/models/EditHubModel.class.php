<?php

class EditHubModel extends WikiaModel {
	const CACHE_KEY = 'HubsV3v0.92';
	const CACHE_KEY_LAST_PUBLISHED_TIMESTAMP = 'v3LastPublishedTimestamp';
	const HUBS_TABLE_NAME = '`wikia_hub_modules`';
	const FORM_THUMBNAIL_SIZE = 149;
	const FORM_FIELD_PREFIX = 'WikiaHubs';
	const STRTOTIME_MIDNIGHT = '00:00';
	protected $statuses = [];
	protected $modules = [];
	protected $editableModules = [];
	protected $nonEditableModules = [];
	protected $modulesCount;
	protected $specialPageClass = 'SpecialPage';
	protected $userClass = 'User';

	// Tags that will NOT get stripped from curator-provided text
	protected $allowedTags = ['<a>', '<br>'];

	public function __construct($app = null) {
		parent::__construct();

		if (!empty($app)) {
			$this->setApp($app);
		}

		$this->statuses = [
			'NOT_PUBLISHED' => 1,
			'PUBLISHED' => 2
		];

		$this->editableModules = [
			WikiaHubsModuleSliderService::MODULE_ID => 'slider',
			WikiaHubsModuleWikiaspicksService::MODULE_ID => 'wikias-picks',
			WikiaHubsModuleFeaturedvideoService::MODULE_ID => 'featured-video',
			WikiaHubsModuleExploreService::MODULE_ID => 'explore',
			WikiaHubsModuleFromthecommunityService::MODULE_ID => 'from-the-community',
			WikiaHubsModulePollsService::MODULE_ID => 'polls',
			WikiaHubsModulePopularvideosService::MODULE_ID => 'popular-videos'
		];

		if ($this->wg->DisableWAMOnHubs) {
			$this->nonEditableModules[WikiaHubsModuleWikiastatsService::MODULE_ID] = 'wikia-stats';
		} else {
			$this->nonEditableModules[WikiaHubsModuleWAMService::MODULE_ID] = 'wam';
		}

		$this->modules = $this->editableModules + $this->nonEditableModules;

		$this->modulesCount = count($this->editableModules);
	}

	/**
	 * Gets modules statuses for given language and vertical between selected dates
	 *
	 * @param $cityId
	 * @param $beginTimestamp
	 * @param $endTimestamp
	 * @return array
	 */
	public function getCalendarData($cityId, $beginTimestamp, $endTimestamp) {
		global $wgExternalSharedDB;
		$sdb = wfGetDB(DB_SLAVE, [], $wgExternalSharedDB);
		$conds = [ 'city_id' => $cityId ];

		$conds = $sdb->makeList($conds, LIST_AND);
		$conds .= ' AND hub_date >= ' . $sdb->timestamp($beginTimestamp)
			. ' AND hub_date <= ' . $sdb->timestamp($endTimestamp);

		$fields = ['hub_date', 'module_status'];

		$options = [
			'GROUP BY' => [
				'hub_date',
				'module_status'
			]
		];

		$results = $sdb->select(self::HUBS_TABLE_NAME, $fields, $conds, __METHOD__, $options);

		$out = [];
		while ($row = $sdb->fetchRow($results)) {
			$out[$row['hub_date']] = $row['module_status'];
		}

		return $out;

	}

	/**
	 * Get list of modules for selected hub city id
	 * applying translation for module name
	 *
	 * @param int $cityId
	 * @param int $timestamp
	 * @param int $activeModule
	 *
	 * @return array
	 */
	public function getModulesData($cityId, $timestamp, $activeModule = WikiaHubsModuleSliderService::MODULE_ID) {
		$moduleList = $this->getModuleList($cityId, $timestamp);

		$modulesData = [
			'lastEditor' => null,
			'moduleList' => []
		];

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
			$module['href'] = $this->getModuleUrl( $timestamp, $moduleId );
		}
		$modulesData['moduleList'] = $moduleList;

		return $modulesData;
	}

	/**
	 * Get list of modules for selected hub city id
	 *
	 * @param int $cityId
	 * @param int $timestamp
	 *
	 * @return array
	 */
	protected function getModuleList($cityId, $timestamp) {
		$lastPublishTimestamp = $this->getLastPublishedTimestamp($cityId, $timestamp);

		if ($lastPublishTimestamp) {
			$out = $this->getModulesDataFromDb($cityId, $lastPublishTimestamp);
		} else {
			$out = $this->getDefaultModuleList();
		}

		$actualData = $this->getModulesDataFromDb($cityId, $timestamp);
		$out = $actualData + $out;
		ksort($out);

		return $out;
	}

	/**
	 * Get last timestamp when vertical was published (before selected timestamp)
	 *
	 * @param int $cityId
	 * @param int $timestamp - max timestamp that we should search for published hub
	 *
	 * @return int timestamp
	 */
	public function getLastPublishedTimestamp($cityId, $timestamp = null, $useMaster = false) {
		if ($timestamp === null) {
			$timestamp = time();
		}
		$timestamp = strtotime(self::STRTOTIME_MIDNIGHT, $timestamp);

		if ($timestamp == strtotime(self::STRTOTIME_MIDNIGHT)) {
			$lastPublishedTimestamp = WikiaDataAccess::cache(
				$this->getMKeyForLastPublishedTimestamp($cityId, $timestamp),
				6 * 60 * 60,
				function () use ($cityId, $timestamp, $useMaster) {
					return $this->getLastPublishedTimestampFromDB($cityId, $timestamp, $useMaster);
				}
			);
		} else {
			$lastPublishedTimestamp = $this->getLastPublishedTimestampFromDB($cityId, $timestamp, $useMaster);
		}

		return $lastPublishedTimestamp;
	}

	protected function getMKeyForLastPublishedTimestamp($cityId, $timestamp) {
		return wfSharedMemcKey(
			self::CACHE_KEY,
			$cityId,
			$timestamp,
			self::CACHE_KEY_LAST_PUBLISHED_TIMESTAMP
		);
	}

	public function getLastPublishedTimestampFromDB($cityId, $timestamp, $useMaster = false) {
		global $wgExternalSharedDB;
		$sdb = wfGetDB(
			($useMaster) ? DB_MASTER : DB_SLAVE,
			[],
			$wgExternalSharedDB
		);

		$conds = [
			'city_id' => $cityId,
			'module_status' => $this->statuses['PUBLISHED']
		];

		$conds = $sdb->makeList($conds, LIST_AND);
		$conds .= ' AND hub_date <= ' . $sdb->timestamp($timestamp);

		$result = $sdb->selectField(self::HUBS_TABLE_NAME, 'unix_timestamp(max(hub_date))', $conds, __METHOD__);

		return $result;
	}

	/**
	 * Get data for module list from DB
	 *
	 * @param int $cityId
	 * @param int $timestamp
	 * @param int $moduleId (optional) returns data only for specified module
	 *
	 * @return array
	 */
	protected function getModulesDataFromDb($cityId, $timestamp, $moduleId = null) {
		global $wgExternalSharedDB;
		$sdb = wfGetDB(DB_SLAVE, [], $wgExternalSharedDB);
		$conds = [
			'city_id' => $cityId,
			'hub_date' => $sdb->timestamp($timestamp),
		];

		if( is_int($moduleId) ) {
			$conds['module_id'] = $moduleId;
		}

		$fields = ['module_id', 'module_status', 'module_data', 'last_edit_timestamp', 'last_editor_id'];

		$results = $sdb->select(self::HUBS_TABLE_NAME, $fields, $conds, __METHOD__);

		$out = [];
		while ($row = $sdb->fetchRow($results)) {
			$out[$row['module_id']] = [
				'status' => $row['module_status'],
				'lastEditTime' => $row['last_edit_timestamp'],
				'lastEditorId' => $row['last_editor_id'],
				'data' => json_decode($row['module_data'], true)
			];
		}

		return $out;
	}

	/**
	 * Get default data for module list if not data is specified in DB
	 *
	 * @return array
	 */
	protected function getDefaultModuleList() {
		$out = [];

		foreach ($this->editableModules as $moduleId => $moduleName) {
			$out[$moduleId] = [
				'status' => $this->statuses['NOT_PUBLISHED'],
				'lastEditTime' => null,
				'lastEditorId' => null,
				'data' => []
			];
		}

		return $out;
	}

	/**
	 * @return User
	 */
	protected function getUserClass() {
		return $this->userClass;
	}

	public function setUserClass($userClass) {
		$this->userClass = $userClass;
	}

	public function getModuleName($moduleId) {
		return wfMessage('wikia-hubs-module-' . $this->modules[$moduleId]);
	}

	/**
	 * Get url to edit module page in Edit Hub
	 *
	 * @param $timestamp
	 * @param $moduleId
	 * @internal param $cityId
	 * @return mixed
	 */
	public function getModuleUrl( $timestamp, $moduleId ) {
		$specialPage = $this->getSpecialPageClass();
		return $specialPage::getTitleFor('EditHub', 'editHub')->getLocalURL(
			[
				'moduleId' => $moduleId,
				'date' => $timestamp
			]
		);
	}

	/**
	 * @return SpecialPage
	 */
	protected function getSpecialPageClass() {
		return $this->specialPageClass;
	}

	public function setSpecialPageClass($specialPageClass) {
		$this->specialPageClass = $specialPageClass;
	}

	/**
	 * Get modules data for last published hub before selected timestamp
	 *
	 * @param int    $cityId
	 * @param int    $timestamp
	 * @param int    $moduleId
	 *
	 * @return array
	 */
	public function getPublishedData($cityId, $timestamp = null, $moduleId = null) {
		$lastPublishTimestamp = $this->getLastPublishedTimestamp($cityId, $timestamp);
		return $this->getModulesDataFromDb($cityId, $lastPublishTimestamp, $moduleId);
	}

	/**
	 * Main method to publish hub page of specific city id on specific day
	 *
	 * @param $cityId
	 * @param $timestamp
	 *
	 * @return stdClass (properties: boolean $success, string $errorMsg)
	 */
	public function publish($cityId, $timestamp) {
		wfProfileIn(__METHOD__);

		$results = new stdClass();
		$results->success = null;
		$results->errorMsg = null;

		if( wfReadOnly() ) {
			$results->success = false;
			$results->errorMsg = wfMsg('edit-hub-module-publish-error-read-only');

			wfProfileOut(__METHOD__);
			return $results;
		}


		$this->publishHub($cityId, $timestamp, $results);

		wfProfileOut(__METHOD__);
		return $results;
	}

	/**
	 * @param $cityId
	 * @param $timestamp
	 * @param stdClass $results
	 *
	 * @return stdClass (properties: boolean $success, string $errorMsg)
	 */
	protected function publishHub($cityId, $timestamp, &$results) {
		global $wgExternalSharedDB;
		wfProfileIn(__METHOD__);
		if( !$this->checkModulesSaved($cityId, $timestamp) ) {
			$results->success = false;
			$results->errorMsg = wfMsg('edit-hub-module-publish-error-modules-not-saved');

			wfProfileOut(__METHOD__);
			return;
		}

		$mdb = wfGetDB(DB_MASTER, [], $wgExternalSharedDB);
		$hubDate = date('Y-m-d', $timestamp);

		$changes = [
			'module_status' => $this->statuses['PUBLISHED']
		];

		$conditions = [
			'city_id' => $cityId,
			'hub_date' => $hubDate
		];

		$dbSuccess = $mdb->update(self::HUBS_TABLE_NAME, $changes, $conditions, __METHOD__);

		if( $dbSuccess ) {
			$mdb->commit(__METHOD__);
			$results->success = true;
		} else {
			$results->success = false;
			$results->errorMsg = wfMsg('edit-hub-module-publish-error-db-error');
		}

		$actualPublishedTimestamp = $this->getLastPublishedTimestamp($cityId);
		if ($actualPublishedTimestamp < $timestamp && $timestamp < time()) {
			$this->purgeLastPublishedTimestampCache($cityId);
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Check if all modules in current hub (city id) are filled and saved
	 *
	 * @param int $cityId
	 * @param int $timestamp
	 */
	public function checkModulesSaved($cityId, $timestamp) {
		global $wgExternalSharedDB;
		$sdb = wfGetDB(DB_SLAVE, [], $wgExternalSharedDB);

		$hubDate = date('Y-m-d', $timestamp);

		$fields = ['count(module_id)'];
		$conds = [
			'city_id' => $cityId,
			'hub_date' => $hubDate
		];

		$result = $sdb->select(self::HUBS_TABLE_NAME, $fields, $conds);

		$row = $sdb->fetchRow($result);

		return ($row[0] == $this->modulesCount) ? true : false;
	}

	protected function purgeLastPublishedTimestampCache($params) {
		$this->wg->Memc->delete($this->getMKeyForLastPublishedTimestamp($params, strtotime(self::STRTOTIME_MIDNIGHT)));
	}

	/**
	 * Save module
	 *
	 * @param Array $params
	 * 			- string $langCode
	 * 			- int $cityId
	 * 			- int $verticalId
	 * @param int $timestamp
	 * @param int $moduleId
	 * @param array $data
	 * @param int $editorId
	 *
	 */
	public function saveModule($params, $timestamp, $moduleId, $data, $editorId) {
		global $wgExternalSharedDB;
		$mdb = wfGetDB(DB_MASTER, [], $wgExternalSharedDB);
		$sdb = wfGetDB(DB_SLAVE, [], $wgExternalSharedDB);

		$updateData = [
			'module_data' => json_encode($data),
			'last_editor_id' => $editorId,
		];

		$conds = [
			'lang_code' => $params['langCode'],
			'vertical_id' => $params['verticalId'],
			'city_id' => $params['cityId'],
			'module_id' => $moduleId,
			'hub_date' => $mdb->timestamp($timestamp)
		];

		$result = $sdb->selectField(self::HUBS_TABLE_NAME, 'count(1)', $conds, __METHOD__);

		if ($result) {
			$mdb->update(self::HUBS_TABLE_NAME, $updateData, $conds, __METHOD__);
		} else {
			$insertData = array_merge($updateData, $conds);

			$mdb->insert(self::HUBS_TABLE_NAME, $insertData, __METHOD__);
		}

		$mdb->commit();
	}

	/**
	 * Get hub url
	 *
	 * @param int $wikiId
	 *
	 * @return String
	 */
	public function getHubUrl($wikiId) {
		$title = GlobalTitle::newMainPage($wikiId);

		return $title->getFullURL();
	}

	public function getModulesCount() {
		return $this->modulesCount;
	}

	/**
	 * Returns HTML tags which are allowed in the module's text field
	 *
	 * @return String
	 */
	public function getAllowedTags() {
		return implode('', $this->allowedTags);
	}

	public function getThumbnailSize() {
		return self::FORM_THUMBNAIL_SIZE;
	}

	public function getModulesIds() {
		return array_merge($this->getEditableModulesIds(), $this->getNonEditableModulesIds());
	}

	public function getEditableModulesIds() {
		return array_keys($this->editableModules);
	}

	public function getNonEditableModulesIds() {
		return array_keys($this->nonEditableModules);
	}

	public function getNotTranslatedModuleName($moduleId) {
		return ucfirst(str_replace('-', '', $this->modules[$moduleId]));
	}

	public function getAvailableStatuses() {
		return $this->statuses;
	}

	/**
	 * Get corporate wikis languages
	 *
	 * @return array
	 */
	public function getCorporateWikisLanguages() {
		$visualizationModel = new CityVisualization();
		$wikisData = $visualizationModel->getVisualizationWikisData();

		$regions = [];

		foreach ($wikisData as $wikiData) {
			$regions[$wikiData['lang']] = Language::getLanguageName($wikiData['lang']);
		}
		return $regions;
	}

	/**
	 * Return array consisting of videoThumb and videoTimestamp
	 * for given video name
	 *
	 * @param string $fileName
	 * @param int    $thumbSize
	 *
	 * @return array
	 */
	public function getVideoData ($fileName, $thumbSize) {
		$videoData = [];
		$title = Title::newFromText($fileName, NS_FILE);
		if (!empty($title)) {
			$file = wffindFile($title);
		}
		if (!empty($file)) {
			$htmlParams = [
				'file-link' => true,
				'duration' => true,
				'img-class' => 'media',
				'linkAttribs' => [ 'class' => 'video-thumbnail lightbox', 'data-video-name' => $fileName ]
			];

			$thumb = $file->transform( ['width' => $thumbSize] );

			$videoData['videoThumb'] = $thumb->toHtml($htmlParams);
			$videoData['videoTimestamp'] = $file->getTimestamp();
			$videoData['videoTime'] = wfTimeFormatAgo($videoData['videoTimestamp']);

			$meta = unserialize($file->getMetadata());
			$videoData['duration'] = isset($meta['duration']) ? $meta['duration'] : null;
			$videoData['title'] = $title->getText();
			$videoData['fileUrl'] = $title->getFullURL();
			$videoData['thumbUrl'] = $thumb->getUrl();
		}

		return $videoData;
	}

	/**
	 * Method to extract textual filename from VET-generated
	 * wikitext (i.e. [[File:Batman - Following|thumb|right|335 px]]
	 * returns false if not found
	 *
	 * @param string $wikiText
	 *
	 * @return string|false $fileName
	 */
	public function extractTitleFromVETWikitext($wikiText) {
		wfProfileIn(__METHOD__);

		$fileName = false;

		$tmpString = ltrim($wikiText, '[');
		$tmpString = rtrim($tmpString, ']');
		$fragments = mb_split('\|', $tmpString);
		if (!empty($fragments[0])) {
			$fileText = mb_split(':', $fragments[0]);
			if (!empty($fileText[1])) {
				$fileName = $fileText[1];
			}
		}

		wfProfileOut(__METHOD__);

		return $fileName;
	}
}
