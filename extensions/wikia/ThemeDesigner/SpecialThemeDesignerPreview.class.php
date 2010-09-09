<?php

class SpecialThemeDesignerPreview extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct( 'ThemeDesignerPreview', 'themedesignerpreview' );
	}

	public function execute() {
		wfProfileIn( __METHOD__ );
		global $wgOut, $wgExtensionsPath;

		$this->setHeaders();

		$wgOut->setPageTitle('Example Page Title');

		$wgOut->addScript('<script src="'. $wgExtensionsPath .'/wikia/ThemeDesigner/js/ThemeDesignerPreview.js"></script>');
		$wgOut->addLink(array(
				"type" => "text/css",
				"rel" => "stylesheet",
				"href" => wfGetSassUrl($wgExtensionsPath.'/wikia/ThemeDesigner/css/ThemeDesignerPreview.scss'),
			)
		);

		$wgOut->addHtml(wfRenderModule('ThemeDesigner', 'Preview'));

		wfProfileOut( __METHOD__ );
	}
}
