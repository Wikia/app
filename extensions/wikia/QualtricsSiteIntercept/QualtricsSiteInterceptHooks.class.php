<?php

class QualtricsSiteInterceptHooks {
	/**
	 * Add Qualtrics assets on Oasis
	 *
	 * @param $assetsArray
	 *
	 * @return bool
	 */
	static public function onOasisSkinAssetGroups( array &$assetsArray ): bool {
		global $wgNoExternals;

		if ( empty( $wgNoExternals ) ) {
			$assetsArray[] = 'qualtrics_js';
		}

		return true;
	}
}
