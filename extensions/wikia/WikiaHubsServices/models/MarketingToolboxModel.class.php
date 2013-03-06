<?php

class MarketingToolboxModel extends WikiaModel {
	const SECTION_HUBS = 1;

	const HUBS_TABLE_NAME = '`wikia_hub_modules`';

	const FORM_THUMBNAIL_SIZE = 149;
	const FORM_FIELD_PREFIX = 'MarketingToolbox';

	protected $statuses = array();
	protected $modules = array();
	protected $sections = array();
	protected $verticals = array();
	protected $modulesCount;

	protected $specialPageClass = 'SpecialPage';
	protected $userClass = 'User';

	protected $allowedTags = array('<a>');

	public function __construct($app = null) {
		parent::__construct();

		if (!empty($app)) {
			$this->setApp($app);
		}

		$this->statuses = array(
			'NOT_PUBLISHED' => 1,
			'PUBLISHED' => 2
		);

		$this->modules = array(
			MarketingToolboxModuleSliderService::MODULE_ID => 'slider',
			MarketingToolboxModuleWikiaspicksService::MODULE_ID => 'wikias-picks',
			MarketingToolboxModuleFeaturedvideoService::MODULE_ID => 'featured-video',
			MarketingToolboxModuleExploreService::MODULE_ID => 'explore',
			MarketingToolboxModuleFromthecommunityService::MODULE_ID => 'from-the-community',
			MarketingToolboxModulePollsService::MODULE_ID => 'polls',
			MarketingToolboxModulePopularvideosService::MODULE_ID => 'popular-videos'
		);

		$this->modulesCount = count($this->modules);

		$this->sections = array(
			self::SECTION_HUBS => $this->wf->msg('marketing-toolbox-section-hubs-button')
		);

		$this->verticals = array(
			self::SECTION_HUBS => array(
				WikiFactoryHub::CATEGORY_ID_GAMING => $this->wf->msg('marketing-toolbox-section-games-button'),
				WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT => $this->wf->msg('marketing-toolbox-section-entertainment-button'),
				WikiFactoryHub::CATEGORY_ID_LIFESTYLE => $this->wf->msg('marketing-toolbox-section-lifestyle-button'),
			)
		);

	}

	public function getModulesCount() {
		return $this->modulesCount;
	}

	/**
	 * @desc Returns HTML tags which are allowed in the module's text field
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
		return array_keys($this->modules);
	}
	
	public function getModuleName($moduleId) {
		return $this->wf->msg('marketing-toolbox-hub-module-' . $this->modules[$moduleId]);
	}

	public function getNotTranslatedModuleName($moduleId) {
		return ucfirst(str_replace('-', '', $this->modules[$moduleId]));
	}

	public function getCalendarData($langCode, $verticalId, $beginTimestamp, $endTimestamp) {
		$sdb = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);
		$conds = array(
			'lang_code' => $langCode,
			'vertical_id' => $verticalId,
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

	public function getAvailableStatuses() {
		return $this->statuses;
	}

	/**
	 * Get corporate wikis languages
	 *
	 * @return array
	 */
	public function getCorporateWikisLanguages() {
		$visualizationModel = F::build('CityVisualization');
		$wikisData = $visualizationModel->getVisualizationWikisData();

		$regions = array();

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
		$videoData = array();
		$title = Title::newFromText($fileName, NS_FILE);
		if (!empty($title)) {
			$file = $this->wf->findFile($title);
		}
		if (!empty($file)) {
			$htmlParams = array(
				'file-link' => true,
				'duration' => true,
				'linkAttribs' => array('class' => 'video-thumbnail lightbox')
			);
			$thumb = $file->transform(array('width' => $thumbSize));

			$videoData['videoThumb'] = $thumb->toHtml($htmlParams);
			$videoData['videoTimestamp'] = $file->getTimestamp();
			$videoData['videoTime'] = $this->wf->TimeFormatAgo($videoData['videoTimestamp']);

			$meta = unserialize($file->getMetadata());
			$videoData['duration'] = isset($meta['duration']) ? $meta['duration'] : null;
			$videoData['title'] = $title->getText();
			$videoData['fileUrl'] = $title->getFullURL();
			$videoData['thumbUrl'] = $thumb->getUrl();
		}

		return $videoData;
	}


	/**
	 * Get avalable sections
	 *
	 * @return array
	 */
	public function getAvailableSections() {
		return $this->sections;
	}

	/**
	 * Get section name
	 *
	 * @param int $sectionId sectionId
	 *
	 * @return string section name
	 */
	public function getSectionName($sectionId) {
		return $this->sections[$sectionId];
	}

	/**
	 * Get vertical ids
	 *
	 * @param int $sectionId section id
	 *
	 * @return array vertical ids
	 */
	public function getVerticalsIds($sectionId = self::SECTION_HUBS) {
		return array_keys($this->verticals[$sectionId]);
 	}

	/**
	 * Get vertical name
	 *
	 * @param int $sectionId section id
	 * @param int $verticalId vertical id
	 *
	 * @return string vertical name
	 */
	public function getVerticalName($sectionId, $verticalId) {
		return $this->verticals[$sectionId][$verticalId];
	}

	/**
	 * Get available verticals for selected section
	 *
	 * @param int $sectionId
	 * @return array
	 */
	public function getAvailableVerticals($sectionId) {
		if (isset($this->verticals[$sectionId])) {
			return $this->verticals[$sectionId];
		}
		return null;
	}

	/**
	 * Get list of modules for selected lang/vertical/date
	 * applying translation for module name
	 *
	 * @param string $langCode
	 * @param int $sectionId
	 * @param int $verticalId
	 * @param int $timestamp
	 * @param int $activeModule
	 *
	 * @return array
	 */
	public function getModulesData($langCode, $sectionId, $verticalId, $timestamp, $activeModule = MarketingToolboxModuleSliderService::MODULE_ID) {
		$moduleList = $this->getModuleList($langCode, $sectionId, $verticalId, $timestamp);

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
			$module['href'] = $this->getModuleUrl($langCode, $sectionId, $verticalId, $timestamp, $moduleId);
		}
		$modulesData['moduleList'] = $moduleList;

		return $modulesData;
	}

	/**
	 * Get modules data for last published hub before selected timestamp
	 *
	 * @param string $langCode
	 * @param int    $sectionId
	 * @param int    $verticalId
	 * @param int    $timestamp
	 * @param int    $moduleId
	 *
	 * @return array
	 */
	public function getPublishedData($langCode, $sectionId, $verticalId, $timestamp = null, $moduleId = null) {
		$lastPublishTimestamp = $this->getLastPublishedTimestamp($langCode, $sectionId, $verticalId, $timestamp);
		return $this->getModulesDataFromDb($langCode, $sectionId, $verticalId, $lastPublishTimestamp, $moduleId);
	}

	public function getModuleUrl($langCode, $sectionId, $verticalId, $timestamp, $moduleId) {
		$specialPage = $this->getSpecialPageClass();
		return $specialPage::getTitleFor('MarketingToolbox', 'editHub')->getLocalURL(
			array(
				'moduleId' => $moduleId,
				'date' => $timestamp,
				'region' => $langCode,
				'verticalId' => $verticalId,
				'sectionId' => $sectionId
			)
		);
	}

	/**
	 * Get list of modules for selected lang/vertical/timestamp
	 *
	 * @param string $langCode
	 * @param int $sectionId
	 * @param int $verticalId
	 * @param int $timestamp
	 *
	 * @return array
	 */
	protected function getModuleList($langCode, $sectionId, $verticalId, $timestamp) {
		$lastPublishTimestamp = $this->getLastPublishedTimestamp($langCode, $sectionId, $verticalId);

		if ($lastPublishTimestamp) {
			$out = $this->getModulesDataFromDb($langCode, $sectionId, $verticalId, $lastPublishTimestamp);
		} else {
			$out = $this->getDefaultModuleList();
		}
		
		$actualData = $this->getModulesDataFromDb($langCode, $sectionId, $verticalId, $timestamp);
		$out = $actualData + $out;
		ksort($out);

		return $out;
	}

	/**
	 * @param $moduleId
	 * @param $langCode
	 * @param $sectionId
	 * @param $verticalId
	 * @param $timestamp
	 * 
	 * @return array
	 */
	public function getModuleDataFromDb($langCode, $sectionId, $verticalId, $timestamp, $moduleId) {
		$data = $this->getModulesDataFromDb($langCode, $sectionId, $verticalId, $timestamp, $moduleId);
		return isset($data[$moduleId]) ? $data[$moduleId] : array();
	}

	/**
	 * Get data for module list from DB
	 *
	 * @param string $langCode
	 * @param int $sectionId
	 * @param int $verticalId
	 * @param int $timestamp
	 * @param int $moduleId (optional) returns data only for specified module
	 *
	 * @return array
	 */
	protected function getModulesDataFromDb($langCode, $sectionId, $verticalId, $timestamp, $moduleId = null) {
		$sdb = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);
		$conds = array(
			'lang_code' => $langCode,
			'vertical_id' => $verticalId,
			'hub_date' => $sdb->timestamp($timestamp),
		);
		
		if( is_int($moduleId) ) {
			$conds['module_id'] = $moduleId; 
		}
		
		$table = $this->getTablesBySectionId($sectionId);
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
	 * Get default data for module list if not data is specified in DB
	 *
	 * @return array
	 */
	protected function getDefaultModuleList() {
		$out = array();

		foreach ($this->modules as $moduleId => $moduleName) {
			$out[$moduleId] = array(
				'status' => $this->statuses['NOT_PUBLISHED'],
				'lastEditTime' => null,
				'lastEditorId' => null,
				'data' => array()
			);
		}

		return $out;
	}

	/**
	 * Save module
	 *
	 * @param string $langCode
	 * @param int $sectionId
	 * @param int $verticalId
	 * @param int $timestamp
	 * @param int $moduleId
	 * @param array $data
	 * @param int $editorId
	 *
	 */
	public function saveModule($langCode, $sectionId, $verticalId, $timestamp, $moduleId, $data, $editorId) {
		$mdb = $this->wf->GetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);
		$sdb = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);

		$updateData = array(
			'module_data' => json_encode($data),
			'last_editor_id' => $editorId,
		);

		$table = $this->getTablesBySectionId($sectionId);

		$conds = array(
			'lang_code' => $langCode,
			'vertical_id' => $verticalId,
			'module_id' => $moduleId,
			'hub_date' => $mdb->timestamp($timestamp)
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
	 * @param string $langCode
	 * @param int $sectionId
	 * @param int $verticalId
	 * @param int $timestamp - max timestamp that we should search for published hub
	 *
	 * @return int timestamp
	 */
	protected function getLastPublishedTimestamp($langCode, $sectionId, $verticalId, $timestamp = null) {
		if ($timestamp === null) {
			$timestamp = time();
		}
		$sdb = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);
		$table = $this->getTablesBySectionId($sectionId);

		$conds = array(
			'lang_code' => $langCode,
			'vertical_id' => $verticalId,
			'module_status' => $this->statuses['PUBLISHED']
		);

		$conds = $sdb->makeList($conds, LIST_AND);
		$conds .= ' AND hub_date <= ' . $sdb->timestamp($timestamp);

		$result = $sdb->selectField($table, 'unix_timestamp(max(hub_date))', $conds, __METHOD__);

		return $result;
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
		$this->wf->profileIn(__METHOD__);

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

		$this->wf->profileOut(__METHOD__);

		return $fileName;
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

	protected function getSpecialPageClass() {
		return $this->specialPageClass;
	}

	public function setSpecialPageClass($specialPageClass) {
		$this->specialPageClass = $specialPageClass;
	}

	protected function getUserClass() {
		return $this->userClass;
	}

	public function setUserClass($userClass) {
		$this->userClass = $userClass;
	}
}