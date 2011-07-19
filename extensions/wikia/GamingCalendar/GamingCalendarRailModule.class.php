<?php
/**
 * SSW Gaming Calendar (rail module)
 */
class GamingCalendarRailModule extends Module {
    
    public $contents;
    
    public function executeIndex() {
        wfProfileIn( __METHOD__ );
        // load assets
        $extPath = F::app()->wg->extensionsPath;
        F::app()->wg->out->addScript( "<script src=\"{$extPath}/wikia/GamingCalendar/js/GamingCalendar.js\"></script>" );
        F::app()->wg->out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/GamingCalendar/css/GamingCalendar.scss' ) );
        /**
         * Michał Roszka <michal@wikia-inc.com>
         * 
         * Replace the value below with some data getter call.
         */
        $this->contents = 'Sample contents.';
        wfProfileOut( __METHOD__ );
    }
    
}
