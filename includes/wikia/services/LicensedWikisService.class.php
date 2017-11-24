<?php

class LicensedWikisService extends WikiaModel {

	const LICENSE_WIKI_FACTORY_VAR_ID = 253; /* wgRightsText */
	const CACHE_KEY_COMMERCIAL_NOT_ALLOWED = 'commercial_use_not_allowed_wiki_list';
	const CACHE_VALID_TIME = 86400;

	protected static $wikiList = null;

	/*
	 * Assuming that if wgRightsText is set, wiki has some commercial restrictions
	 * @return Array wiki list [ ["id", "url", "host", "db" ], ... ]
	 */
	public function getCommercialUseNotAllowedWikis() {

		if ( empty( self::$wikiList ) ) {
			self::$wikiList = WikiaDataAccess::cache(
								wfSharedMemcKey( self::CACHE_KEY_COMMERCIAL_NOT_ALLOWED ),
								self::CACHE_VALID_TIME,
								function() {
									return $this->getWikisWithVar();
								}
							);
		}
		return self::$wikiList;
	}

	protected function getWikisWithVar() {
		$wikiList = [];
		$list =  WikiFactory::getListOfWikisWithVar( self::LICENSE_WIKI_FACTORY_VAR_ID, "full", '', '' );
		foreach ( $list as $wikiId => $val ) {
			$wikiList[ $wikiId ] = array(
				"id" => $wikiId,
				"url" => $val['u'],
				"host" => parse_url( $val[ 'u' ] )[ 'host' ],
				"db" => $val['d']
			);
		}
		return $wikiList;
	}

	public function isCommercialUseAllowedById( $wikiId ) {
		$list = $this->getCommercialUseNotAllowedWikis();
		if ( isset( $list[ $wikiId ]) ) {
			return false;
		}

		return true;
	}

	public function isCommercialUseAllowedForThisWiki() {
		return $this->isCommercialUseAllowedById( $this->wg->cityId );
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

	public function isCommercialUseAllowedByUrl( $url ) {
		$urlStructure = parse_url( $url );
		if ( !empty($urlStructure) && !empty( $urlStructure['host'] ) ) {
			return $this->isCommercialUseAllowedByHostName( $urlStructure['host'] );
		}
		return true;
	}
}
