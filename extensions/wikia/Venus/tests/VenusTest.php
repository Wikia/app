<?php

class VenusTest extends WikiaBaseTest {

	public function setUp() {
		require_once( dirname(__FILE__) . '/../VenusHooks.class.php');
		parent::setUp();
	}

	/**
	 * @dataProvider testShowVenusSkinDataProvider
	 */
	public function testShowVenusSkin($enableVenusSkin, $enableVenusSpecialSearch, $enableVenusArticle, $isArticlePage,
									  $isSearch, $isSpecialPage, $text, $requestVals, $expected) {
		$wgRequestMock = $this->getMock( 'WebRequest', [ 'getVal' ] );
		$titleMock = $this->getMock( 'Title', [ 'isSpecialPage', 'getText' ] );

		$wgRequestMock->expects($this->any())
			->method('getVal')
			->with($this->logicalOr(
				$this->equalTo('action'),
				$this->equalTo('diff')
			))
			->will($this->returnCallback(
				function($param) use ($requestVals){
					if (isset($requestVals[$param]) ) {
						return $requestVals[$param];
					}
				}
			));

		$titleMock->expects($this->once())
			->method('isSpecialPage')
			->will( $this->returnValue($isSpecialPage) );

		$titleMock->expects($this->any())
			->method('getText')
			->will( $this->returnValue($text) );

		$this->mockStaticMethod( 'WikiaPageType', 'isArticlePage', $isArticlePage );
		$this->mockStaticMethod( 'WikiaPageType', 'isSearch', $isSearch );

		$this->mockGlobalVariable( 'wgEnableVenusSkin', $enableVenusSkin );
		$this->mockGlobalVariable( 'wgEnableVenusSpecialSearch', $enableVenusSpecialSearch );
		$this->mockGlobalVariable( 'wgEnableVenusArticle', $enableVenusArticle );
		$this->mockGlobalVariable( 'wgRequest', $wgRequestMock );

		$result = VenusHooks::showVenusSkin( $titleMock );
		$this->assertEquals($expected, $result);
	}

	public function testShowVenusSkinDataProvider() {
		return [
			// #1 $wgEnableVenusSkin == false
			[
				false, 		// $wgEnableVenusSkin
				true, 		// $wgEnableVenusSpecialSearch
				true, 		// $wgEnableVenusArticle
				true, 		// WikiaPageType::isArticlePage
				false, 		// WikiaPageType::isSearch
				true, 		// Title::isSpecialPage
				'Title', 	// Title::getText
				// $wgRequest values
				[
					'action' => 'view',
					'diff' => ''
				],
				false 		// expected result
			],
			// #2 Search Page & $wgEnableVenusSpecialSearch == true
			[
				true, 		// $wgEnableVenusSkin
				true, 		// $wgEnableVenusSpecialSearch
				false, 		// $wgEnableVenusArticle
				false, 		// WikiaPageType::isArticlePage
				true, 		// WikiaPageType::isSearch
				false, 		// Title::isSpecialPage
				'Title', 	// Title::getText
				// $wgRequest values
				[
					'action' => 'view',
					'diff' => ''
				],
				true 		// expected result
			],
			// #3 Search Page & $wgEnableVenusSpecialSearch == false
			[
				true, 		// $wgEnableVenusSkin
				false, 		// $wgEnableVenusSpecialSearch
				false, 		// $wgEnableVenusArticle
				false, 		// WikiaPageType::isArticlePage
				true, 		// WikiaPageType::isSearch
				false, 		// Title::isSpecialPage
				'Title', 	// Title::getText
				// $wgRequest values
				[
					'action' => 'view',
					'diff' => ''
				],
				false 		// expected result
			],
			// #4 Special:VenusTest
			[
				true, 		// $wgEnableVenusSkin
				false, 		// $wgEnableVenusSpecialSearch
				false, 		// $wgEnableVenusArticle
				false, 		// WikiaPageType::isArticlePage
				false, 		// WikiaPageType::isSearch
				true, 		// Title::isSpecialPage
				'VenusTest', 	// Title::getText
				// $wgRequest values
				[
					'action' => 'view',
					'diff' => ''
				],
				true 		// expected result
			],
			// #5 Special:VenusTestt (typo)
			[
				true, 		// $wgEnableVenusSkin
				false, 		// $wgEnableVenusSpecialSearch
				false, 		// $wgEnableVenusArticle
				false, 		// WikiaPageType::isArticlePage
				false, 		// WikiaPageType::isSearch
				true, 		// Title::isSpecialPage
				'VenusTestt', 	// Title::getText
				// $wgRequest values
				[
					'action' => 'view',
					'diff' => ''
				],
				false 		// expected result
			],
			// #6 Article Page
			[
				true, 		// $wgEnableVenusSkin
				false, 		// $wgEnableVenusSpecialSearch
				true, 		// $wgEnableVenusArticle
				true, 		// WikiaPageType::isArticlePage
				false, 		// WikiaPageType::isSearch
				false, 		// Title::isSpecialPage
				'Test', 	// Title::getText
				// $wgRequest values
				[
					'action' => 'view',
					'diff' => ''
				],
				true 		// expected result
			],
			// #7 Article Page
			[
				true, 		// $wgEnableVenusSkin
				false, 		// $wgEnableVenusSpecialSearch
				true, 		// $wgEnableVenusArticle
				true, 		// WikiaPageType::isArticlePage
				false, 		// WikiaPageType::isSearch
				false, 		// Title::isSpecialPage
				'Test', 	// Title::getText
				// $wgRequest values
				[
					'action' => '',
					'diff' => ''
				],
				true 		// expected result
			],
			// #8 Article Page disabled ($wgEnableVenusArticle == false)
			[
				true, 		// $wgEnableVenusSkin
				false, 		// $wgEnableVenusSpecialSearch
				false, 		// $wgEnableVenusArticle
				true, 		// WikiaPageType::isArticlePage
				false, 		// WikiaPageType::isSearch
				false, 		// Title::isSpecialPage
				'Test', 	// Title::getText
				// $wgRequest values
				[
					'action' => '',
					'diff' => ''
				],
				false 		// expected result
			],
			// #9 Article Page disabled (action == 'edit')
			[
				true, 		// $wgEnableVenusSkin
				false, 		// $wgEnableVenusSpecialSearch
				true, 		// $wgEnableVenusArticle
				true, 		// WikiaPageType::isArticlePage
				false, 		// WikiaPageType::isSearch
				false, 		// Title::isSpecialPage
				'Test', 	// Title::getText
				// $wgRequest values
				[
					'action' => 'edit',
					'diff' => ''
				],
				false 		// expected result
			],
			// #10 Article Page disabled (diff not empty)
			[
				true, 		// $wgEnableVenusSkin
				false, 		// $wgEnableVenusSpecialSearch
				true, 		// $wgEnableVenusArticle
				true, 		// WikiaPageType::isArticlePage
				false, 		// WikiaPageType::isSearch
				false, 		// Title::isSpecialPage
				'Test', 	// Title::getText
				// $wgRequest values
				[
					'action' => '',
					'diff' => 'notEmpty'
				],
				false 		// expected result
			],
		];
	}
} 
