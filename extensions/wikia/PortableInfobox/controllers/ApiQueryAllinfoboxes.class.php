<?php

class ApiQueryAllinfoboxes extends ApiQueryBase {

	const CACHE_TTL = 86400;
	const MCACHE_KEY = 'allinfoboxes-list';

	public function execute() {
		$data = WikiaDataAccess::cache( wfMemcKey( self::MCACHE_KEY ), self::CACHE_TTL, function () {
			$dbr = wfGetDB( DB_SLAVE );

			return ( new WikiaSQL() )
				->SELECT( 'qc_value', 'qc_namespace', 'qc_title' )
				->FROM( 'querycache' )
				->WHERE( 'qc_type' )->EQUAL_TO( AllinfoboxesQueryPage::ALL_INFOBOXES_TYPE )
				->run( $dbr, function ( ResultWrapper $result ) {
					$out = [ ];
					while ( $row = $result->fetchRow() ) {
						$out[] = [ 'pageid' => $row[ 'qc_value' ],
							'title' => $row[ 'qc_title' ],
							'label' => $this->createLabel( $row[ 'qc_title' ] ),
							'ns' => $row[ 'qc_namespace' ] ];
					}

					return $out;
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

	/**
	 * @desc As a infobox template label we want to return a nice, clean text, without e.g. '_' signs
	 * @param $text infobox template title
	 * @return String
	 */
	private function createLabel( $text ) {
		$title = Title::newFromText( $text , NS_TEMPLATE );

		if ( $title ) {
			return $title->getText();
		}

		return $text;
	}
}
