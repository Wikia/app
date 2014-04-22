<?php
/**
 * Optimizely
 *
 * @author Damian Jóźwiak
 *
 */
class Optimizely {
	public static function onWikiaSkinTopScripts( &$vars, &$scripts ) {
		global $wgDevelEnvironment;

		if ($wgDevelEnvironment) {
			$scripts .= '<script src="//cdn.optimizely.com/js/874080211.js" async></script>';
		} else {
			$scripts .= '<script src="//cdn.optimizely.com/js/554924358.js" async></script>';
		}
		return true;
	}
}
