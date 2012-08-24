<?php

/**
 * Controller for WikiaBar - Meebo replacement
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */

class WikiaBarController extends WikiaController {
	function executeIndex($params) {
		$this->response->addAsset('skins/oasis/css/modules/WikiaBar.scss');
		$this->response->addAsset('skins/oasis/js/WikiaBar.js');

		$lang = !empty($params['lang'])?$params['lang']:'en';
		$vertical = !empty($params['vertical'])?$params['lang']:9;

		/** @var $model WikiaBarModel */
		$model = F::build('WikiaBarModel');
		$model->setLang($lang);
		$model->setVertical($vertical);

		$this->barContents = $model->getBarContents();
	}
}

