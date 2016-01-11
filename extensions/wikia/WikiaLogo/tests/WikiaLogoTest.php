<?php
class WikiaLogoTest extends WikiaBaseTest
{

	const FANDOM_URL = WikiaLogoHelper::FANDOM_URL;
	const CORP_PAGE_URL = 'wikia.com';

	public function setUp()
	{
		$this->setupFile = __DIR__ . '/../WikiaLogo.setup.php';
		parent::setUp();
	}

	public function testGetCentralUrlForLangWhenCentralWikiExists()
	{
		$globalTitleMock = $this->getMock('GlobalTitle', ['getServer']);
		$globalTitleMock->expects($this->any())
			->method('getServer')
			->will($this->returnValue('foo'));

		$wikiaLogoHelperMock = $this->getMock(
			'WikiaLogoHelper', ['getCentralWikiUrlForLangIfExists']
		);
		$wikiaLogoHelperMock->expects($this->any())
			->method('getCentralWikiUrlForLangIfExists')
			->will($this->returnValue($globalTitleMock));

		$this->assertEquals($wikiaLogoHelperMock->getCentralUrlForLang('bar'), 'foo');
	}

	public function testGetCentralUrlForLangWhenCentralWikiExistsInWgLangToCentralMap()
	{
		$this->mockGlobalVariable('wgLangToCentralMap', ['foo' => 'bar']);

		$wikiaLogoHelperMock = $this->getMock('WikiaLogoHelper', ['getCentralWikiUrlForLangIfExists']);
		$wikiaLogoHelperMock->expects($this->any())
			->method('getCentralWikiUrlForLangIfExists')
			->will($this->returnValue(false));

		$this->assertEquals($wikiaLogoHelperMock->getCentralUrlForLang('foo'), 'bar');
	}

	public function testGetCentralUrlForLangWhenCentralWikiDoesNotExist()
	{
		$this->mockGlobalVariable('wgLangToCentralMap', null);

		$globalTitleMock = $this->getMock('GlobalTitle', ['getServer']);
		$globalTitleMock->expects($this->any())
			->method('getServer')
			->will($this->returnValue('foo'));

		$wikiaLogoHelperMock = $this->getMock(
			'WikiaLogoHelper', ['getCentralWikiUrlForLangIfExists']
		);
		$wikiaLogoHelperMock->expects($this->any())
			->method('getCentralWikiUrlForLangIfExists')
			->will($this->returnCallback(function ($arg) use ($globalTitleMock) {
				if ($arg == 'en') {
					return $globalTitleMock;
				};
				return false;
			}));

		$this->assertEquals($wikiaLogoHelperMock->getCentralUrlForLang('fizz'), 'foo');
	}

	/**
	 * @dataProvider getMainCorpPageURLDataProvider
	 * @param $wgEnableGlobalNav2016Value
	 * @param $wgLangValue
	 * @param $wgLanguageCodeValue
	 * @param $expectedResult
	 */
	public function testGetMainCorpPageURL($wgEnableGlobalNav2016Value, $wgLangValue, $wgLanguageCodeValue, $expectedResult)
	{
		global $wgLang;

		$this->mockGlobalVariable('wgEnableGlobalNav2016', $wgEnableGlobalNav2016Value);
		$wgLang = Language::factory( $wgLangValue );
		$this->mockGlobalVariable('wgLanguageCode', $wgLanguageCodeValue);

		$wikiaLogoHelperMock = $this->getMock(
			'WikiaLogoHelper', ['getCentralUrlForLang']
		);
		$wikiaLogoHelperMock->expects($this->any())
			->method('getCentralUrlForLang')
			->will($this->returnValue(self::CORP_PAGE_URL));

		$this->assertEquals($wikiaLogoHelperMock->getMainCorpPageURL(), $expectedResult);
	}

	public function getMainCorpPageURLDataProvider() {
		return [
			[false, 'en', WikiaLogoHelper::FANDOM_LANG, self::CORP_PAGE_URL],
			[true, 'en', 'de', self::CORP_PAGE_URL],
			[true, 'de', WikiaLogoHelper::FANDOM_LANG, self::FANDOM_URL],
			[true, 'de', 'de', self::CORP_PAGE_URL]
		];
	}
}
