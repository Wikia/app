<?php

class MarketingToolboxModel {
	const SECTION_HUBS = 1;

	const VERTICAL_VIDEOGAMES = 1;
	const VERTICAL_ENTERTAINMENT = 2;
	const VERTICAL_LIFESTYLE = 3;

	protected $statuses = array();
	protected $sections = array();
	protected $verticals = array();

	public function __construct() {
		$this->statuses = array(
			'DAY_EDITED_NOT_PUBLISHED' => 1,
			'DAY_PUBLISHED' => 2
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
			date('Y-m-d', $beginTimestamp - 13 * 24 * 60 * 60) => $this->statuses['DAY_EDITED_NOT_PUBLISHED'],
			date('Y-m-d', $beginTimestamp - 11 * 24 * 60 * 60) => $this->statuses['DAY_EDITED_NOT_PUBLISHED'],
			date('Y-m-d', $beginTimestamp - 7 * 24 * 60 * 60) => $this->statuses['DAY_PUBLISHED'],
			date('Y-m-d', $beginTimestamp - 4 * 24 * 60 * 60) => $this->statuses['DAY_EDITED_NOT_PUBLISHED'],
			date('Y-m-d', $beginTimestamp + 4 * 24 * 60 * 60) => $this->statuses['DAY_EDITED_NOT_PUBLISHED'],
			date('Y-m-d', $beginTimestamp + 7 * 24 * 60 * 60) => $this->statuses['DAY_PUBLISHED'],
			date('Y-m-d', $beginTimestamp + 11 * 24 * 60 * 60) => $this->statuses['DAY_PUBLISHED'],
			date('Y-m-d', $beginTimestamp + 13 * 24 * 60 * 60) => $this->statuses['DAY_PUBLISHED'],
			date('Y-m-d', $beginTimestamp + 19 * 24 * 60 * 60) => $this->statuses['DAY_EDITED_NOT_PUBLISHED'],
			date('Y-m-d', $beginTimestamp + 23 * 24 * 60 * 60) => $this->statuses['DAY_PUBLISHED']
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
}

