<?php

class CuratedTourHooks {

	/**
	 * Add JS assets package to the output
	 * @param \OutputPage $out  An output object passed from a hook
	 * @return bool
	 */
	public static function onBeforePageDisplay( \OutputPage $out ) {
		if ( $out->getTitle()->isSpecial( 'CuratedTour' )
			|| $out->getRequest()->getInt('curatedTour') > 0 )
		{
			\Wikia::addAssetsToOutput( 'curated_tour_play' );
		} elseif ( $out->getTitle()->isSpecial( 'CuratedTour' )
			|| $out->getRequest()->getCookie('curatedTourEditMode') !== null ) {
			\Wikia::addAssetsToOutput( 'curated_tour_planning' );
			\Wikia::addAssetsToOutput( 'curated_tour_planning_css' );
		}

		return true;
	}

	public static function onWikiaSkinTopScripts(&$vars, &$scripts){
		global $wgTitle;

		if ( $wgTitle->isSpecial( 'CuratedTour' ) ) {
			$vars [ 'initTourPlan' ] = true;
		}
		return true;
	}
}
