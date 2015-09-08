<?php

class ApiQueryUnconvertedInfoboxes extends ApiQueryBase {

	const CACHE_TTL = 86400;
	const MCACHE_KEY = 'unconvertedinfoboxes-list';

	public function execute() {
		$data = WikiaDataAccess::cache( wfMemcKey( self::MCACHE_KEY ), self::CACHE_TTL, function () {
			$dbr = wfGetDB( DB_SLAVE );

			return ( new WikiaSQL() )
				->SELECT( 'qc_value', 'qc_namespace', 'qc_title' )
				->FROM( 'querycache' )
				->WHERE( 'qc_type' )->EQUAL_TO( UnconvertedInfoboxesPage::UNCONVERTED_INFOBOXES_TYPE )
				->run( $dbr, function ( ResultWrapper $result ) {
					$out = [ ];
					while ( $row = $result->fetchRow() ) {
						$out[] = [ 'pageid' => $row[ 'qc_value' ],
							'title' => $row[ 'qc_title' ],
							'ns' => $row[ 'qc_namespace' ] ];
					}

					return $out;
				} );
		} );

		foreach ( $data as $id => $infobox ) {
			$this->getResult()->addValue( [ 'query', 'unconvertedinfoboxes' ], null, $infobox );
		}
		$this->getResult()->setIndexedTagName_internal( [ 'query', 'unconvertedinfoboxes' ], 'i' );
	}

	public function getVersion() {
		return __CLASS__ . '$Id$';
	}
}
