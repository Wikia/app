<?php

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_NOTICE );

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class PurgeInfoboxes extends Maintenance {

	public function execute() {
		$templates = ( new WikiaSQL() )
			->SELECT( 'qc_title' )
			->FROM( 'querycache' )
			->WHERE( 'qc_type' )->EQUAL_TO( AllinfoboxesQueryPage::ALL_INFOBOXES_TYPE )
			->run( $this->getDB( DB_SLAVE ), function ( ResultWrapper $result ) {
				$out = [ ];
				while ( $row = $result->fetchRow() ) {
					$out[] = Title::newFromText( $row[ 'qc_title' ], NS_TEMPLATE )->getFullText();
				}

				return $out;
			} );

		foreach ( $templates as $template ) {
			$articles = array_chunk( $this->getTemplateUsage( $template ), 50 );
			foreach ( $articles as $slice ) {
				$this->purgeArticles( $slice );
			}
		}
	}

	private function getTemplateUsage( $template, $continue = null ) {
		$params = [ 'action' => 'query',
					'list' => 'embeddedin',
					'eititle' => $template,
					'eilimit' => 500 ];
		if ( isset( $continue ) ) {
			$params[ 'eicontinue' ] = $continue;
		}
		$data = $this->callApi( $params );

		$next = $data[ 'query-continue' ][ 'embeddedin' ][ 'eicontinue' ];
		$result = array_map( function ( $item ) {
			return $item[ 'pageid' ];
		}, $data[ 'query' ][ 'embeddedin' ] );

		if ( isset( $next ) ) {
			return array_merge( $result, $this->getTemplateUsage( $template, $next ) );
		}

		return $result;
	}

	private function purgeArticles( $slice ) {
		$params = [ 'action' => 'purge',
					'pageids' => implode( '|', $slice ),
					'forcelinkupdate' => true ];

		$data = array_map( function ( $purged ) {
			return $purged[ 'title' ];
		}, $this->callApi( $params )[ 'purge' ] );
		$this->output( implode( ', ', $data ) );
	}

	/**
	 * @param $params
	 *
	 * @return ApiMain
	 */
	private function callApi( $params ) {
		$request = new FauxRequest( $params );
		$api = new ApiMain( $request, true );
		$api->execute();

		return $api->getResult()->getResultData();
	}


}

$maintClass = "PurgeInfoboxes";
require_once( RUN_MAINTENANCE_IF_MAIN );
