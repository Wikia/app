<?php

class QueryPagesModel {
	private $queryPageInstance;

	public function __construct( $className ) {
		if ( class_exists( $className ) ) {
			$this->queryPageInstance = new $className();
		}
	}

	public function getList( $limit = 100 ) {
		$data = [];

		$res = $this->queryPageInstance->fetchFromCache( $limit );
		if ( $res->numRows() > 0 ) {
			$data = $this->prepareData( $res );
		}

		return $data;
	}

	private function prepareData( $res ) {
		$data = [];
		$dbr = wfGetDB( DB_SLAVE );

		while ( $row = $dbr->fetchRow( $res ) ) {
			if ( $row['title'] ) {
				$article = [];
				$title = Title::newFromText( $row['title'] );

				$article['title'] = $title->getText();
				$article['link'] = $title->getFullURL();

				$lastRev = $title->getLatestRevID();
				$rev = Revision::newFromId( $lastRev );

				if ( $rev ) {
					$article['revision'] = $this->prepareRevisionData( $rev );
					$data[ $title->getArticleID() ] = $article;
				}
			}
		}

		return $data;
	}

	private function prepareRevisionData( Revision $rev ) {
		$data['timestamp'] = wfTimestamp(TS_UNIX, $rev->getTimestamp());

		$userId = $rev->getUser();
		$user = User::newFromId( $userId );

		$data['username'] = $user->getName();
		$data['userpage'] = $user->getUserPage()->getFullURL();

		return $data;
	}
} 
