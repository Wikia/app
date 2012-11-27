<?php

class MarketingToolboxModel extends WikiaModel {
	const SECTION_HUBS = 1;

	const MODULE_SLIDER = 1;
	const MODULE_PULSE = 2;
	const MODULE_WIKIAS_PICKS = 3;
	const MODULE_FEATURED_VIDEO = 4;
	const MODULE_EXPLORE = 5;
	const MODULE_FROM_THE_COMMUNITY = 6;
	const MODULE_POLLS = 7;
	const MODULE_TOP_10_LISTS = 8;
	const MODULE_POPULAR_VIDEOS = 9;

	protected $statuses = array();
	protected $modules = array();
	protected $sections = array();
	protected $verticals = array();

	public function __construct() {
		$this->statuses = array(
			'NOT_PUBLISHED' => 1,
			'PUBLISHED' => 2
		);

		$this->modules = array(
			self::MODULE_SLIDER => 'slider',
			self::MODULE_PULSE => 'pulse',
			self::MODULE_WIKIAS_PICKS => 'wikias-picks',
			self::MODULE_FEATURED_VIDEO => 'featured-video',
			self::MODULE_EXPLORE => 'explore',
			self::MODULE_FROM_THE_COMMUNITY => 'from-the-community',
			self::MODULE_POLLS => 'polls',
			self::MODULE_TOP_10_LISTS => 'top10-lists',
			self::MODULE_POPULAR_VIDEOS => 'popular-videos'
		);

		$this->sections = array(
			self::SECTION_HUBS => wfMsg('marketing-toolbox-section-hubs-button')
		);

		$this->verticals = array(
			self::SECTION_HUBS => array(
				WikiFactoryHub::CATEGORY_ID_GAMING => wfMsg('marketing-toolbox-section-games-button'),
				WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT => wfMsg('marketing-toolbox-section-entertainment-button'),
				WikiFactoryHub::CATEGORY_ID_LIFESTYLE => wfMsg('marketing-toolbox-section-lifestyle-button'),
			)
		);
	}

	public function getData($langCode, $verticalId, $beginTimestamp, $endTimestamp) {
		return $this->getMockData($langCode, $verticalId, $beginTimestamp, $endTimestamp);
	}

	protected function getMockData($langCode, $verticalId, $beginTimestamp, $endTimestamp) {
		return array(
			date('Y-m-d', $beginTimestamp - 13 * 24 * 60 * 60) => $this->statuses['NOT_PUBLISHED'],
			date('Y-m-d', $beginTimestamp - 11 * 24 * 60 * 60) => $this->statuses['NOT_PUBLISHED'],
			date('Y-m-d', $beginTimestamp - 7 * 24 * 60 * 60) => $this->statuses['PUBLISHED'],
			date('Y-m-d', $beginTimestamp - 4 * 24 * 60 * 60) => $this->statuses['NOT_PUBLISHED'],
			date('Y-m-d', $beginTimestamp + 4 * 24 * 60 * 60) => $this->statuses['NOT_PUBLISHED'],
			date('Y-m-d', $beginTimestamp + 7 * 24 * 60 * 60) => $this->statuses['PUBLISHED'],
			date('Y-m-d', $beginTimestamp + 11 * 24 * 60 * 60) => $this->statuses['PUBLISHED'],
			date('Y-m-d', $beginTimestamp + 13 * 24 * 60 * 60) => $this->statuses['PUBLISHED'],
			date('Y-m-d', $beginTimestamp + 19 * 24 * 60 * 60) => $this->statuses['NOT_PUBLISHED'],
			date('Y-m-d', $beginTimestamp + 23 * 24 * 60 * 60) => $this->statuses['PUBLISHED']
		);
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
	 * @param int $sectionId sectioId
	 *
	 * @return string section name
	 */
	public function getSectionName($sectionId) {
		return $this->sections[$sectionId];
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
	 * @param $langCode
	 * @param $verticalId
	 * @param $timestamp
	 * @return array
	 */
	public function getModulesData($langCode, $verticalId, $timestamp, $activeModule = self::MODULE_SLIDER) {
		$moduleList = $this->getModuleList($langCode, $verticalId, $timestamp);

		$modulesData = array(
			'lastEditDate' => null,
			'lastEditorName' => null,
			'moduleList' => array()
		);

		foreach ($moduleList as $moduleId => &$module) {
			if ($moduleId == $activeModule) {
				$user = User::newFromId($module['lastEditorId']);
				if ($user instanceof User) {
					$userName = $user->getName();
				} else {
					$userName = null;
				}
				$modulesData['lastEditor'] = $userName;
				$modulesData['lastEditTime'] = $module['lastEditTime'];
				$modulesData['activeModuleName'] = wfMsg('marketing-toolbox-hub-module-' . $this->modules[$moduleId]);
			}
			$module['name'] = wfMsg('marketing-toolbox-hub-module-' . $this->modules[$moduleId]);
			$module['href'] = SpecialPage::getTitleFor('MarketingToolbox', 'editHub')->getLocalURL(array(
				'moduleId' => $moduleId,
				'date' => $timestamp,
				'region' => $langCode,
				'verticalId' => $verticalId
			));
		}
		$modulesData['moduleList'] = $moduleList;

		return $modulesData;
	}

	/**
	 * Gets mocked data for modules
	 *
	 * @param $langCode
	 * @param $verticalId
	 * @param $timestamp
	 * @return array
	 */
	protected function getModuleList($langCode, $verticalId, $timestamp) {
		$mockEditorId = 4807210;

		return array(
			self::MODULE_SLIDER => array(
				'status' => $this->statuses['PUBLISHED'],
				'lastEditTime' => $timestamp - 4 * 24 * 60 * 60,
				'lastEditorId' => $mockEditorId
			),
			self::MODULE_PULSE => array(
				'status' => $this->statuses['NOT_PUBLISHED'],
				'lastEditTime' => $timestamp - 5 * 24 * 60 * 60,
				'lastEditorId' => $mockEditorId
			),
			self::MODULE_WIKIAS_PICKS => array(
				'status' => $this->statuses['PUBLISHED'],
				'lastEditTime' => $timestamp - 6 * 24 * 60 * 60,
				'lastEditorId' => $mockEditorId
			),
			self::MODULE_FEATURED_VIDEO => array(
				'status' => $this->statuses['NOT_PUBLISHED'],
				'lastEditTime' => $timestamp - 7 * 24 * 60 * 60,
				'lastEditorId' => $mockEditorId
			),
			self::MODULE_EXPLORE => array(
				'status' => $this->statuses['PUBLISHED'],
				'lastEditTime' => $timestamp - 8 * 24 * 60 * 60,
				'lastEditorId' => $mockEditorId
			),
			self::MODULE_FROM_THE_COMMUNITY => array(
				'status' => $this->statuses['PUBLISHED'],
				'lastEditTime' => $timestamp - 9 * 24 * 60 * 60,
				'lastEditorId' => $mockEditorId
			),
			self::MODULE_POLLS => array(
				'status' => $this->statuses['NOT_PUBLISHED'],
				'lastEditTime' => $timestamp - 10 * 24 * 60 * 60,
				'lastEditorId' => $mockEditorId
			),
			self::MODULE_TOP_10_LISTS => array(
				'status' => $this->statuses['PUBLISHED'],
				'lastEditTime' => $timestamp - 11 * 24 * 60 * 60,
				'lastEditorId' => $mockEditorId
			),
			self::MODULE_POPULAR_VIDEOS => array(
				'status' => $this->statuses['PUBLISHED'],
				'lastEditTime' => $timestamp - 12 * 24 * 60 * 60,
				'lastEditorId' => $mockEditorId
			),
		);
	}
}

