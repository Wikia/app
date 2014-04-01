<?

class ThumbnailVideoHooks {

	/**
	 * @param OutputPage $out
	 * @param $skin
	 * @return bool
	 */
	static public function onBeforePageDisplay( $out, $skin ) {
		wfProfileIn(__METHOD__);

		if ( F::app()->checkSkin( 'monobook', $skin ) ) {
			// not used on mobileskin
			// part of oasis skin so not needed there
			$out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'skins/oasis/css/core/video-thumbnail.scss' ) );
		}

		wfProfileOut(__METHOD__);
		return true;
	}

}
