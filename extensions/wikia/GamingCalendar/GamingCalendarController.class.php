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
	}
        
        /**
         * @author Michał Roszka <michal@wikia-inc.com>
         * 
         * This method is most likely to be removed. I created it so I can continue
         * styling the modal window for Gaming Calendar without hardcoding HTML anywhere.
         */
	public function getModalLayout() {
	}
}
