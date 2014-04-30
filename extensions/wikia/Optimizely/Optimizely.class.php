<?php
/**
 * Optimizely
 *
 * @author Damian Jóźwiak
 *
 */
class Optimizely {
	public static function onWikiaSkinTopScripts( &$vars, &$scripts ) {
		global $wgDevelEnvironment, $wgOptimizelyUrl, $wgOptimizelyDevUrl;

		if ($wgDevelEnvironment) {
			$scripts .= '<script src="' . $wgOptimizelyDevUrl . '" async></script>';
		} else {
			$scripts .= '<script src="' . $wgOptimizelyUrl . '" async></script>';
		}
		return true;
	}
}
