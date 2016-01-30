<?php
class VisitSourceHooks {

	/**
	 * Adds assets for AuthPages on each Oasis pageview
	 *
	 * @param {String} $skin
	 * @param {String} $text
	 *
	 * @return true
	 */
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		if ( F::app()->checkSkin( 'oasis', $skin ) ) {
			\Wikia::addAssetsToOutput( 'visit_source_js' );
		}
		return true;
	}
}
