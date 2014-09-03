<?php

class NjordController extends WikiaController {
	public function index() {
		$this->wg->out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/NjordPrototype/css/Njord.scss' ) );
		$this->wg->Out->addScriptFile($this->wg->ExtensionsPath . '/wikia/NjordPrototype/scripts/Njord.js');

		$wikiData = new WikiDataModel( Title::newMainPage()->getText() );
		$wikiData->getFromProps();
		$this->wikiData = $wikiData;
	}
}