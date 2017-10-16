<?php


class InsightsPaginatorTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../InsightsV2.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider providerRemovingCurrentPageParam
	 */
	public function testRemovingCurrentPageParam( $params, $expectedParams ) {
		$paginator = new InsightsPaginator( 'mytestinsightssubpage', $params );

		$this->assertEquals( $expectedParams, $paginator->getParams() );
	}

	/**
	 * @dataProvider providerCurrentPage
	 */
	public function testCurrentPage( $params, $expectedPageNumber ) {
		$paginator = new InsightsPaginator( 'mytestinsightssubpage', $params );

		$this->assertEquals( $expectedPageNumber, $paginator->getPage() );
	}

	/**
	 * @dataProvider providerOffset
	 */
	public function testOffset( $params, $expectedOffset ) {
		$paginator = new InsightsPaginator( 'mytestinsightssubpage', $params );

		$this->assertEquals( $expectedOffset, $paginator->getOffset() );
	}

	public function providerRemovingCurrentPageParam() {
		return [
			[ [], [] ],
			[ [ 'page' => 2 ], [] ],
			[ [ 'page' => 2, 'someOtherParam' => 'abc' ], [ 'someOtherParam' => 'abc' ] ],
			[ [ 'someOtherParam' => 'abc' ], [ 'someOtherParam' => 'abc' ] ]
		];
	}

	public function providerCurrentPage() {
		return [
			[ [], 1 ],
			[ [ 'page' => 1 ], 1 ],
			[ [ 'page' => 2 ], 2 ],
			[ [ 'page' => 2, 'someOtherParam' => 'abc' ], 2 ],
			[ [ 'someOtherParam' => 'abc' ], 1 ]
		];
	}

	public function providerOffset() {
		return [
			[ [], 0 ],
			[ [ 'page' => 2 ], 1 * InsightsPaginator::INSIGHTS_LIST_MAX_LIMIT ],
			[ [ 'page' => 3 ], 2 * InsightsPaginator::INSIGHTS_LIST_MAX_LIMIT ],
			[ [ 'limit' => 30 ], 0 ],
			[ [ 'page' => 3, 'limit' => 30 ], 2 * 30 ],
		];
	}
}
