<?php

class InstantGlobalsHooks {

	public static function onWikiaSkinTopShortTTLModules( Array &$modules, $skin ) {
		if ( F::app()->checkSkin( 'oasis', $skin ) ) {
			$modules[] = 'wikia.ext.instantGlobals';
		}
		return true;
	}
}
