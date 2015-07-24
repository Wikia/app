<?php

namespace UserActivity;

use Wikia\Logger\WikiaLogger;

class Controller extends \WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

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

		$contribs = new \LookupContribsCore( $user->getName() );
		if ( !$contribs->checkUser() ) {
			$this->response->setData( $result );
			return;
		}

		$contribs->setLimit( $limit );
		$contribs->setOffset( $offset );

		$activity = $contribs->checkUserActivity( $addEditCount = true, $order );

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
			$lastEditTS = wfTimestamp( TS_MW, $contribItem[ 'last_edit' ] );
			$localizedDate = \F::app()->wg->Lang->timeanddate( $lastEditTS, $localTZ = true );
			$contribItem['lastEdit'] = $localizedDate;
			unset($contribItem['last_edit']);

			$editCount = $contribItem['editcount'];
			$editString = wfMessage( 'user-activity-edit-count', $editCount )->text();
			$contribItem['editString'] = $editString;
			$contribItem['editCount'] = $editCount;
			unset($contribItem['editcount']);

			$contribItem['wordmarkData'] = $this->getWordmark( $contribItem['dbname'] );

			$flattened[] = $contribItem;
		}

		return $flattened;
	}


	private function getWordmark( $dbName ) {
		$params = [
			'controller' => 'WikiHeader',
			'method' => 'Wordmark',
		];

		$resp = \ApiService::foreignCall( $dbName, $params, \ApiService::WIKIA );

		if ( $resp === false ) {
			return [];
		} else {
			$host = \WikiFactory::getHostByDbName( $dbName );

			$wm = [
				'isText' => $resp['wordmarkType'] == 'text',
				'isGraphic' => $resp['wordmarkType'] != 'text',
				'text' => $resp['wordmarkText'],
				'textSize' => $resp['wordmarkSize'],
				'textFont' => $resp['wordmarkFontClass'],
				'wikiaUrl' => 'http://'.$host.$resp['mainPageURL'],
				'imageUrl' => $resp['wordmarkUrl'],
				'imageStyle' => $resp['wordmarkStyle'],
			];

			return $wm;
		}
	}
}
