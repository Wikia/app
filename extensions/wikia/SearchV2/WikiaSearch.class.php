<?php

class WikiaSearch extends WikiaObject {

	const RESULTS_PER_PAGE = 10;

	/**
	 * Search client
	 * @var WikiaSearchClient
	 */
	protected $client = null;

	public function __construct( WikiaSearchClient $client ) {
		$this->client = $client;
		parent::__construct();
	}

	public function doSearch( $query, $start = 0, $length = null ) {
		$results = $this->client->search( $query, $start, ( !empty($length) ? $length : self::RESULTS_PER_PAGE ) );
		return $results;
	}

	public function setClient( WikiaSearchClient $client ) {
		$this->client = $client;
	}

	public function getPage( $pageId, $withMetaData = true ) {
		$result = array();

		$page = Article::newFromID( $pageId );

		// hack: setting wgTitle as rendering fails otherwise
		$wgTitle = $this->wg->Title;
		$this->wg->Title = $page->getTitle();

		// hack: setting action=render to exclude "Related Pages" and other unwanted stuff
		$wgRequest = $this->wg->Request;
		$this->wg->Request->setVal('action', 'render');

		$page->render();

		$result['title'] = $page->getTitle()->getText();
		$result['text'] = $this->wg->Out->getHTML();
		$result['url'] = $page->getTitle()->getFullUrl();

		if( $withMetaData ) {
			$result = array_merge( $result, $this->getPageMetaData( $pageId ) );
		}

		// restore global state
		$this->wg->Title = $wgTitle;
		$this->wg->Request = $wgRequest;

		return $result;
	}

	public function getPageMetaData( $pageId ) {
		$result = array();

		$result['backlinks'] = 0;

		return $result;
	}

}