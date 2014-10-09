<?php
class WikiaMapsHooksTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/WikiaMaps/WikiaMaps.setup.php";
		parent::setUp();
	}

	/**
	 * @dataProvider isSingleMapPageDataProvider
	 */
	public function testIsSingleMapPage( $subpageText, $expected ) {
		$wgTitleMock = $this->getMock( 'wgTitle', [ 'getSubpageText' ], [], '', false );
		$wgTitleMock->expects( $this->any() )
			->method( 'getSubpageText' )
			->willReturn( $subpageText );

		$this->mockGlobalVariable( 'wgTitle', $wgTitleMock );

		$this->getMock( 'WikiaMapsSpecialController', [ 'getWikiPageUrl' ], [], '', false );

		$this->assertEquals( $expected, WikiaMapsHooks::isSingleMapPage() );
	}

	public function isSingleMapPageDataProvider() {
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
