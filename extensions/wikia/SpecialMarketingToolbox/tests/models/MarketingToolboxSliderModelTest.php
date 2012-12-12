<?

class MarketingToolboxSliderModelTest extends WikiaBaseTest {
	public function testGetSlidesCount() {
		$model = new MarketingToolboxSliderModel();

		$this->assertEquals(5, $model->getSlidesCount());
	}
}