<?php

/**
 * Class EmailIntegrationTest
 *
 * @group Integration
 */
class EmailIntegrationTest extends WikiaBaseTest {
	function setUp() {
		$this->setupFile = __DIR__ . '/../Email.setup.php';
		include_once( __DIR__ . '/../../../../includes/HttpFunctions.php');
		parent::setUp();
	}

	/**
	 * Make sure all the images we're using exist
	 */
	public function testEmailImages() {
		$icons = Email\ImageHelper::getIconInfo();

		foreach ( $icons as $info ) {
			$url = $info['url'];
			$name = $info['name'];
			$response = HTTP::get( $url );
			$this->assertTrue( $response !== false, "{$name} should return HTTP 200" );
		}
	}
}
