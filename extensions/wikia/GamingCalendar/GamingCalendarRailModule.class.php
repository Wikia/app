<?php
/**
 * SSW Gaming Calendar (rail module)
 */
class GamingCalendarRailModule extends Module {
    
    public $moduleTitle;
    
    public function executeIndex() {
        wfProfileIn( __METHOD__ );
        // load assets
        $extPath = F::app()->wg->extensionsPath;
        F::app()->wg->out->addScript( "<script src=\"{$extPath}/wikia/GamingCalendar/js/GamingCalendar.js\"></script>" );
        F::app()->wg->out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/GamingCalendar/css/GamingCalendar.scss' ) );
	$this->moduleTitle = F::app()->wf->msgForContent( 'gamingcalendar-heading' );
        wfProfileOut( __METHOD__ );
    }
    
}
