<?php


class LanguageWikisIndexController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'LanguageWikisIndex' );
	}

	public function index() {

		$this->specialPage->setHeaders();

		$this->sendRequest('MiniEditor', 'loadAssets', array(
			'additionalAssets' => array(
				'extensions/wikia/MiniEditor/js/SpecialPage.js',
				'extensions/wikia/MiniEditor/css/SpecialPage.scss'
			)
		));

		$this->response->addAsset( 'special_discussions_scss' );
		global $wgOut;

		$wgOut->addModules( "ext.wikia.TimeAgoMessaging" );

		$this->response->setTemplateEngine( \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

	}

}
