<?php

class SpecialThemeDesignerPreview extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct( 'ThemeDesignerPreview', 'themedesignerpreview' );
	}

	public function execute() {
		wfProfileIn( __METHOD__ );
		global $wgOut, $wgExtensionsPath, $wgCacheBuster;

		$this->setHeaders();

		$wgOut->setPageTitle('Example Page Title');

		$wgOut->addScript('<script src="'. $wgExtensionsPath .'/wikia/ThemeDesigner/js/ThemeDesignerPreview.js?'. $wgCacheBuster .'"></script>');
		$wgOut->addLink(array(
				"type" => "text/css",
				"rel" => "stylesheet",
				"href" => wfGetSassUrl('/extensions/wikia/ThemeDesigner/css/ThemeDesignerPreview.scss'),
			)
		);

		$wgOut->addHtml(wfRenderModule('ThemeDesigner', 'Preview'));

		// page header: use static date
		global $wgHooks;
		$wgHooks['PageHeaderIndexAfterExecute'][] = 'SpecialThemeDesignerPreview::modifyHeaderData';

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Use fake data for page header when rendering page preview
	 *
	 * @author macbre
	 */
	static function modifyHeaderData(&$moduleObject, &$params) {
		global $wgExtensionsPath;
		wfProfileIn(__METHOD__);

		// fake static data for ThemeDesignerPreview
		$moduleObject->revisions = array(
			'current' => array(
				'user' => 'foo',
				'avatarUrl' => "{$wgExtensionsPath}/wikia/ThemeDesigner/images/td-avatar.jpg",
				'link' => '<a>FunnyBunny</a>',
				'timestamp' => ''
			),
		);

		$moduleObject->categories = array("<a>More Sample</a>", "<a>Others</a>");
		$moduleObject->comments = 23;
		$moduleObject->pageSubtitle = false;
		$moduleObject->action = array("text" => "Edit this page");
		$moduleObject->actionImage = '';
		$moduleObject->actionName = 'edit';
		$moduleObject->dropdown = array('foo', 'bar');

		wfProfileOut(__METHOD__);
		return true;
	}
}
