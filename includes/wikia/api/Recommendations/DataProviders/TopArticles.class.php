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
 * @author Maciej Brencz <macbre@wikia-inc.com>
 * @author Damian Jozwiak <damian@wikia-inc.com>
 * @author Łukasz Konieczny <lukaszk@wikia-inc.com>
 */
class TopArticles implements IDataProvider {
	const RECOMMENDATION_ENGINE = 'TopArticles';
	const RECOMMENDATION_TYPE = 'article';

	/**
	 * Keep it low for better performance - we're using foreign call to fetch data about every article
	 */
	const MAX_LIMIT = 10;

	const MCACHE_VERSION = '1.03';

	/**
	 * @param int $articleId
	 * @param int $limit - max limit = 10
	 * @return array of articles with details
	 */
	public function get( $articleId, $limit ) {
		wfProfileIn( __METHOD__ );

		$hubName = $this->getHubName();
		$lang = $this->getContentLangCode();

		$out = \WikiaDataAccess::cache(
			\wfSharedMemcKey( 'RecommendationApi', self::RECOMMENDATION_ENGINE, $hubName, $lang, self::MCACHE_VERSION ),
			\WikiaResponse::CACHE_STANDARD,
			function () use ( $hubName, $lang ) {
				$topArticles = $this->getTopArticles( $hubName, $lang);
				return $this->getArticlesInfo( $topArticles );
			}
		);

		shuffle( $out );
		$out = array_slice( $out, 0, $limit );

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
	 * Get 10 most popular cross wiki articles
	 *
	 * @param string $hubName
	 * @param string $langCode
	 * @return array of articles - format
	 * [
	 *   ['wikiId' => 1, 'articleId' => 2],
	 *   ['wikiId' => 2, 'articleId' => 3],
	 * ]
	 */
	protected function getTopArticles( $hubName, $langCode) {
		wfProfileIn( __METHOD__ );

		$topArticles = [];

		$results = \DataMartService::getTopCrossWikiArticlesByPageview(
			$hubName,
			[$langCode],
			[NS_MAIN]
		);

		$articlesCount = ceil( self::MAX_LIMIT / count( $results ) );

		foreach ( $results as $wikiResult ) {
			for ( $i = 0; $i < $articlesCount; $i++ ) {
				$topArticles[] = [
					'wikiId' => $wikiResult['wiki']['id'],
					'articleId' => $wikiResult['articles'][$i]['id']
				];
			}
		}

		wfDebug( sprintf( "%s: returning %s items\n", __METHOD__, count($topArticles) ) );

		wfProfileOut( __METHOD__ );
		return $topArticles;
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

			$wikiData = \WikiFactory::getWikiByID( $wikiId );

			$response = \ApiService::foreignCall( $wikiData->city_dbname, $params, \ApiService::WIKIA );

			if ( !empty( $response['items'][$articleId] ) ) {
				$articleDetails =  $response['items'][$articleId];

				$media = [
					'thumbUrl' => $articleDetails['thumbnail'],
					'originalWidth' => !empty( $articleDetails['original_dimensions']['width'])
							? (int) $articleDetails['original_dimensions']['width']
							: null,
					'originalHeight' => !empty( $articleDetails['original_dimensions']['height'])
							? (int) $articleDetails['original_dimensions']['height']
							: null,
				];

				$out[] = [
					'type' => self::RECOMMENDATION_TYPE,
					'title' => $wikiData->city_title . ' - ' . $articleDetails['title'],
					'url' => $response['basepath'] . $articleDetails['url'],
					'description' => $articleDetails['abstract'],
					'media' => $media,
					'source' => self::RECOMMENDATION_ENGINE
				];
			}
		}

		wfProfileOut( __METHOD__ );
		return $out;
	}
}
