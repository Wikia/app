<?php

class SpecialThemeDesignerPreview extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct( 'ThemeDesignerPreview', 'themedesignerpreview' );
	}

	public function execute( $par ) {
		global $wgExtensionsPath;

		$wgOut = RequestContext::getMain()->getOutput();

		// check rights
		if ( !ThemeDesignerHelper::checkAccess() ) {
			$this->displayRestrictionError();
			return;
		}

		$wgOut->allowClickjacking();

		$this->setHeaders();

		$wgOut->setPageTitle( 'Example Page Title' );

		$wgOut->addScript( '<script src="' . $wgExtensionsPath . '/wikia/ThemeDesigner/js/ThemeDesignerPreview.js"></script>' );
		$wgOut->addLink( [
			"type" => "text/css",
			"rel" => "stylesheet",
			"href" => AssetsManager::getInstance()->getSassCommonURL( '/extensions/wikia/ThemeDesigner/css/ThemeDesignerPreview.scss' ),
		] );

		$wgOut->addHtml( F::app()->renderView( 'ThemeDesigner', 'Preview' ) );
	}

	static function onPageHeaderActionButtonShouldDisplay( \Title $title, bool &$shouldDisplayActionButton ) {
		if ( $title->isSpecial( 'ThemeDesignerPreview' ) ) {
			$shouldDisplayActionButton = true;
		}

		return true;
	}

	static function onBeforePrepareActionButtons( $actionButton, &$contentActions ) {
		if ( $actionButton->getTitle()->isSpecial( 'ThemeDesignerPreview' ) ) {
			$contentActions['edit'] = [
				'text' => wfMessage( 'edit' )->text(),
				'href' => '#',
				'id' => 'ca-edit',
				'main' => true
			];
		}

		return true;
	}
}
