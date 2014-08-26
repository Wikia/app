<?php
class VenusTestController extends WikiaSpecialPageController {
	public function __construct() {
		parent::__construct('VenusTest', '', false);
	}

	/**
	 * Main page for Special:VenusTest page
	 * 
	 * @return boolean
	 */
	public function index() {
		if( $this->checkPermissions() ) {
			$this->displayRestrictionError();
			return false; // skip rendering
		}

		// As we assign to Body, we don't need it now, but it should be implemented

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_HANDLEBARS );
		$this->response->addAsset( 'extensions/wikia/VenusTest/styles/VenusTest.scss' );
		$this->response->setData( $this->getTestData() );
	}

	private function getTestData() {
		$testData = [
			'members' => [
				'qAga',
				'Bogna',
				'Damian',
				'Warkot',
				'V.',
				'Kalina',
				'Tower',
				'Opener',
				'Chris'
			],
			'team' => 'Consumer'
		];

		return $testData;
	}

	public static function onGetSkin(RequestContext $context, &$skin) {
		$skin = new SkinVenus();

		return false;
	}
}
