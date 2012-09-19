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
		if (
			HubService::isCorporatePage(F::app()->wg->cityId)
			&& Wikia::isMainPage()
			&& !F::app()->wg->User->isAnon()
		) {
			$this->wgSuppressWikiaBar = true;
			OasisController::addBodyClass('nowikiabar');
		}
		$this->lang = F::app()->wg->contLang->getCode();
		$this->vertical = HubService::getCategoryInfoForCity(F::app()->wg->cityId)->cat_id;
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
}
