<?php

/**
 * Class SpecialStyleguideDataModel
 * Handles getting of data
 */
class SpecialStyleguideDataModel {

	/**
	 * Returns data for section given as param
	 * @param $sectionName string
	 * @return array
	 */
	public function getSectionData($sectionName) {
		$sectionDataProvider = $this->getSectionDataProvider($sectionName);
		return $sectionDataProvider->getData();
	}

	private function getSectionDataProvider($sectionName) {
		switch ($sectionName) {
			case 'home':
				return new StyleguideHomePageSectionDataProvider;
				break;
			case 'header':
				return new StyleguideHeaderSectionDataProvider;
				break;
			case 'footer':
				return new StyleguideFooterSectionDataProvider;
				break;
			default:
				return new StyleguideNullSectionDataProvider;
		}
	}
}
