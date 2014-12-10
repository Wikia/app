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
			'GlobalNavigationHelper', ['getCentralWikiUrlForLangIfExists']
		);
		$globalNavHelperMock->expects( $this->any() )
			->method( 'getCentralWikiUrlForLangIfExists' )
			->will( $this->returnValue( $globalTitleMock ) );

		$this->assertEquals( $globalNavHelperMock->getCentralUrlForLang( 'bar' ), 'foo' );
	}

	public function testGetCentralUrlForLangWhenCentralWikiExistsInWgLangToCentralMap() {
		$this->mockGlobalVariable( 'wgLangToCentralMap', ['foo' => 'bar'] );

		$globalNavHelperMock = $this->getMock( 'GlobalNavigationHelper', ['getCentralWikiUrlForLangIfExists'] );
		$globalNavHelperMock->expects( $this->any() )
			->method( 'getCentralWikiUrlForLangIfExists' )
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
			'GlobalNavigationHelper', ['getCentralWikiUrlForLangIfExists']
		);
		$globalNavHelperMock->expects( $this->any() )
			->method( 'getCentralWikiUrlForLangIfExists' )
			->will( $this->returnCallback(function($arg) use ($globalTitleMock){
				if ($arg == 'en') {
					return $globalTitleMock;
				};
				return false;
			}));

		$this->assertEquals( $globalNavHelperMock->getCentralUrlForLang( 'fizz' ), 'foo' );
	}

	public function testGetCentralUrlFromGlobalTitleWhenCentralWikiExists() {
		$globalTitleMock = $this->getMock( 'GlobalTitle', ['getServer'] );
		$globalTitleMock->expects( $this->any() )
			->method( 'getServer' )
			->will( $this->returnValue( 'foo' ) );

		$globalNavHelperMock = $this->getMock(
			'GlobalNavigationHelper', ['getCentralWikiUrlForLangIfExists']
		);
		$globalNavHelperMock->expects( $this->any() )
			->method( 'getCentralWikiUrlForLangIfExists' )
			->will( $this->returnValue($globalTitleMock));

		$this->assertEquals( $globalNavHelperMock->getCentralUrlForLang( 'bar' ), 'foo' );
	}

	public function testGetCentralUrlFromGlobalTitleWhenCentralWikiNotExists() {
		$globalTitleMock = $this->getMock( 'GlobalTitle', ['getServer'] );
		$globalTitleMock->expects( $this->any() )
			->method( 'getServer' )
			->will( $this->returnValue( 'foo' ) );

		$globalNavHelperMock = $this->getMock(
			'GlobalNavigationHelper', ['getCentralWikiUrlForLangIfExists']
		);
		$globalNavHelperMock->expects( $this->any() )
			->method( 'getCentralWikiUrlForLangIfExists' )
			->will( $this->returnCallback(function($arg) use ($globalTitleMock){
				if ($arg == 'en') {
					return $globalTitleMock;
				};
				return false;
			}));

		$this->assertEquals( $globalNavHelperMock->getCentralUrlForLang( 'bar' ), 'foo' );
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

	public function testGetLangForSearchResultsIfResultsLangSet() {
		$wgRequestMock = $this->getMock( 'WebRequest', [ 'getVal' ] );
		$wgRequestMock->expects($this->any())
			->method('getVal')
			->will($this->returnValue('foo'));
		$this->mockGlobalVariable('wgRequest', $wgRequestMock);

		$globalNavHelper = new GlobalNavigationHelper();

		$this->assertEquals($globalNavHelper->getLangForSearchResults(), 'foo');
	}

	public function testGetLangForSearchResultsIfResultsLangNotSet() {
		$wgRequestMock = $this->getMock( 'WebRequest', [ 'getVal' ] );
		$wgRequestMock->expects($this->any())
			->method('getVal')
			->will($this->returnValue(null));
		$this->mockGlobalVariable('wgRequest', $wgRequestMock);

		$wgLangMock = $this->getMock( 'Language', [ 'getCode' ] );
		$wgLangMock->expects($this->any())
			->method('getCode')
			->will($this->returnValue('bar'));
		$this->mockGlobalVariable('wgLang', $wgLangMock);

		$globalNavHelper = new GlobalNavigationHelper();

		$this->assertEquals($globalNavHelper->getLangForSearchResults(), 'bar');
	}
}
