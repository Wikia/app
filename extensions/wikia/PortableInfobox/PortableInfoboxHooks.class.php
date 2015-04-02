<?php
class PortableInfoboxHooks {
	// FIX ME: temporary implementation - styles should be included only on page with portable infobox
	static public function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
		if ( F::app()->checkSkin( 'oasis', $skin ) ) {
			$out->addStyle(AssetsManager::getInstance()->getSassCommonURL(
				'extensions/wikia/PortableInfobox/styles/PortableInfobox.scss'));
		}

		return true;
	}
}
