<?php
class SpecialCssHooksTest extends WikiaBaseTest {

	protected function setUp () {
		require_once( dirname(__FILE__) . '/../SpecialCssHooks.class.php');
	}

	/**
	 * @dataProvider testShouldRedirectDataProvider
	 */
	public function testShouldRedirect($isExtensionEnabled, $isCssWikiaArticle, $isSkinRight, $isUserAllowed, $isRedirectExpected) {
		$this->markTestSkipped('work in progress...');
		
		$specialCssModelMock = $this->getMock('SpecialCssModel', array('isWikiaCssArticle'));
		$specialCssModelMock->expects($this->once())
			->method('isWikiaCssArticle')
			->will($this->returnValue($isCssWikiaArticle));

		$userMock = $this->getMock('User', array('isAllowed'));
		$userMock->expects($this->any())
			->method('isAllowed')
			->will($this->returnValue($isUserAllowed));
		
		$this->mockGlobalVariable('wgEnableSpecialCssExt', $isExtensionEnabled);
		$this->mockGlobalVariable('wgUser', $userMock);
		$this->mockGlobalFunction('checkSkin', $isSkinRight);
		$this->mockApp();
		
		$class = new ReflectionClass('SpecialCssHooks');
		$method = $class->getMethod('shouldRedirect');
		$method->setAccessible(true);

		$specialCssHooks = new SpecialCssHooks();
		$result = $method->invokeArgs($specialCssHooks, array($this->app, $specialCssModelMock, 1));
		$this->assertEquals($result, $isRedirectExpected);
	}
	
	public function testShouldRedirectDataProvider() {
		return [
			// the Special:CSS extension is enabled, user is allowed to use it and she visits Wikia.css article's edit page in oasis skin -- redirection should happen
			[
				'isExtensionEnabled' => true,
				'isCssWikiaArticle' => true,
				'isSkinRight' => true,
				'isUserAllowed' => true,
				'isRedirectExpected' => true,
			],
			// the Special:CSS extension is disabled despite other factors are correct the redirection should NOT happen
			[
				'isExtensionEnabled' => false,
				'isCssWikiaArticle' => true,
				'isSkinRight' => true,
				'isUserAllowed' => true,
				'isRedirectExpected' => false,
			]
		];
	}
	
}