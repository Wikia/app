<?
namespace Wikia\Api\Recommendations\DataProviders;

class TopArticles implements IDataProvider {
	const RECOMMENDATION_ENGINE = 'Top articles';
	const RECOMMENDATION_TYPE = 'article';

	public function get( $articleId, $limit ) {

		$hubName = $this->getHubName();
		$lang = $this->getContentLang();

		$out = \WikiaDataAccess::cache(
			\wfMemcKey('RecommendationApi', self::RECOMMENDATION_ENGINE, $hubName, $lang, $limit),
			24 * 60 *60,
			function () use ($hubName, $lang, $limit) {
				$topArticles = $this->getTopArticles( $hubName, $lang, $limit );
				return $this->getArticlesInfo( $topArticles );
			}
		);

		return $out;
	}

	protected function getHubName() {
		global $wgCityId;

		// Yes, we need this old category name because rollups don't use new verticals
		return \WikiFactoryHub::getInstance()->getCategoryName( $wgCityId );
	}

	protected function getContentLang() {
		global $wgContLang;

		return $wgContLang->getCode();
	}

	protected function getTopArticles( $hubName, $lang, $limit ) {
		$topArticles = [];

		$results = \DataMartService::getTopCrossWikiArticlesByPageview(
			$hubName,
			[$lang],
			[NS_MAIN],
			$limit
		);

		$articlesCount = ceil( $limit / count($results) );

		foreach ( $results as $wikiResult ) {
			for ( $i = 0; $i < $articlesCount; $i++ ) {
				$topArticles[] = [
					'wikiId' => $wikiResult['wiki']['id'],
					'articleId' => $wikiResult['articles'][$i]['id']
				];
			}
		}

		return array_slice( $topArticles, 0, $limit );
	}

	protected function getArticlesInfo( $topArticles ) {
		$out = [];
		$articleService = new \ArticleService();

		foreach ( $topArticles as $topArticleInfo ) {
			$articleId = $topArticleInfo['articleId'];
			$wikiId = $topArticleInfo['wikiId'];
			$title = \GlobalTitle::newFromId( $articleId, $topArticleInfo['wikiId'] );


			$articleService->setArticleById( $articleId );

			$articleInfoExpanded = [
				'type' => self::RECOMMENDATION_TYPE,
				'title' => $title->getText(),
				'url' => $title->getFullURL(),
				'description' => $articleService->getTextSnippet(),
				'media' => [],
				'source' => self::RECOMMENDATION_ENGINE
			];

			$imageServing = new \ImageServing(
				[$articleId],
				400,
				['w' => 16, 'h' => 9],
				wfGetDB( DB_SLAVE, [], $wikiId )
			);
			$images = $imageServing->getImages( 1 );
			if ( !empty( $images[$articleId] ) ) {
				$articleInfoExpanded['media']['url'] = $images[$articleId]['url'];
			}

			$out[] = $articleInfoExpanded;
		}

		return $out;
	}
}
