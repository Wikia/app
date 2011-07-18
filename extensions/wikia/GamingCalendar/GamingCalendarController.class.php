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
	
  }
