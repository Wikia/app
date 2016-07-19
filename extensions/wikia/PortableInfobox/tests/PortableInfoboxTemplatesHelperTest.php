<?php

class PortableInfoboxTemplatesHelperTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider testsProvider
	 */
	public function testInfoboxParsing( $markup, $expected ) {
		$helper = $this->getMockBuilder( 'Wikia\PortableInfobox\Helpers\PortableInfoboxTemplatesHelper' )
			->setMethods( [ 'fetchContent' ] )->getMock();
		$helper->expects( $this->once() )->method( 'fetchContent' )->will( $this->returnValue( $markup ) );

		$result = $helper->parseInfoboxes( new Title() );

		$this->assertEquals( $expected, $result );
	}

	public function testsProvider() {
		return [
			[ 'test', false ],
			[ '<includeonly><infobox><data source="test"><label>1</label></data></infobox></includeonly>',
			  [ [ 'data' => [ ], 'sourcelabels' => [ 'test' => 1 ] ] ] ],
			[ '<includeonly></includeonly><infobox></infobox>', false ],
			[ '<includeonly><infobox></infobox></includeonly> ', [ [ 'data' => [ ], 'sourcelabels' => [ ] ] ] ],
			[ '<nowiki><includeonly><infobox></infobox></includeonly></nowiki>', false ],
			[ '<includeonly><nowiki><infobox></infobox></nowiki></includeonly>', false ],
		];
	}
}
