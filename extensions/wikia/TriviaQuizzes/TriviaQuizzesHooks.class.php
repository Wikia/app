<?php

class TriviaQuizzesHooks {
	public static function onBeforePageDisplay( OutputPage $out ) {
		wfProfileIn( __METHOD__ );
		global $wgEnableTriviaQuizzesExt, $wgTriviaQuizzesEnabledPages;

		if ( $wgEnableTriviaQuizzesExt && in_array( $out->getTitle()->getPrefixedText(), $wgTriviaQuizzesEnabledPages ) ) {
			$out->addModules( 'ext.wikia.TriviaQuizzes' );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	public static function onWikiaSkinTopScripts( Array &$vars, &$scripts ) {
		wfProfileIn( __METHOD__ );
		$td = (new ThemeSettings())->getSettings();
		$vars[ 'wgTriviaQuizzesPrimaryColor' ] = $td['color-community-header'];

		wfProfileOut( __METHOD__ );
		return true;
	}
}
