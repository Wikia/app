<?php

class TriviaQuizzesHooks extends WikiaController {
	public static function onBeforePageDisplay( OutputPage $out ) {
		global $wgEnableTriviaQuizzesExt, $wgTriviaQuizzesEnabledPages;

		if ( $wgEnableTriviaQuizzesExt && in_array( $out->getTitle()->getPrefixedText(), $wgTriviaQuizzesEnabledPages ) ) {
			$out->addModules( 'ext.wikia.TriviaQuizzes' );
		}

		return true;
	}
}
