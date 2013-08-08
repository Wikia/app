<?php
class SpecialCssHooksTest extends WikiaBaseTest {

	protected function setUp () {
		require_once( dirname(__FILE__) . '/../SpecialCssHooks.class.php');
		require_once( dirname(__FILE__) . '/../SpecialCssModel.class.php');
		require_once( dirname(__FILE__) . '/../SpecialCssController.class.php');
		parent::setUp();
	}

	/**
	 * @dataProvider testShouldRedirectDataProvider
	 */
	public function testShouldRedirect( $isExtensionEnabled, $isWikiaCssTitle, $isSkinRight, $isUserAllowed, $isRedirectExpected, $assertionMessage ) {

		$specialCssModelMock = $this->getMock( 'SpecialCssModel', array( 'isWikiaCssTitle' ) );
		$specialCssModelMock->expects( $this->any() )
			->method( 'isWikiaCssTitle' )
			->will( $this->returnValue( $isWikiaCssTitle ) );

		$userMock = $this->getMock( 'User', array( 'isAllowed' ) );
		$userMock->expects( $this->any() )
			->method( 'isAllowed' )
			->will( $this->returnValue( $isUserAllowed ) );

		$this->mockGlobalVariable( 'wgEnableSpecialCssExt', $isExtensionEnabled );
		$this->mockGlobalVariable( 'wgUser', $userMock );

		$appMock = $this->getMock( 'WikiaApp', array( 'checkSkin' ) );
		$appMock->expects( $this->any() )
			->method( 'checkSkin' )
			->will( $this->returnValue( $isSkinRight ) );

		$class = new ReflectionClass( 'SpecialCssHooks' );
		$method = $class->getMethod( 'shouldRedirect' );
		$method->setAccessible( true );

		$specialCssHooks = new SpecialCssHooks();
		$result = $method->invokeArgs( $specialCssHooks, array( $appMock, $specialCssModelMock, 1 ) );
		$this->assertEquals( $isRedirectExpected, $result, $assertionMessage );
	}

	public function testShouldRedirectDataProvider() {
		return [
			[
				'isExtensionEnabled' => true,
				'isCssWikiaArticle' => true,
				'isSkinRight' => true,
				'isUserAllowed' => true,
				'isRedirectExpected' => true,
				'assertionMessage' => "The Special:CSS extension is enabled, user is allowed to use it and she visits Wikia.css article's edit page in oasis skin -- redirection should happen"
			],
			[
				'isExtensionEnabled' => false,
				'isCssWikiaArticle' => true,
				'isSkinRight' => true,
				'isUserAllowed' => true,
				'isRedirectExpected' => false,
				'assertionMessage' => 'The Special:CSS extension is disabled despite other factors are correct the redirection should NOT happen'
			],
			[
				'isExtensionEnabled' => true,
				'isCssWikiaArticle' => false,
				'isSkinRight' => true,
				'isUserAllowed' => true,
				'isRedirectExpected' => false,
				'assertionMessage' => 'The current article is not wikia css - the redirection should NOT happen'
			],
			[
				'isExtensionEnabled' => true,
				'isCssWikiaArticle' => true,
				'isSkinRight' => false,
				'isUserAllowed' => true,
				'isRedirectExpected' => false,
				'assertionMessage' => 'The current skin is not oasis - the redirection should NOT happen'
			],
			[
				'isExtensionEnabled' => true,
				'isCssWikiaArticle' => true,
				'isSkinRight' => true,
				'isUserAllowed' => false,
				'isRedirectExpected' => false,
				'assertionMessage' => 'The current user is not allowed to edit css - the redirection should NOT happen'
			],

		];
	}

	public function testRemoveNamespace() {
		$removeNamespaceMethod = new ReflectionMethod('SpecialCssHooks', 'removeNamespace');
		$removeNamespaceMethod->setAccessible(true);

		$langMock = $this->getMock( 'Language', array( 'getNsText' ) );
		$langMock->expects( $this->once() )
			->method( 'getNsText' )
			->will( $this->returnValue( 'Category' ) );

		$this->mockGlobalVariable( 'wgContLang', $langMock );

		$categories = ['Category:Abc', 'Category:Def', 'Category:123', 'Category:1 a 2 b 3 c', 'Kategoria:Raz', 'Something'];
		$expected = ['Abc', 'Def', '123', '1 a 2 b 3 c', 'Kategoria:Raz', 'Something'];

		$this->assertEquals( $expected, $removeNamespaceMethod->invoke( new SpecialCssHooks(), $categories ) );
	}

	/**
	 * @dataProvider testGetCategoriesFromWikitextDataProvider
	 */
	public function testGetCategoriesFromWikitext($mockedResultsFromCategorySelect, $categorySelectEnabled, $expected, $assertionMessage) {
		/** @var $specialCssHooksMock PHPUnit_Framework_MockObject_MockObject */
		$specialCssHooksMock = $this->getMockClass( 'SpecialCssHooks', [ 'getCategoriesFromCategorySelect' ] );
		$specialCssHooksMock::staticExpects( $this->any() )
			->method( 'getCategoriesFromCategorySelect' )
			->will( $this->returnValue( $mockedResultsFromCategorySelect ) );

		$this->mockGlobalVariable( 'wgEnableCategorySelectExt', $categorySelectEnabled );

		/** @var $specialCssHooksMock SpecialCssHooks */
		$this->assertEquals( $expected, $specialCssHooksMock::getCategoriesFromWikitext( 'wikitext' ), $assertionMessage );
	}

	public function testGetCategoriesFromWikitextDataProvider() {
		return [
			[
				'mockedResultsFromCategorySelect' => [ 'categories' => [ ['name' => 'CSS Updates' ], [ 'name' => 'Test' ] ] ],
				'categorySelectEnabled' => true,
				'expected' => ['CSS_Updates', 'Test'],
				'assertionMessage' => 'All fine'
			],
			[
				'mockedResultsFromCategorySelect' => [ 'categories' => [ ['name' => 'CSS Updates' ], [ 'name' => 'Test' ] ] ],
				'categorySelectEnabled' => false,
				'expected' => [],
				'assertionMessage' => 'CategorySelect disabled'
			],
			[
				'mockedResultsFromCategorySelect' => [ 'cats' => [ ['name' => 'CSS Updates' ], [ 'name' => 'Test' ] ] ],
				'categorySelectEnabled' => true,
				'expected' => [],
				'assertionMessage' => 'Invalid CategorySelect results'
			]
		];
	}

}
