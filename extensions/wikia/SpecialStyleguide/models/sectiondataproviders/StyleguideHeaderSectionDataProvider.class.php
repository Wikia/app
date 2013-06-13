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
				'mainHeader' => 'Lorem Ipsum Dolor',
				'getStartedBtnLink' => '',
				'getStartedBtnTitle' => 'Lorem Ipsum',
				'getStartedBtnLabel' => 'Get started',
				'version' => 'Version 1.0.0'
			],
			'tagLine' => 'Maecenas faucibus mollis interdum',
		];
	}
}
