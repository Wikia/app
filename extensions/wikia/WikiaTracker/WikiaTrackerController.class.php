<?php

class WikiaTrackerController extends WikiaController {

	/**
	 * Add global JS variables with GoogleAnalytics and WikiaTracker queues
	 *
	 * @param array $vars global variables list
	 * @return boolean return true
	 */
	public function onMakeGlobalVariablesScript($vars) {
		$vars['wikiaTrackingSpool'] = array();
	
	
		// TODO: REMOVE? (PERFORMANCE?) We probably won't need these queues once the new system is done (since all calls will use wikiaTrackingSpool).
		// There are a few usages around the code-base that would need to be removed if they really aren't needed & migrated otherwise.
		$vars['_gaq'] = array();
		$vars['_wtq'] = array();

		return true;
	}

	/**
	 * Add inline JS in <head> section
	 *
	 * @param string $scripts inline JS scripts
	 * @return boolean return true
	 */
	public function onSkinGetHeadScripts($scripts) {
		// used for page load time tracking
		$scripts .= "\n\n<!-- Used for page load time tracking -->\n" .
			Html::inlineScript("var wgNow = new Date();") .	"\n";

		// Create a small stub which will spool up any event calls that happen before the real code is loaded.
		$scripts .= "\n\n<!-- Spool any early event-tracking calls -->\n" .
			Html::inlineScript( self::getTrackerSpoolingJs() ) . "\n";

		// debug
		/** 
		$scripts .= Html::inlineScript(<<<JS
_wtq.push('/1_wikia/foo/bar');
_wtq.push(['/1_wikia/foo/bar', 'profil1']);
_wtq.push([['1_wikia', 'user', 'foo', 'bar'], 'profil1']);
JS
);
		**/

		return true;
	}

	/**
	 * Returns a string that contains minified javascript of a small function stub which will
	 * spool any calls to $.internalTrack until the code is actually loaded for doing the tracking (at
	 * which point the calls will be replayed).
	 *
	 * TODO: $.internalTrack will be refactored-away soon, so we'll need to change the function names and
	 * signatures in here to work for the new function signature (because we'll still need this spooling
	 * functionality).
	 */
	public static function getTrackerSpoolingJs()
	{
		wfProfileIn( __METHOD__ );

		// This code will spool all of the calls (in the order they were called) and different code will replay them later.
		ob_start();
		?>
		if(typeof $ == 'undefined'){
			var $ = {};
		}
		$.internalTrack = function(eventName, dataHash){
			wikiaTrackingSpool.push( [ eventName, dataHash ] );
		};
		<?php
		$jsString = ob_get_clean();

		// We're embedding this in every page, so minify it.
		$jsString = AssetsManagerBaseBuilder::minifyJs( $jsString );

		wfProfileOut( __METHOD__ );
		return $jsString;
	}

}
