<?php

use \Wikia\Logger\WikiaLogger;

class RTE {

    const INIT_MODE_SOURCE = 'source';
    const INIT_MODE_WYSIWYG = 'wysiwyg';

    private static	$useWysiwyg = true;

    private static 	$wysiwygDisabledReason = '';

    private static $initMode = self::INIT_MODE_WYSIWYG;

    static public function isEnabled (){
        return self::$useWysiwyg;
    }
    static public function isWysiwygModeEnabled(){
        return self::getInitMode() == self::INIT_MODE_WYSIWYG;
    }

    static public function getInitMode() {
        return self::$initMode;
    }

    static public function disableEditor( string $reason ) {
        self::$useWysiwyg = false;
        self::$wysiwygDisabledReason = $reason;
        WikiaLogger::instance()->debug( 'RTE CK editor disabled', [ 'reason' => $reason ] );
    }

}
