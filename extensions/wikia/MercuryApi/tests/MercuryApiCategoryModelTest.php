<?php

class MercuryApiCategoryModelTest extends WikiaBaseTest {

	/**
	 * @param $availablePages
	 * @param $page
	 * @param $expected
	 *
	 *
	 * @dataProvider paginationProvider
	 */
	public function testGetPagination( $availablePages, $page, $expected ) {
		$this->mockStaticMethod( 'MercuryApiCategoryModel', 'getNumberOfPagesAvailable', $availablePages );

		$this->assertEquals( $expected, MercuryApiCategoryModel::getPagination( Title::newFromText( 'nothing_important' ), $page ) );
	}

	public function paginationProvider() {
		return [
			[
				'availablePages' => 0,
				'page' => 0,
				'expected' => [
					'nextPage' => null,
					'nextPageUrl' => null,
					'prevPage' => null,
					'prevPageUrl' => null
				]
			],
			[
				'availablePages' => 10,
				'page' => 0,
				'expected' => [
					'nextPage' => 1,
					'nextPageUrl' => '/wiki/Nothing_important',
					'prevPage' => null,
					'prevPageUrl' => null
				]
			],
			[
				'availablePages' => 10,
				'page' => 1,
				'expected' => [
					'nextPage' => 2,
					'nextPageUrl' => '/wiki/Nothing_important?page=2',
					'prevPage' => null,
					'prevPageUrl' => null
				]
			],
			[
				'availablePages' => 10,
				'page' => 2,
				'expected' => [
					'nextPage' => 3,
					'nextPageUrl' => '/wiki/Nothing_important?page=3',
					'prevPage' => 1,
					'prevPageUrl' => '/wiki/Nothing_important'
				]
			],
			[
				'availablePages' => 10,
				'page' => 3,
				'expected' => [
					'nextPage' => 4,
					'nextPageUrl' => '/wiki/Nothing_important?page=4',
					'prevPage' => 2,
					'prevPageUrl' => '/wiki/Nothing_important?page=2'
				]
			],
			[
				'availablePages' => 10,
				'page' => 10,
				'expected' => [
					'nextPage' => null,
					'nextPageUrl' => null,
					'prevPage' => 9,
					'prevPageUrl' => '/wiki/Nothing_important?page=9'
				]
			],
		];
	}
}