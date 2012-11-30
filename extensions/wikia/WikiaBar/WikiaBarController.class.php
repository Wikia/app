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
		if( $this->isWikiaBarSuppressed() ) {
			$this->wgSuppressWikiaBar = true;
			OasisController::addBodyClass('nowikiabar');
		}

		$this->lang = F::app()->wg->contLang->getCode();

		if( HubService::isCurrentPageAWikiaHub() ) {
			$this->vertical = HubService::getCategoryInfoForCurrentPage()->cat_id;
		} else {
			$this->vertical = HubService::getCategoryInfoForCity(F::app()->wg->cityId)->cat_id;
		}
	}

	protected function isWikiaBarSuppressed() {
		return ($this->isCorporateMainPageNonAnon() || $this->isNonViewActionAnon() || WikiaBarHooks::isWikiaBarSuppressedByExtensions());
	}

	protected function isCorporateMainPageNonAnon() {
		return (
			HubService::isCorporatePage()
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
	 * @desc Handles AJAX request and changes wikia bar display state
	 */
	public function changeUserStateBar() {
		$results = new stdClass();
		$changeTo = $this->request->getVal('changeTo', false);

		if( !$changeTo || !in_array($changeTo, array(self::WIKIA_BAR_SHOWN_STATE_VALUE, self::WIKIA_BAR_HIDDEN_STATE_VALUE)) ) {
			$results->error = wfMsg('wikiabar-change-state-error');
			$results->success = false;
		} else {
			$results->wikiaBarState = $changeTo;
			$results->success = true;
		}

		$wikiaUserProperties = F::build('WikiaUserPropertiesController');
		$wikiaUserProperties->saveWikiaBarState($changeTo);
		$this->results = $results;
	}

	/**
	 * @desc Gets Wikia Bar display state from user_properties table. If it's not set will return default value WIKIA_BAR_SHOWN_STATE_VALUE
	 */
	public function getUserStateBar() {
		$this->results = new stdClass();

		try {
			$response = $this->app->sendRequest('WikiaUserPropertiesController', 'getUserPropertyValue', array(
				'propertyName' => self::WIKIA_BAR_STATE_OPTION_NAME,
				'defaultOption' => self::WIKIA_BAR_SHOWN_STATE_VALUE
			));
			$results = $response->getVal('results', false);

			if( $results ) {
				$this->results->wikiaBarState = $results->value;
				$this->results->success = true;
			} else {
				$this->results->success = false;
			}
		} catch( Exception $e ) {
			$this->results->error = wfMsg('wikiabar-get-state-error');
			$this->results->success = false;
		}
	}
}
