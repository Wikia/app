<?php

class solr2rss extends SpecialPage {

	public function __construct() {
		parent::__construct( 'solr2rss'  /*class*/, '' /*restriction*/, true);
	}

	public function execute() {
		global $wgRequest, $wgOut, $wgSolrHost, $wgSolrPort, $wgEnableWikiaSearchExt;

		if (empty($wgEnableWikiaSearchExt)) {
			$wgOut->addHTML( "ERROR: WikiaSearch extension is disabled" );
			return;
		}

		$params = array();

		$query = $wgRequest->getVal('q');
		$sort = $wgRequest->getVal('sort');

		$params['sort'] = !empty($sort) ? $sort : 'created desc';
		$params['fl'] = 'title,url,html,created';

		$lang = $wgRequest->getVal('uselang');
		if(!empty($lang) && !empty($query)) {
			$query .= ' AND lang:' . strtolower($lang);
		}

		$excludeWikis = $wgRequest->getVal('exclude');
		if(!empty($excludeWikis)) {
			$excludeWikis = explode( ',', $excludeWikis);
			foreach($excludeWikis as $wikiDomain) {
				$wikiId = WikiFactory::DomainToID( $wikiDomain );
				if(!empty($query) && !empty($wikiId)) {
					$query .= ' AND !wid:' . $wikiId;
				}
			}
		}

		$limit = $wgRequest->getVal('rows');
		$limit = ( empty($limit) || ( $limit > 100 ) ) ? 15 : $limit;

		if(!empty($query)) {
			$solr = new Apache_Solr_Service($wgSolrHost, $wgSolrPort, '/solr');
			try {
				$response = $solr->search( $query, 0, $limit, $params );
			}
			catch (Exception $exception) {
				$wgOut->addHTML( 'ERROR: ' . $exception->getMessage() );
			}

			// render template
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates' );
			$oTmpl->set_vars(
				array(
					'url' => $wgRequest->getFullRequestURL(),
					'docs' => $response->response->docs,
					'dateFormat' => 'D, d M Y H:i:s O'
				));

			$wgRequest->response()->header('Cache-Control: max-age=60');
			$wgRequest->response()->header('Content-Type: text/xml');

			echo $oTmpl->execute( 'results' );
			exit;
		}
	}
}