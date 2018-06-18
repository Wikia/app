<?php

class InterwikiDispatcherTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = dirname( __FILE__ ) . "/../SpecialInterwikiDispatcher.php";
		parent::setUp();

		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
		$this->mockGlobalVariable( 'wgDevelEnvironment', false );
	}
	/**
	 * @param string $interwikiPageName
	 * @param $expected
	 *
	 * @dataProvider interwikiaUrlDataProvider
	 */
	public function testGetInterwikiaUrl( string $interwikiPageName, string $expected ) {
		$t = Title::newFromText( $interwikiPageName );
		$this->assertEquals( $expected, InterwikiDispatcher::getInterWikiaURL( $t ) );
	}

	public function interwikiaUrlDataProvider() {
		return [
			[
				'$interwikiPageName' => 'w:c:muppet:Elmo',
				'$expected' =>  '//muppet.wikia.com/wiki/Elmo'
			],
			[
				'$interwikiPageName' => 'w:c:muppet:NonExisting',
				'$expected' =>  '//muppet.wikia.com/wiki/NonExisting'
			],
			[
				'$interwikiPageName' => 'c:muppet:Elmo',
				'$expected' =>  ''
			],

		];
	}
}
