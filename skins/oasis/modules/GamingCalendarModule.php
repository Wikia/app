<?php
/**
 * SSW Gaming Calendar (rail module)
 */
class GamingCalendarModule extends Module {
    
    public $contents;
    
    public function executeRail() {
        wfProfileIn( __METHOD__ );
        /**
         * Michał Roszka <michal@wikia-inc.com>
         * 
         * Replace the value below with some data getter call.
         */
        $this->contents = 'Sample contents.';
        wfProfileOut( __METHOD__ );
    }
    
}
