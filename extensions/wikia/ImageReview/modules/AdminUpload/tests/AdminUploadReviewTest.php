<?php
class AdminUploadReviewTest extends WikiaBaseTest {
	private $corporatePagesWithVisualization = array(
		'en' => 123,
		'de' => 345,
	);

	/**
	 * @dataProvider adminUploadReviewSpecialControllerDataProvider
	 */
	public function testAdminUploadReviewSpecialControllerIsVisualizationOn($lang, $expected) {
		$this->mockGlobalVariable('wgCorporatePagesWithVisualization', $this->corporatePagesWithVisualization);

		$adminUploadReviewController = F::build('AdminUploadReviewSpecialController');
		$this->assertEquals($expected, $adminUploadReviewController->isVisualizationOn($lang));
	}

	public function adminUploadReviewSpecialControllerDataProvider() {
		return array(
			array('en', true),
			array('EN', true),
			array('En', true),
			array('de', true),
			array('', false),
			array('pl', false),
		);
	}

}