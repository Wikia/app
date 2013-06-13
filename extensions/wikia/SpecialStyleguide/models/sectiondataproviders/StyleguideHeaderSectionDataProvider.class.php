<?php

/**
 * Class StyleguideHeaderSectionDataProvider
 *
 * Returns  data for Header section of Styleguide
 */
class StyleguideHeaderSectionDataProvider implements iStyleguideSectionDataProvider {

	public function getData() {
		return [
			'home' => [
				'mainHeader' => wfMessage( 'styleguide-home-header' )->plain(),
				'getStartedBtnLink' => '',
				'getStartedBtnTitle' => wfMessage( 'styleguide-get-started' )->plain(),
				'getStartedBtnLabel' => wfMessage( 'styleguide-get-started' )->plain(),
				'version' => 'Version 1.0.0'
			],
			'tagLine' => wfMessage( 'styleguide-home-header-tagline' )->plain(),
		];
	}
}
