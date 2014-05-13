<?php

class InstantGlobalsHooks {

	public static function onWikiaSkinTopShortTTLModules(Array &$modules, $skin) {
		if ( F::app()->checkSkin( 'oasis', $skin ) ) {
			$modules[] = 'wikia.ext.instantglobals';
		}
		return true;
	}
}
