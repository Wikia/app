<?php

class TriviaQuizzesHooks {
    public static function onBeforePageDisplay(OutputPage $out) {
        global $wgEnableTriviaQuizzesAlpha;

        if ( $wgEnableTriviaQuizzesAlpha ) {
            $out->addModules('ext.wikia.TriviaQuizzes');
        }

        return true;
    }
}