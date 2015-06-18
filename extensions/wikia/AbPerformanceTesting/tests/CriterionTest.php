<?php

use Wikia\AbPerformanceTesting\Criterion;
use Wikia\AbPerformanceTesting\Criteria\OasisArticles;
use Wikia\AbPerformanceTesting\Criteria\Traffic;
use Wikia\AbPerformanceTesting\Criteria\Wikis;

class CriterionTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . "/../AbPerformanceTesting.setup.php";
		parent::setUp();
	}

	function testCriterionFactory() {
		$this->assertInstanceOf( 'Wikia\AbPerformanceTesting\Criteria\Traffic', Criterion::factory( 'traffic' ) );
		$this->assertInstanceOf( 'Wikia\AbPerformanceTesting\Criteria\Traffic', Criterion::factory( 'Traffic' ) );
	}

	/**
	 * @expectedException Wikia\AbPerformanceTesting\UnknownCriterionException
	 */
	function testCriterionFactoryErrorHandling() {
		Criterion::factory( 'foobar' );
	}

	function testTrafficCriterion() {
		$this->mockGlobalFunction( 'wfGetBeaconId', '' );
		$this->assertFalse( ( new Traffic() )->matches( 0 ) );

		$this->mockGlobalFunction( 'wfGetBeaconId', '8gQHS-Q4_c' );
		$this->assertTrue( ( new Traffic() )->matches( 87 ) );

		$this->mockGlobalFunction( 'wfGetBeaconId', '3j-YqSr9BQ' );
		$this->assertFalse( ( new Traffic() )->matches( 87 ) );

		$this->mockGlobalFunction( 'wfGetBeaconId', '3j-YqSr9BQ' );
		$this->assertTrue( ( new Traffic() )->matches( 158 ) );

		// ranges matching
		$this->assertFalse( ( new Traffic() )->matches( [140, 150] ) );

		$this->assertTrue( ( new Traffic() )->matches( [150, 160] ) );
		$this->assertTrue( ( new Traffic() )->matches( [158, 160] ) ); // left boundary
		$this->assertTrue( ( new Traffic() )->matches( [150, 158] ) ); // right boundary
	}

	function testWikisCriterion() {
		$this->mockGlobalVariable( 'wgCityId', 5123 );
		$this->assertTrue( ( new Wikis() )->matches( 123 ) );

		$this->mockGlobalVariable( 'wgCityId', 1 );
		$this->assertTrue( ( new Wikis() )->matches( 1 ) );

		$this->mockGlobalVariable( 'wgCityId', 1000 );
		$this->assertTrue( ( new Wikis() )->matches( 0 ) );

		$this->mockGlobalVariable( 'wgCityId', 5123 );
		$this->assertFalse( ( new Wikis() )->matches( 23 ) );
	}

	/**
	 * @dataProvider oasisArticlesCriterionDataProvider
	 */
	function testOasisArticlesCriterion( $skinName, $titleExists, $isContentPage, $expected ) {
		$skinMock = $this->mockClassWithMethods( 'Skin', [
			'getSkinName' => $skinName,

			// required by an abstract class
			'outputPage' => null,
			'setupSkinUserCss' => null,
		] );

		$titleMock =  $this->mockClassWithMethods( 'Title', [
			'exists' => $titleExists,
			'isContentPage' => $isContentPage
		] );

		// mock \RequestContext::getMain()
		$this->mockClassWithMethods( 'RequestContext', [
			'getSkin' => $skinMock,
			'getTitle' => $titleMock,
		], 'getMain' );

		$this->assertEquals( $expected, ( new OasisArticles() )->matches( true ) );
	}

	function oasisArticlesCriterionDataProvider() {
		return [
			// only pass for Oasis and existing content pages
			[
				'skinName' => 'oasis',
				'titleExists' => true,
				'isContentPage' => true,
				'expected' => true,
			],
			// other skin
			[
				'skinName' => 'monobook',
				'titleExists' => true,
				'isContentPage' => true,
				'expected' => false,
			],
			// not existing page
			[
				'skinName' => 'oasis',
				'titleExists' => false,
				'isContentPage' => true,
				'expected' => false,
			],
			// not a content page
			[
				'skinName' => 'oasis',
				'titleExists' => true,
				'isContentPage' => false,
				'expected' => false,
			],
		];
	}
}
