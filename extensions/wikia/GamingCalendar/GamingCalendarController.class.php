<?php

/**
 * Controller for Gaming Calendar
 *
 * @author wlee
 */
class GamingCalendarController extends WikiaController {
	
	public function getEntries() {
		$offset = $this->request->getInt( 'offset', 0 );
		$weeks = $this->request->getInt( 'weeks', 2 );
		
		$entries = GamingCalendar::loadEntries($offset, $weeks);

		$this->response->setVal('entries', $entries );

		$this->response->setCacheValidity( 3600, 3600,  array(
			WikiaResponse::CACHE_TARGET_BROWSER,
			WikiaResponse::CACHE_TARGET_VARNISH,
		));
	}

	/**
	 * @author Michał Roszka <michal@wikia-inc.com>
	 * 
	 * This method is most likely to be removed. I created it so I can continue
	 * styling the modal window for Gaming Calendar without hardcoding HTML anywhere.
	*/
	public function getModalLayout() {
		global $wgCityId;
		
		$catName = WikiFactoryHub::getInstance()->getCategoryName($wgCityId);
		$this->setVal('calendarHeading', wfMsgForContent( 'gamingcalendar-heading', $catName ));
		$this->setVal('wgBlankImgUrl', $this->wg->BlankImgUrl );
	}
}
