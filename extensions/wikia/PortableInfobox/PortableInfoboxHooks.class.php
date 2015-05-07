<?php

class PortableInfoboxHooks {
	// TODO: Add to global css group on sitewide release
	static public function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
		Wikia::addAssetsToOutput( 'portable_infobox_scss' );
		return true;
	}
}
