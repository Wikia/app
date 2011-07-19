<?php

/**
 * Controller for Gaming Calendar
 *
 * @author wlee
 */
class GamingCalendarController extends WikiaController {
	
	public function getEntries() {
		$startDate = $this->request->getVal('startDate', '');
		$endDate = $this->request->getVal('endDate', '');
		
		$entries = GamingCalendar::loadEntries($startDate, $endDate);

		$this->response->setVal('entries', $entries);
	}
        
        /**
         * @author Michał Roszka <michal@wikia-inc.com>
         * 
         * This method is most likely to be removed. I created it so I can continue
         * styling the modal window for Gaming Calendar without hardcoding HTML anywhere.
         */
        public function getModalLayout() {
            // do nothing (which means: automatically call the proper template and render it's contents).
        }
  }
