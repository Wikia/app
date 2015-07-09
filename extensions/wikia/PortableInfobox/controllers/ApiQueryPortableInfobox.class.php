<?php


class ApiQueryPortableInfobox extends ApiQueryBase {

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'ib' );
	}

	public function execute() {
		$this->runOnPageSet( $this->getPageSet() );
	}

	public function getVersion() {
		return __CLASS__ . '$Id$';
	}

	protected function runOnPageSet( ApiPageSet $pageSet ) {
		$articles = array_map( function ( Title $item ) {
			return Article::newFromTitle( $item, RequestContext::getMain() );
		}, $pageSet->getGoodTitles() );
		/**
		 * @var Article $article
		 */
		foreach ( $articles as $id => $article ) {
			$d = $article->getParserOutput()->getProperty( PortableInfoboxDataService::INFOBOXES_PROPERTY_NAME );
			if ( is_array( $d ) ) {

				$inf = [ ];
				foreach ( array_keys( $d ) as $k => $v ) {
					$inf[ $k ] = [ ];
				}
				$pageSet->getResult()->setIndexedTagName( $inf, 'infobox' );
				$pageSet->getResult()->addValue( [ 'query', 'pages', $id ], 'infoboxes', $inf );
				foreach ( $d as $count => $infobox ) {
					$s = isset( $infobox[ 'sources' ] ) ? $infobox[ 'sources' ] : [ ];
					$pageSet->getResult()->addValue( [ 'query', 'pages', $id, 'infoboxes', $count ], 'id', $count );
					$pageSet->getResult()->setIndexedTagName( $s, "source" );
					$pageSet->getResult()->addValue( [ 'query', 'pages', $id, 'infoboxes', $count ], 'sources', $s );
				}
			}
		}
	}
}
