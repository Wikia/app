<?php
class PortableInfoboxHooks {
	// FIX ME: temporary implementation - styles should be included only on page with portable infobox
	static public function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
		Wikia::addAssetsToOutput('portable_infobox_scss');
		return true;
	}
}
