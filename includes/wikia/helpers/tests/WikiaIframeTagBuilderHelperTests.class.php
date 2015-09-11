<?php
class WikiaIframeTagBuilderHelperTests extends WikiaBaseTest {

	public function setUp() {
		parent::setUp();
	}

	public function testWrapForMobile() {
		$helper = new WikiaIframeTagBuilderHelper();
		$this->getMethodMock( $helper, 'isMobileSkin' )
			->expects( $this->any() )
			->method( 'isMobileSkin' )
			->will( $this->returnValue( true ) );

		$html = '<iframe />';
		$expectedResult = '<script type="x-wikia-widget"><iframe /></script>';

		$this->assertSame( $helper->wrapForMobile($html), $expectedResult );
	}
}
