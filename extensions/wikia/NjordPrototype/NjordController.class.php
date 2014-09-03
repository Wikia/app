<?php

class NjordController extends WikiaController {
	public function index() {
		$this->wg->out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/NjordPrototype/css/Njord.scss' ) );

		$wikiData = new WikiDataModel( Title::newMainPage()->getText() );
		$wikiData->getFromProps();
		$this->wikiData = $wikiData;
	}
}