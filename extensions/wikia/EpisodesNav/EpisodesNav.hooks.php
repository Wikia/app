<?php

class EpisodesNavHooks {
	public static function onBeforePageDisplay( /*\OutputPage $out, \Skin $skin */ ) {
		\Wikia::addAssetsToOutput( 'episodes_nav_scss' );
		return true;
	}
}
