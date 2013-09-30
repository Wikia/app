<?php
/**
 * Renders search box
 *
 * @author Maciej Brencz
 */

class SearchController extends WikiaController {
	public function executeIndex() {
		$this->setVal('specialSearchUrl', SpecialPage::getTitleFor( 'Search' )->getFullUrl());
		$this->searchterm = $this->wg->request->getVal('search');
		if ( !isset( $this->searchterm ) ) {
			$this->searchterm = $this->request->getVal( 'search' );
		}
		$this->noautocomplete = $this->wg->request->getVal('noautocomplete');
		if ( !isset( $this->noautocomplete ) ) {
			$this->noautocomplete = $this->request->getVal( 'noautocomplete' );
		}

		$this->nonamespaces = $this->wg->request->getVal('nonamespaces');
		if ( !isset( $this->nonamespaces ) ) {
			$this->nonamespaces = $this->request->getVal( 'nonamespaces' );
		}

		$this->fulltext = $this->wg->User->getOption('enableGoSearch') ? 0 : 'Search';
		$this->placeholder = wfMsg('Tooltip-search', $this->wg->Sitename);
		$this->isCrossWikiaSearch = $this->wg->request->getCheck('crossWikiaSearch');

		$this->searchFormId = $this->request->getVal('searchFormId');
	}

}
