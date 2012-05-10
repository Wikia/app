<?php
/**
 * Renders categories box below the article
 *
 * @author Maciej Brencz
 */

class CampfireCategoriesController extends WikiaController {

	public function executeIndex() {
		wfProfileIn(__METHOD__);
		$this->catlinks = $this->app->getSkinTemplateObj()->data['catlinks'];
		// MW1.16 always returns non empty $catlinks
		if (strpos($this->catlinks, ' catlinks-allhidden\'></div>') !== false) {
			$this->catlinks = '';
		}

		wfProfileOut(__METHOD__);
	}
}
