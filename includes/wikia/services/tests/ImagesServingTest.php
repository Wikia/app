<?php
class ImagesServingTest extends WikiaBaseTest {

	/**
	 * @dataProvider calculateScaledImageSizesDataProvider
	 * 
	 * @param $desiredImageSize
	 * @param $originalWidth
	 * @param $originalHeight
	 * @param $results
	 */
	public function testCalculateScaledImageSizes($desiredImageSize, $originalSizes, $results) {
		$expected = new stdClass();
		$expected->width = $results['width'];
		$expected->height = $results['height'];
		
		$result = ImagesService::calculateScaledImageSizes($desiredImageSize, $originalSizes['width'], $originalSizes['height']);
		
		$this->assertEquals($result, $expected);
	}
	
	public function calculateScaledImageSizesDataProvider() {
		return array(
			//edge case #1
			array(
				'desiredImageSize' => 0, 
				'orginalSize' => array(
					'width' => 0,
					'height' => 0,
				),
				'results' => array(
					'width' => 0,
					'height' => 0,
				),
			),
			//edge case #2
			array(
				'desiredImageSize' => 0,
				'orginalSize' => array(
					'width' => 150,
					'height' => 150,
				),
				'results' => array(
					'width' => 0,
					'height' => 0,
				),
			),
			//desired size equals both dimensions of original image
			array(
				'desiredImageSize' => 150,
				'orginalSize' => array(
					'width' => 150,
					'height' => 150,
				),
				'results' => array(
					'width' => 150,
					'height' => 150,
				),
			),
			//desired size is smaller than both dimensions of original image (width is the higher one)
			array(
				'desiredImageSize' => 180,
				'orginalSize' => array(
					'width' => 560,
					'height' => 280,
				),
				'results' => array(
					'width' => 180,
					'height' => 90,
				),
			),
			//desired size is smaller than both dimensions of original image (height is the higher one)
			array(
				'desiredImageSize' => 180,
				'orginalSize' => array(
					'width' => 280,
					'height' => 560,
				),
				'results' => array(
					'width' => 90,
					'height' => 180,
				),
			),
			//desired size is smaller than both dimensions of original image (width is the higher one and desired size is odd)
			array(
				'desiredImageSize' => 133,
				'orginalSize' => array(
					'width' => 600,
					'height' => 480,
				),
				'results' => array(
					'width' => 133,
					'height' => 106,
				),
			),
			//desired size is smaller than one original dimensions of original image (height is the higher one and desired size is odd)
			array(
				'desiredImageSize' => 155,
				'orginalSize' => array(
					'width' => 123,
					'height' => 654,
				),
				'results' => array(
					'width' => 29,
					'height' => 155,
				),
			),
		);
	}
}
