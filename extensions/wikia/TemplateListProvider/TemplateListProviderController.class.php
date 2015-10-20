<?php

class TemplateListProviderController extends WikiaController {
	const CACHE_TTL = 86400;
	const WIKIS_MCACHE_KEY = 'top-wikis-list';

	/**
	 * @desc get top wikis according to WAM ranking
	 * @return Mixed|null
	 */
	public function getTopWikis( $limit = 100 ) {
		$data = WikiaDataAccess::cache( wfMemcKey( self::WIKIS_MCACHE_KEY ), self::CACHE_TTL, function () use ( $limit ) {
			$dbr = $this->getDB();
			return ( new WikiaSQL() )
				->SELECT( 'wam', 'wiki_id' )
				->FROM( 'fact_wam_scores' )
				->GROUP_BY( 'wiki_id' )
				->ORDER_BY( 'wam' )->DESC()
				->LIMIT( $limit )
				->run( $dbr, function ( ResultWrapper $result ) {
					$out = [ ];
					while ( $row = $result->fetchRow() ) {
						$out[] = [
							'wam' => $row[ 'wam' ],
							'wiki_id' => $row[ 'wiki_id' ]
						];
					}

					return $out;
				} );
		} );

		return $data;
	}

	protected function getDB() {
		$app = F::app();

		wfGetLB( $app->wg->DatamartDB )->allowLagged(true);
		$db = wfGetDB( DB_SLAVE, array(), $app->wg->DatamartDB );
		$db->clearFlag( DBO_TRX );
		return $db;
	}
}
