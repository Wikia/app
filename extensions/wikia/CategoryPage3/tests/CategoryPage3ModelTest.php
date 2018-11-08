<?php

/**
 * @group Integration
 */
class CategoryPage3ModelTest extends WikiaDatabaseTest {
	protected function setUp() {
		$this->setupFile = __DIR__ . '/../CategoryPage3Hooks.class.php';
		parent::setUp();
	}

	/**
	 * @dataProvider modelDataProvider
	 *
	 * @param string|null $from
	 * @param array $expectedMembers
	 * @param array $expectedPagination
	 * @throws FatalError
	 * @throws MWException
	 */
	public function testModel( $from, $expectedMembers, $expectedPagination ) {
		$model = new CategoryPage3Model( Title::newFromID( 1 ), $from );
		$model->setMembersPerPageLimit( 2 );
		$model->loadData();

		$this->assertEquals(
			8,
			$model->getTotalNumberOfMembers(),
			'Total number of members is correct'
		);

		$membersGroupedByChar = $model->getMembersGroupedByChar();

		foreach ( $expectedMembers as $expectedMember ) {
			/** @var CategoryPage3Member $memberToCheck */
			$memberToCheck = $membersGroupedByChar[ $expectedMember['firstChar'] ][ $expectedMember['positionInGroup'] ];

			$this->assertEquals(
				$expectedMember['title'],
				$memberToCheck->getTitle()->getText(),
				"Page '${expectedMember['title']}' is in the correct position"
			);
		}

		$pagination = $model->getPagination();
		$this->assertEquals(
			$expectedPagination,
			$pagination->toArray(),
			'Pagination is set correctly'
		);
	}

	public function modelDataProvider(): Generator {
		yield [
			null,
			[
				[
					'title' => 'Oh Page 1',
					'firstChar' => 'O',
					'positionInGroup' => 0
				],
				[
					'title' => 'Page 2',
					'firstChar' => 'P',
					'positionInGroup' => 0
				]
			],
			[
				'isPrevPageTheFirstPage' => false,
				'firstPageUrl' => null,
				'prevPageKey' => null,
				'prevPageUrl' => null,
				'nextPageKey' => 'Page 3',
				'nextPageUrl' => 'http://firefly.wikia.com/wiki/Category:CategoryA?from=Page+3',
				'lastPageKey' => 'Page 7',
				'lastPageUrl' => 'http://firefly.wikia.com/wiki/Category:CategoryA?from=Page+7'
			]
		];
		yield [
			'Page 3',
			[
				[
					'title' => 'Page 3',
					'firstChar' => 'P',
					'positionInGroup' => 0
				],
				[
					'title' => 'Page 4',
					'firstChar' => 'P',
					'positionInGroup' => 1
				]
			],
			[
				'isPrevPageTheFirstPage' => true,
				'firstPageUrl' => null,
				'prevPageKey' => 'Oh Page 1',
				'prevPageUrl' => 'http://firefly.wikia.com/wiki/Category:CategoryA',
				'nextPageKey' => 'Page 5',
				'nextPageUrl' => 'http://firefly.wikia.com/wiki/Category:CategoryA?from=Page+5',
				'lastPageKey' => 'Page 7',
				'lastPageUrl' => 'http://firefly.wikia.com/wiki/Category:CategoryA?from=Page+7'
			]
		];
		yield [
			'Page 5',
			[
				[
					'title' => 'Page 5',
					'firstChar' => 'P',
					'positionInGroup' => 0
				],
				[
					'title' => 'Page 6',
					'firstChar' => 'P',
					'positionInGroup' => 1
				]
			],
			[
				'isPrevPageTheFirstPage' => false,
				'firstPageUrl' => 'http://firefly.wikia.com/wiki/Category:CategoryA',
				'prevPageKey' => 'Page 3',
				'prevPageUrl' => 'http://firefly.wikia.com/wiki/Category:CategoryA?from=Page+3',
				'nextPageKey' => 'Page 7',
				'nextPageUrl' => 'http://firefly.wikia.com/wiki/Category:CategoryA?from=Page+7',
				'lastPageKey' => 'Page 7',
				'lastPageUrl' => null
			]
		];
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/category_page3_model.yaml' );
	}
}
