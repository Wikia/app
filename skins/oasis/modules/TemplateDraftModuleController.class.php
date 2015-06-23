<?php

class TemplateDraftModuleController extends WikiaController {

	public function executeIndex( $params ) {
		$this->wg->Out->addStyle(
			AssetsManager::getInstance()->getSassCommonURL( "skins/oasis/css/modules/TemplateDraftModule.scss" )
		);

		/**
		 * TODO: Make a better URL composing script
		 */
		$title = $this->app->wg->Title;
		$this->draftUrl = $title->getFullURL() . '/Draft?action=edit';
	}
}
