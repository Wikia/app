<?
namespace Wikia\Api\Recommendations\DataProviders;

class TopArticles implements IDataProvider {
	const RECOMMENDATION_ENGINE = 'Top articles';
	const RECOMMENDATION_TYPE = 'article';

	public function get( $articleId, $limit ) {
		$hubName = $this->getHubName();
		$lang = $this->getContentLang();

		// TODO cache
		$topArticles = $this->getTopArticles( $hubName, $lang, $limit );

		return $this->getArticlesInfo( $topArticles );
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
			null,
			$limit
		);

		$articlesCount = ceil( $limit / count($results) );

		foreach ( $results as $wikiResult ) {
			for ( $i = 0; $i < $articlesCount; $i++ ) {
				$topArticles[] = [
					'wikiId' => $wikiResult['wiki']['id'],
					'articleId' => $wikiResult['articles'][$i]
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
			$title = \GlobalTitle::newFromId( $articleId, $topArticleInfo['wikiId'] );

			$imageServing = new \ImageServing( [$articleId], 400, array( 'w' => 16, 'h' => 9 ) );
			$images = $imageServing->getImages( 1 );

			$articleService->setArticleById( $articleId );

			$articleInfoExpanded = [
				'type' => self::RECOMMENDATION_TYPE,
				'title' => $title->getText(),
				'url' => $title->getFullURL(),
				'description' => $articleService->getTextSnippet(),
				'media' => [],
				'source' => self::RECOMMENDATION_ENGINE
			];

			if ( !empty( $images[$articleId] ) ) {
				$articleInfoExpanded['media']['url'] = $images[$articleId]['url'];
			}

			$out[] = $articleInfoExpanded;
		}

		return $out;
	}
}
