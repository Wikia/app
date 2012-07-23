<?php

/**
 * MediaTool Helper
 * @author mech
 */
class MediaToolHelper extends WikiaModel {

	public function secToMMSS($seconds) {
		$min = floor($seconds / 60);
		$sec = $seconds - ($min * 60);

		return ( $min . ':' . (( strlen($sec) < 2 ) ? '0' : '') . $sec );
	}

	public function getFileFromUrl( $url ) {
		wfProfileIn( __METHOD__ );

		$file = null;
		$pattern = '/(' . implode( '|', $this->getNSCanonicalNames() ) . ')(.+)$/';

		if(preg_match($pattern, $url, $matches)) {
			$file = wfFindFile( $matches[2] );

			if ( !$file ) { // bugID: 26721
				$file = wfFindFile( urldecode($matches[2]) );
			}
		}

		wfProfileOut( __METHOD__ );
		return $file;
	}

	/*
	public function isWikiaUrl( $url ) {
		if(  endsWith($url, "wikia.com") || endsWith($url, "wikia-inc.com") ) {
			return true;
		}

		// local links
		foreach( $this->getNSCanonicalNames() as $nsName ) {
			if( startsWith(ucfirst($url), $nsName) ) {
				return true;
			}
		}

		return false;
	}
	*/

	private function getNSCanonicalNames() {
		$names = array();

		$names[] = MWNamespace::getCanonicalName( NS_FILE ) . ":";
		$names[] = $this->wg->contLang->getNsText( NS_FILE ) . ":";

		return $names;
	}

}