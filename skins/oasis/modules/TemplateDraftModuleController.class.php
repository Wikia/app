<?php

class TemplateDraftModuleController extends WikiaController {

	public function executeIndex( $params ) {
		$this->wg->Out->addStyle(
			AssetsManager::getInstance()->getSassCommonURL( "skins/oasis/css/modules/TemplateDraftModule.scss" )
		);

		$subpage = wfMessage( 'templatedraft-subpage' )->inContentLanguage()->escaped();
		$subpageTitle = Title::newFromText( $this->app->wg->Title->getText() . '/' . $subpage, NS_TEMPLATE );
		$this->draftUrl = $subpageTitle->getFullUrl( [
			'action' => 'edit',
			TemplateConverter::CONVERSION_MARKER => 1,
		] );
	}
}
