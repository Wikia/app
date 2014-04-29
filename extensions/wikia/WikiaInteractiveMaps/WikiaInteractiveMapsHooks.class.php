<?php
class WikiaInteractiveMapsHooks {

	/**
	 * @desc Adds the JS asset to the bottom scripts
	 *
	 * @param $skin
	 * @param String $text
	 *
	 * @return bool
	 */
	public static function onSkinAfterBottomScripts( $skin, &$text ) {
		global $wgEnableWikiaInteractiveMaps, $wgExtensionsPath;

		if( !empty( $wgEnableWikiaInteractiveMaps ) ) {
			$text .= sprintf(
				'<script src="%s/%s"></script>',
				$wgExtensionsPath,
				'wikia/WikiaInteractiveMaps/js/WikiaInteractiveMaps.js'
			);
		}

		return true;
	}

}
