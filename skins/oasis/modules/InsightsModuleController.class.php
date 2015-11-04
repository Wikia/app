<?php

class InsightsModuleController extends WikiaController {

	public function executeIndex( $params ) {
		wfProfileIn( __METHOD__ );

		Wikia::addAssetsToOutput( 'insights_module_scss' );
		Wikia::addAssetsToOutput( 'insights_module_js' );

		$this->themeClass = SassUtil::isThemeDark() ? 'insights-dark' : 'insights-light';
		$this->messageKeys = InsightsHelper::getMessageKeys();

		wfProfileOut(__METHOD__);
	}
}
