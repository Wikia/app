<?php

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

			$this->subpageText = $title->getSubpageText();
			$currentTabIndex = $this->model->getTabIndexBySubpageText($this->subpageText);

			$this->redirectIfUnknownTab($currentTabIndex, $title);
			$this->redirectIfFirstTab($currentTabIndex, $this->subpageText);

			$this->subpageText = $this->model->getSubpageTextByIndex($currentTabIndex, $this->subpageText);
		}

		$this->faqPage = !empty($faqPageName) ? $faqPageName : '#';
		$this->tabs = $this->model->getTabs($currentTabIndex, $this->filterParams);
		$this->visualizationWikis = $this->model->getVisualizationWikis($currentTabIndex);

		$this->indexWikis = $this->model->getIndexWikis($this->getIndexParams());

		$total = ( empty($this->indexWikis['wam_results_total']) ) ? 0 : $this->indexWikis['wam_results_total'];
		$itemsPerPage = $this->model->getItemsPerPage();
		if( $total > $itemsPerPage ) {
			$paginator = Paginator::newFromArray( array_fill( 0, $total, '' ), $itemsPerPage );
			$paginator->setActivePage( $this->page - 1 );
			$this->paginatorBar = $paginator->getBarHTML( $this->getUrlWithAllParams() );
		}
	}

	protected function collectRequestParameters() {
		$this->filterLanguages = $this->model->getCorporateWikisLanguages();
		$this->filterVerticals = $this->model->getVerticals();

		$this->searchPhrase = htmlspecialchars($this->getVal('searchPhrase', null));
		$this->selectedVerticalId = $this->getVal('verticalId', null);
		$this->selectedLangCode = $this->getVal('langCode', null);
		$this->selectedDate = $this->getVal('date', null);

		$this->selectedVerticalId = ($this->selectedVerticalId !== '') ? $this->selectedVerticalId : null;
		$this->selectedLangCode = ($this->selectedLangCode !== '') ? $this->selectedLangCode : null;
		$this->selectedDate = ($this->selectedDate !== '') ? $this->selectedDate : null;

		$this->page = $this->getVal('page', $this->model->getFirstPage());

		$langValidator = new WikiaValidatorSelect(array('allowed' => $this->filterLanguages));
		if (!$langValidator->isValid($this->selectedLangCode)) {
			$this->selectedLangCode = null;
		}
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
			$timestamp = $this->getTimestampFromLocalDate($this->selectedDate);

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
		if( $forPaginator ) {
			$date = isset($this->selectedDate) ? $this->selectedDate : null;
			$page = '%s';
		} else {
			$date = isset($this->selectedDate) ? strtotime($this->selectedDate) : null;
			$page = $this->page;
		}

		$indexParams = [
			'searchPhrase' => $this->searchPhrase,
			'verticalId' => $this->selectedVerticalId,
			'langCode' => $this->selectedLangCode,
			'date' => $date,
			'page' => $page,
		];

		return $indexParams;
	}

	/**
	 * Convert date local language into timestamp (workaround for not existing locales)
	 *
	 * @param $localDate
	 * @return int
	 */
	protected function getTimestampFromLocalDate($localDate) {
		$engMonthNames = array_map(
			'mb_strtolower',
			Language::factory(self::DEFAULT_LANG_CODE)->getMonthNamesArray()
		);

		$localMonthNames = array_map(
			'mb_strtolower',
			$this->wg->Lang->getMonthNamesArray()
		);

		$monthMap = array_combine($localMonthNames, $engMonthNames);
		// remove first element because it's always empty
		array_shift($monthMap);

		// get month short version
		$engShortMonthNames = array_map(
			'mb_strtolower',
			Language::factory(self::DEFAULT_LANG_CODE)->getMonthAbbreviationsArray()
		);

		$localShortMonthNames = array_map(
			'mb_strtolower',
			$this->wg->Lang->getMonthAbbreviationsArray()
		);

		$shortMonthMap = array_combine($localShortMonthNames, $engShortMonthNames);
		// remove first element because it's always empty
		array_shift($shortMonthMap);

		$monthMap += $shortMonthMap;

		$engDate = strtr(mb_strtolower($localDate), $monthMap);

		$timestamp = strtotime($engDate);

		return $timestamp;
	}

	protected function getUrlWithAllParams() {
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
			$this->wg->Out->redirect($this->model->getWAMSubpageUrl($title), HTTP_REDIRECT_PERM);
		}
	}

	private function redirectIfFirstTab($tabIndex, $subpageText) {
		// we don't check here if $title is instance of Title
		// because this method is called after this check and isWAMPage() check

		$isFirstTab = ($tabIndex === WAMPageModel::TAB_INDEX_TOP_WIKIS && !empty($subpageText));
		$mainWAMPageUrl = $this->model->getWAMMainPageUrl($this->filterParams);

		if( $isFirstTab && !empty($mainWAMPageUrl) ) {
			$this->wg->Out->redirect($mainWAMPageUrl, HTTP_REDIRECT_PERM);
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
			$this->wg->Out->redirect($this->model->getWAMMainPageUrl(), HTTP_REDIRECT_PERM);
		}
	}

	public function faq() {
		$this->wamPageUrl = $this->model->getWAMMainPageUrl();
	}
}

