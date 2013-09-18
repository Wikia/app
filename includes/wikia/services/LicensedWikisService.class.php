<?php

class LicensedWikisService extends WikiaModel {

	const LICENSE_WIKI_FACTORY_VAR_ID = 253;


	public function getCommercialUseNotAllowedWikis() {

		//WikiFactory::getListOfWikisWithVar( self::LICENSE_WIKI_FACTORY_VAR_ID, "string" );

	}

	public function isCommercialUseAllowedById( $wikiId ) {

		if ( $wikiId == 3125 ) {
			return false;
		}
		return true;
	}

	public function isCommercialUseAllowedByHostName( $hostName ) {

	}

}