<?php
/**
 * Renders search box
 *
 * @author Maciej Brencz
 */

class SearchModule extends Module {

	var $searchterm;
	var $fulltext;
	var $placeholder;
	var $wgBlankImgUrl;
	var $wgSitename;
	var $wgTitle;
	var $isCrossWikiaSearch;

	public function executeIndex() {
		global $wgRequest, $wgSitename, $wgSearchDefaultFulltext;

		$this->searchterm = $this->wg->request->getVal('search');
		$this->noautocomplete = $this->wg->request->getVal('noautocomplete');

		$this->fulltext = !empty($wgSearchDefaultFulltext) ? 1 : 0;
		$this->placeholder = wfMsg('Tooltip-search', $wgSitename);
		$this->isCrossWikiaSearch = $wgRequest->getCheck('crossWikiaSearch');
	}

}