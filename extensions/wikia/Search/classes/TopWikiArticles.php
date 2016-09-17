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
	 * Dimensions for hot article image in Top Wiki Articles module
	 */
	const HOT_ARTICLE_IMAGE_WIDTH = 300;
	const HOT_ARTICLE_IMAGE_HEIGHT = 150;

	/**
	 * Dimensions for hot article image in Top Wiki Articles module in fluid layout
	 */
	const HOT_ARTICLE_IMAGE_WIDTH_FLUID = 270;
	const HOT_ARTICLE_IMAGE_HEIGHT_FLUID = 135;

	static public function getArticlesWithCache( $cityId, $isGridLayoutEnabled ) {
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

	static public function getArticles() {
		global $wgLang;

		$app = \F::app();
		$pages = [];

		try {
			$pageData = $app->sendRequest( 'ArticlesApiController', 'getTop', [ 'namespaces' => 0 ] )->getData();
			$ids = [];
			$counter = 0;

			foreach ( $pageData['items'] as $pageDatum ) {
				$ids[] = $pageDatum['id'];
				if ( $counter++ >= 12 ) {
					break;
				}
			}

			if ( !empty( $ids ) ) {
				$params = [ 'ids' => implode( ',', $ids ), 'height' => 50, 'width' => 50, 'abstract' => 120 ];
				$detailResponse = $app->sendRequest( 'ArticlesApiController', 'getDetails', $params )->getData();
				$dimensions = static::getHotArticleImageDimensions();

				foreach ( $detailResponse['items'] as $id => $item ) {
					if ( !empty( $item['thumbnail'] ) ) {
						$item['thumbnailSize'] = "small";
						//get the first one image from imageServing as it needs other size
						if ( empty( $pages ) ) {
							$is = new \ImageServing( [ $id ], $dimensions['width'], $dimensions['height'] );
							$result = $is->getImages( 1 );
							if ( !empty( $result[$id][0]['url'] ) ) {
								$item['thumbnail'] = $result[$id][0]['url'];
								$item['thumbnailSize'] = "large";
							}
						}
						//render date
						$item['date'] = $wgLang->date( $item['revision']['timestamp'] );
						$item = \WikiaSearchController::processArticleItem( $item, 75 );
						$pages[] = $item;
					}
				}
			}
		} catch ( \Exception $e ) {
			// ignoring API exceptions for gracefulness
		}

		return $pages;
	}

	private static function getHotArticleImageDimensions() {
		if ( \BodyController::isGridLayoutEnabled() ) {
			$dimensions = [
				'width' => self::HOT_ARTICLE_IMAGE_WIDTH,
				'height' => self::HOT_ARTICLE_IMAGE_HEIGHT
			];
		} else {
			$dimensions = [
				'width' => self::HOT_ARTICLE_IMAGE_WIDTH_FLUID,
				'height' => self::HOT_ARTICLE_IMAGE_HEIGHT_FLUID
			];
		}

		return $dimensions;
	}
}
