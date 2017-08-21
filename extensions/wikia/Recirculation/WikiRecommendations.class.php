<?php

class WikiRecommendations {

	const THUMBNAIL_WIDTH = 100;
	const THUMBNAIL_RATIO = 16 / 9;

	const RECOMMENDATIONS = [
		'en' => [
			[
				'thumbnailUrl' => '/assassinscreed/images/2/25/Wikia-Visualization-Main%2Cassassinscreed.png/revision/latest/thumbnail-down/width/660/height/660?cb=20161102142202',
				'title' => 'Assassin\'s Creed',
				'url' => 'http://assassinscreed.wikia.com',
			],
			[
				'thumbnailUrl' => '/harrypotter/images/6/64/Grindelwald-Profile.jpg/revision/latest/zoom-crop/width/1000/height/563?cb=20170425165236',
				'title' => 'Wiki Name2',
				'url' => 'http://gta2.wikia.com',
			],
			[
				'thumbnailUrl' => '/harrypotter/images/6/64/Grindelwald-Profile.jpg/revision/latest/zoom-crop/width/1000/height/563?cb=20170425165236',
				'title' => 'Wiki Name3',
				'url' => 'http://gta3.wikia.com',
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

	const LANGUAGES = [ 'en', 'de', 'fr', 'es', 'pt-br', 'ru', 'it', 'pl', 'zh', 'ja' ];

	public static function getRecommendations( $contentLanguage ) {
		$recommendations = self::RECOMMENDATIONS['en'];
		if ( in_array( $contentLanguage, self::LANGUAGES ) ) {
			$recommendations = self::RECOMMENDATIONS[$contentLanguage];
		}
		shuffle( $recommendations );

		return array_map( function ( $recommendation ) {
			$recommendation['thumbnailUrl'] =
				self::getThumbnailUrl( $recommendation['thumbnailUrl'] );

			return $recommendation;
		}, array_slice( $recommendations, 0, 3 ) );
	}

	private static function getThumbnailUrl( $url ) {
		global $wgVignetteUrl;

		return VignetteRequest::fromUrl( $wgVignetteUrl . $url )
			->zoomCrop()
			->width( self::THUMBNAIL_WIDTH )
			->height( floor( self::THUMBNAIL_WIDTH / self::THUMBNAIL_RATIO ) )
			->url();
	}
}