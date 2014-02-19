<?php

/**
 * Lightbox Helper
 * @author Saipetch Kongkatong
 */
class LightboxHelper extends WikiaModel {

	public function getRemoteUrl( $fileTitle ) {
		$wikiId = WikiFactory::DBtoID( $this->wg->WikiaVideoRepoDBName );
		$globalTitle = GlobalTitle::newFromText( $fileTitle, NS_FILE, $wikiId );
		$remoteUrl = $globalTitle->getFullURL();

		return $remoteUrl;
	}

}
