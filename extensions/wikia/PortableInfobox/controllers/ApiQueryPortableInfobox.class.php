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
		$articles = $pageSet->getGoodTitles();

		foreach ( $articles as $id => $articleTitle ) {
			$parsedInfoboxes = PortableInfoboxDataService::newFromTitle( $articleTitle )->getData();

			if ( is_array( $parsedInfoboxes ) && count( $parsedInfoboxes ) ) {
				$inf = [ ];
				foreach ( array_keys( $parsedInfoboxes ) as $k => $v ) {
					$inf[ $k ] = [ ];
				}
				$pageSet->getResult()->setIndexedTagName( $inf, 'infobox' );
				$pageSet->getResult()->addValue( [ 'query', 'pages', $id ], 'infoboxes', $inf );
				foreach ( $parsedInfoboxes as $count => $infobox ) {
					$sl = isset( $infobox[ 'sourcelabels' ] ) ? $infobox[ 'sourcelabels' ] : [ ];
					$pageSet->getResult()->addValue( [ 'query', 'pages', $id, 'infoboxes', $count ], 'id', $count );
					$pageSet->getResult()->setIndexedTagName( $l, "sourcelabels" );
					$pageSet->getResult()->addValue(
						[ 'query', 'pages', $id, 'infoboxes', $count ], 'sourcelabels', $sl
					);
				}
			}
		}
	}
}
