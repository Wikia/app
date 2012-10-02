<?php

class WikiaHomePageImageResizeTest extends WikiaBaseTest {

	public function setUp() {
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
		$helper = F::build('WikiaHomePageHelper');
		$params = $helper->getImageServingParamsForResize($requestedWidth, $requestedHeight, $originalWidth, $originalHeight);
		$this->assertEquals($expParams, $params);
	}

	public function testGetImageResizeParamsDataProvider() {
		return array(
			array(320, 320, 320, 320, array(null, 320, array('w' => 320, 'h' => 320))),
			array(480, 320, 320, 320, array(null, 320, array('w' => 320, 'h' => 320))),
			array(320, 480, 320, 320, array(null, 320, array('w' => 320, 'h' => 320))),
			array(320, 320, 480, 320, array(null, 320, array('w' => 320, 'h' => 214))),
			array(320, 320, 320, 480, array(null, 320, array('w' => 214, 'h' => 320))),
			array(480, 320, 560, 374, array(null, 480, array('w' => 480, 'h' => 320))),
			array(330, 210, 330, 160, array(null, 330, array('w' => 330, 'h' => 160))),
		);
	}

}