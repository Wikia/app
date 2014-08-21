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

	public function testRedirectIfForeignWiki_not_foreign() {
		$wikiaInteractiveMapsControllerMock = $this->getWikiaInteractiveMapsControllerMock();
		$wikiaInteractiveMapsControllerMock->redirectIfForeignWiki( self::WIKI_CITY_ID, 1 );
	}

	public function testRedirectIfForeignWiki_foreign() {
		$wikiaInteractiveMapsControllerMock = $this->getWikiaInteractiveMapsControllerMock( true );
		$wikiaInteractiveMapsControllerMock->redirectIfForeignWiki( self::WIKI_FOREIGN_CITY_ID, 1 );
	}

	/**
	 * Returns WikiaInteractiveMapsController mock
	 *
	 * @param bool $expectRedirection
	 * @return PHPUnit_Framework_MockObject_MockObject|WikiaInteractiveMapsController
	 */
	private function getWikiaInteractiveMapsControllerMock( $expectRedirection = false ) {
		$mock = $this->getMock( 'WikiaInteractiveMapsController', [ 'getWikiPageUrl' ], [], '', false );

		$mock->expects( $this->any() )
			->method( 'getWikiPageUrl' )
			->will( $this->returnValue( self::WIKI_URL ) );

		//wg
		$mock->wg->CityId = self::WIKI_CITY_ID;

		$outputPageMock = $this->getMock( 'OutputPage', [ 'redirect' ], [], '', false );
		if ( $expectRedirection ) {
			$outputPageMock->expects( $this->once() )
				->method( 'redirect' );
		}
		$mock->wg->out = $outputPageMock;

		return $mock;
	}
}
