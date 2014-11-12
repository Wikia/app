<?
namespace Wikia\Api\Recommendations;

class Api {
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
			(new DataProviders\Video),
			(new DataProviders\TopArticles),
			(new DataProviders\Category)
		];
	}
}
