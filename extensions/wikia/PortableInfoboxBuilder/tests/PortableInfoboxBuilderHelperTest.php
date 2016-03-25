<?php

class PortableInfoboxBuilderHelperTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfoboxBuilder.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider titleTextProvider
	 */
	public function testGetUrlPath( $titleText, $expected ) {
		$this->assertEquals( $expected, PortableInfoboxBuilderHelper::getUrlPath( $titleText ) );
	}

	/**
	 * @dataProvider requestModeProvider
	 */
	public function testForcedSourceMode( $queryStringValue, $expectedResult ) {
		$requestMock = $this->getMockBuilder( 'WebRequest' )->setMethods( [ 'getVal' ] )->getMock();
		$requestMock->expects( $this->any() )->method( 'getVal' )->willReturn( $queryStringValue );

		$this->assertEquals( $expectedResult, PortableInfoboxBuilderHelper::isForcedSourceMode( $requestMock ) );
	}

	/**
	 * @dataProvider requestActionProvider
	 */
	public function testActionSubmit( $queryStringValue, $expectedResult ) {
		$requestMock = $this->getMockBuilder( 'WebRequest' )->setMethods( [ 'getVal' ] )->getMock();
		$requestMock->expects( $this->any() )->method( 'getVal' )->willReturn( $queryStringValue );

		$this->assertEquals( $expectedResult, PortableInfoboxBuilderHelper::isSubmitAction( $requestMock ) );
	}

	/**
	 * @dataProvider getTitleProvider
	 */
	public function testGetTitle( $title, $expected ) {
		$status = new Status();
		$this->assertEquals( $expected, PortableInfoboxBuilderHelper::getTitle( $title, $status ) );
	}

	public function titleTextProvider() {
		return [
			[ '', ''],
			[ 'Special:InfoboxBuilder', '' ],
			[ 'Special:InfoboxBuilder/', '' ],
			[ 'Special:InfoboxBuilder/TemplateName', 'TemplateName' ],
			[ 'Special:InfoboxBuilder/TemplateName/Subpage', 'TemplateName/Subpage' ]
		];
	}

	public function requestModeProvider() {
		return [
			[ 'source', true ],
			[ 'mediawiki', false ],
			[ '', false ],
			[ null, false ]
		];
	}

	public function requestActionProvider() {
		return [
			[ 'submit', true ],
			[ 'raw', false ],
			[ 'source', false ],
			[ 'edit', false ],
			[ null, false ]
		];
	}

	public function getTitleProvider() {
		return [
			[ 'testtitle', Title::newFromText( 'testtitle', NS_TEMPLATE ) ],
			[ 't t', Title::newFromText( 't t', NS_TEMPLATE ) ],
			[ '', false ],
			[ null, false ]
		];
	}
}
