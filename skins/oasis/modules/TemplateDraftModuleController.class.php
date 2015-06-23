<?php

class TemplateDraftModuleController extends WikiaController {

	public function executeIndex( $params ) {
		$this->wg->Out->addStyle(
			AssetsManager::getInstance()->getSassCommonURL( "skins/oasis/css/modules/TemplateDraftModule.scss" )
		);
	}
}
