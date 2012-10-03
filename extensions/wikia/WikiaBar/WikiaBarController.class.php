<?php
/**
 * Controller for WikiaBar - Meebo replacement
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */
class WikiaBarController extends WikiaController {
	/**
	 * @desc User property name of field which has data about display state of WikiaBar
	 */
	const WIKIA_BAR_STATE_OPTION_NAME = 'WikiaBarDisplayState';

	/**
	 * @desc User WikiaBarDisplayState property shown value
	 */
	const WIKIA_BAR_SHOWN_STATE_VALUE = 'shown';

	/**
	 * @desc User WikiaBarDisplayState property hidden value
	 */
	const WIKIA_BAR_HIDDEN_STATE_VALUE = 'hidden';

	/**
	 * @desc Template for wrapper containing Weebo / Admin Toolbar
	 */
	public function index() {
		if (
			$this->isWikiaBarSuppressed()
		) {
			$this->wgSuppressWikiaBar = true;
			OasisController::addBodyClass('nowikiabar');
		}
		$this->lang = F::app()->wg->contLang->getCode();
		$this->vertical = HubService::getCategoryInfoForCity(F::app()->wg->cityId)->cat_id;
	}

	protected function isWikiaBarSuppressed() {
		return ($this->isCorporateMainPageNonAnon() || $this->isNonViewActionAnon() || WikiaBarHooks::isWikiaBarSuppressed());
	}

	protected function isCorporateMainPageNonAnon() {
		return (
			HubService::isCorporatePage(F::app()->wg->cityId)
			&& Wikia::isMainPage()
			&& !F::app()->wg->User->isAnon()
		);
	}

	protected function isNonViewActionAnon() {
		return (
			F::app()->wg->User->isAnon()
			&& F::app()->wg->request->getText('action', 'view') != 'view'
		);
	}

	/**
	 * @desc Contents for Weebo
	 * @param Array $params request params
	 */
	public function anon() {
		$this->wf->profileIn(__METHOD__);

		$params = $this->request->getParams();

		$lang = !empty($params['lang']) ? $params['lang'] : WikiaBarModel::WIKIA_BAR_DEFAULT_LANG_CODE;
		$vertical = !empty($params['vertical']) ? $params['vertical'] : HubService::getCategoryInfoForCity($this->wg->cityId)->cat_id;

		/** @var $model WikiaBarModel */
		$model = F::build('WikiaBarModel');
		$vertical = $model->mapVerticalToMain($vertical);
		$model->setLang($lang);
		$model->setVertical($vertical);

		$barContents = $model->getBarContents();

		$this->barContents = $barContents['data'];
		$this->status = $barContents['status'];

		$this->wf->profileOut(__METHOD__);
	}

	/**
	 * @desc Contents for AdminToolbar
	 */
	public function user() {
		//just render template
	}

	/**
	 * @desc Checks users properties for WikiaBar display state and changes it to oposite
	 */
	public function changeUserStateBar() {
		$results = $this->getWikiaBarState();
		$state = $results->wikiaBarState;
		$isShown = ($state === self::WIKIA_BAR_SHOWN_STATE_VALUE) ? true : false;

		if( $isShown && $results->success ) {
			$results->wikiaBarState = self::WIKIA_BAR_HIDDEN_STATE_VALUE;
			$results->success = true;
		} else if( !$isShown && $results->success ) {
			$results->wikiaBarState = self::WIKIA_BAR_SHOWN_STATE_VALUE;
			$results->success = true;
		} else {
			//results from WikiaBarController::getWikiaBarState()
		}

		$this->setWikiaBarState($results->wikiaBarState);
		$this->results = $results;
	}

	/**
	 * @desc Returns 'shown' or 'hidden' strings which discribe WikiaBar display state
	 * @return String
	 */
	public function getWikiaBarState() {
		$results = new stdClass();

		if( $this->wg->User->isAnon() ) {
			$state = self::WIKIA_BAR_SHOWN_STATE_VALUE;
			$results->success = false;
		} else {
			$state = $this->wg->User->getOption(self::WIKIA_BAR_STATE_OPTION_NAME);
			if( is_null($state) ) {
				$state = self::WIKIA_BAR_SHOWN_STATE_VALUE;
			}

			$results->success = true;
		}

		$results->wikiaBarState = $state;
		$this->results = $results;
		return $results;
	}

	protected function setWikiaBarState($state) {
		$this->wg->User->setOption(self::WIKIA_BAR_STATE_OPTION_NAME, $state);
		$this->wg->User->saveSettings();
	}
}
