<?php
class CommunityDataService
{
	function __construct( $cityId ) {
		$this->cityId = $cityId;
	}

	private $wgWikiaCuratedContent = [
		'curated' => [
			'items' => [
				'item1' => 'costam',
				'item2' => 'cos innego'
			]
		],
		'featured' => [],
		'community_data' => [
			'description' => '',
			'image_id' => 162219,
			'image_crop' => [
				'square' => [
					'x' => 0,
					'y'=> 0,
				'width'=> 512,
				'height'=> 512
			]
			]
		]
	];

	public function getCommunityData() {
		return isset( $wgWikiaCuratedContent['community_data'] ) ? $wgWikiaCuratedContent['community_data'] : [];
	}

	public function getCommunityImageId() {
		return 195822;
	}
}