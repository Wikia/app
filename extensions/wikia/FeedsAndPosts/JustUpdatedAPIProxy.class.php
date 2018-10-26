<?php

namespace Wikia\FeedsAndPosts;

class JustUpdatedAPIProxy {

	const LIMIT = 4;
	const MINOR_CHANGE_THRESHOLD = 100;

	private function requestAPI( $params ) {
		$api = new \ApiMain( new \FauxRequest( $params ) );
		$api->execute();

		return $api->GetResultData();
	}

	private function filterOutSmallChanges( $articles ) {
		$articlesWithMinorChange = [];
		$articlesWithMajorChange = [];

		foreach ( $articles as &$article ) {
			if ( abs( $article['newlen'] - $article['oldlen'] ) >= self::MINOR_CHANGE_THRESHOLD ) {
				$articlesWithMajorChange[] = $article;
			} else {
				$articlesWithMinorChange[] = $article;
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
			'rcprop' => 'title|sizes',
			'rcshow' => '!bot|!minor|!redirect',
			'rcnamespace' => implode( '|', $wgContentNamespaces ),
			// load 20 times more items so we'll be able to filter out articles with minor changes
			'rclimit' => self::LIMIT * 20,
		] );

		if ( isset( $response['query']['recentchanges'] ) ) {
			return $this->filterOutSmallChanges( $response['query']['recentchanges'] );
		}

		return [];
	}

	private function getImage( $title ) {
		$response = $this->requestAPI( [
			'action' => 'imageserving',
			'wisTitle' => $title,
		] );

		if ( isset( $response['image']['imageserving'] ) ) {
			return $response['image']['imageserving'];
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
