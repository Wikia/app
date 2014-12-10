<?php
class GlobalNavigationTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../GlobalNavigation.setup.php';
		parent::setUp();
	}

	public function testGetCentralUrlForLangWhenCentralWikiExists() {
		$globalTitleMock = $this->getMock( 'GlobalTitle', ['getServer'] );
		$globalTitleMock->expects( $this->any() )
			->method( 'getServer' )
			->will( $this->returnValue( 'foo' ) );

		$globalNavHelperMock = $this->getMock(
			'GlobalNavigationHelper', ['centralWikiInLangExists', 'getCentralWikiTitleForLang']
		);
		$globalNavHelperMock->expects( $this->any() )
			->method( 'centralWikiInLangExists' )
			->will( $this->returnValue( true ) );
		$globalNavHelperMock->expects( $this->any() )
			->method( 'getCentralWikiTitleForLang' )
			->will( $this->returnValue( $globalTitleMock ) );

		$this->assertEquals( $globalNavHelperMock->getCentralUrlForLang( 'bar' ), 'foo' );
	}

	public function testGetCentralUrlForLangWhenCentralWikiExistsInWgLangToCentralMap() {
		$this->mockGlobalVariable( 'wgLangToCentralMap', ['foo' => 'bar'] );

		$globalNavHelperMock = $this->getMock( 'GlobalNavigationHelper', ['centralWikiInLangExists'] );
		$globalNavHelperMock->expects( $this->any() )
			->method( 'centralWikiInLangExists' )
			->will( $this->returnValue( false ) );

		$this->assertEquals( $globalNavHelperMock->getCentralUrlForLang( 'foo' ), 'bar' );
	}

	public function testGetCentralUrlForLangWhenCentralWikiDoesNotExist() {
		$this->mockGlobalVariable( 'wgLangToCentralMap', null );

		$globalTitleMock = $this->getMock( 'GlobalTitle', ['getServer'] );
		$globalTitleMock->expects( $this->any() )
			->method( 'getServer' )
			->will( $this->returnValue( 'foo' ) );

		$globalNavHelperMock = $this->getMock(
			'GlobalNavigationHelper', ['centralWikiInLangExists', 'getCentralWikiTitleForLang']
		);
		$globalNavHelperMock->expects( $this->any() )
			->method( 'centralWikiInLangExists' )
			->will( $this->returnValue( null ) );
		$globalNavHelperMock->expects( $this->any() )
			->method( 'getCentralWikiTitleForLang' )
			->will( $this->returnValue( $globalTitleMock ) );

		$this->assertEquals( $globalNavHelperMock->getCentralUrlForLang( 'fizz' ), 'foo' );
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
