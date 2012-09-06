<?php

/**
 * Controller for WikiaBar - Meebo replacement
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */

class WikiaBarController extends WikiaController {
	const DEFAULT_LANG_CODE = 'en';

	function executeIndex($params) {
		$this->wf->profileIn(__METHOD__);

		$lang = !empty($params['lang']) ? $params['lang'] : self::DEFAULT_LANG_CODE;
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
}
