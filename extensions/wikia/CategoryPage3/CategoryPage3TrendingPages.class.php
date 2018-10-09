<?php

use Wikia\Logger\WikiaLogger;

class CategoryPage3TrendingPages {
	const LIMIT = 8;

	// 4:3 ratio
	const THUMBNAIL_HEIGHT = 120;
	const THUMBNAIL_WIDTH = 160;

	public static function getTrendingPages( Title $title ) {
		global $wgContentNamespaces;

		$params = [
			'abstract' => false,
			'category' => $title->getText(),
			'expand' => true,
			'height' => static::THUMBNAIL_HEIGHT,
			'limit' => static::LIMIT,
			'namespaces' => implode( ',', $wgContentNamespaces ),
			'width' => static::THUMBNAIL_WIDTH,
		];

		$trendingPages = [];

		try {
			$rawData = F::app()
				->sendRequest( 'ArticlesApi', 'getTop', $params )
				->getData();
			$trendingPages = static::processTrendingPagesData( $rawData );
		} catch ( NotFoundException $ex ) {
			WikiaLogger::instance()->info( 'Trending articles data is empty' );
		}

		return $trendingPages;
	}

	private static function processTrendingPagesData( $data ) {
		if ( !isset( $data['items'] ) || !is_array( $data['items'] ) ) {
			return null;
		}

		$items = [];

		foreach ( $data['items'] as $item ) {
			$processedItem = static::processTrendingPagesItem( $item );

			if ( !empty( $processedItem ) ) {
				$items[] = $processedItem;
			}
		}

		return $items;
	}

	/**
	 * Remove unused params - no need to pass the large structure further
	 * Reject items without the required params - we don't want to display items without thumbnail
	 * Would be nice to always get the LIMIT but it requires large refactor of ArticlesApi::getTop()
	 *
	 * @param $item
	 * @return array|null
	 */
	private static function processTrendingPagesItem( $item ) {
		$requiredParams = [ 'title', 'thumbnail', 'url' ];

		$processedItem = [];

		if ( !empty( $item ) && is_array( $item ) ) {
			foreach ( $requiredParams as $param ) {
				if ( !empty( $item[ $param ] ) ) {
					$processedItem[ $param ] = $item[ $param ];
				} else {
					return null;
				}
			}
		}

		return $processedItem;
	}
}
