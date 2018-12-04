<?php

namespace Wikia\FeedsAndPosts;

use Wikia\Logger\WikiaLogger;
use WikiaHttpException;

class TopArticles {

	const LIMIT = 12;

	const IMAGE_WIDTH = 80;
	const IMAGE_RATIO = 4 / 3;

	public function get() {
		$cacheTTL = 3600; // an hour

		return \WikiaDataAccess::cache(
			wfMemcKey( 'feeds-top-articles' ),
			$cacheTTL,
			function () {
				global $wgContentNamespaces;

				$responseData = [];
				$mainPageId = \Title::newMainPage()->getArticleID();
				$params = [
					'abstract' => false,
					'expand' => true,
					'limit' => self::LIMIT,
					'namespaces' => implode( ',', $wgContentNamespaces )
				];

				try {
					$data = \F::app()->sendRequest( 'ArticlesApi', 'getTop', $params )->getData();
				} catch ( WikiaHttpException $e ) {
					if ( $e->getCode() != 404 ) {
						WikiaLogger::instance()->error(
							'could not fetch top articles - ' . $e->getMessage(),
							[ 'exception' => $e ]
						);
					}

					$data = [ 'items' => [] ];
				}

				foreach ( $data['items'] as $articleData ) {
					if ( count( $responseData ) === self::LIMIT ) {
						break;
					}

					if ( $mainPageId !== $articleData['id'] ) {
						$responseData[] = [
							'title' => $articleData['title'],
							'url' => $articleData['url'],
							'image' => Thumbnails::getThumbnailUrl(
								$articleData['thumbnail'],
								self::IMAGE_WIDTH,
								self::IMAGE_RATIO
							),
						];
					}
				}

				return $responseData;
			}
		);
	}

}
