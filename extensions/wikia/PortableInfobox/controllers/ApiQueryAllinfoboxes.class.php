<?php

class ApiQueryAllinfoboxes extends ApiQueryBase {

	public function execute() {
		$data = WikiaDataAccess::cache( wfMemcKey( 'allinfoboxes-list' ), 3600, function () {
			$dbr = wfGetDB( DB_SLAVE );
			$result = ( new WikiaSQL() )
				->SELECT( 'page_id', 'page_title' )
				->FROM( 'page' )
				->WHERE( 'page_namespace' )->EQUAL_TO( NS_TEMPLATE )
				->AND_( 'page_is_redirect' )->EQUAL_TO( 0 )
				->run( $dbr, function ( ResultWrapper $result ) {
					$out = [ ];
					while ( $row = $result->fetchRow() ) {
						$out[] = [ 'pageid' => $row[ 'page_id' ], 'title' => $row[ 'page_title' ] ];
					}

					return $out;
				} );

			return array_filter( $result, function ( $tmpl ) {
				$data = PortableInfoboxDataService::newFromPageID( $tmpl[ 'pageid' ] )->getData();

				return !empty( $data );
			} );
		} );

		foreach ( $data as $id => $infobox ) {
			$this->getResult()->addValue( [ 'query', 'allinfoboxes' ], null, $infobox );
		}
		$this->getResult()->setIndexedTagName_internal( [ 'query', 'allinfoboxes' ], 'i' );
	}

	public function getVersion() {
		return __CLASS__ . '$Id$';
	}
}
