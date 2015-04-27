<?php

/**
 * Class QueryPagesModel
 *
 * Model for pages which extends QueryPage
 */
abstract class InsightsQuerypageModel extends InsightsModel {
	private $queryPageInstance,
		$template = 'subpageList';

	public
		$offset = 0,
		$limit = 100;

	abstract function getDataProvider();
	abstract function isItemFixed( Title $title );

	protected function getQueryPageInstance() {
		return $this->queryPageInstance;
	}

	public function getTemplate() {
		return $this->template;
	}

	public function getData() {
		$data['offset'] = $this->offset;
		return $data;
	}

	/**
	 * Get list of article
	 *
	 * @return array
	 */
	public function getContent() {
		$this->queryPageInstance = $this->getDataProvider();

		$content = [];
		$res = $this->queryPageInstance->doQuery( $this->offset, $this->limit );
		if ( $res->numRows() > 0 ) {
			$content = $this->prepareData( $res );
		}
		return $content;
	}

	public function prepareData( $res ) {
		$data = [];
		$dbr = wfGetDB( DB_SLAVE );
		while ( $row = $dbr->fetchObject( $res ) ) {
			if ( $row->title ) {
				$article = [];
				$params = $this->getUrlParams();

				$title = Title::newFromText( $row->title );
				$article['link'] = InsightsHelper::getTitleLink( $title, $params );

				$lastRev = $title->getLatestRevID();
				$rev = Revision::newFromId( $lastRev );

				if ( $rev ) {
					$article['metadata']['lastRevision'] = $this->prepareRevisionData( $rev );
				}
				$data[] = $article;
			}
		}
		return $data;
	}

	/**
	 * Get data about revision
	 * Who and when made last edition
	 *
	 * @param Revision $rev
	 * @return mixed
	 */
	public function prepareRevisionData( Revision $rev ) {
		$data['timestamp'] = wfTimestamp( TS_UNIX, $rev->getTimestamp() );

		$user = $rev->getUserText();
		$userpage = Title::newFromText( $user, NS_USER )->getFullURL();

		$data['username'] = $user;
		$data['userpage'] = $userpage;

		return $data;
	}

	public function getUrlParams() {
		$params = array_merge(
			InsightsHelper::getEditUrlParams(),
			$this->getInsightParam()
		);

		return $params;
	}

	public function removeFixedItem( $type, Title $title ) {
		$dbr = wfGetDB( DB_MASTER );
		$dbr->delete( 'querycache', [ 'qc_type' => $type, 'qc_title' => $title->getDBkey() ] );
		return $dbr->affectedRows() > 0;
	}

	/**
	 * Get data about next element
	 *
	 * @param int $offset
	 * @return mixed
	 */
	public function getNextItem( $type, $articleName ) {
		$next = [];

		$dbr = wfGetDB( DB_SLAVE );
		$articleName = $dbr->strencode( $articleName );

		$res = $dbr->select(
			'querycache',
			'qc_title',
			[ 'qc_type' => ucfirst( $type ), "qc_title != '$articleName'" ],
			'DatabaseBase::select',
			[ 'LIMIT' => 1 ]
		);

		if ( $res->numRows() > 0 ) {
			$row = $dbr->fetchObject( $res );

			$title = Title::newFromText( $row->qc_title );
			$next['link'] = InsightsHelper::getTitleLink( $title, self::getUrlParams() );
		}

		return $next;
	}
} 
