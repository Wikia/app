<?
namespace Wikia\Api\Recommendations\DataProviders;

class Video implements IDataProvider {
	const VIDEO_TYPE = 'video';
	const VIDEO_SOURCE = 'VideoRecommendations';

	public function get( $articleId, $limit ) {
		$app = \F::app();

		if ( empty( $app->wg->EnableVideosModuleExt ) ) {
			return [];
		}

		$response = $app->sendRequest( 'VideosModuleController', 'index', [
			'limit' => $limit
		]);

		$videos = $response->getData();

		$recommendations = $this->prepareData( $videos['videos'] );

		return $recommendations;
	}

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
}
