<?php

class solr2rss extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct( 'solr2rss'  /*class*/, '' /*restriction*/, true);
	}

	public function execute() {
		global $wgRequest, $wgOut, $wgEnableWikiaSearchExt, $wgContLang;

		if (empty($wgEnableWikiaSearchExt)) {
			$wgOut->addHTML( "ERROR: WikiaSearch extension is disabled" );
			return;
		}
		
		$searchConfig = new Wikia\Search\Config();

		$lang = $wgRequest->getVal( 'uselang', $wgContLang->mCode );
		
		$fields = array(
				Wikia\Search\Utilities::field( 'title',	$lang ),
				Wikia\Search\Utilities::field( 'url',		$lang ),
				Wikia\Search\Utilities::field( 'html',		$lang ),
				Wikia\Search\Utilities::field( 'created',	$lang ),
				);
		
		$query = $wgRequest->getVal('q');
		$params['fl'] = 'title,url,html,created';

		$lang = $wgRequest->getVal('uselang');
		if(!empty($lang) && !empty($query)) {
			$query .= ' AND lang:' . strtolower($lang);
		}

		$excludeWikis = $wgRequest->getVal('exclude');
		if(!empty($excludeWikis) && !empty($query)) {
			$excludeWikis = explode( ',', $excludeWikis);
			foreach($excludeWikis as $wikiDomain) {
				$wikiId = WikiFactory::DomainToID( $wikiDomain );
				if(!empty($wikiId)) {
					$query .= ' AND !wid:' . $wikiId;
				}
			}
		}

		$namespaces = $wgRequest->getVal('ns');
		if(!empty($namespaces) && !empty($query)) {
			$namespaces = explode(',', $namespaces);
			$nsQuery = '';
			foreach($namespaces as $ns) {
				$nsQuery .= ( !empty($nsQuery) ? ' OR ' : '' ) . 'ns:' . $ns;
			}
			$query .= " AND ($nsQuery)";
		}
		
		$rows = $wgRequest->getVal( 'rows' );
		$rows = ( empty( $rows ) || ( $rows > 100 ) ) ? 15 : $rows;
		$searchConfig->setSort				( $wgRequest->getVal( 'sort', 'created desc' ) )
					 ->setRequestedFields	( $fields )
					 ->setQuery				( $query )
					 ->setLength			( $rows )
					 ->setDirectLuceneQuery ( true )
		;

		if( !empty( $query ) ) {
			$container = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $searchConfig ) );
			$wikiaSearch = Wikia\Search\QueryService\Factory::getInstance()->get( $container );
			try {
				$resultSet = $wikiaSearch->search();
			}
			catch (Exception $exception) {
				$wgOut->addHTML( 'ERROR: ' . $exception->getMessage() );
			}

			// render template
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates' );
			$oTmpl->set_vars(
				array(
					'url' => $wgRequest->getFullRequestURL(),
					'docs' => $resultSet->toNestedArray( $fields ),
					'dateFormat' => 'D, d M Y H:i:s O',
					'lang'	=> $lang
				));

			$wgRequest->response()->header('Cache-Control: max-age=60');
			$wgRequest->response()->header('Content-Type: application/xml');

			echo $oTmpl->render( 'results' );
			exit;
		}
	}
}
