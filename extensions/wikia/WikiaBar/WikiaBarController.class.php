<?php
/**
 * Controller for WikiaBar - Meebo replacement
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */
class WikiaBarController extends WikiaController {


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
		wfProfileIn(__METHOD__);

		$params = $this->request->getParams();

		$lang = !empty($params['lang']) ? $params['lang'] : WikiaBarModel::WIKIA_BAR_DEFAULT_LANG_CODE;
		$vertical = !empty($params['vertical']) ? $params['vertical'] : HubService::getCategoryInfoForCity($this->wg->cityId)->cat_id;

		/** @var $model WikiaBarModel */
		$model = new WikiaBarModel();
		$vertical = $model->mapVerticalToMain($vertical);
		$model->setLang($lang);
		$model->setVertical($vertical);

		$barContents = $model->getBarContents();

		$this->barContents = $barContents['data'];
		$this->status = $barContents['status'];

		wfProfileOut(__METHOD__);
	}

	/**
	 * @desc Contents for AdminToolbar
	 */
	public function user() {
		//just render template
	}
}
