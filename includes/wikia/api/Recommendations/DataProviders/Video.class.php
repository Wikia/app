<?php
namespace Wikia\Api\Recommendations\DataProviders;

/**
 * Video recommendations for RecommendationsApi
 * @author Maciej Brencz <macbre@wikia-inc.com>
 * @author Damian Jozwiak <damian@wikia-inc.com>
 * @author Łukasz Konieczny <lukaszk@wikia-inc.com>
 *
 */
class Video implements IDataProvider {
	const VIDEO_TYPE = 'video';
	const VIDEO_SOURCE = 'VideoRecommendations';

	/**
	 * Get data about recommended videos
	 *
	 * @param int $articleId - article id - not needed for videos
	 * @param int $limit - number of returned videos
	 * @return array recommended videos
	 */
	public function get( $articleId, $limit ) {
		global $wgEnableVideosModuleExt;

		$app = \F::app();

		$recommendations = [];
		// We are fetching more videos to randomize results
		$limitForRandomize = $limit * 3;

		if ( !empty( $wgEnableVideosModuleExt ) ) {
			$response = $app->sendRequest( 'VideosModuleController', 'index', [
				'limit' => $limitForRandomize
			]);

			$videos = $response->getData();

			if ( isset( $videos[ 'videos' ] ) ) {
				$randomVideos = $this->getRandomRecommendations( $videos['videos'], $limit );
				$recommendations = $this->prepareData( $randomVideos );
			}
		}
		else {
			wfDebug( __METHOD__ . ": \$wgEnableVideosModuleExt is set to false, no data returned!\n" );
		}

		return $recommendations;
	}

	/**
	 * Prepare data in proper structure
	 *
	 * @param array $videos videos data fetch from Videos Module
	 * @return array videos data with proper structure
	 */
	protected function prepareData( Array $videos ) {
		$data = [];

		foreach ( $videos as $video ) {
			$data[] = [
				'type' => self::VIDEO_TYPE,
				'title' => $video[ 'title' ],
				'url' => $video[ 'url' ],
				'description' => $video[ 'description' ],
				'source' => self::VIDEO_SOURCE,
				'media' => [
					'thumbUrl' => $video[ 'thumbUrl' ],
					'duration' => $video[ 'duration' ],
					'videoKey' => $video[ 'videoKey' ]
				]
			];
		}

		return $data;
	}

	/**
	 * Get random videos data
	 *
	 * @param array $videos videos data
	 * @param int $limit number of videos to return
	 * @return array limited random videos array
	 */
	protected function getRandomRecommendations( Array $videos, $limit ) {
		$randomVideos = [];

		$randomKeys = array_rand( $videos, $limit );

		foreach ( $randomKeys as $key ) {
			$randomVideos[] = $videos[ $key ];
		}

		return $randomVideos;
	}
}
