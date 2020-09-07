<?php

namespace UserActivity;

class Controller extends \WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;
	const NUM_ARTICLES_SHOWN = 3;

	public function index() {
		$user = \F::app()->wg->User;
		$limit = $this->getVal( 'limit' );
		$offset = $this->getVal( 'offset' );
		$order = $this->getVal( 'order' );

		$result = [
			'total' => 0,
			'totalReturned' => 0,
			'items' => []
		];

		if ( empty( $user ) ) {
			return;
		}

		if ( $user->isBlocked() ) {
			return;
		}

		if ( !$user->isLoggedIn() ) {
			return;
		}

		$contribs = new \LookupContribsCore( $user );
		$contribs->setLimit( $limit );
		$contribs->setOffset( $offset );
		$contribs->setOrder( $order );

		$activity = $contribs->getUserActivity();

		if ( !empty( $activity ) ) {
			$result['items'] = $this->formatItems( $activity['data'] );
			$result['total'] = $activity['cnt'];
			$result['totalReturned'] = count( $result['items'] );
		}

		$this->response->setData( $result );
	}

	protected function formatItems( $items ) {
		$flattened = [];
		foreach ( $items as $sortKey => $contribItem ) {
			$lastEditTS = wfTimestamp( TS_MW, $contribItem['lastedit'] );
			$localizedDate = \F::app()->wg->Lang->timeanddate( $lastEditTS, $localTZ = true );

			$editCount = $contribItem['edits'];
			$editString = wfMessage( 'user-activity-edit-count', $editCount )->text();

			$dbName = $contribItem['dbname'];
			$groups = implode(', ', $this->getGroups( $dbName ) );

			$flattened[] = [
				'lastEdit' => $localizedDate,
				'editString' => $editString,
				'groups' => $groups,
				'url' => $contribItem['url'],
				'title' => $contribItem['title'],
			];
		}

		return $flattened;
	}

	private function getGroups( $dbName ) {
		$userName = $this->wg->User->getName();
		$params = [
			'action' => 'query',
			'list' => 'users',
			'ususers' => urlencode( $userName ),
			'usprop' => 'groups',
		];

		$resp = \ApiService::foreignCall( $dbName, $params, \ApiService::API );

		if ( ( $resp === false ) || ( empty( $resp['query']['users'][0]['groups'] ) ) ) {
			return [];
		}

		$allGroups = $resp['query']['users'][0]['groups'];
		$selectGroups = preg_grep( '/chatmoderator|bureaucrat|sysop/', $allGroups );
		$translatedGroups = array_map(
			function( $value ) {
				$key = "group-$value-member";
				return wfMessage( $key )->text();
			},
			$selectGroups
		);

		if ( $this->isUserFounder( $dbName ) ) {
			$translatedGroups[] = wfMessage( 'lookupuser-founder' )->text();
		}

		return $translatedGroups;
	}

	private function isUserFounder( $dbName ) {
		$wiki = \WikiFactory::getWikiByDB( $dbName );
		return $wiki->city_founding_user == $this->wg->User->getId();
	}

	public function getArticleBlurbs( $dbName ) {
		$articleIds = $this->getRecentChangeIds( $dbName );
		$articleInfo = $this->getRecentChangeInfo( $dbName, $articleIds );

		return $articleInfo;
	}

	private function getRecentChangeIds( $dbName ) {
		$params = [
			'action' => 'query',
			'list' => 'recentchanges',
			'rcuser' => $this->wg->User->getName(),
			'rcprop' => 'ids|title',
			'rcshow' => '!minor|!redirect',
			'rctype' => 'new|edit',
			'rctoponly' => 1,
			'rcnamespace' => 0,
			'rclimit' => self::NUM_ARTICLES_SHOWN,
		];

		$resp = \ApiService::foreignCall( $dbName, $params, \ApiService::API );
		if ( $resp == false || empty( $resp['query']['recentchanges'][0] ) ) {
			return [];
		}

		$articleIds = [];
		foreach ( $resp['query']['recentchanges'] as $change ) {
			$articleIds[] = $change['pageid'];
		}

		return $articleIds;
	}

	private function getRecentChangeInfo( $dbName, $articleIds ) {
		$params = array(
			'controller' => 'ArticleSummary',
			'method' => 'blurb',
			'ids' => implode( ',', $articleIds ),
		);

		$response = \ApiService::foreignCall( $dbName, $params, \ApiService::WIKIA );
		if ( empty( $response['summary'] ) ) {
			return [];
		}

		$recentChanges = [];
		foreach ( $response[ 'summary' ] as $id => $info ) {
			if ( !array_key_exists( 'error', $info ) ) {
				if ( empty( $info['imageUrl'] ) ) {
					$info['imageUrl'] = wfBlankImgUrl();
					$info['noImage'] = true;
				}
				$recentChanges[] = $info;
			}
		}

		return $recentChanges;
	}
}
