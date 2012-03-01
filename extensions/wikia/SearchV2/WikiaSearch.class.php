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

	public function doSearch( $query, $start = 0, $length = null, $cityId = 0, $rankExpr = '', $groupResults = false ) {
		$results = $this->client->search( $query, $start, ( !empty($length) ? $length : self::RESULTS_PER_PAGE ), $cityId, $rankExpr );
//var_dump($results);
//exit;

		if(empty($cityId) && $groupResults) {
			$results = $this->groupResults( $results );
		}

		return $results;
	}

	private function groupResults(stdClass $results) {
		$wikiResults = array();

		foreach( $results->hit as $hit) {
			if(!isset($wikiResults[$hit->data->cityid])) {
				$cityId = $hit->data->cityid;
				$cityTitle = WikiFactory::getVarValueByName( 'wgSitename', $cityId );
				$cityUrl = WikiFactory::getVarValueByName( 'wgServer', $cityId );
				$wikiResults[$cityId] = array(
					'cityId' => $cityId,
					'cityTitle' => !empty($cityTitle) ? $cityTitle : '?',
					'cityUrl' => !empty($cityUrl) ? $cityUrl : '#',
					'hits' => array()
				);
			}
			$wikiResults[$hit->data->cityid]['hits'][] = $hit;
		}
echo "<pre>";
var_dump($wikiResults);
exit;

		return $results;
	}

	private function groupWikiResults($wikiId, Array $resultsPerWiki) {
		return $resultsPerWiki;
	}

	public function setClient( WikiaSearchClient $client ) {
		$this->client = $client;
	}

	public function getPage( $pageId, $withMetaData = true ) {
		$result = array();

		$page = F::build( 'Article', array( $pageId ), 'newFromID' );

		if(!($page instanceof Article)) {
			throw new WikiaException('Invalid Article ID');
		}

		// hack: setting wgTitle as rendering fails otherwise
		$wgTitle = $this->wg->Title;
		$this->wg->Title = $page->getTitle();

		// hack: setting action=render to exclude "Related Pages" and other unwanted stuff
		$wgRequest = $this->wg->Request;
		$this->wg->Request->setVal('action', 'render');

		if( $page->isRedirect() ) {
			$redirectPage = F::build( 'Article', array( $page->getRedirectTarget() ) );
			$redirectPage->loadContent();

			// hack: setting wgTitle as rendering fails otherwise
			$this->wg->Title = $page->getRedirectTarget();

			$redirectPage->render();
			$canonical = $page->getRedirectTarget()->getPrefixedText();
		}
		else {
			$page->render();
			$canonical = '';
		}

		$result['sitename'] = $this->wg->Sitename;
		$result['title'] = $page->getTitle()->getText();
		$result['canonical'] = $canonical;
		$result['text'] = $this->wg->Out->getHTML();
		$result['url'] = $page->getTitle()->getFullUrl();
		$result['ns'] = $page->getTitle()->getNamespace();

		if( $withMetaData ) {
			$result['metadata'] = $this->getPageMetaData( $page );
		}

		// restore global state
		$this->wg->Title = $wgTitle;
		$this->wg->Request = $wgRequest;

		return $result;
	}

	public function getPageMetaData( $page ) {
		$result = array();

		$data = $this->callMediaWikiAPI( array(
			'titles' => $page->getTitle(),
			'bltitle' => $page->getTitle(),
			'action' => 'query',
			'list' => 'backlinks',
			'bllimit' => 600
		));

		if( is_array( $data['query']['backlinks'] ) ) {
			$result['backlinks'] = count( $data['query']['backlinks'] );
		}
		else {
			$result['backlinks'] = 0;
		}

		/*
		$data = $this->callMediaWikiAPI( array(
			'pageids' => $page->getId(),
			'action' => 'query',
			'prop' => 'info',
			'inprop' => 'url|created|views|revcount|redirect'
		));

		if( isset( $data['query']['pages'][$page->getId()] ) ) {
			$pageData = $data['query']['pages'][$page->getId()];
			$result['views'] = $pageData['views'];
			$result['revcount'] = $pageData['revcount'];
			$result['created'] = $pageData['created'];
			$result['touched'] = $pageData['touched'];
		}
		*/
		$result['views'] = 1;

		return $result;
	}

	private function callMediaWikiAPI( Array $params ) {
		$api = F::build( 'ApiMain', array( 'request' => new FauxRequest($params) ) );
		$api->execute();

		return  $api->getResultData();
	}

}