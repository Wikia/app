<?php

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class PurgeInfoboxes extends Maintenance {

	const ARTICLES_LIMIT = 500;
	const PURGE_CHUNK = 50;

	public function execute() {
		$templates = ( new WikiaSQL() )
			->SELECT( 'qc_title' )
			->FROM( 'querycache' )
			->WHERE( 'qc_type' )->EQUAL_TO( AllinfoboxesQueryPage::ALL_INFOBOXES_TYPE )
			->run( $this->getDB( DB_SLAVE ), function ( ResultWrapper $result ) {
				$out = [ ];
				while ( $row = $result->fetchRow() ) {
					$title = Title::newFromText( $row[ 'qc_title' ], NS_TEMPLATE );
					if ( $title && $title->exists() ) {
						$out[] = $title->getFullText();
					}
				}

				return $out;
			} );

		foreach ( $templates as $template ) {
			$articles = array_chunk( $this->getTemplateUsage( $template ), self::PURGE_CHUNK );
			foreach ( $articles as $slice ) {
				$this->purgeArticles( $slice );
			}
		}
	}

	private function getTemplateUsage( $template, $continue = null ) {
		$params = [ 'action' => 'query',
					'list' => 'embeddedin',
					'eititle' => $template,
					'eilimit' => self::ARTICLES_LIMIT ];
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
		$api = new ApiMain( new FauxRequest( $params ), true );
		$api->execute();

		return $api->getResult()->getResultData();
	}


}

$maintClass = "PurgeInfoboxes";
require_once( RUN_MAINTENANCE_IF_MAIN );
