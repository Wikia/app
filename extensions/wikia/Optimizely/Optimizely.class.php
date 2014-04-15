<?php
/**
 * Optimizely
 *
 * @author Damian Jóźwiak
 *
 */
class Optimizely {
	public static function onWikiaSkinTopScripts( &$vars, &$scripts ) {

		$scripts .= '<script src="//cdn.optimizely.com/js/554924358.js" async></script>';
		return true;
	}
}
