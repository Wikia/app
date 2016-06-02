<?php

use Wikia\Paginator\Paginator;

class WAMPageController extends WikiaController
{
	const DEFAULT_LANG_CODE = 'en';

	protected $model;

	public function __construct() {
		parent::__construct();

		$this->model = new WAMPageModel();
	}

	public function init() {
		$this->response->addAsset('wampage_scss');
		$this->response->addAsset('wampage_js');

		OasisController::addBodyClass('WAMPage');
	}

	public function index() {
		$this->response->addAsset('/skins/oasis/css/modules/CorporateDatepicker.scss');
		$this->collectRequestParameters();

		$faqPageName = $this->model->getWAMFAQPageName();

		$title = $this->wg->Title;
		if( $title instanceof Title ) {
			$this->redirectIfMisspelledWamMainPage($title);
		}

		$this->faqPage = !empty($faqPageName) ? $faqPageName : '#';
		$this->visualizationWikis = $this->model->getVisualizationWikis( $this->selectedVerticalId );

		$this->indexWikis = $this->model->getIndexWikis( $this->getIndexParams() );

		$total = ( empty( $this->indexWikis['wam_results_total'] ) ) ? 0 : $this->indexWikis['wam_results_total'];
		$itemsPerPage = $this->model->getItemsPerPage();
		if( $total > $itemsPerPage ) {
			$paginator = new Paginator( $total, $itemsPerPage, $this->getUrlForPagination() );
			$paginator->setActivePage( $this->page );
			$this->paginatorBar = $paginator->getBarHTML();
			$this->wg->Out->addHeadItem( 'Pagination', $paginator->getHeadItem() );
		}
	}

	protected function collectRequestParameters() {
		$this->filterVerticals = $this->model->getVerticals();
		$this->verticalsShorts = $this->model->getVerticalsShorts();
		$this->verticalsNamesMsgKeys = $this->model->generateVerticalsNamesMsgKeys( $this->verticalsShorts );

		$this->searchPhrase = htmlspecialchars( $this->getVal( 'searchPhrase', null ) );
		$this->selectedVerticalId = intval( $this->getVal( 'verticalId', null ) );
		$this->selectedLangCode = $this->getVal( 'langCode', null );
		$this->selectedDate = $this->getVal( 'date', null );

		$this->selectedVerticalId = ( $this->selectedVerticalId !== '' ) ? $this->selectedVerticalId : null;
		$this->selectedLangCode = ( $this->selectedLangCode !== '' ) ? $this->selectedLangCode : null;
		$this->selectedDate = ( $this->selectedDate !== '' ) ? $this->selectedDate : null;

		$this->isSingleVertical = ( $this->selectedVerticalId != WikiFactoryHub::VERTICAL_ID_OTHER );

		$this->page = intval( $this->getVal( 'page', $this->model->getFirstPage() ) );

		$verticalValidator = new WikiaValidatorSelect(array('allowed' => array_keys($this->filterVerticals)));
		if (!$verticalValidator->isValid($this->selectedVerticalId)) {
			$this->selectedVerticalId = null;
		}

		$filterMinMaxDates = $this->model->getMinMaxIndexDate();
		$this->wg->Out->addJsConfigVars(
			[
				'wamFilterMinMaxDates' => $filterMinMaxDates,
				'wamFilterDateFormat' => $this->getJsDateFormat()
			]
		);

		if (!empty($this->selectedDate)) {
			$timestamp = $this->selectedDate;

			if (!empty($filterMinMaxDates['min_date'])) {
				$dateValidator = new WikiaValidatorCompare(['expression' => WikiaValidatorCompare::GREATER_THAN_EQUAL]);
				if (!$dateValidator->isValid([$timestamp, $filterMinMaxDates['min_date']])) {
					$this->selectedDate = null;
				}
			}

			if (!empty($filterMinMaxDates['max_date'])) {
				$dateValidator = new WikiaValidatorCompare(['expression' => WikiaValidatorCompare::LESS_THAN_EQUAL]);
				if (!$dateValidator->isValid([$timestamp, $filterMinMaxDates['max_date']])) {
					$this->selectedDate = null;
				}
			}
		}

		$this->filterLanguages = $this->model->getWAMLanguages( $this->selectedDate );

		$langValidator = new WikiaValidatorSelect(array('allowed' => $this->filterLanguages));
		if (!$langValidator->isValid($this->selectedLangCode)) {
			$this->selectedLangCode = null;
		}

		// combine all filter params to array
		$this->filterParams = array(
			'searchPhrase' => $this->searchPhrase,
			'verticalId' => $this->selectedVerticalId,
			'langCode' => $this->selectedLangCode,
			'date' => $this->selectedDate,
		);
	}

	protected function getJsDateFormat() {
		$format = $this->wg->Lang->getDateFormatString( 'date', $this->wg->Lang->dateFormat( true ) );
		return DateFormatHelper::convertFormatToJqueryUiFormat($format);
	}

	protected function getIndexParams($forPaginator = false) {
		$indexParams = [
			'searchPhrase' => $this->searchPhrase,
			'verticalId' => Sanitizer::encodeAttribute( $this->selectedVerticalId ),
			'langCode' => $this->selectedLangCode,
			'date' => isset( $this->selectedDate ) ? $this->selectedDate : null,
		];
		if ( !$forPaginator ) {
			$indexParams['page'] = Sanitizer::encodeAttribute( $this->page );
		}

		return $indexParams;
	}

	protected function getUrlForPagination() {
		$url = '#';
		$title = $this->wg->Title;
		if( $title instanceof Title ) {
			$url = $title->getLocalURL($this->getIndexParams(true));
			$url = urldecode($url);
		}

		return $url;
	}

	private function redirectIfUnknownTab($currentTabIndex, $title) {
		// we don't check here if $title is instance of Title
		// because this method is called after this check and isWAMPage() check

		if( $title->isSubpage() && !$currentTabIndex ) {
			$this->wg->Out->redirect($this->model->getWAMSubpageUrl($title), 301);
		}
	}

	private function redirectIfFirstTab($tabIndex, $subpageText) {
		// we don't check here if $title is instance of Title
		// because this method is called after this check and isWAMPage() check

		$isFirstTab = ($tabIndex === WAMPageModel::TAB_INDEX_TOP_WIKIS && !empty($subpageText));
		$mainWAMPageUrl = $this->model->getWAMMainPageUrl($this->filterParams);

		if( $isFirstTab && !empty($mainWAMPageUrl) ) {
			$this->wg->Out->redirect($mainWAMPageUrl, 301);
		}
	}

	private function redirectIfMisspelledWamMainPage($title) {
		// we don't check here if $title is instance of Title
		// because this method is called after this check and isWAMPage() check

		$dbkey = $title->getDbKey();
		$mainPage = $this->model->getWAMMainPageName();
		$isMainPage = (mb_strtolower($dbkey) === mb_strtolower($mainPage));
		$isMisspeledMainPage = !($dbkey === $mainPage);

		if( $isMainPage && $isMisspeledMainPage ) {
			$this->wg->Out->redirect($this->model->getWAMMainPageUrl(), 301);
		}
	}

	public function faq() {
		$this->wamPageUrl = $this->model->getWAMMainPageUrl();
	}
}
