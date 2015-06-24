<?php

class TemplateDraftModuleController extends WikiaController {

	public function executeIndex( $params ) {
		$this->wg->Out->addStyle(
			AssetsManager::getInstance()->getSassCommonURL( "skins/oasis/css/modules/TemplateDraftModule.scss" )
		);

		/**
		 * TODO: Make a better URL composing script
		 */
		$titleUrl = $this->app->wg->Title->getFullURL();
		$subpage = wfMessage( 'templatedraft-subpage' )->inContentLanguage()->escaped();
		$this->draftUrl = "{$titleUrl}/{$subpage}?action=edit";
	}
}
