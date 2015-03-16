<?php
class WikiaLogoTest extends WikiaBaseTest
{

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

	public function testGetCentralUrlFromGlobalTitleWhenCentralWikiExists()
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

	public function testGetCentralUrlFromGlobalTitleWhenCentralWikiNotExists()
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
			->will($this->returnCallback(function ($arg) use ($globalTitleMock) {
				if ($arg == 'en') {
					return $globalTitleMock;
				};
				return false;
			}));

		$this->assertEquals($wikiaLogoHelperMock->getCentralUrlForLang('bar'), 'foo');
	}
}
