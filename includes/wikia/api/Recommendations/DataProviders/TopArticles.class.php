<?php
namespace Wikia\Api\Recommendations\DataProviders;

/**
 * Collects recommendations for current wiki.
 * This class was suppose to get most popular cross wiki articles by pageviews in last week,
 * unfortunately because of performance reasons it gets most popular wikis
 * and then most popular articles on those wikis
 *
 * Class TopArticles
 * @package Wikia\Api\Recommendations\DataProviders
 */
class TopArticles implements IDataProvider {
	const RECOMMENDATION_ENGINE = 'Top articles';
	const RECOMMENDATION_TYPE = 'article';

	/**
	 * @param int $articleId
	 * @param int $limit
	 * @return array of articles with details
	 */
	public function get( $articleId, $limit ) {
		wfProfileIn( __METHOD__ );

		$hubName = $this->getHubName();
		$lang = $this->getContentLangCode();

		$out = \WikiaDataAccess::cache(
			\wfsharedMemcKey('RecommendationApi', self::RECOMMENDATION_ENGINE, $hubName, $lang, $limit),
			24 * 60 *60,
			function () use ($hubName, $lang, $limit) {
				$topArticles = $this->getTopArticles( $hubName, $lang, $limit );
				return $this->getArticlesInfo( $topArticles );
			}
		);

		wfProfileOut( __METHOD__ );
		return $out;
	}

	/**
	 * Get wiki HubName - the old one
	 *
	 * @return string
	 */
	protected function getHubName() {
		global $wgCityId;

		// Yes, we need this old category name because rollups don't use new verticals
		return \WikiFactoryHub::getInstance()->getCategoryName( $wgCityId );
	}

	/**
	 * Get wiki content lang code
	 *
	 * @return string
	 */
	protected function getContentLangCode() {
		global $wgContLang;

		return $wgContLang->getCode();
	}

	/**
	 * Get most popular cross wiki articles
	 *
	 * @param string $hubName
	 * @param string $langCode
	 * @param int $limit
	 * @return array of articles - format
	 * [
	 *   ['wikiId' => 1, 'articleId' => 2],
	 *   ['wikiId' => 2, 'articleId' => 3],
	 * ]
	 */
	protected function getTopArticles( $hubName, $langCode, $limit ) {
		wfProfileIn( __METHOD__ );

		$topArticles = [];

		$results = \DataMartService::getTopCrossWikiArticlesByPageview(
			$hubName,
			[$langCode],
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

		wfProfileOut( __METHOD__ );
		return array_slice( $topArticles, 0, $limit );
	}

	/**
	 * @param array $topArticles - output from getTopArticles
	 * @return array of article details. Format:
	 * [
	 *   'type' => self::RECOMMENDATION_TYPE,
	 *   'title' => $articleDetails['title'],
	 *   'url' => $response['basepath'] . $articleDetails['url'],
	 *   'description' => $articleDetails['abstract'],
	 *   'media' => [
	 *     'url' => $articleDetails['thumbnail']
	 *   ],
	 *   'source' => self::RECOMMENDATION_ENGINE
	 * ]
	 */
	protected function getArticlesInfo( $topArticles ) {
		wfProfileIn( __METHOD__ );

		$out = [];

		foreach ( $topArticles as $topArticleInfo ) {
			$articleId = $topArticleInfo['articleId'];
			$wikiId = $topArticleInfo['wikiId'];

			$params = [
				'controller' => 'ArticlesApiController',
				'method' => 'getDetails',
				'ids' => $articleId,
				'width' => 400,
				'height' => 225
			];

			$response = \ApiService::foreignCall(\WikiFactory::IDtoDB( $wikiId ), $params, \ApiService::WIKIA);

			if ( !empty( $response['items'][$articleId] ) ) {
				$articleDetails =  $response['items'][$articleId];

				$out[] = [
					'type' => self::RECOMMENDATION_TYPE,
					'title' => $articleDetails['title'],
					'url' => $response['basepath'] . $articleDetails['url'],
					'description' => $articleDetails['abstract'],
					'media' => [
						'url' => $articleDetails['thumbnail']
					],
					'source' => self::RECOMMENDATION_ENGINE
				];
			}
		}

		wfProfileOut( __METHOD__ );
		return $out;
	}
}
