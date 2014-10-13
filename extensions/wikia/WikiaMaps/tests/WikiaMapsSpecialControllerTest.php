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
	public function testIndex_main() {
		$wikiaMapsSpecialControllerMock = $this->getControllerMockForIndexTest( null, null );

		$wikiaMapsSpecialControllerMock->expects( $this->once() )
			->method( 'forward' )
			->with( 'WikiaMapsSpecial', 'main' );

		$wikiaMapsSpecialControllerMock->index();
	}

	/**
	 * @covers WikiaMapsSpecialController::index
	 */
	public function testIndex_map() {
		$wikiaMapsSpecialControllerMock = $this->getControllerMockForIndexTest( 1, null );

		$wikiaMapsSpecialControllerMock->expects( $this->once() )
			->method( 'forward' )
			->with( 'WikiaMapsSpecial', 'map' );

		$wikiaMapsSpecialControllerMock->index();
	}

	/**
	 * @covers WikiaMapsSpecialController::index
	 */
	public function testIndex_mapData() {
		$wikiaMapsSpecialControllerMock = $this->getControllerMockForIndexTest( 1, '_escaped_fragment_' );

		$wikiaMapsSpecialControllerMock->expects( $this->once() )
			->method( 'forward' )
			->with( 'WikiaMapsSpecial', 'mapData' );

		$wikiaMapsSpecialControllerMock->index();
	}

	/**
	 * @param mixed $par Value to be returned by getPar() method
	 * @param mixed $val Value to be returned by getRequest()->getVal() method
	 * @return PHPUnit_Framework_MockObject_MockObject|WikiaMapsSpecialController
	 */
	public function getControllerMockForIndexTest( $par, $val ) {
		$wikiaMapsSpecialControllerMock = $this->getControllerMock( 'testIndex' );

		$wikiaMapsSpecialControllerMock->expects( $this->once() )
			->method( 'getPar' )
			->will( $this->returnValue( $par ) );

		$requestMock = $this->getMock( 'WikiaRequest', [ 'getVal' ], [], '', false );
		$requestMock->expects( $this->any() )
			->method( 'getVal' )
			->will( $this->returnValue( $val ) );

		$wikiaMapsSpecialControllerMock->expects( $this->any() )
			->method( 'getRequest' )
			->will( $this->returnValue( $requestMock ) );

		return $wikiaMapsSpecialControllerMock;
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

		$mapsControllerMock = $this->getControllerMock( 'testMap' );
		$mapsControllerMock->expects( $this->once() )
			->method( 'getModel' )
			->will( $this->returnValue( $mapsModelMock ) );
		$mapsControllerMock->expects( $this->never() )
			->method( 'redirectIfForeignWiki' );

		$mapsControllerMock->map();
	}

	/**
	 * @covers WikiaMapsSpecialController::map
	 */
	public function testMap_mapFoundNotRedirected() {
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

		$mapsControllerMock = $this->getControllerMock( 'testMap' );
		$mapsControllerMock->expects( $this->once() )
			->method( 'getModel' )
			->will( $this->returnValue( $mapsModelMock ) );
		$mapsControllerMock->expects( $this->once() )
			->method( 'redirectIfForeignWiki' );
		$mapsControllerMock->expects( $this->once() )
			->method( 'getMenuMarkup' );

		$mapsControllerMock->wg->CityId = self::WIKI_CITY_ID;

		$mapsControllerMock->map();
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
					'redirectIfForeignWiki',
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
