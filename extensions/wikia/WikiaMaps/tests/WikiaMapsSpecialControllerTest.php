<?php
class WikiaMapsSpecialControllerTest extends WikiaBaseTest {

	const WIKI_URL = 'http://muppet.wikia.com/wiki/Special:Maps';
	const WIKI_CITY_ID = 1;
	const WIKI_FOREIGN_CITY_ID = 2;

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/WikiaMaps/WikiaMaps.setup.php";
		parent::setUp();
	}

	/**
	 * @covers WikiaMapsSpecialController::index
	 */
	public function testIndex_forwardToMain() {
		$wikiaMapsSpecialControllerMock = $this->getControllerMock( 'testIndex' );
		$this->setValToBeReturned( $wikiaMapsSpecialControllerMock, null );

		$wikiaMapsSpecialControllerMock->expects( $this->once() )
			->method( 'getPar' )
			->will( $this->returnValue( null ) );

		$wikiaMapsSpecialControllerMock->expects( $this->once() )
			->method( 'forward' )
			->with( 'WikiaMapsSpecial', 'main' );

		$wikiaMapsSpecialControllerMock->index();
	}

	/**
	 * @covers WikiaMapsSpecialController::index
	 */
	public function testIndex_forwardToMap() {
		$wikiaMapsSpecialControllerMock = $this->getControllerMock( 'testIndex' );
		$this->setValToBeReturned( $wikiaMapsSpecialControllerMock, null );

		$wikiaMapsSpecialControllerMock->expects( $this->once() )
			->method( 'getPar' )
			->will( $this->returnValue( 1 ) );

		$wikiaMapsSpecialControllerMock->expects( $this->once() )
			->method( 'forward' )
			->with( 'WikiaMapsSpecial', 'map' );

		$wikiaMapsSpecialControllerMock->index();
	}

	/**
	 * @covers WikiaMapsSpecialController::index
	 */
	public function testIndex_forwardToMapData() {
		$wikiaMapsSpecialControllerMock = $this->getControllerMock( 'testIndex' );
		$this->setValToBeReturned( $wikiaMapsSpecialControllerMock, '_escaped_fragment_' );

		$wikiaMapsSpecialControllerMock->expects( $this->once() )
			->method( 'getPar' )
			->will( $this->returnValue( 1 ) );

		$wikiaMapsSpecialControllerMock->expects( $this->once() )
			->method( 'forward' )
			->with( 'WikiaMapsSpecial', 'mapData' );

		$wikiaMapsSpecialControllerMock->index();
	}

	/**
	 * @covers WikiaMapsSpecialController::map
	 */
	public function testMap_mapNotFound() {
		$exceptionObject = new stdClass();
		$exceptionObject->message = 'Map not found';
		$exceptionObject->details = 'Map with given id (1) was not found.';

		$mapsModelMock = $this->getWikiaMapsMock();
		$mapsModelMock->expects( $this->once() )
			->method( 'getMapByIdFromApi' )
			->will( $this->returnValue( $exceptionObject ) );

		$wikiaMapsSpecialControllerMock = $this->getControllerMock( 'testMap' );
		$wikiaMapsSpecialControllerMock->expects( $this->once() )
			->method( 'getModel' )
			->will( $this->returnValue( $mapsModelMock ) );
		$wikiaMapsSpecialControllerMock->expects( $this->never() )
			->method( 'prepareSingleMapPage' );
		$wikiaMapsSpecialControllerMock->expects( $this->once() )
			->method( 'mapNotFound' );

		$wikiaMapsSpecialControllerMock->map();
	}

	/**
	 * @covers WikiaMapsSpecialController::map
	 */
	public function testMap_mapFound() {
		$mapMock = new stdClass();
		$mapMock->title = 'A Unit Test Map';
		$mapMock->map_id = 123;
		$mapMock->city_id = self::WIKI_CITY_ID;
		$mapMock->deleted = 0;

		$mapsModelMock = $this->getWikiaMapsMock();
		$mapsModelMock->expects( $this->once() )
			->method( 'getMapByIdFromApi' )
			->will( $this->returnValue( $mapMock ) );
		$mapsModelMock->expects( $this->once() )
			->method( 'getMapRenderUrl' );

		$wikiaMapsSpecialControllerMock = $this->getControllerMock( 'testMap' );
		$wikiaMapsSpecialControllerMock->expects( $this->once() )
			->method( 'getModel' )
			->will( $this->returnValue( $mapsModelMock ) );
		$wikiaMapsSpecialControllerMock->expects( $this->once() )
			->method( 'prepareSingleMapPage' );
		$wikiaMapsSpecialControllerMock->expects( $this->once() )
			->method( 'getMenuMarkup' );

		$wikiaMapsSpecialControllerMock->wg->CityId = self::WIKI_CITY_ID;

		$wikiaMapsSpecialControllerMock->map();
	}

	/**
	 * @covers WikiaMapsSpecialController::mapData
	 */
	public function testMapData_mapNotFound() {
		$exceptionObject = new stdClass();
		$exceptionObject->message = 'Map not found';
		$exceptionObject->details = 'Map with given id (1) was not found.';

		$mapsModelMock = $this->getWikiaMapsMock();
		$mapsModelMock->expects( $this->once() )
			->method( 'getMapDataByIdFromApi' )
			->will( $this->returnValue( $exceptionObject ) );

		$wikiaMapsSpecialControllerMock = $this->getControllerMock( 'testMapData' );

		$wikiaMapsSpecialControllerMock->expects( $this->once() )
			->method( 'getModel' )
			->will( $this->returnValue( $mapsModelMock ) );
		$wikiaMapsSpecialControllerMock->expects( $this->never() )
			->method( 'prepareSingleMapPage' );
		$wikiaMapsSpecialControllerMock->expects( $this->once() )
			->method( 'mapNotFound' );

		$wikiaMapsSpecialControllerMock->mapData();
	}

	/**
	 * @covers WikiaMapsSpecialController::mapData
	 */
	public function testMapData_mapFound() {
		$mapDataMock = new stdClass();
		$mapDataMock->title = 'A Unit Test Map';
		$mapDataMock->map_id = 123;
		$mapDataMock->city_id = self::WIKI_CITY_ID;
		$mapDataMock->deleted = 0;

		$mapsModelMock = $this->getWikiaMapsMock();
		$mapsModelMock->expects( $this->once() )
			->method( 'getMapDataByIdFromApi' )
			->will( $this->returnValue( $mapDataMock ) );

		$wikiaMapsSpecialControllerMock = $this->getControllerMock( 'testMapData' );
		$wikiaMapsSpecialControllerMock->expects( $this->once() )
			->method( 'getModel' )
			->will( $this->returnValue( $mapsModelMock ) );
		$wikiaMapsSpecialControllerMock->expects( $this->once() )
			->method( 'prepareSingleMapPage' );
		$wikiaMapsSpecialControllerMock->expects( $this->once() )
			->method( 'getMenuMarkup' );
		$wikiaMapsSpecialControllerMock->expects( $this->once() )
			->method( 'prepareListOfPois' );

		$wikiaMapsSpecialControllerMock->mapData();
	}

	/**
	 * @covers WikiaMapsSpecialController::redirectIfForeignWiki
	 */
	public function testRedirectIfForeignWiki_not_foreign() {
		$wikiaMapsSpecialControllerMock = $this->getControllerMock( 'testRedirectIfForeignWiki' );

		$wikiaMapsSpecialControllerMock->wg->CityId = self::WIKI_CITY_ID;

		$outputPageMock = $this->getMock( 'OutputPage', [ 'redirect' ], [], '', false );
		$outputPageMock->expects( $this->never() )
			->method( 'redirect' );
		$wikiaMapsSpecialControllerMock->wg->out = $outputPageMock;

		$wikiaMapsSpecialControllerMock->redirectIfForeignWiki( self::WIKI_CITY_ID, 1 );
	}

	/**
	 * @covers WikiaMapsSpecialController::redirectIfForeignWiki
	 */
	public function testRedirectIfForeignWiki_foreign() {
		$wikiaMapsSpecialControllerMock = $this->getControllerMock( 'testRedirectIfForeignWiki' );

		$wikiaMapsSpecialControllerMock->wg->CityId = self::WIKI_CITY_ID;

		$outputPageMock = $this->getMock( 'OutputPage', [ 'redirect' ], [], '', false );
		$outputPageMock->expects( $this->once() )
			->method( 'redirect' );
		$wikiaMapsSpecialControllerMock->wg->out = $outputPageMock;

		$wikiaMapsSpecialControllerMock->redirectIfForeignWiki( self::WIKI_FOREIGN_CITY_ID, 1 );
	}

	/**
	 * @param PHPUnit_Framework_MockObject_MockObject|WikiaMapsSpecialController $wikiaMapsSpecialControllerMock
	 * @param mixed $val Value to be returned by getRequest()->getVal() method
	 */
	private function setValToBeReturned( $wikiaMapsSpecialControllerMock, $val ) {
		$requestMock = $this->getMock( 'WikiaRequest', [ 'getVal' ], [], '', false );
		$requestMock->expects( $this->any() )
			->method( 'getVal' )
			->will( $this->returnValue( $val ) );

		$wikiaMapsSpecialControllerMock->expects( $this->any() )
			->method( 'getRequest' )
			->will( $this->returnValue( $requestMock ) );
	}

	/**
	 * @param String $test Name of test/test group basic on which proper mock object will be returned
	 * @return PHPUnit_Framework_MockObject_MockObject|WikiaMapsSpecialController
	 */
	private function getControllerMock( $test ) {
		$mapsSpecialControllerMock = null;

		switch( $test ) {
			case 'testIndex':
				$mapsSpecialControllerMock = $this->getMock( 'WikiaMapsSpecialController', [ 'getPar', 'getRequest', 'forward' ], [], '', false );
				$outputPageMock = $this->getMock( 'OutputPage', [], [], '', false );
				$mapsSpecialControllerMock->wg->out = $outputPageMock;
				break;

			case 'testRedirectIfForeignWiki':
				$mapsSpecialControllerMock = $this->getMock( 'WikiaMapsSpecialController', [ 'getWikiPageUrl' ], [], '', false );

				$mapsSpecialControllerMock->expects( $this->any() )
					->method( 'getWikiPageUrl' )
					->will( $this->returnValue( self::WIKI_URL ) );
				break;

			case 'testMap':
				$appMock = $this->getMock( 'WikiaApp', [ 'checkSkin' ], [], '', false );
				$appMock->expects( $this->once() )
					->method( 'checkSkin' )
					->will( $this->returnValue(false) );

				$requestMock = $this->getMock( 'WikiaRequest', [ 'getInt' ], [], '', false );
				$requestMock->expects( $this->any() )
					->method( 'getInt' )
					->will( $this->returnValue(1) );

				$responseMock = $this->getMock( 'WikiaResponse', [ 'addAsset', 'setTemplateEngine' ], [], '', false );
				$responseMock->expects( $this->once() )
					->method( 'addAsset' );
				$responseMock->expects( $this->once() )
					->method( 'setTemplateEngine' );

				$mapsSpecialControllerMock = $this->getMock( 'WikiaMapsSpecialController', [
					'getModel',
					'prepareSingleMapPage',
					'mapNotFound',
					'setVal',
					'addAsset',
					'setTemplateEngine',
					'getMenuMarkup'
				], [], '', false );

				$mapsSpecialControllerMock->expects( $this->any() )
					->method( 'setVal' );

				$outputPageMock = $this->getMock( 'OutputPage', [], [], '', false );
				$mapsSpecialControllerMock->wg->out = $outputPageMock;

				$mapsSpecialControllerMock->app = $appMock;
				$mapsSpecialControllerMock->request = $requestMock;
				$mapsSpecialControllerMock->response = $responseMock;
				break;

			case 'testMapData':
				$requestMock = $this->getMock( 'WikiaRequest', [], [], '', false );

				$responseMock = $this->getMock( 'WikiaResponse', [ 'addAsset', 'setTemplateEngine' ], [], '', false );
				$responseMock->expects( $this->once() )
					->method( 'addAsset' );
				$responseMock->expects( $this->once() )
					->method( 'setTemplateEngine' );

				$mapsSpecialControllerMock = $this->getMock( 'WikiaMapsSpecialController', [
					'getModel',
					'prepareSingleMapPage',
					'mapNotFound',
					'prepareListOfPois',
					'setVal',
					'addAsset',
					'setTemplateEngine',
					'getMenuMarkup'
				], [], '', false );

				$mapsSpecialControllerMock->expects( $this->any() )
					->method( 'setVal' );

				$outputPageMock = $this->getMock( 'OutputPage', [], [], '', false );
				$mapsSpecialControllerMock->wg->out = $outputPageMock;

				$mapsSpecialControllerMock->request = $requestMock;
				$mapsSpecialControllerMock->response = $responseMock;
				break;
		}

		return $mapsSpecialControllerMock;
	}

	private function getWikiaMapsMock() {
		$wikiaMapsMock = $this->getMockBuilder('WikiaMaps')
			->setMethods( [ 'getMapByIdFromApi', 'getMapDataByIdFromApi', 'getMapRenderUrl', 'getMapRenderParams' ] )
			->disableOriginalConstructor()
			->getMock();

		$wikiaMapsMock->expects( $this->any() )
			->method( 'getMapRenderParams' )
			->willReturn( [ 'uselang' => 'en' ] );

		return $wikiaMapsMock;
	}
}
