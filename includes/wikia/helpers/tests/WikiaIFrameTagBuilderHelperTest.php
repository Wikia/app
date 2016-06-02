<?php
class WikiaIFrameTagBuilderHelperTest extends WikiaBaseTest {

	public function setUp() {
		require_once( __DIR__ . '/../WikiaIFrameTagBuilderHelper.class.php' );
		parent::setUp();
	}

	public function testWrapForMobileOnMobile() {
		$helper = new WikiaIFrameTagBuilderHelper();

		$this->getMethodMock( 'WikiaTagBuilderHelper', 'isMobileSkin' )
			->expects( $this->any() )
			->method( 'isMobileSkin' )
			->will( $this->returnValue( true ) );

		$html = '<iframe src="http://example.com" />';
		$expectedResult = '<script type="x-wikia-widget">' . $html . '</script>';

		$this->assertSame( $helper->wrapForMobile( $html ), $expectedResult );
	}

	public function testWrapForMobileOnDesktop() {
		$helper = new WikiaIFrameTagBuilderHelper();

		$this->getMethodMock( 'WikiaTagBuilderHelper', 'isMobileSkin' )
			->expects( $this->any() )
			->method( 'isMobileSkin' )
			->will( $this->returnValue( false ) );

		$html = '<iframe src="http://example.com" />';
		$expectedResult = $html;

		$this->assertSame( $helper->wrapForMobile( $html ), $expectedResult );
	}
}
