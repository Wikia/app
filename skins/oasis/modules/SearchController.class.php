<?php
/**
 * Renders search box
 *
 * @author Maciej Brencz
 */

class SearchController extends WikiaController {

	use Wikia\Search\Traits\NamespaceConfigurable;

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

		$searchParams = [];
		if (! $this->wg->request->getVal('nonamespaces', $this->request->getVal( 'nonamespaces' ), false ) ) { // why both?
			$searchConfig = new Wikia\Search\Config();
			$this->setNamespacesFromRequest($searchConfig, $this->wg->User);
			foreach ( $searchConfig->getNamespaces() as $namespaceInt ) {
				$searchParams['ns'.$namespaceInt] = 1;
			}
		}
		if ( $this->wg->CityId == Wikia\Search\QueryService\Select\Dismax\Video::VIDEO_WIKI_ID ) {
			$searchParams['filters[]'] = 'is_video';
		}
		$this->searchParams = $searchParams;

		$this->fulltext = $this->wg->User->getOption('enableGoSearch') ? 0 : 'Search';
		$this->placeholder = wfMsg('Tooltip-search', $this->wg->Sitename);
		$this->isCrossWikiaSearch = $this->wg->request->getCheck('crossWikiaSearch');

		$this->searchFormId = $this->request->getVal('searchFormId');
	}

}
