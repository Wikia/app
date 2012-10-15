<?php
/**
 * Renders search box
 *
 * @author Maciej Brencz
 */

class SearchController extends WikiaController {

	public function executeIndex() {

		$this->searchterm = $this->wg->request->getVal('search');
		$this->noautocomplete = $this->wg->request->getVal('noautocomplete');

		$this->fulltext = $this->wg->User->getOption('enableGoSearch') ? 0 : 'Search';
		$this->placeholder = wfMsg('Tooltip-search', $this->wg->Sitename);
		$this->isCrossWikiaSearch = $this->wg->request->getCheck('crossWikiaSearch');
	}

}