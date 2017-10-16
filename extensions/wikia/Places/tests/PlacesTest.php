<?php

class PlacesTest extends WikiaBaseTest {

	private $attribs;

	/* @var PlaceModel */
	private $model;

	protected function setUp() {
		$this->setupFile = __DIR__ . '/../Places.setup.php';
		parent::setUp();

		$this->attribs = array(
			'align' => 'right',
			'width' => 300,
			'caption' => 'Foo',
			'lat' => '52.406878',
			'lon' => '16.922124',
		);

		$this->model = PlaceModel::newFromAttributes($this->attribs);

		// use main page as an article for this place
		$this->model->setPageId(1);

		// mock Title object
		$this->mockClassWithMethods('Title', [
			'exists' => true
		], 'newFromId');
	}

	function testPlaceModelNewFromAttributes() {
		$this->assertInstanceOf('PlaceModel', $this->model);

		$this->assertEquals('right', $this->model->getAlign());
		$this->assertEquals(300, $this->model->getWidth());
		$this->assertEquals(52.406878, $this->model->getLat());
		$this->assertEquals(16.922124, $this->model->getLon());
		$this->assertEquals('Foo', $this->model->getCaption());
		$this->assertEquals("52° 24.413' N 16° 55.327' E", $this->model->getDefaultCaption());

		// check lat/lon storage precision
		$this->model->setLat('52.406878001');
		$this->assertEquals(52.406878001, $this->model->getLat());
	}

	function testPlaceFromAttributes() {
		$resp = $this->app->sendRequest('Places', 'placeFromAttributes', array('attributes' => $this->attribs));
		$html = $resp->toString();

		$this->assertContains('<img class="thumbimage" src="http://maps.googleapis.com/maps/api/staticmap', $html);
		$this->assertContains('<meta itemprop="latitude" content="52.406878">', $html);
		$this->assertContains('<meta itemprop="longitude" content="16.922124">', $html);
	}

	function testPlaceFromModel() {
		$resp = $this->app->sendRequest('Places', 'placeFromModel', array('model' => $this->model));
		$html = $resp->toString();

		$this->assertContains('<img class="thumbimage" src="http://maps.googleapis.com/maps/api/staticmap', $html);
		$this->assertContains('<meta itemprop="latitude" content="52.406878">', $html);
		$this->assertContains('<meta itemprop="longitude" content="16.922124">', $html);
	}

	function testRenderMarkers() {
		$resp = $this->app->sendRequest('Places', 'renderMarkers', array('markers' => array($this->model)));
		$html = $resp->toString();

		$this->assertContains('class="places-map"', $html);
		$this->assertContains('JSSnippetsStack.push', $html);
		$this->assertContains('"markers":[{"lat":52.406878,"lan":16.922124,', $html);
	}

	function testGetPlaceWikiTextFromModel() {
		$resp = $this->app->sendRequest('Places', 'getPlaceWikiTextFromModel', array('model' => $this->model));
		$html = $resp->toString();

		$this->assertEquals("<place width='300' lat='52.406878' lon='16.922124' />", $html);
	}

	function testGetDistanceTo() {
		$dest = PlaceModel::newFromAttributes( [
			'lat' => '52.38720549',
			'lon' => '16.95263382',
		] );

		$this->assertEquals( 0, $this->model->getDistanceTo( $this->model ) );
		$this->assertEquals( 3012, $this->model->getDistanceTo( $dest ) );
	}
}
