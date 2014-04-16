<?php


class WikiaMaps {

	private $config = [];

	public function __construct( $config ) {
		$this->config = $config;
	}

	public function getMapInstances( $cityId, $search, $mapOrder, $offset, $limit ) {
		return [
			[
				'id' => 1,
				'image' => 'http://placekitten.com/1494/300',
        		'title' => 'Kittenlandia',
                'created_on' => date('c', time()),
				'status' => 'Processing',
			],
			[
				'id' => 2,
				'image' => 'http://placekitten.com/1494/300',
				'title' => 'Kittenopolis',
				'created_on' => date('c', time()),
			]
		];
	}
}
