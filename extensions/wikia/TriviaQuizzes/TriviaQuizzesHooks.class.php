<?php

class TriviaQuizzesHooks extends WikiaController {
	public static function onBeforePageDisplay( OutputPage $out ) {
		global $wgTitle, $wgEnableTriviaQuizzesExt, $wgTriviaQuizzesEnabledPages;

		if ( $wgEnableTriviaQuizzesExt && in_array( $wgTitle->getPrefixedText(), $wgTriviaQuizzesEnabledPages ) ) {
			$out->addModules( 'ext.wikia.TriviaQuizzes' );
		}

		return true;
	}
}
