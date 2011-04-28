<?php

class SpecialThemeDesignerPreview extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct( 'ThemeDesignerPreview', 'themedesignerpreview' );
	}

	public function execute() {
		wfProfileIn( __METHOD__ );
		global $wgOut, $wgExtensionsPath, $wgCacheBuster;

		$wgOut->allowClickjacking();

		$this->setHeaders();

		$wgOut->setPageTitle('Example Page Title');

		$wgOut->addScript('<script src="'. $wgExtensionsPath .'/wikia/ThemeDesigner/js/ThemeDesignerPreview.js?'. $wgCacheBuster .'"></script>');
		$wgOut->addLink(array(
				"type" => "text/css",
				"rel" => "stylesheet",
				"href" => AssetsManager::getInstance()->getSassCommonURL('/extensions/wikia/ThemeDesigner/css/ThemeDesignerPreview.scss'),
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
	static function modifyHeaderData(&$controller, &$params) {
		global $wgExtensionsPath;
		wfProfileIn(__METHOD__);

		// fake static data for ThemeDesignerPreview
		$response = $controller->getResponse();

		$response->setVal('revisions', array(
			'current' => array(
				'user' => 'foo',
				'avatarUrl' => "{$wgExtensionsPath}/wikia/ThemeDesigner/images/td-avatar.jpg",
				'link' => '<a>FunnyBunny</a>',
				'timestamp' => ''
			),
		));

		$response->setVal('action', array("text" => "Edit this page"));
		$response->setVal('actionImage', '');
		$response->setVal('actionName', 'edit');
		$response->setVal('categories',array("<a>More Sample</a>", "<a>Others</a>"));
		$response->setVal('comments', 23);
		$response->setVal('dropdown',  array('foo', 'bar'));
		$response->setVal('pageSubtitle', false);

		wfProfileOut(__METHOD__);
		return true;
	}
}
