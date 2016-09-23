<?php
class GlobalNavigationTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../GlobalNavigation.setup.php';
		parent::setUp();
	}

	public function testGetCreateNewWikiWhenLangDifferentThanDefault() {
		$globalNavHelperMock = $this->getMock( 'GlobalNavigationHelper', ['createCNWUrlFromGlobalTitle'] );
		$globalNavHelperMock->expects( $this->any() )
			->method( 'createCNWUrlFromGlobalTitle' )
			->will( $this->returnValue( 'bar' ) );

		$this->assertEquals( $globalNavHelperMock->getCreateNewWikiUrl( 'foo' ), 'bar?uselang=foo' );
	}

	public function testGetCreateNewWikiUrlWhenLangIsDefault() {
		$globalNavHelperMock = $this->getMock( 'GlobalNavigationHelper', ['createCNWUrlFromGlobalTitle'] );
		$globalNavHelperMock->expects( $this->any() )
			->method( 'createCNWUrlFromGlobalTitle' )
			->will( $this->returnValue( 'foo' ) );

		$this->assertEquals( $globalNavHelperMock->getCreateNewWikiUrl( 'en' ), 'foo' );
	}
}
