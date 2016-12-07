<?php

namespace Wikia\Search;

class TopWikiArticles {
	/**
	 * Used for changing mem cache key for top articles snippet (after changed will end up in purging cache)
	 */
	const TOP_ARTICLES_CACHE = 1;

	/**
	 * 5 days, one business week
	 */
	const CACHE_TTL = 86400 * 5;

	/**
	 * We want to return articles with thumbnails, but not all articles
	 * returned from ArticlesApiController:getTop() have them, that is why we ask for
	 * more articles than we will return
	 */
	const GET_NUMBER_OF_TOP_ARTICLES_FROM_DB = 12;
	const TOP_ARTICLES_RESULT_LIMIT = 5;

	public static function getArticlesWithCache( $cityId, $isGridLayoutEnabled ) {
		$cacheKey = wfMemcKey(
			__CLASS__,
			'WikiaSearch',
			'topWikiArticles',
			$cityId,
			static::TOP_ARTICLES_CACHE,
			$isGridLayoutEnabled
		);

		return \WikiaDataAccess::cache(
			$cacheKey,
			86400 * 5, // 5 days, one business week
			function () {
				return static::getArticles();
			}
		);
	}

	public static function getArticles() {
		global $wgLang;

		$pages = [];

		try {
			$app = \F::app();
			$pageData = $app->sendRequest(
					'ArticlesApiController',
					'getTop',
					[ 'namespaces' => 0, 'limit' => static::GET_NUMBER_OF_TOP_ARTICLES_FROM_DB ]
				)->getData();
			$ids = [];

			foreach ( $pageData['items'] as $item ) {
				$ids[] = $item['id'];
			}

			$params = [ 'ids' => implode( ',', $ids ), 'height' => 90, 'width' => 90, 'abstract' => 120 ];
			$detailResponse = $app->sendRequest( 'ArticlesApiController', 'getDetails', $params )->getData();

			foreach ( $detailResponse['items'] as $item ) {
				if ( !empty( $item['thumbnail'] ) && count( $pages ) < static::TOP_ARTICLES_RESULT_LIMIT ) {
					$item['thumbnailSize'] = "small";
					//render date
					$item['date'] = $wgLang->date( $item['revision']['timestamp'] );
					$item = \WikiaSearchController::processArticleItem( $item, 120 );
					$pages[] = $item;
				}
			}
		} catch ( \Exception $e ) {
			// ignoring API exceptions for gracefulness
		}

		return $pages;
	}
}
