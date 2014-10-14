<?php

class MarketingToolboxSliderModelTest extends WikiaBaseTest {
	/**
	 * (non-PHPdoc)
	 * @see WikiaBaseTest::setUp()
	 */
	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../../WikiaHubsServices.setup.php';
		parent::setUp();
	}

	public function testGetSlidesCount() {
		$model = new MarketingToolboxSliderModel();

		$this->assertEquals(5, $model->getSlidesCount());
	}
}