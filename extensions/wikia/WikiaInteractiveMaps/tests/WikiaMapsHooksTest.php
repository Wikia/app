<?php
class WikiaMapsHooksTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/WikiaInteractiveMaps/WikiaInteractiveMaps.setup.php";
		parent::setUp();
	}

	/**
	 * @dataProvider isSpecialMapsSingleMapPageDataProvider
	 */
	public function testIsSpecialMapsSingleMapPage( $subpageText, $expected ) {
		$wgTitleMock = $this->getMock( 'wgTitle', [ 'getSubpageText' ], [], '', false );
		$wgTitleMock->expects( $this->any() )
			->method( 'getSubpageText' )
			->willReturn( $subpageText );

		$this->mockGlobalVariable( 'wgTitle', $wgTitleMock );

		$this->getMock( 'WikiaInteractiveMapsController', [ 'getWikiPageUrl' ], [], '', false );

		$this->assertEquals( $expected, WikiaInteractiveMapsHooks::isSpecialMapsSingleMapPage() );
	}

	public function isSpecialMapsSingleMapPageDataProvider() {
		return [
			[
				'wgTitle' => 'Maps',
				'expected' => false
			],
			[
				'wgTitle' => 'Maps/',
				'expected' => false
			],
			[
				'wgTitle' => 'Maps/123',
				'expected' => true
			],
			[
				'wgTitle' => 'Maps/asd',
				'expected' => false
			],
		];
	}
}
