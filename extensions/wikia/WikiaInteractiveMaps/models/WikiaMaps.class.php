<?php


class WikiaMaps {
	public function getMapInstances( $cityId ) {
		return [
			[
				'id' => 1,
				'image' => 'http://placekitten.com/1494/300',
        		'name' => 'Kittenlandia',
                'updated' => time(),
			]
		];
	}
} 