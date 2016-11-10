<?php

use Wikia\PortableInfobox\Parser\Nodes\NodeFactory;
use Wikia\PortableInfobox\Parser\Nodes\NodeInfobox;

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class ThemingCheck extends Maintenance {

	const ARTICLES_LIMIT = 500;
	const PURGE_CHUNK = 50;

	public function execute() {
		$dbr = wfGetDB( DB_SLAVE );
		$result = ( new WikiaSQL() )
			->SELECT( 'qc_value', 'qc_namespace', 'qc_title' )
			->FROM( 'querycache' )
			->WHERE( 'qc_type' )->EQUAL_TO( AllinfoboxesQueryPage::ALL_INFOBOXES_TYPE )
			->run( $dbr, function ( ResultWrapper $result ) {
				$out = [ ];
				while ( $row = $result->fetchRow() ) {
					$out[] = [ 'pageid' => $row[ 'qc_value' ],
						'title' => $row[ 'qc_title' ]
					];
				}

				return $out;
			} );
		$theming = array_map( function ( $infobox ) {
			$markups = PortableInfoboxDataService::newFromPageID( $infobox[ 'pageid' ] )
				->getInfoboxes();
			foreach ( $markups as $markup ) {
				$infoboxNode = NodeFactory::newFromXML( $markup );
				if ( $infoboxNode instanceof NodeInfobox ) {
					$attributes = $infoboxNode->getParams();

					return array_merge( $infobox, [
						't' => isset( $attributes[ 'theme' ] ) ?
							count( explode( " ", trim( $attributes[ 'theme' ] ) ) ) : 0,
						'theme' => $attributes[ 'theme' ] ?? "",
						's' => isset( $attributes[ 'theme-source' ] ) ?
							count( explode( " ", trim( $attributes[ 'theme-source' ] ) ) ) : 0,
						'theme-source' => $attributes[ 'theme-source' ] ?? ""
					] );
				}
			}
		}, $result );

		$output = array_filter( $theming, function ( $data ) {
			return $data[ 't' ] > 0 && $data[ 's' ] > 0;
		} );

		global $wgCityId;
		if ( !empty( $output ) ) {
			foreach ( $output as $data ) {
				$this->output( $wgCityId . ":" . $data[ 'title' ] . " uses themes "
					. "with [theme] = " . $data[ 'theme' ] . " and [theme-source] = "
					. $data[ 'theme-source' ] ."\n" );
			}
		}
	}
}

$maintClass = "ThemingCheck";
require_once( RUN_MAINTENANCE_IF_MAIN );
