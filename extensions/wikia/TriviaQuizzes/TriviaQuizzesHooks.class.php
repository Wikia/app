<?php

class TriviaQuizzesHooks {
    public static function onBeforePageDisplay( OutputPage $out ) {
        global $wgTitle, $wgEnableTriviaQuizzesAlpha, $wgTriviaQuizzesEnabledPages;

        if ( $wgEnableTriviaQuizzesAlpha && in_array( $wgTitle->getText(), $wgTriviaQuizzesEnabledPages ) ) {
            $out->addModules( 'ext.wikia.TriviaQuizzes' );
        }

        return true;
    }
}