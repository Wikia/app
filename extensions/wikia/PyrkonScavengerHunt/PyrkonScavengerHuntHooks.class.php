<?php

class PyrkonScavengerHuntHooks {
	public static function onBeforePageDisplay( \OutputPage $out/*, \Skin $skin*/ ) {
		\Wikia::addAssetsToOutput( 'pyrkon_scavenger_hunt_scss' );
		\Wikia::addAssetsToOutput( 'pyrkon_scavenger_hunt_js' );

		return true;
	}
}
