<?php

class TemplateListProviderController extends WikiaController {
	//const CACHE_TTL = 86400;
	const CACHE_TTL = 1;
	const WIKIS_MCACHE_KEY = 'top-wikis-list';
	const TEMPLATES_MCACHE_KEY = 'top-wikis-template-list';

	public function getTemplateList() {
		$topWikis = $this->getTopWikis();
		$templates = [];

		foreach ($topWikis as $wiki) {
			$templates[] = $this->getTemplatesFromWiki( $wiki['wiki_id'] );
		}
	}

	protected function getTopWikis( ) {

		$data = WikiaDataAccess::cache( wfMemcKey( self::WIKIS_MCACHE_KEY ), self::CACHE_TTL, function () {
			$dbr = $this->getDB();

			return ( new WikiaSQL() )
				->SELECT( 'wam', 'wiki_id' )
				->FROM( 'fact_wam_scores' )
				->GROUP_BY( 'wiki_id' )
				->ORDER_BY( 'wam' )->DESC()
				->LIMIT( 10 )
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

		var_dump($data);

		return $data;
	}

	protected function getTemplatesFromWiki( $wikiId ) {

		$data = WikiaDataAccess::cache( wfMemcKey( self::TEMPLATES_MCACHE_KEY ), self::CACHE_TTL, function () use( $wikiId ) {
			$dbr = wfGetDB( DB_SLAVE, [], $wikiId );
			return ( new WikiaSQL() )
				->SELECT( 'tl_namespace AS namespace', 'tl_title AS title', 'COUNT(*) AS value' )
				->FROM( 'templatelinks' )
				->WHERE('tl_namespace')->EQUAL_TO( NS_TEMPLATE )
				//where count(*) > 0
				->GROUP_BY( 'tl_namespace', 'tl_title' )
				->ORDER_BY( 'COUNT(*)' )->DESC()
				->run( $dbr, function ( ResultWrapper $result ) {
					$out = [ ];
					while ( $row = $result->fetchRow() ) {
						$out[] = [
							'tl_namespace' => $row[ 'tl_namespace' ],
							'tl_title' => $row[ 'tl_title' ],
							'COUNT(*)' => $row[ 'COUNT(*)' ]
						];
					}

					return $out;
				} );
		} );

		var_dump($data);

		return $data;
	}

	protected function getDB( $wikiId = null ) {
		$app = F::app();
		if ( empty( $wikiId) ) {
			$wikiId = $app->wg->DatamartDB;
		}

		var_dump($wikiId);

		wfGetLB( $wikiId )->allowLagged(true);
		$db = wfGetDB( DB_SLAVE, array(), $wikiId );
		$db->clearFlag( DBO_TRX );
		return $db;
	}
}