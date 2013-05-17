<?php

class WikiaHomePageImageResizeTest extends WikiaBaseTest {

	public function setUp() {
		require_once( dirname(__FILE__) . '/../../CityVisualization/CityVisualization.setup.php' );
		$this->setupFile = dirname(__FILE__) . '/../WikiaHomePage.setup.php';
		parent::setUp();
	}

	/**
	 * @param $requestedWidth
	 * @param $requestedHeight
	 * @param $originalWidth
	 * @param $originalHeight
	 * @param $expParams
	 * @dataProvider testGetImageResizeParamsDataProvider
	 */
	public function testGetImageResizeParams($originalWidth, $originalHeight, $requestedWidth, $requestedHeight, $expParams) {
		/* @var $helper WikiaHomePageHelper */
		$helper = new WikiaHomePageHelper();
		$params = $helper->getImageServingParamsForResize($requestedWidth, $requestedHeight, $originalWidth, $originalHeight);
		$this->assertEquals($expParams, $params);
	}

	public function testGetImageResizeParamsDataProvider() {
		return array(
			array(320, 320, 320, 320, array(null, 320, array('w' => 320, 'h' => 320))),	// no change
			array(480, 320, 320, 320, array(null, 320, array('w' => 320, 'h' => 320))),	// crop width
			array(320, 480, 320, 320, array(null, 320, array('w' => 320, 'h' => 320))),	// crop height
			array(320, 320, 480, 320, array(null, 320, array('w' => 320, 'h' => 214))),	// crop to ratio, horizontal
			array(320, 320, 320, 480, array(null, 320, array('w' => 214, 'h' => 320))),	// crop to ratio, vertical
			array(480, 320, 560, 374, array(null, 480, array('w' => 480, 'h' => 320))),	// crop to ratio, upscaled image
			array(330, 210, 330, 160, array(null, 330, array('w' => 330, 'h' => 160))),	// crop
			array(480, 267, 480, 320, array(null, 401, array('w' => 401, 'h' => 267))), // crop to given ratio
		);
	}

}