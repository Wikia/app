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
	public function testCalculateScaledImageSizes($desiredImageSize, $originalWidth, $originalHeight, $results) {
		$this->assertEquals( ImagesService::calculateScaledImageSizes($desiredImageSize, $originalWidth, $originalHeight), $results);
	}
	
	public function calculateScaledImageSizesDataProvider() {
		$resultSizes = array(
			array('width' => 0, 'height' => 0),
			array('width' => 0, 'height' => 0),
			array('width' => 150, 'height' => 150),
			array('width' => 180, 'height' => 90),
			array('width' => 90, 'height' => 180),
			array('width' => 133, 'height' => 106),
			array('width' => 29, 'height' => 155),
		);
		
		foreach($resultSizes as $data) {
			$result = new stdClass();
			$result->width = $data['width'];
			$result->height = $data['height'];
			$results[] = $result;
		}
		
		return array(
			array(0, 0, 0, $results[0]), 
			array(0, 150, 150, $results[1]),
			array(150, 150, 150, $results[2]),
			array(180, 560, 280, $results[3]),
			array(180, 280, 560, $results[4]),
			array(133, 600, 480, $results[5]),
			array(155, 123, 654, $results[6]),
		);
	}
}
