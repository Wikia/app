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

	protected function getQueryPageInstance() {
		return $this->queryPageInstance;
	}

	public function getTemplate() {
		return $this->template;
	}

	public function getData() {
		$data['messageKeys'] = InsightsHelper::$insightsMessageKeys;
		$data['offset'] = $this->offset;
		$data['themeClass'] = SassUtil::isThemeDark() ? 'insights-dark' : 'insights-light';
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

	public function prepareData( $res ) {
		$data = [];
		$dbr = wfGetDB( DB_SLAVE );
		while ( $row = $dbr->fetchObject( $res ) ) {
			if ( $row->title ) {
				$article = [];
				$params = $this->getUrlParams();

				$title = Title::newFromText( $row->title );

				$article['linkToArticle'] = Linker::link(
					$title,
					null,
					[ 'class' => 'insights-list-item-title' ],
					$params
				);

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

	/**
	 * Get data about next element
	 *
	 * @param int $offset
	 * @return mixed
	 */
	public function getNext( $offset = 0 ) {
		$next = array_pop( $this->getContent( $offset, 1) );

		return $next;
	}

	public function getUrlParams() {
		$params = array_merge(
			InsightsHelper::getEditUrlParams(),
			$this->getInsightParam()
		);

		return $params;
	}
} 
