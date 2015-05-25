<?php

class WDACReviewSpecialController extends WikiaSpecialPageController {

	const FLAG_APPROVE = 1;
	const FLAG_DISAPPROVE = -1;
	const FLAG_UNDETERMINED = 0;
	const WIKIS_PER_PAGE_LIMIT = 50;

	public function __construct() {
		parent::__construct('WDACReview', 'wdacreview', false /* $listed */);
	}

	protected function setGlobalDisplayVars() {
		// get more space for review list
		$this->wg->OasisFluid = true;
		$this->wg->SuppressSpotlights = true;
		$this->wg->SuppressWikiHeader = true;
		$this->wg->SuppressPageHeader = true;
		$this->wg->SuppressFooter = true;

		$this->wg->Out->setPageTitle($this->getToolName());

		$this->wg->Out->enableClientCache( false );
	}

	public function index() {
		$this->setGlobalDisplayVars();

		$this->accessReview = $this->wg->User->isAllowed( 'wdacreview' );
		if (!$this->specialPage->userCanExecute($this->wg->User)) {
			$this->specialPage->displayRestrictionError();
			return false;
		}
		$this->response->addAsset( 'extensions/wikia/WDACReview/js/WDACReview.js' );
		$this->response->addAsset( 'extensions/wikia/WDACReview/css/WDACReview.scss' );

		$helper = $this->getHelper();

		$this->baseUrl = $this->specialPage->getTitle()->getFullUrl();
		$this->paginatorUrl = urldecode( $this->specialPage->getTitle()->getFullUrl( array('page'=>"%s") ) );
		$this->toolName = $this->getToolName();
		$this->submitUrl = $this->baseUrl;

		if( $this->wg->request->wasPosted() ) {
			$data = $this->wg->request->getValues();
			if ( !empty($data) ) {
				$cities = $this->parseData($data);

				if ( count($cities) > 0 ) {
					$helper->updateWDACFlags( $cities );
					BannerNotificationsController::addConfirmation( wfMessage('wdacreview-confirm-update')->escaped() );
				}
			}
		}

		$iPage = $this->wg->request->getVal( 'page', 1 );
		$iCount = $helper->getCountWikisForReview();
		$this->aCities = $helper->getCitiesForReviewList( self::WIKIS_PER_PAGE_LIMIT, $iPage-1 );
		$this->paginator = '';
		if ( self::WIKIS_PER_PAGE_LIMIT < $iCount ) {
			$oPaginator = Paginator::newFromArray( array_fill( 0, $iCount, '' ), self::WIKIS_PER_PAGE_LIMIT );
			$oPaginator->setActivePage( $iPage - 1 );

			// And here we go! The %s will be replaced with the page number.
			$this->paginator = $oPaginator->getBarHTML( $this->paginatorUrl );
		}
	}


	protected function getHelper() {
		return new WDACReviewHelper();
	}

	protected function getToolName() {
		return wfMessage('wdacreview-tool-name')->escaped();
	}

	protected function parseData($data) {
		$cities = array();

		foreach( $data as $name => $value ) {
			if (preg_match('/city-(\d+)/', $name, $matches)) {
				if ( !empty($matches[1]) ) {
					$cities[$matches[1]] = $value;
				}
			}
		}

		return $cities;
	}
}
