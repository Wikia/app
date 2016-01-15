<?php
class WikiaLogoTest extends WikiaBaseTest
{

	const FANDOM_URL = WikiaLogoHelper::FANDOM_URL;

	public function setUp()
	{
		$this->setupFile = __DIR__ . '/../WikiaLogo.setup.php';
		parent::setUp();
	}

	public function testGetCentralUrlForLangWhenCentralWikiExists()
	{
		$globalTitleMock = $this->getMock( 'GlobalTitle', ['getServer'] );
		$globalTitleMock->expects( $this->any() )
			->method( 'getServer' )
			->will( $this->returnValue( 'foo' ) );

		$wikiaLogoHelperMock = $this->getMock(
			'WikiaLogoHelper', ['getCentralWikiUrlForLangIfExists']
		);
		$wikiaLogoHelperMock->expects( $this->any() )
			->method( 'getCentralWikiUrlForLangIfExists' )
			->will( $this->returnValue( $globalTitleMock ) );

		$this->assertEquals( $wikiaLogoHelperMock->getCentralUrlForLang( 'bar' ), 'foo' );
	}

	public function testGetCentralUrlForLangWhenCentralWikiExistsInWgLangToCentralMap()
	{
		$this->mockGlobalVariable( 'wgLangToCentralMap', ['foo' => 'bar'] );

		$wikiaLogoHelperMock = $this->getMock( 'WikiaLogoHelper', ['getCentralWikiUrlForLangIfExists'] );
		$wikiaLogoHelperMock->expects( $this->any() )
			->method( 'getCentralWikiUrlForLangIfExists' )
			->will( $this->returnValue( false ) );

		$this->assertEquals( $wikiaLogoHelperMock->getCentralUrlForLang( 'foo' ), 'bar' );
	}

	public function testGetCentralUrlForLangWhenCentralWikiDoesNotExist()
	{
		$this->mockGlobalVariable( 'wgLangToCentralMap', null );

		$globalTitleMock = $this->getMock( 'GlobalTitle', ['getServer'] );
		$globalTitleMock->expects( $this->any() )
			->method( 'getServer' )
			->will( $this->returnValue( 'foo' ) );

		$wikiaLogoHelperMock = $this->getMock(
			'WikiaLogoHelper', ['getCentralWikiUrlForLangIfExists']
		);
		$wikiaLogoHelperMock->expects( $this->any() )
			->method( 'getCentralWikiUrlForLangIfExists' )
			->will( $this->returnCallback( function ( $arg ) use ( $globalTitleMock ) {
				if ( $arg == 'en' ) {
					return $globalTitleMock;
				} ;
				return false;
			} ) );

		$this->assertEquals( $wikiaLogoHelperMock->getCentralUrlForLang( 'fizz' ), 'foo' );
	}

	/**
	 * @dataProvider isFandomExposedDataProvider
	 * @param $wgEnableGlobalNav2016Value
	 * @param $wgLanguageCodeValue
	 * @param $expectedResult
	 */
	public function testIsFandomExposed( $wgEnableGlobalNav2016Value, $wgLanguageCodeValue, $expectedResult )
	{
		$this->mockGlobalVariable( 'wgEnableGlobalNav2016', $wgEnableGlobalNav2016Value );
		$this->mockGlobalVariable( 'wgLanguageCode', $wgLanguageCodeValue );

		$this->assertEquals( ( new WikiaLogoHelper() )->isFandomExposed(), $expectedResult );
	}

	public function isFandomExposedDataProvider() {
		return [
			[false, WikiaLogoHelper::FANDOM_LANG, false],
			[false, 'de', false],
			[true, 'de', false],
			[true, WikiaLogoHelper::FANDOM_LANG, true]
		];
	}
}
