<?php
class WikiaInteractiveMapsHooks {

	public static function onSkinAfterBottomScripts( $skin, &$text ) {
		global $wgEnableWikiaInteractiveMaps, $wgExtensionsPath;

		if( !empty( $wgEnableWikiaInteractiveMaps ) ) {
			$text .= '<script src="' . $wgExtensionsPath . '/wikia/WikiaInteractiveMaps/js/WikiaInteractiveMaps.js" />';
		}

		return true;
	}

}
