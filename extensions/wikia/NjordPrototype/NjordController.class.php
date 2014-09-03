<?php

class NjordController extends WikiaController {
	public function index() {
		$this->wg->out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/NjordPrototype/css/Njord.scss' ) );
		$this->wg->Out->addScriptFile($this->wg->ExtensionsPath . '/wikia/NjordPrototype/scripts/Njord.js');
		$this->wg->Out->addScriptFile($this->wg->ExtensionsPath . '/wikia/NjordPrototype/scripts/Njord.fileUpload.js');

		$wikiDataModel = new WikiDataModel( Title::newMainPage()->getText() );
		$wikiDataModel->getFromProps();
		$this->wikiData = $wikiDataModel;
	}

	public function saveHeroData() {
		$wikiData = $this->request->getVal('wikiData', []);
		$wikiDataModel = new WikiDataModel( Title::newMainPage()->getText() );
		$wikiDataModel->setFromAttributes($wikiData);

		/**
		 * TODO: edit the article (#smutnyszok)
		 */
		$this->wikiData = $wikiDataModel;
	}
}