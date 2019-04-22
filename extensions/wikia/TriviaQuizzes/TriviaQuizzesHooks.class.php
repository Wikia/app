<?php

class TriviaQuizzesHooks {
    public static function onBeforePageDisplay( OutputPage $out ) {
        global $wgTitle, $wgEnableTriviaQuizzesExt, $wgTriviaQuizzesEnabledPages;

        if ( $wgEnableTriviaQuizzesExt && in_array( $wgTitle->getText(), $wgTriviaQuizzesEnabledPages ) ) {
            $out->addModules( 'ext.wikia.TriviaQuizzes' );
        }

        return true;
    }
}