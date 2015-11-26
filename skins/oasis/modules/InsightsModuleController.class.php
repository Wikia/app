<?php

class InsightsModuleController extends WikiaController {

	public function executeIndex( $params ) {
		wfProfileIn( __METHOD__ );

		Wikia::addAssetsToOutput( 'insights_module_scss' );
		Wikia::addAssetsToOutput( 'insights_module_js' );

		$this->themeClass = SassUtil::isThemeDark() ? 'insights-dark' : 'insights-light';
		$this->insightsList = ( new InsightsHelper() )->prepareInsightsList();

		wfProfileOut(__METHOD__);
	}
}
