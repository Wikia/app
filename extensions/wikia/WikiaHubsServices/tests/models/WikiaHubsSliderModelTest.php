<?php

class WikiaHubsSliderModelTest extends WikiaBaseTest {
	/**
	 * (non-PHPdoc)
	 * @see WikiaBaseTest::setUp()
	 */
	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../../WikiaHubsServices.setup.php';
		parent::setUp();
	}

	public function testGetSlidesCount() {
		$model = new WikiaHubsSliderModel();

		$this->assertEquals(5, $model->getSlidesCount());
	}
}
