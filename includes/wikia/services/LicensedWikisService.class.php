<?php

class LicensedWikisService extends WikiaModel {

	const LICENSE_WIKI_FACTORY_VAR_ID = 253; /* wgRightsText */
	const CACHE_KEY_COMMERCIAL_NOT_ALLOWED = 'commercial_use_not_allowed_wikis';
	const CACHE_VALID_TIME = 86400;

	protected static $wikiList = null;

	/*
	 * Assuming that if wgRightsText is set, wiki has some commercial restrictions
	 * @return Array wiki list [ ["id", "url", "host", "db" ], ... ]
	 */
	public function getCommercialUseNotAllowedWikis() {

		if ( empty( self::$wikiList ) ) {

			$varId = self::LICENSE_WIKI_FACTORY_VAR_ID;
			self::$wikiList = WikiaDataAccess::cache(
								wfSharedMemcKey( self::CACHE_KEY_COMMERCIAL_NOT_ALLOWED ),
								self::CACHE_VALID_TIME,
								function() use( $varId ) {
									$wikiList = [];
									$list =  WikiFactory::getListOfWikisWithVar( $varId, "full", '', '' );
									foreach ( $list as $wikiId => $val ) {
										$wikiList[ $wikiId ] = array(
											"id" => $wikiId,
											"url" => $val['u'],
											"host" => rtrim( ltrim( $val['u'], "http://" ), "/"),
											"db" => $val['d']
										);
									}
									return $wikiList;
								}
							);
		}
		return self::$wikiList;
	}

	public function isCommercialUseAllowedById( $wikiId ) {

		$list = $this->getCommercialUseNotAllowedWikis();
		if ( isset( $list[ $wikiId ]) ) {
			return false;
		}
		return true;
	}

	public function isCommercialUseAllowedByHostName( $hostName ) {

		$list = $this->getCommercialUseNotAllowedWikis();
		foreach ( $list as $wiki ) {
			if ( $wiki['host'] == $hostName ) {
				return false;
			}
		}
		return true;
	}

}