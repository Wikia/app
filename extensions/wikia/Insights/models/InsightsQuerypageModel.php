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
	abstract function prepareData( $res );

	protected function getQueryPageInstance() {
		return $this->queryPageInstance;
	}

	public function getTemplate() {
		return $this->template;
	}

	public function getData() {
		$data['messageKeys'] = InsightsHelper::$insightsMessageKeys;
		$data['offset'] = $this->offset;
		return $data;
	}

	/**
	 * Get list of article
	 *
	 * @param int $limit
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
