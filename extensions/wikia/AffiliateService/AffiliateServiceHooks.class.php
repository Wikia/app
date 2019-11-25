<?php

class AffilliateServiceHooks {
	public static function onBeforePageDisplay( OutputPage $out ) {
		wfProfileIn( __METHOD__ );

		wfProfileOut( __METHOD__ );
		return true;
	}

	public static function onWikiaSkinTopScripts( Array &$vars, &$scripts ) {
		wfProfileIn( __METHOD__ );
		// $td = (new ThemeSettings())->getSettings();
		// $vars['wgTriviaQuizzesPrimaryColor'] = $td['color-community-header'];
		// $vars['wgTriviaQuizzesLinkColor'] = $td['color-links'];

		wfProfileOut( __METHOD__ );
		return true;
	}
}
