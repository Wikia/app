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
					'linkTitle' => wfMessage( 'styleguide-blog' )->plain(),
					'linkLabel' => wfMessage( 'styleguide-blog' )->plain(),
				],
				[
					'link' => '#',
					'linkTitle' => wfMessage( 'styleguide-changelog' )->plain(),
					'linkLabel' => wfMessage( 'styleguide-changelog' )->plain(),
				]
			]
		];
	}
}
