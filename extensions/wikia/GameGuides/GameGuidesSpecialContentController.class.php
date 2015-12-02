<?php

/**
 * @deprecated
 */
class GameGuidesSpecialContentController extends WikiaSpecialPageController {
	const CURATED_CONTENT = "CuratedContent";
	public function __construct() {
		parent::__construct( 'GameGuidesContent', '', false );
	}

	public function index()
	{
		if ( !$this->wg->User->isAllowed( 'gameguidescontent' ) ) {
			$this->displayRestrictionError();
			return false;  // skip rendering
		}

		$this->wg->Out->addStyle(
			'extensions/wikia/GameGuides/css/GameGuidesContentManagmentTool.scss'
		);

		$this->response->setTemplateEngine(
			WikiaResponse::TEMPLATE_ENGINE_MUSTACHE
		);

		$title = wfMsg( 'wikiagameguides-content-title' );
		$this->wg->Out->setPageTitle( $title );
		$this->wg->Out->setHTMLTitle( $title );

		$this->response->setVal(
			'game_guides_have_moved', //<a href="$3" class="badgeName">$1</a
			wfMessage( 'wikiagameguides-content-have-been-deprecated-by' )->params(
				SkinTemplate::makeSpecialUrl( self::CURATED_CONTENT ),
				SpecialPage::getTitleFor( self::CURATED_CONTENT )
			)->text()
		);

		return true;
	}
}
