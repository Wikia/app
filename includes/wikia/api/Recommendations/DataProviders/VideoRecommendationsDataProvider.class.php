<?
class VideoRecommendationsDataProvider extends AbstractRecommendationsDataProvider {
	public function get( $articleId, $limit ) {
		// TODO
		return [
			[
				'type' => 'video',
				'title' => 'Example title',
				'url' => 'http://muppet.wikia.com/wiki/Kermit',
				'description' => 'example desciption',
				'media' => [], // TODO
				'source' => 'VideoRecommendations'
			]
		];
	}
}
