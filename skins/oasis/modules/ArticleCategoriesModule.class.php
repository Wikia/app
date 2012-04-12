<?php
/**
 * Renders categories box below the article
 *
 * @author Maciej Brencz
 */

class ArticleCategoriesModule extends WikiaController {

	public function executeIndex() {
		wfProfileIn(__METHOD__);
		$this->catlinks = $this->app->getSkinTemplateObj()->data['catlinks'];
		$catlinks = $this->request->getVal('catlinks');
		if(!empty($catlinks)) {
			$this->catlinks = $catlinks;
		}

		// MW1.16 always returns non empty $catlinks
		if (strpos($this->catlinks, ' catlinks-allhidden\'></div>') !== false) {
			$this->catlinks = '';
		}

		wfProfileOut(__METHOD__);
	}
}