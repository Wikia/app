<?php

namespace Wikia\FeedsAndPosts;

class TopArticles extends MediaWikiAPI {

	const LIMIT = 12;

	const IMAGE_WIDTH = 80;
	const IMAGE_RATIO = 4 / 3;

	public function get() {
		$cacheTTL = 3600; // an hour

		return \WikiaDataAccess::cache( wfMemcKey( 'feeds-top-articles' ), $cacheTTL, function () {
			global $wgContentNamespaces;

			$responseData = [];
			$mainPageId = \Title::newMainPage()->getArticleID();
			$params = [
				'abstract' => false,
				'expand' => true,
				'limit' => self::LIMIT,
				'namespaces' => implode( ',', $wgContentNamespaces )
			];
			
			$data = \F::app()->sendRequest( 'ArticlesApi', 'getTop', $params )->getData();

			var_dump($data); die();

			foreach ( $data['items'] as $articleId => $articleData ) {
				if ( count( $responseData ) === self::LIMIT ) {
					break;
				}

				$title = $articleData['link']['title'];

				if ( $mainPageId !== $articleId ) {
					$responseData[] = [
						'title' => $title,
						'url' => $articleData['link']['url'],
						'image' => $this->getImage( $title, self::IMAGE_WIDTH, self::IMAGE_RATIO ),
					];
				}
			}

			return $responseData;
		} );
	}

}
