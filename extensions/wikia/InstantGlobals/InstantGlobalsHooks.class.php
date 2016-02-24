<?php

class InstantGlobalsHooks {

	public static function onWikiaSkinTopShortTTLModules( Array &$modules, $skin ) {
		if ( F::app()->checkSkin( [ 'oasis', 'wikiamobile' ], $skin ) ) {
			$modules[] = 'wikia.ext.instantGlobals';
			$modules[] = 'wikia.ext.instantGlobalsOverride';
		}
		return true;
	}
}
