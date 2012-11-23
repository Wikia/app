<?php

class MarketingToolboxModel {
	const SECTION_HUBS = 1;

	const VERTICAL_VIDEOGAMES = 1;
	const VERTICAL_ENTERTAINMENT = 2;
	const VERTICAL_LIFESTYLE = 3;

	const MODULE_SLIDER = 1;
	const MODULE_PULSE = 2;
	const MODULE_WIKIAS_PICKS = 3;
	const MODULE_FEATURED_VIDEO = 4;
	const MODULE_EXPLORE = 5;
	const MODULE_FROM_THE_COMMUNITY = 6;
	const MODULE_POLLS = 7;
	const MODULE_TOP_10_LISTS = 8;
	const MODULE_POPULAR_VIDEO = 9;

	protected $statuses = array();
	protected $sections = array();
	protected $verticals = array();

	public function __construct() {
		$this->statuses = array(
			'NOT_PUBLISHED' => 1,
			'PUBLISHED' => 2
		);

		$this->sections = array(
			self::SECTION_HUBS => wfMsg('marketing-toolbox-section-hubs-button')
		);

		$this->verticals = array(
			self::SECTION_HUBS => array(
				self::VERTICAL_VIDEOGAMES => wfMsg('marketing-toolbox-section-games-button'),
				self::VERTICAL_ENTERTAINMENT => wfMsg('marketing-toolbox-section-entertainment-button'),
				self::VERTICAL_LIFESTYLE => wfMsg('marketing-toolbox-section-lifestyle-button'),
			)
		);
	}

	public function getData($langId, $verticalId, $beginTimestamp, $endTimestamp) {
		return $this->getMockData($langId, $verticalId, $beginTimestamp, $endTimestamp);
	}

	protected function getMockData($langId, $verticalId, $beginTimestamp, $endTimestamp) {
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
			$regions[$wikiData['wikiId']] = Language::getLanguageName($wikiData['lang']);
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
	 *
	 * @param $langId
	 * @param $verticalId
	 * @param $timestamp
	 * @return array
	 */
	public function getModuleList($langId, $verticalId, $timestamp) {
		$moduleData = $this->getModuleData($langId, $verticalId, $timestamp);

		foreach ($moduleData as &$module) {
			$user = User::newFromId($module['lastEditorId']);
			if($user instanceof User) {
				$userName = $user->getName();
			} else {
				$userName = null;
			}
			$module['lastEditorName'] = $userName;
		}

		return $moduleData;
	}

	/**
	 * Gets mocked data for modules
	 *
	 * @param $langId
	 * @param $verticalId
	 * @param $timestamp
	 * @return array
	 */
	protected function getModuleData($langId, $verticalId, $timestamp) {
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
			self::MODULE_POPULAR_VIDEO => array(
				'status' => $this->statuses['PUBLISHED'],
				'lastEditTime' => $timestamp - 12 * 24 * 60 * 60,
				'lastEditorId' => $mockEditorId
			),
		);
	}
}

