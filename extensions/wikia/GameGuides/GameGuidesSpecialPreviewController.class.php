<?php

class GameGuidesSpecialPreviewController extends WikiaSpecialPageController {
	public function __construct() {
		parent::__construct( 'GameGuidesPreview', '', false );
	}

	public function index() {
		if (!$this->wg->User->isAllowed( 'gameguidespreview' )) {
			$this->displayRestrictionError();
			return false;  // skip rendering
		}

		$this->wg->Out->setSubtitle( wfMessage( 'wikiagameguides-preview-description' )->parse() );

		$titles = array_unique( explode( '/', $this->getPar() ) );

		$urls = [];

		foreach ( $titles as $title ) {
			//Simple fallback to main page if Title does not exist or none specified
			if( $title == '' ) {
				$title = Title::newMainPage()->getFullText();
			} else {
				$title = Title::newFromText( $title );

				if ( $title instanceof Title && $title->exists() ) {
					$title = $title->getFullText();
				} else {
					$title = Title::newMainPage()->getFullText();
				}
			}

			$urls[] = GameGuidesController::getUrl(
				'renderFullPage',
				array(
					'allinone' => 1,
					'page' => $title,
					'cb' => $this->wg->StyleVersion
				)
			);
		}

		$this->setVal( 'urls', $urls );
	}
}
