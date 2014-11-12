<?
class RecommendationApi {
	public function get( $articleId, $limit ) {
		$out = [];
		$dataProviders = $this->getDataProviders();
		foreach ( $dataProviders as $dataProvider ) {
			// TODO better limit :)
			$out = array_merge( $out, $dataProvider->get($articleId, 3 ) );
		}

		return $out;
	}

	protected function getDataProviders() {
		return [
			(new VideoRecommendationsDataProvider),
			(new TopArticlesRecommendationsDataProvider),
			(new CategoryRecommendationsDataProvider)
		];
	}
}
