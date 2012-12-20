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
			array(0, 0),
			array(0, 0),
			array(150, 150),
		);
		foreach($resultSizes as $data) {
			$result = new stdClass();
			$result->width = $data[0];
			$result->height = $data[1];
			$results[] = $result;
		}
		
		var_dump($results);
		
		return array(
			array(0, 0, 0, $results[0]), 
			array(0, 150, 150, $results[1]),
			array(150, 150, 150, $results[2])
		);
	}
}
