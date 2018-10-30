<?php

namespace Wikia\FeedsAndPosts;

class WikiRecentChangesAPIProxy {

	const LIMIT = 4;
	const MINOR_CHANGE_THRESHOLD = 100;

	const IMAGE_WIDTH = 150;
	const IMAGE_RATIO = 3/4;

	private function requestAPI( $params ) {
		$api = new \ApiMain( new \FauxRequest( $params ) );
		$api->execute();

		return $api->GetResultData();
	}

	private function getThumbnailUrl( $url ) {
		try {
			return \VignetteRequest::fromUrl( $url )
				->zoomCrop()
				->width( self::IMAGE_WIDTH )
				->height( floor( self::IMAGE_WIDTH / self::IMAGE_RATIO ) )
				->url();
		}
		catch ( \Exception $exception ) {
			\Wikia\Logger\WikiaLogger::instance()
				->warning( "Invalid thumbnail url provided for recent updates module",
					[
						'thumbnailUrl' => $url,
						'message' => $exception->getMessage(),
					] );

			return $url;
		}
	}

	private function filterOutSmallChangesAndCleanUp( $articles ) {
		$articlesWithMinorChange = [];
		$articlesWithMajorChange = [];
		$mainPageId = \Title::newMainPage()->getArticleID();

		foreach ( $articles as &$article ) {
			$diffSize = abs( $article['newlen'] - $article['oldlen'] );

			$resultArticle = [
				'title' => $article['title'],
			];

			// filter out main page
			if ( $article['pageid'] !== $mainPageId ) {
				if ( $diffSize >= self::MINOR_CHANGE_THRESHOLD ) {
					$articlesWithMajorChange[] = $resultArticle;
				} else {
					$articlesWithMinorChange[] = $resultArticle;
				}
			}
		}

		if ( count( $articlesWithMajorChange ) >= 4 ) {
			return array_slice( $articlesWithMajorChange, 0, self::LIMIT );
		}

		return array_slice( array_merge( $articlesWithMajorChange, $articlesWithMinorChange ), 0,
			self::LIMIT );
	}

	private function getRecentChanges() {
		global $wgContentNamespaces;

		$response = $this->requestAPI( [
			'action' => 'query',
			'list' => 'recentchanges',
			'rcprop' => 'title|sizes|ids',
			'rcshow' => '!bot|!minor|!redirect',
			'rcnamespace' => implode( '|', $wgContentNamespaces ),
			// load 20 times more items so we'll be able to filter out articles with minor changes
			'rclimit' => self::LIMIT * 20,
		] );

		if ( isset( $response['query']['recentchanges'] ) ) {
			return $this->filterOutSmallChangesAndCleanUp( $response['query']['recentchanges'] );
		}

		return [];
	}

	private function getImage( $title ) {
		$response = $this->requestAPI( [
			'action' => 'imageserving',
			'wisTitle' => $title,
		] );

		if ( isset( $response['image']['imageserving'] ) ) {
			return $this->getThumbnailUrl( $response['image']['imageserving'] );
		}

		return null;
	}

	public function get() {
		$cacheTTL = 3600; // an hour

		return \WikiaDataAccess::cache( wfMemcKey( 'feeds-just-updated' ), $cacheTTL, function () {
			$recentChanges = $this->getRecentChanges();

			foreach ( $recentChanges as &$article ) {
				$article['image'] = $this->getImage( $article['title'] );
			}

			return $recentChanges;
		} );
	}

}
