<?php

class CuratedContentSpecialPreviewController extends WikiaSpecialPageController {
	public function __construct() {
		parent::__construct( 'CuratedContentPreview', '', false );
	}

	public function index() {
		global $wgStyleVersion, $wgUser;
		if (!$wgUser->isAllowed( 'curatedcontentpreview' )) {
			$this->displayRestrictionError();
			return false;  // skip rendering
		}

		$this->wg->Out->setSubtitle( wfMessage( 'wikiaCuratedContent-preview-description' )->parse() );

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

			$urls[] = CuratedContentController::getUrl(
				'renderFullPage',
				array(
					'allinone' => 1,
					'page' => $title,
					'cb' => $wgStyleVersion
				)
			);
		}

		$this->setVal( 'urls', $urls );
	}
}
