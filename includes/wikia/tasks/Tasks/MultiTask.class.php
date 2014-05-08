<?php
/**
 * MultiTask
 *
 * dummy math class for testing puposes
 *
 * @author Piotr Molski <moli@wikia-inc.com>
 */

namespace Wikia\Tasks\Tasks;


class MultiTask extends BaseTask {
	private $params = [];
	private $allowed_params = [ 'm', 'b', 'a', 'no-rc', 'newonly' ];
	/**
	 * add two numbers together
	 *
	 * @param int $uid - User ID
	 * @param int $page - PageIdentifier
	 * @param string $text - Text to add to comtent
	 * @param string $summary - Summary of edit
	 * @param string $wikis - Comma separated list of Wikis
	 * @param string $params - Comma separated list of edit params( m: minor edit, b: bot (hidden) edit, a: enable autosummary, no-rc: do not show the change in recent changes, newonly: skip existing articles)
	 * 
	 * @return double
	 */
	public function edit( $uid, $page = 0, $text = '', $summary = '', $wikis = '', $lang = null, $cat = null, $params = '' ) {
		$oUser = \User::newFromId( $uid );
		$task_wikis = [];
		 
		if ( $oUser instanceof \User ) {
			$oUser->load();
			$username = $oUser->getName();
		} else {
			$username = '';
		}

		if ( !empty( $username ) ) {
			throw new \Exception( 'Invalid task result: ' . __METHOD__ );
		}
		
		if ( !empty( $params ) ) {
			foreach ( explode( ',', $params ) as $param ) {
				$param = trim( $param );
				if ( in_array( $param, $this->allowed_params ) ) {
					$this->params[] = $param;
				}
			}
		}
		
		if ( !empty( $wikis ) ) {
			$task_wikis = explode( ",", $wikis );
		}
		
		$wikis_to_execute = $this->fetchWikis( $task_wikis, $lang, $cat );

		return $username;
	}
	
	private function fetchWikis( $wikis = [], $lang = null, $cat = null ) {
		global $wgExternalSharedDB ;
		$dbr = wfGetDB (DB_SLAVE, array(), $wgExternalSharedDB);

		$where = [ "city_public" => 1 ];
		$count = 0;
		
		# check conditions
		if ( !empty( $lang ) ) 
			$where[ 'city_lang' ] = $lang;
			
		if ( !empty( $cat ) )
			$where[ 'cat_id' ] = $cat;

		if ( !empty( $wikis ) && count( $wikis ) == 1 ) {
			$where[ 'city_list.city_id' ] = reset( $wikis );
			$wikis = [];
		}

		if ( empty( $wikis ) ) {
			$oRes = $dbr->select(
				[ "city_list", "city_cat_mapping" ],
				[ "city_list.city_id, city_dbname, city_url, '' as city_server', '' as city_script" ], 
				array( "city_list join city_cat_mapping on city_cat_mapping.city_id = city_list.city_id" ),
				array( "city_list.city_id, city_dbname, city_url, '' as city_server, '' as city_script" ),
				$where,
				__METHOD__
			);
		} else {
			$where[] = "city_list.city_id = city_domains.city_id";
			$where[] = " city_domain in ('" . implode("','", $wikis) . "') ";

			$oRes = $dbr->select(
				array( "city_list", "city_domains" ),
				array( "city_list.city_id, city_dbname, city_url, '' as city_server, '' as city_script" ),
				$where,
				__METHOD__
			);
		}

		$wiki_array = array();
		while ($oRow = $dbr->fetchObject($oRes)) {
			$oRow->city_server = WikiFactory::getVarValueByName( "wgServer", $oRow->city_id );
			$oRow->city_script = WikiFactory::getVarValueByName( "wgScript", $oRow->city_id );
			array_push($wiki_array, $oRow) ;
		}
		$dbr->freeResult ($oRes) ;

		return $wiki_array;
	}

}
