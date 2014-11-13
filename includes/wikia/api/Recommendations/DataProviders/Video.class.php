<?
namespace Wikia\Api\Recommendations\DataProviders;

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
		$app = \F::app();

		$recommendations = [];
		// We are fetching more videos to randomize results
		$limitForRandomize = $limit * 3;

		$response = $app->sendRequest( 'VideosModuleController', 'index', [
			'limit' => $limitForRandomize
		]);

		$videos = $response->getData();

		if ( isset( $videos[ 'videos' ] ) ) {
			$randomVideos = $this->getRandomRecommendations( $videos['videos'], $limit );
			$recommendations = $this->prepareData( $randomVideos );
		}

		return $recommendations;
	}

	/**
	 * Prepare data in proper structure
	 *
	 * @param array $videos videos data fetch from Videos Module
	 * @return array videos data with proper structure
	 */
	protected function prepareData( $videos ) {
		$data = [];

		foreach ( $videos as $video ) {
			$data[] = [
				'type' => self::VIDEO_TYPE,
				'title' => $video[ 'title' ],
				'url' => $video[ 'url' ],
				'description' => '',
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
	protected function getRandomRecommendations( $videos, $limit ) {
		$randomVideos = [];

		$randomKeys = array_rand( $videos, $limit );

		foreach ( $randomKeys as $key ) {
			$randomVideos[] = $videos[ $key ];
		}

		return $randomVideos;
	}
}
