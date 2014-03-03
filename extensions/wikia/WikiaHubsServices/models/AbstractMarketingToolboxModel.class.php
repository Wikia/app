<?php

abstract class AbstractMarketingToolboxModel extends WikiaModel {
	const SECTION_HUBS = 1;

	const HUBS_TABLE_NAME = '`wikia_hub_modules`';

	const FORM_THUMBNAIL_SIZE = 149;
	const FORM_FIELD_PREFIX = 'MarketingToolbox';

	const STRTOTIME_MIDNIGHT = '00:00';

	protected $statuses = array();
	protected $modules = array();
	protected $editableModules = array();
	protected $nonEditableModules = array();
	protected $sections = array();
	protected $verticals = array();
	protected $modulesCount;

	protected $specialPageClass = 'SpecialPage';
	protected $userClass = 'User';

	// Tags that will NOT get stripped from curator-provided text
	protected $allowedTags = array('<a>', '<br>');

	public function __construct($app = null) {
		parent::__construct();

		if (!empty($app)) {
			$this->setApp($app);
		}

		$this->statuses = array(
			'NOT_PUBLISHED' => 1,
			'PUBLISHED' => 2
		);

		$this->editableModules = array(
			MarketingToolboxModuleSliderService::MODULE_ID => 'slider',
			MarketingToolboxModuleWikiaspicksService::MODULE_ID => 'wikias-picks',
			MarketingToolboxModuleFeaturedvideoService::MODULE_ID => 'featured-video',
			MarketingToolboxModuleExploreService::MODULE_ID => 'explore',
			MarketingToolboxModuleFromthecommunityService::MODULE_ID => 'from-the-community',
			MarketingToolboxModulePollsService::MODULE_ID => 'polls',
			MarketingToolboxModulePopularvideosService::MODULE_ID => 'popular-videos'
		);

		$this->nonEditableModules = array(
			MarketingToolboxModuleWAMService::MODULE_ID => 'wam'
		);

		$this->modules = $this->editableModules + $this->nonEditableModules;

		$this->modulesCount = count($this->editableModules);

		$this->sections = array(
			self::SECTION_HUBS => wfMessage('marketing-toolbox-section-hubs-button')
		);

		$this->verticals = array(
			self::SECTION_HUBS => array(
				WikiFactoryHub::CATEGORY_ID_GAMING => wfMessage('marketing-toolbox-section-games-button'),
				WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT => wfMessage('marketing-toolbox-section-entertainment-button'),
				WikiFactoryHub::CATEGORY_ID_LIFESTYLE => wfMessage('marketing-toolbox-section-lifestyle-button'),
			)
		);

	}


	//Gets modules statuses for given language and vertical between selected dates
	abstract public function getCalendarData($params, $beginTimestamp, $endTimestamp);

	// Get list of modules
	abstract public function getModulesData($params, $timestamp, $activeModule);

	// Get modules data for last published hub before selected timestamp
	abstract public function getPublishedData($params, $timestamp = null, $moduleId = null);

	// Get url to edit module page in Marketing Toolbox
	abstract public function getModuleUrl($params, $timestamp, $moduleId);

	// Get list of modules for selected
	abstract protected function getModuleList($params, $timestamp);

	// TODO: confirm this is UNUSED
	abstract public function getModuleDataFromDb($params, $timestamp, $moduleId);

	// Check if all modules in current hub are filled and saved
	abstract public function checkModulesSaved($params, $timestamp);

	// Main method to publish hub page on specific day
	abstract public function publish($params, $timestamp);

	abstract protected function publishHub($params, $timestamp, &$results);

	// Save module
	abstract public function saveModule($params, $timestamp, $moduleId, $data, $editorId);

	// Get data for module list from DB
	abstract protected function getModulesDataFromDb($params, $timestamp, $moduleId = null);

	// Get last timestamp when hub was published (before selected timestamp)
	abstract public function getLastPublishedTimestamp($params, $timestamp = null, $useMaster = false);

	abstract public function getLastPublishedTimestampFromDB($params, $timestamp, $useMaster = false);

	abstract protected function getMKeyForLastPublishedTimestamp($params, $timestamp);


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
	
	public function getEditableModulesIds() {
		return array_keys($this->editableModules);
	}

	public function getNonEditableModulesIds() {
		return array_keys($this->nonEditableModules);
	}

	public function getModulesIds() {
		return array_merge($this->getEditableModulesIds(), $this->getNonEditableModulesIds());
	}
	
	public function getModuleName($moduleId) {
		return wfMessage('wikia-hubs-module-' . $this->modules[$moduleId]);
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
			$file = wffindFile($title);
		}
		if (!empty($file)) {
			$htmlParams = array(
				'file-link' => true,
				'duration' => true,
				'img-class' => 'media',
				'linkAttribs' => array('class' => 'video-thumbnail lightbox', 'data-video-name' => $fileName )
			);

			$thumb = $file->transform(array('width' => $thumbSize));

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
	 * Get default data for module list if not data is specified in DB
	 *
	 * @return array
	 */
	protected function getDefaultModuleList() {
		$out = array();

		foreach ($this->editableModules as $moduleId => $moduleName) {
			$out[$moduleId] = array(
				'status' => $this->statuses['NOT_PUBLISHED'],
				'lastEditTime' => null,
				'lastEditorId' => null,
				'data' => array()
			);
		}

		return $out;
	}

	protected function purgeLastPublishedTimestampCache($params) {
		$this->wg->Memc->delete($this->getMKeyForLastPublishedTimestamp($params, strtotime(self::STRTOTIME_MIDNIGHT)));
	}

	/**
	 * Get hub url
	 *
	 * @param $langCode
	 * @param $verticalId
	 *
	 * @return String
	 */
	public function getHubUrl($langCode, $verticalId) {
		$corporateModel = new WikiaCorporateModel();
		$wikiId = $corporateModel->getCorporateWikiIdByLang($langCode);
		$hubName = WikiaHubsServicesHelper::getHubName($wikiId, $verticalId);

		$title = GlobalTitle::newFromText($hubName, NS_MAIN, $wikiId);

		return $title->getFullURL();
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
