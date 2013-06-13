<?php

/**
 * Class StyleguideHomePageSectionDataProvider
 *
 * Returns data for Home Page section of Styleguide
 */
class StyleguideHomePageSectionDataProvider implements iStyleguideSectionDataProvider {

	public function getData() {
		return [
			'sections' => [
				[
					'header' => wfMessage( 'styleguide-home-welcome-message' )->plain(),
					'paragraph' => wfMessage( 'styleguide-home-welcome-message' )->plain(),
				],
				[
					'header' => wfMessage( 'styleguide-home-stakeholders-header' )->plain(),
					'paragraph' => wfMessage( 'styleguide-home-stakeholders-paragraph' )->plain(),
				],
				[
					'header' => wfMessage( 'styleguide-home-team-header' )->plain(),
					'paragraph' => wfMessage( 'styleguide-home-team-paragraph' )->plain(),
					'list' => [
						[
							'link' => '',
							'linkTitle' => 'Elizabeth Worthy',
							'linkName' => 'Elizabeth Worthy',
							'linkTagline' => wfMessage( 'styleguide-home-team-pm' )->plain(),
						],
						[
							'link' => '',
							'linkTitle' => 'Rafał Leszczyński',
							'linkName' => 'Rafał Leszczyński',
							'linkTagline' => wfMessage( 'styleguide-home-team-engineer' )->plain(),
						],
						[
							'link' => '',
							'linkTitle' => 'Mika Kozma',
							'linkName' => 'Mika Kozma',
							'linkTagline' => wfMessage( 'styleguide-home-team-designer' )->plain(),
						],
						[
							'link' => '',
							'linkTitle' => 'Earl Carlson',
							'linkName' => 'Earl Carlson',
							'linkTagline' => 'Product designer'
						]
					]
				]
			]
		];
	}
}
