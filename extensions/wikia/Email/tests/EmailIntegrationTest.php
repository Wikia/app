<?php

/**
 * Class EmailIntegrationTest
 *
 * @group Integration
 */
class EmailIntegrationTest extends WikiaBaseTest {

	const VIGNETTE_BASE_URL_PROD = 'http://vignette<SHARD>.wikia.nocookie.net';

	function setUp() {
		$this->setupFile = __DIR__ . '/../Email.setup.php';
		include_once( __DIR__ . '/../../../../includes/HttpFunctions.php');
		parent::setUp();
	}

	/**
	 * Make sure all the images we're using exist
	 */
	public function testEmailImages() {

		$this->setVignetteEnvToProd();

		foreach ( Email\ImageHelper::getIconInfo() as $iconInfo ) {
			$url = $iconInfo['url'];
			$name = $iconInfo['name'];
			$response = HTTP::get( $url );
			$this->assertTrue( $response !== false, "{$name} should return HTTP 200" );
		}
	}

	/**
	 * Set the Vignette base URL to point to production. The testEmailImages test above
	 * was failing frequently in dev and since prod images are what our user's see as
	 * part of our emails, we're updating that test to only run in prod. See SOC-860.
	 */
	private function setVignetteEnvToProd() {
		global $wgVignetteUrl;
		$wgVignetteUrl = self::VIGNETTE_BASE_URL_PROD;
	}
}
