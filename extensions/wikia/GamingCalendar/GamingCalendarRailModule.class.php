<?php
/**
 * SSW Gaming Calendar (rail module)
 */
class GamingCalendarRailModule extends Module {
    
	public $moduleTitle;
    
	public function executeIndex() {
		global $wgCityId;
	    
		wfProfileIn( __METHOD__ );
		// load assets
		$extPath = F::app()->wg->extensionsPath;
		F::app()->wg->out->addScript( "<script src=\"{$extPath}/wikia/GamingCalendar/js/GamingCalendar.js\"></script>" );
		F::app()->wg->out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/GamingCalendar/css/GamingCalendar.scss' ) );
		$catShort = WikiFactoryHub::getInstance()->getCategoryShort($wgCityId);
		$this->moduleTitle = F::app()->wf->msgForContent( 'gamingcalendar-heading-'.$catShort );
		wfProfileOut( __METHOD__ );
    }
    
}
