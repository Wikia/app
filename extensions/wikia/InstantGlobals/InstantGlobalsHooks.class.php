<?php

class InstantGlobalsHooks {

	public static function onWikiaSkinTopShortTTLModules(Array &$modules, $skin) {
		$modules[] = 'wikia.ext.instantglobals';
		return true;
	}
}
