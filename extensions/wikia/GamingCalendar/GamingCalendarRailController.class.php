<?php
/**
 * SSW Gaming Calendar (rail module)
 */
class GamingCalendarRailController extends WikiaController {
    
	public function executeIndex() {
		global $wgCityId;
	    
		wfProfileIn( __METHOD__ );
		// load assets
		$extPath = F::app()->wg->extensionsPath;
		F::app()->wg->out->addScript( "<script src=\"{$extPath}/wikia/GamingCalendar/js/GamingCalendar.js\"></script>" );
		F::app()->wg->out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/GamingCalendar/css/GamingCalendar.scss' ) );
		$catName = WikiFactoryHub::getInstance()->getCategoryName($wgCityId);
		$this->moduleTitle = wfMsgForContent( 'gamingcalendar-heading', $catName );
		wfProfileOut( __METHOD__ );
    }
    
}
