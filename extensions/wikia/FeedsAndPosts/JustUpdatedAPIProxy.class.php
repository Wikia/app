<?php

namespace Wikia\FeedsAndPosts;

class JustUpdatedAPIProxy {

	const LIMIT = 4;

	private function requestAPI( $params ) {
		$api = new \ApiMain( new \FauxRequest( $params ) );
		$api->execute();

		return $api->GetResultData();
	}

	private function getRecentChanges() {
		global $wgContentNamespaces;

		$response = $this->requestAPI( [
			'action' => 'query',
			'list' => 'recentchanges',
			'rcprop' => 'title',
			'rcshow' => '!bot|!minor|!redirect',
			'rcnamespace' => implode( '|', $wgContentNamespaces ),
			'rclimit' => self::LIMIT,
		] );

		if ( isset( $response['query']['recentchanges'] ) ) {
			return $response['query']['recentchanges'];
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
