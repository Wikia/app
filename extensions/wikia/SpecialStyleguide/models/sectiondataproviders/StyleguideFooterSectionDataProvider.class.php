<?php

/**
 * Class StyleguideFooterSectionDataProvider
 *
 * Returns  data for Footer section of Styleguide
 */
class StyleguideFooterSectionDataProvider implements iStyleguideSectionDataProvider {

	public function getData() {
		return [
			'list' => [
				[
					'link' => '#',
					'linkTitle' => 'Blog',
					'linkLabel' => 'Blog'
				],
				[
					'link' => '#',
					'linkTitle' => 'Changelog',
					'linkLabel' => 'Changelog'
				]
			]
		];
	}
}
