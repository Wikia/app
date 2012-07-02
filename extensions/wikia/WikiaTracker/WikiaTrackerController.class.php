<?php

class WikiaTrackerController extends WikiaController {

	/**
	 * Implementation of new WikiaSkinTopScripts hook since we want it to be 
	 * at the top of the page
	 *
	 * @param array $vars global variables list
	 * @param string $scripts inline JS scripts
	 * @return boolean return true
	 */
	public function onWikiaSkinTopScripts( &$vars, &$scripts, $skin ) {
		$this->onMakeGlobalVariablesScript($vars);
		$this->onSkinGetHeadScripts($scripts);
		return true;
	}

	/**
	 * Add global JS variables with GoogleAnalytics and WikiaTracker queues
	 *
	 * @param array $vars global variables list
	 * @return boolean return true
	 */
	public function onMakeGlobalVariablesScript(&$vars) {
		$vars['wikiaTrackingSpool'] = array();
	
	
		// TODO: REMOVE? (PERFORMANCE?) We probably won't need these queues once the new system is done (since all calls will use wikiaTrackingSpool).
		// There are a few usages around the code-base that would need to be removed if they really aren't needed & migrated otherwise.
		$vars['_gaq'] = array();
		$vars['_wtq'] = array();
		
		$app = F::app();
		if (!empty($app->wg->IsGASpecialWiki)) {
			$vars['wgIsGASpecialWiki'] = true;
		}

		return true;
	}

	/**
	 * Add inline JS in <head> section
	 *
	 * @param string $scripts inline JS scripts
	 * @return boolean return true
	 */
	public function onSkinGetHeadScripts(&$scripts) {
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

		global $wgJsMimeType, $wgExtensionsPath;

		$scripts .= "\n<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/WikiaTracker/js/analytics_prod.js?v=5\"></script>";

		return true;
	}

	/**
	 * Returns a string that contains minified javascript of a small function stub which will
	 * spool any calls to WikiaTracker.trackEvent until the code is actually loaded for doing the tracking (at
	 * which point the calls will be replayed).
	 */
	public static function getTrackerSpoolingJs()
	{
		wfProfileIn( __METHOD__ );

		// This code will spool all of the calls (in the order they were called) and different code will replay them later.
		// The wikiatracker implememtation will be replaced directly as soon as the correct file will load.
		ob_start();
		?>
		window.WikiaTracker = window.WikiaTracker || {
			trackEvent: function(eventName, params, method){
				wikiaTrackingSpool.push([eventName, params, method]);
			}
		};
		<?php
		$jsString = ob_get_clean();

		// We're embedding this in every page, so minify it.
		//@Sean: wrapping this in memcache using the cachebuster as part of the key could save some time?
		$jsString = AssetsManagerBaseBuilder::minifyJs( $jsString );

		wfProfileOut( __METHOD__ );
		return $jsString;
	}

}
