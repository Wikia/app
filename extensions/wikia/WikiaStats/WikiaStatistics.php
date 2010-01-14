<?php

/**
 * @package MediaWiki
 * @author Piotr Molski <moli@wikia.com> for Wikia.com
 * @copyright (C) 2007, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id: Classes.php 6127 2007-10-11 11:10:32Z moli $
 */

class WikiaHubStats {
	const PV_MONTHS = 12;
	private 
		$mCityId,
		$mWFHub,
		$mName;
	
	/**
	 * initialization
	 * 
	 * @access public
	 *
	 * @param String or Integer $cat,
	 */
	function __construct( $cityId, $hubName = null ) {
		$this->mCityId = $cityId;
		$this->mWFHub = WikiFactoryHub::getInstance();
		$this->mName = $hubName;
		if ( empty($this->mName) ) {
			$this->mName = $this->mWFHub->getCategoryName($this->mCityId);
		} 
	}
	
	/**
	 * newFromId 
	 * 
	 * @access public
	 *
	 * @param Integer $catid 
	 */
	public function newFromId( $cityId ) {
		return new WikiaHubStats($cityId);
	}

	/**
	 * newFromHub
	 * 
	 * @access public
	 *
	 * @param String $hubName
	 */
	public function newFromHub( $hubName ) {
		global $wgCityId;
		return new WikiaHubStats($cityId, $hubName);
	}

	/**
	 * getTopPVWikis 
	 * 
	 * @access public
	 *
	 * @param Array $data - list of Top Wikis (by PV) in hub
	 */
	public function getTopPVWikis( $limit = 20 ) {
		global $wgMemc, $wgExternalStatsDB;
		wfProfileIn( __METHOD__ );
		
		$data = array();
		$cities = $this->getCities();
		
		if ( is_array($cities) && !empty($cities) ) {
			$memkey = wfMemcKey( __METHOD__, $this->mName, $limit );
			$data = $wgMemc->get( $memkey );
			
			if ( empty($data) ) {
				$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalStatsDB );
				$oRes = $dbr->select(
					array( 'city_page_views' ),
					array( 'pv_city_id, sum(pv_views) as views' ),
					array(
						sprintf( ' pv_use_date >= last_day(now() - interval %d day) ', self::PV_MONTHS * 30 ),
						'pv_namespace' => 0,
						' pv_city_id in (' . $dbr->makeList($cities) . ') '
					),
					__METHOD__,
					array(
						'GROUP BY' => 'pv_city_id'
					)
				);

				$order = $data = array(); 
				while ( $oRow = $dbr->fetchObject( $oRes ) ) {
					$order[$oRow->pv_city_id] = $oRow->views;
				}
				$dbr->freeResult( $oRes );

				if ( !empty($order) ) {
					arsort($order);
					$loop = 0; foreach ( $order as $city_id => $views ) {
						if ( $loop > $limit ) break;
						$domain = WikiFactory::getVarValueByName( "wgServer", $city_id );
						if ( $domain ) {
							$data[$city_id] = array('url' => $domain, 'count' => $views);
							$loop++;
						}
					}
					$wgMemc->set( $memkey, $data, 60*60 );
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $data;
	}
	
	/**
	 * getCities
	 * 
	 * @access private
	 *
	 * @param Array $data - list of Wikis in hub
	 */
	private function getCities() {
    	global $wgExternalSharedDB, $wgMemc;

		$memkey = wfMemcKey( __METHOD__, $this->mName );
		$data = $wgMemc->get( $memkey );
		if ( empty($data) ) {
			$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
			
			$oRes = $dbr->select(
				array( "city_cats_view" ),
				array( "cc_city_id" ),
				array( "cc_name" => $this->mName ),
				__METHOD__
			);
			$data = array(); while ( $oRow = $dbr->fetchObject( $oRes ) ) {
				$data[] = $oRow->cc_city_id;
			}
			$dbr->freeResult( $oRes );
			$wgMemc->set( $memkey , $data, 60*60*24 );
		}

		wfProfileOut( __METHOD__ );
		return $data;
	}
}
