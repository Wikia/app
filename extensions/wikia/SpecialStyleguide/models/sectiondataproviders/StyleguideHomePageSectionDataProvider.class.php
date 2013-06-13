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
					'header' => 'Lorem ipsum',
					'paragraph' => 'Maecenas sed diam eget risus varius blandit.'
				],
				[
					'header' => 'Lorem ipsum',
					'paragraph' => 'Maecenas faucibus mollis interdum. Maecenas sed diam eget risus varius blandit
					sit amet non magna. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas sed diam eget risus varius blandit sit amet non magna. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.',
				],
				[
					'header' => 'Lorem ipsum',
					'paragraph' => 'Maecenas faucibus mollis interdum. Maecenas sed diam eget risus varius blandit
					sit amet non magna. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.',
					'list' => [
						[
							'link' => '',
							'linkTitle' => 'Lorem Ipsum',
							'linkName' => 'Lorem Ipsum',
							'linkTagline' => 'Lorem ipsum dolor'
						],
						[
							'link' => '',
							'linkTitle' => 'Lorem Ipsum',
							'linkName' => 'Lorem Ipsum',
							'linkTagline' => 'Lorem ipsum dolor'
						],
						[
							'link' => '',
							'linkTitle' => 'Lorem Ipsum',
							'linkName' => 'Lorem Ipsum',
							'linkTagline' => 'Lorem ipsum dolor'
						]
					]
				]
			]
		];
	}
}
