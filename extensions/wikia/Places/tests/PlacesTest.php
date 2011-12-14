<?php

require_once dirname(__FILE__) . '/../Places.setup.php';

class PlacesTest extends WikiaBaseTest {

	function testNewFromAttributes() {
		$attribs = array(
			'align' => 'right',
			'width' => 300,
			'caption' => 'Foo',
			'lat' => '52.406878',
			'lon' => '16.922124',
		);

		$model = F::build('PlaceModel', array($attribs), 'newFromAttributes');

		$this->assertInstanceOf('PlaceModel', $model);
		var_dump($model);

		$this->assertEquals(0, $model->getPageId());
		$this->assertEquals('right', $model->getAlign());
		$this->assertEquals(300, $model->getWidth());
		$this->assertEquals(52.406878, $model->getLat());
		$this->assertEquals(16.922124, $model->getLon());
		$this->assertEquals('Foo', $model->getCaption());
		$this->assertEquals("52° 24.413' N 16° 55.327' E", $model->getDefaultCaption());

		// check lat/lon storage precision
		$model->setLat('52.406878001');
		$this->assertEquals(52.406878001, $model->getLat());
	}
}
