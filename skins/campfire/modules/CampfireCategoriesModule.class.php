<?php
/**
 * Renders categories box below the article
 *
 * @author Maciej Brencz
 */

class CampfireCategoriesModule extends Module {
	var $catlinks;

	public function executeIndex() {
		wfProfileIn(__METHOD__);

		// MW1.16 always returns non empty $catlinks
		if (strpos($this->catlinks, ' catlinks-allhidden\'></div>') !== false) {
			$this->catlinks = '';
		}

		wfProfileOut(__METHOD__);
	}
}
