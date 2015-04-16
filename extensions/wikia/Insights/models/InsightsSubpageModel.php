<?php

/**
 * Class QueryPagesModel
 *
 * Model for pages which extends QueryPage
 */
abstract class InsightsSubpageModel extends InsightsModel {
	private $queryPageInstance;

	abstract function getDataProvider();
	abstract function prepareData( $res );

	public function __construct() {
		$this->queryPageInstance = $this->getDataProvider();
//		parent::__construct( $wikiId );
	}

	/**
	 * Get list of article
	 *
	 * @param int $limit
	 * @return array
	 */
	public function getList( $offset = 0, $limit = 100 ) {
		$data = [];

		$res = $this->queryPageInstance->doQuery( $offset, $limit );
		if ( $res->numRows() > 0 ) {
			$data = $this->prepareData( $res );
			// TODO: initial work for fetching page views
			//$articleIds = array_keys( $data );
			//$this->getArticlesPageviews( $articleIds, $this->wikiId );
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
} 
