<?php

/**
 * Controller for WikiaBar - Meebo replacement
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */

class WikiaBarController extends WikiaController {
	function executeIndex($params) {
		$this->wf->profileIn(__METHOD__);
		$this->response->addAsset('skins/oasis/css/modules/WikiaBar.scss');
		$this->response->addAsset('skins/oasis/js/WikiaBar.js');

		$lang = !empty($params['lang'])?$params['lang']:'en';
		$vertical = !empty($params['vertical'])?$params['vertical']:9;

		/** @var $model WikiaBarModel */
		$model = F::build('WikiaBarModel');
		$model->setLang($lang);
		$model->setVertical($vertical);

		$barContents = $model->getBarContents();
		$this->barContents = $barContents['data'];
		$this->status = $barContents['status'];
		$this->wf->profileOut(__METHOD__);
	}
}
