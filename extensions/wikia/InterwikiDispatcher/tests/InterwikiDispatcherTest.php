<?php

class InterwikiDispatcherTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = dirname( __FILE__ ) . "/../SpecialInterwikiDispatcher.php";
		parent::setUp();
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
				'$expected' =>  'http://muppet.wikia.com/wiki/Elmo'
			],
			[
				'$interwikiPageName' => 'w:c:muppet:NonExisting',
				'$expected' =>  'http://muppet.wikia.com/wiki/NonExisting'
			],
			[
				'$interwikiPageName' => 'c:muppet:Elmo',
				'$expected' =>  ''
			],

		];
	}
}