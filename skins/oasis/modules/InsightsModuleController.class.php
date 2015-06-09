<?php

class InsightsModuleController extends WikiaController {

	public function executeIndex( $params ) {
		wfProfileIn( __METHOD__ );

		// add CSS for this module
		$this->wg->Out->addStyle( AssetsManager::getInstance()->getSassCommonURL( "skins/oasis/css/modules/InsightsModule.scss" ) );

		$this->themeClass = SassUtil::isThemeDark() ? 'insights-dark' : 'insights-light';
		$this->messageKeys = InsightsHelper::getMessageKeys();

		wfProfileOut(__METHOD__);
	}
}
