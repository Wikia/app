<?php

class MonetizationModuleTest extends WikiaBaseTest {

	const TEST_CITY_ID = 79860;

	protected $orgSkin;

	public function setUp() {
		$this->setupFile = dirname( __FILE__ ).'/../MonetizationModule.setup.php';
		parent::setUp();

		$this->mockCache();
	}

	protected function mockCache( $value = null ) {
		$mock_cache = $this->getMock( 'stdClass', [ 'get', 'set', 'delete' ] );
		$mock_cache->expects( $this->any() )
			->method('get')
			->will( $this->returnValue( $value ) );
		$mock_cache->expects( $this->any() )
			->method( 'set' );
		$mock_cache->expects( $this->any())
			->method( 'delete' );

		$this->mockGlobalVariable( 'wgMemc', $mock_cache );
		$this->mockGlobalVariable( 'wgCityId', self::TEST_CITY_ID );
	}

	protected function setUpSkin( $skinName ) {
		$skin = Skin::newFromKey( $skinName );
		$this->orgSkin = RequestContext::getMain()->getSkin();
		RequestContext::getMain()->setSkin( $skin );
	}

	protected function tearDownSkin() {
		RequestContext::getMain()->setSkin( $this->orgSkin );
	}

	protected function mockUser( $isAnon = true ) {
		$user = $this->getMock( 'User', [ 'isAnon' ] );
		$user->expects( $this->any() )
			->method( 'isAnon' )
			->will( $this->returnValue( $isAnon ) );
		$this->mockGlobalVariable( 'wgUser', $user );
	}

	protected function mockTitle( $pageExists = true, $isMainPage = false, $namespace = 0 ) {
		$title = $this->getMock( 'Title', [ 'exists', 'isMainPage', 'getNamespace' ] );
		$title->expects( $this->any() )
			->method( 'exists' )
			->will( $this->returnValue( $pageExists ) );
		$title->expects( $this->any() )
			->method( 'isMainPage' )
			->will( $this->returnValue( $isMainPage ) );
		$title->expects( $this->any() )
			->method( 'getNamespace' )
			->will( $this->returnValue( $namespace ) );

		return $title;
	}

	/**
	 * @dataProvider canShowModuleDataProvider
	 */
	public function testCanShowModule( $corporatePage, $pageExists, $mainPage, $ns, $actionPage, $skin, $anon, $exp ) {
		$this->setUpSkin( $skin );

		$this->mockGlobalVariable( 'wgContentNamespaces', [ 0 ] );

		$this->mockStaticMethod( 'WikiaPageType', 'isCorporatePage', $corporatePage );
		$this->mockStaticMethod( 'WikiaPageType', 'isActionPage', $actionPage );

		$this->mockUser( $anon );
		$title = $this->mockTitle(  $pageExists, $mainPage, $ns );

		$result = MonetizationModuleHelper::canShowModule( $title );
		$this->assertEquals( $exp, $result );

		$this->tearDownSkin();
	}

	public function canShowModuleDataProvider() {
		return [
			// Module shown - article page
			[ false, true, false, NS_MAIN, false, 'oasis', true, true ],
			// Module shown - file page
			[ false, true, false, NS_FILE, false, 'oasis', true, true ],
			// Module not shown - blog page
			[ false, true, false, NS_BLOG_ARTICLE, false, 'oasis', true, false ],
			// Module not shown - category page
			[ false, true, false, NS_CATEGORY, false, 'oasis', true, false ],
			// Module not shown - help page
			[ false, true, false, NS_HELP, false, 'oasis', true, false ],
			// Module not shown - user page
			[ false, true, false, NS_USER, false, 'oasis', true, false ],
			// Module not shown - corporate page
			[ true, true, false, NS_MAIN, false, 'oasis', true, false ],
			// Module not shown - page not found
			[ false, false, false, NS_MAIN, false, 'oasis', true, false ],
			// Module not shown - action page
			[ false, false, false, NS_MAIN, true, 'oasis', true, false ],
			// Module not shown - wikia mobile skin
			[ false, false, false, NS_MAIN, true, 'wikiamobile', true, false ],
			// Module not shown - monobook skin
			[ false, false, false, NS_MAIN, true, 'monobook', true, false ],
			// Module not shown - logged in user
			[ false, true, false, NS_MAIN, false, 'oasis', false, false ],
		];
	}

	/**
	 * @dataProvider getWikiVerticalDataProvider
	 */
	public function testGetWikiVertical( $verticalId, $exp ) {
		$this->mockGlobalVariable( 'wgCityId', self::TEST_CITY_ID );
		$this->mockStaticMethod( 'WikiFactoryHub', 'getVerticalId', $verticalId );

		$helper = new MonetizationModuleHelper();
		$vertical = $helper->getWikiVertical();
		$this->assertEquals( $exp, $vertical );
	}

	public function getWikiVerticalDataProvider() {
		$expOther = 'other';
		return [
			[ null, $expOther ],
			[ 0, $expOther ],
			[ '0', $expOther ],
			[ '9999', $expOther ],
			[ '1', 'tv' ],
			[ '2', 'gaming' ],
			[ '5', 'lifestyle' ],
		];
	}

}
