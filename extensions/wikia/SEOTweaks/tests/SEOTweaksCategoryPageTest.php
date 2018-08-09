<?php

use PHPUnit\Framework\MockObject\MockObject;

/**
 * @group Integration
 */
class SEOTweaksCategoryPageTest extends WikiaDatabaseTest {
	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../SEOTweaksHooksHelper.class.php';
	}

	protected function getDataSet()	{
		return $this->createYamlDataSet( __DIR__ . '/fixtures/category_page.yaml' );
	}

	/**
	 * @dataProvider provideOnCategoryPageView
	 * @param $pageId
	 * @param $statusCode
	 */
	public function testOnCategoryPageView( $pageId, $statusCode ) {
		$categoryPage = CategoryPage::newFromID( $pageId );

		$outputMock = $this->createMock( OutputPage::class );

		/** @var MockObject|IContextSource $contextMock */
		$contextMock = $this->createMock( IContextSource::class );
		$contextMock->method( 'getOutput' )->willReturn( $outputMock );

		$categoryPage->setContext( $contextMock );

		if ( $statusCode === null ) {
			$outputMock->expects( $this->never() )->method( 'setStatusCode' );
		} else {
			$outputMock->expects( $this->once() )->method( 'setStatusCode' )->with( $statusCode );
		}

		SEOTweaksHooksHelper::onCategoryPageView( $categoryPage );
	}

	public function provideOnCategoryPageView(): Generator {
		yield [ 1, null ];
		yield [ 2, 404 ];
		yield [ 3, 404 ];
	}
}
