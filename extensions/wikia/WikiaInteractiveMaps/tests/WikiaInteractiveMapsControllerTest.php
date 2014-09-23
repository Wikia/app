<?php
class WikiaInteractiveMapsControllerTest extends WikiaBaseTest {

	const WIKI_URL = 'http://muppet.wikia.com/wiki/Special:Maps';
	const WIKI_CITY_ID = 1;
	const WIKI_FOREIGN_CITY_ID = 2;

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/WikiaInteractiveMaps/WikiaInteractiveMaps.setup.php";
		parent::setUp();
	}

	/**
	 * @covers WikiaInteractiveMapsController::redirectIfForeignWiki
	 */
	public function testRedirectIfForeignWiki_not_foreign() {
		$wikiaInteractiveMapsControllerMock = $this->getControllerMock( 'testRedirectIfForeignWiki' );

		$wikiaInteractiveMapsControllerMock->wg->CityId = self::WIKI_CITY_ID;

		$outputPageMock = $this->getMock( 'OutputPage', [ 'redirect' ], [], '', false );
		$outputPageMock->expects( $this->never() )
			->method( 'redirect' );
		$wikiaInteractiveMapsControllerMock->wg->out = $outputPageMock;

		$wikiaInteractiveMapsControllerMock->redirectIfForeignWiki( self::WIKI_CITY_ID, 1 );
	}

	/**
	 * @covers WikiaInteractiveMapsController::redirectIfForeignWiki
	 */
	public function testRedirectIfForeignWiki_foreign() {
		$wikiaInteractiveMapsControllerMock = $this->getControllerMock( 'testRedirectIfForeignWiki' );

		$wikiaInteractiveMapsControllerMock->wg->CityId = self::WIKI_CITY_ID;

		$outputPageMock = $this->getMock( 'OutputPage', [ 'redirect' ], [], '', false );
		$outputPageMock->expects( $this->once() )
			->method( 'redirect' );
		$wikiaInteractiveMapsControllerMock->wg->out = $outputPageMock;

		$wikiaInteractiveMapsControllerMock->redirectIfForeignWiki( self::WIKI_FOREIGN_CITY_ID, 1 );
	}

	/**
	 * @covers WikiaInteractiveMapsController::map
	 */
	public function testMap_mapNotFound() {
		$exceptionObject = new stdClass();
		$exceptionObject->message = 'Map not found';
		$exceptionObject->details = 'Map with given id (1) was not found.';

		$mapsModelMock = $this->getMock( 'WikiaMaps', [ 'getMapByIdFromApi' ], [], '', false );
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
	 * @covers WikiaInteractiveMapsController::map
	 */
	public function testMap_mapFoundNotRedirected() {
		$mapMock = new stdClass();
		$mapMock->title = 'A Unit Test Map';
		$mapMock->map_id = 123;
		$mapMock->city_id = self::WIKI_CITY_ID;
		$mapMock->deleted = 0;

		$mapsModelMock = $this->getMock( 'WikiaMaps', [ 'getMapByIdFromApi', 'getMapRenderUrl' ], [], '', false );
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
	 * @return PHPUnit_Framework_MockObject_MockObject|WikiaInteractiveMapsController
	 */
	private function getControllerMock( $test ) {
		$mapsControllerMock = null;

		switch( $test ) {
			case 'testRedirectIfForeignWiki':
				$mapsControllerMock = $this->getMock( 'WikiaInteractiveMapsController', [ 'getWikiPageUrl' ], [], '', false );

				$mapsControllerMock->expects( $this->any() )
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

				$mapsControllerMock = $this->getMock( 'WikiaInteractiveMapsController', [
					'getModel',
					'redirectIfForeignWiki',
					'setVal',
					'addAsset',
					'setTemplateEngine',
					'getMenuMarkup'
				], [], '', false );

				$mapsControllerMock->expects( $this->any() )
					->method( 'setVal' );

				$outputPageMock = $this->getMock( 'OutputPage', [], [], '', false );
				$mapsControllerMock->wg->out = $outputPageMock;

				$mapsControllerMock->app = $appMock;
				$mapsControllerMock->request = $requestMock;
				$mapsControllerMock->response = $responseMock;
				break;
		}

		return $mapsControllerMock;
	}

}
