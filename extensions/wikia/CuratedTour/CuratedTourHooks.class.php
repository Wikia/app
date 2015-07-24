<?php

class CuratedTourHooks {

	public static function onBeforePageDisplay( OutputPage &$out, Skin &$skin ) {
		\Wikia::addAssetsToOutput( 'curated_tour_planning' );
		return true;
	}

}
