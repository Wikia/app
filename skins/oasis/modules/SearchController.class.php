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

		$searchParams = [];
		if (! $this->request->getVal( 'nonamespaces', false ) ) {
			$namespaces = $this->getNamespaceFromRequest();
			foreach ( $namespaces as $namespaceInt ) {
				$searchParams['ns'.$namespaceInt] = 1;
			}
		}
		if ( $this->wg->CityId == Wikia\Search\QueryService\Select\Dismax\Video::VIDEO_WIKI_ID ) {
			$searchParams['filters[]'] = 'is_video'; // this is required to hide images
			$searchParams['rank'] = 'default'; // this is required to keep urls consistent between search and non-search pages
		}
		$this->searchParams = $searchParams;

		$this->fulltext = $this->wg->User->getGlobalPreference('enableGoSearch') ? 0 : 'Search';
		$this->placeholder = WikiaPageType::isWikiaHub()
			? wfMessage('wikiahubs-search-placeholder')->escaped()
			: wfMessage('Tooltip-search', $this->wg->Sitename)->escaped();
		$this->isCrossWikiaSearch = $this->wg->request->getCheck('crossWikiaSearch');

		$this->searchFormId = $this->request->getVal('searchFormId');

	}

	protected function getNamespaceFromRequest()
	{
		$user = $this->wg->User;
		$searchableNamespaces = SearchEngine::searchableNamespaces();
		$namespaces = array();
		foreach( $searchableNamespaces as $i => $name ) {
			if ( $this->getVal( 'ns'.$i, false ) ) {
				$namespaces[] = $i;
			}
		}
		if ( empty($namespaces) ) {
			if ( $user->getGlobalPreference( 'searchAllNamespaces' ) ) {
				$namespaces = array_keys($searchableNamespaces);
			} else {
				// this is mostly needed for unit testing
				$defaultProfile = !empty( $this->wg->DefaultSearchProfile ) ? $this->wg->DefaultSearchProfile : 'default';
				switch($defaultProfile)
				{
					case SEARCH_PROFILE_ADVANCED:
						//There is no Config::setQuery call so it will always return default...
					case SEARCH_PROFILE_DEFAULT:
						$namespaces = \SearchEngine::defaultNamespaces();
						break;
					case SEARCH_PROFILE_IMAGES:
						$namespaces =  array( NS_FILE );
						break;
					case SEARCH_PROFILE_USERS:
						$namespaces =  array( NS_USER );
						break;
					case SEARCH_PROFILE_ALL:
						$namespaces = \SearchEngine::searchableNamespaces();
						break;
				}
			}
		}
		return  $namespaces ;
	}

}
