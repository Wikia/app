<?php

class ApiQueryPagesWithoutInfobox extends ApiQueryBase {

	const CACHE_TTL = WikiaResponse::CACHE_STANDARD;
	const MCACHE_KEY = 'pageswithoutinfobox-list';
	const XML_TAG_NAME = 'page';

	public function execute() {
		$data = WikiaDataAccess::cache( wfMemcKey( self::MCACHE_KEY ), self::CACHE_TTL, function () {
			$dbr = wfGetDB( DB_SLAVE );

			return ( new WikiaSQL() )
				->SELECT( 'qc_value', 'qc_namespace', 'qc_title' )
				->FROM( 'querycache' )
				->WHERE( 'qc_type' )->EQUAL_TO( PagesWithoutInfobox::PAGES_WITHOUT_INFOBOX_TYPE )
				->run( $dbr, function ( ResultWrapper $result ) {
					$out = [ ];
					while ( $row = $result->fetchRow() ) {
						$out[] = [
							'pageid' => $row[ 'qc_value' ],
							'title' => $row[ 'qc_title' ],
							'ns' => $row[ 'qc_namespace' ]
						];
					}

					return $out;
				} );
		} );

		foreach ( $data as $page ) {
			$this->getResult()->addValue( [ 'query', 'pageswithoutinfobox' ], null, $page );
		}

		$this->getResult()->setIndexedTagName_internal( [ 'query', 'pageswithoutinfobox' ], self::XML_TAG_NAME );
	}

	public function getVersion() {
		return __CLASS__ . '$Id$';
	}
}
