<?php
class WikiaSearchHelperTest extends WikiaBaseTest {

	public function testGetLangForSearchResultsIfResultsLangSet() {
		$wgRequestMock = $this->getMock( 'WebRequest', [ 'getVal' ] );
		$wgRequestMock->expects( $this->any() )
			->method( 'getVal' )
			->will( $this->returnValue( 'foo' ) );
		$this->mockGlobalVariable( 'wgRequest', $wgRequestMock );

		$wikiaSearchHelper = new WikiaSearchHelper();

		$this->assertEquals( $wikiaSearchHelper->getLangForSearchResults(), 'foo' );
	}

	public function testGetLangForSearchResultsIfResultsLangNotSet() {
		$wgRequestMock = $this->getMock( 'WebRequest', [ 'getVal' ] );
		$wgRequestMock->expects( $this->any() )
			->method( 'getVal' )
			->will( $this->returnValue( null ) );
		$this->mockGlobalVariable( 'wgRequest', $wgRequestMock );

		$this->mockGlobalVariable( 'wgLanguageCode', 'bar' );

		$wikiaSearchHelper = new WikiaSearchHelper();

		$this->assertEquals( $wikiaSearchHelper->getLangForSearchResults(), 'bar' );
	}
}
