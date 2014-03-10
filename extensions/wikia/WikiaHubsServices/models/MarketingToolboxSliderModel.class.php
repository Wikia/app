<?
class MarketingToolboxSliderModel extends WikiaModel {
	const SLIDES_COUNT = 5;
	const IMAGE_WIDTH = 160;
	const IMAGE_HEIGHT = 100;

	public function getSlidesCount() {
		return self::SLIDES_COUNT;
	}
}
