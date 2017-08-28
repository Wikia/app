<?php

class WikiRecommendations {

	const THUMBNAIL_WIDTH = 100;
	const THUMBNAIL_RATIO = 16 / 9;
	const WIKI_RECOMMENDATIONS_LIMIT = 3;

	const RECOMMENDATIONS = [
		'en' => [
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/gameofthrones/images/3/3a/WhiteWalker_%28Hardhome%29.jpg/revision/latest?cb=20150601151110',
				'title' => 'Game of Thrones',
				'url' => 'http://gameofthrones.wikia.com/wiki/Game_of_Thrones_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/deathnote/images/1/1d/Light_Holding_Death_Note.png/revision/latest?cb=20120525180447',
				'title' => 'Death Note',
				'url' => 'http://deathnote.wikia.com/wiki/Main_Page',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/midnight-texas/images/b/b0/Blinded_by_the_Light_106-01-Rev-Sheehan-Davy-Deputy.jpg/revision/latest?cb=20170820185915',
				'title' => 'Midnight Texas',
				'url' => 'http://midnight-texas.wikia.com/wiki/Midnight,_Texas_Wikia',
			],
		],
		'de' => [],
		'fr' => [],
		'es' => [],
		'pt-br' => [],
		'ru' => [],
		'it' => [],
		'pl' => [],
		'zh' => [],
		'ja' => [],
	];

	const DEV_RECOMMENDATIONS = [
		[
			'thumbnailUrl' => 'https://vignette.wikia-dev.pl/gameofthrones/images/3/3a/WhiteWalker_%28Hardhome%29.jpg/revision/latest?cb=20150601151110',
			'title' => 'Game of Thrones',
			'url' => 'http://gameofthrones.wikia.com/wiki/Game_of_Thrones_Wiki',
		],
		[
			'thumbnailUrl' => 'https://vignette.wikia-dev.pl/deathnote/images/1/1d/Light_Holding_Death_Note.png/revision/latest?cb=20120525180447',
			'title' => 'Death Note',
			'url' => 'http://deathnote.wikia.com/wiki/Main_Page',
		],
		[
			'thumbnailUrl' => 'https://vignette.wikia-dev.pl/midnight-texas/images/b/b0/Blinded_by_the_Light_106-01-Rev-Sheehan-Davy-Deputy.jpg/revision/latest?cb=20170820185915',
			'title' => 'Midnight Texas',
			'url' => 'http://midnight-texas.wikia.com/wiki/Midnight,_Texas_Wikia',
		]
	];
	
	public static function getRecommendations( $contentLanguage ) {
		global $wgDevelEnvironment;


		if ( empty( $wgDevelEnvironment ) ) {
			$recommendations = self::RECOMMENDATIONS['en'];

			if ( array_key_exists( $contentLanguage, self::RECOMMENDATIONS ) ) {
				$recommendations = self::RECOMMENDATIONS[$contentLanguage];
			}
			shuffle( $recommendations );
		} else {
			$recommendations = self::DEV_RECOMMENDATIONS;
		}

		$recommendations = array_slice( $recommendations, 0, self::WIKI_RECOMMENDATIONS_LIMIT );

		$index = 1;
		foreach($recommendations as &$recommendation) {
			$recommendation['thumbnailUrl'] = self::getThumbnailUrl( $recommendation['thumbnailUrl'] );
			$recommendation['index'] = $index;
			$index++;
		}

		return $recommendations;
	}

	private static function getThumbnailUrl( $url ) {

		return VignetteRequest::fromUrl( $url )->zoomCrop()->width( self::THUMBNAIL_WIDTH )->height(
			floor( self::THUMBNAIL_WIDTH / self::THUMBNAIL_RATIO )
		)->url();
	}
}
