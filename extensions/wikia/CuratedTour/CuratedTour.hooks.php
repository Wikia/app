<?php

class CuratedTourHooks {

	/**
	 * Add JS assets package to the output
	 * @param \OutputPage $out  An output object passed from a hook
	 * @return bool
	 */
	public static function onBeforePageDisplay( \OutputPage $out ) {
		\Wikia::addAssetsToOutput( 'curated_tour_planning' );
		\Wikia::addAssetsToOutput( 'curated_tour_planning_css' );
		return true;
	}

}
