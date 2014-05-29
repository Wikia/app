<?php
/**
 * User: artur
 * Date: 15.05.13
 * Time: 18:26
 */

class RevisionServiceTests extends WikiaBaseTest {

	public function testGetLatestRevisions() {
		// $query = "SELECT rc_id as id, page_id as pageId, rc_timestamp as timestamp, rc_user as userId FROM `recentchanges` JOIN `page` ON ((rc_cur_id=page_id)) WHERE (rc_bot=0) AND (page_namespace in ('0','13')) ORDER BY rc_id DESC LIMIT 200";
		$query = "any";

		$dbMock = $this->getMock('StdClass', array( 'selectSQLText', 'query', 'addQuotes' ));
		$dbMock->expects($this->exactly(2))
			->method('addQuotes')
			->will($this->returnValueMap( [ [0, "'0'"], [13, "'13'"] ] ));
		$dbMock->expects($this->once())
			->method('selectSQLText')
			->with(array('recentchanges', 'page')
				, 'rc_id as id, page_id as pageId, rc_timestamp as timestamp, rc_user as userId'
				, array('rc_bot=0', 'page_namespace in (\'0\',\'13\')')
				, 'RevisionService::getLatestRevisionsQuery'
				, array( 'LIMIT' => 199, 'ORDER BY' => 'rc_id DESC' )
				, array( 'page' => array( "JOIN", "rc_cur_id=page_id" ) ))
			->will($this->returnValue($query));
		$dbMock->expects($this->once())
			->method('query')
			->with( $query )
			->will($this->returnValue('fake result'));

		$revisionService = new RevisionService( $dbMock, 0 );

		$result = $revisionService->getLatestRevisionsQuery( 199, array(0,13) );

		$this->assertEquals("fake result", $result);
	}

	public function testGetLatestRevisions_namespaces_is_null() {
		$query = "any";

		$dbMock = $this->getMock('StdClass', array( 'selectSQLText', 'query', 'addQuotes' ));
		$dbMock->expects($this->once())
			->method('selectSQLText')
			->with(array('recentchanges')
				, 'rc_id as id, page_id as pageId, rc_timestamp as timestamp, rc_user as userId'
				, array('rc_bot=0')
				, 'RevisionService::getLatestRevisionsQuery'
				, array( 'LIMIT' => 199, 'ORDER BY' => 'rc_id DESC' )
				, array( ))
			->will($this->returnValue($query));
		$dbMock->expects($this->once())
			->method('query')
			->with( $query )
			->will($this->returnValue('fake result'));

		$revisionService = new RevisionService( $dbMock, 0 );

		$result = $revisionService->getLatestRevisionsQuery( 199, null );

		$this->assertEquals("fake result", $result);
	}

	public function testFilterDuplicates_test_filtering_by_article_id( ) {
		$dbMock = $this->getMock('StdClass', array( 'selectSQLText', 'query', 'addQuotes' ));
		$inputArray = array(
			array(
				'article' => 1,
				'user' => 101,
				'revisionId' => 201,
				'timestamp' => 1363353927,
			),
			array(
				'article' => 2,
				'user' => 101,
				'revisionId' => 201,
				'timestamp' => 1363353927,
			),
			array(
				'article' => 1,
				'user' => 101,
				'revisionId' => 201,
				'timestamp' => 1363353927,
			),
			array(
				'article' => 1,
				'user' => 101,
				'revisionId' => 201,
				'timestamp' => 1363353927,
			),
			array(
				'article' => 1,
				'user' => 101,
				'revisionId' => 201,
				'timestamp' => 1363353927,
			),
			array(
				'article' => 1,
				'user' => 101,
				'revisionId' => 201,
				'timestamp' => 1363353927,
			),
		);
		$expectedResult = array(
			array(
				'article' => 1,
				'user' => 101,
				'revisionId' => 201,
				'timestamp' => 1363353927,
			),
			array(
				'article' => 2,
				'user' => 101,
				'revisionId' => 201,
				'timestamp' => 1363353927,
			),
			array(
				'article' => 1,
				'user' => 101,
				'revisionId' => 201,
				'timestamp' => 1363353927,
			),
		);
		$revisionService = new RevisionService( $dbMock, 0 );
		$result = $revisionService->filterDuplicates( $inputArray );

		$this->assertEquals($expectedResult, $result);
	}

	public function testFilterDuplicates_test_filtering_by_user_id( ) {
		$dbMock = $this->getMock('StdClass', array( 'selectSQLText', 'query', 'addQuotes' ));
		$inputArray = array(
			array(
				'article' => 1,
				'user' => 101,
				'revisionId' => 201,
				'timestamp' => 1363353927,
			),
			array(
				'article' => 1,
				'user' => 101,
				'revisionId' => 201,
				'timestamp' => 1363353927,
			),
			array(
				'article' => 1,
				'user' => 102,
				'revisionId' => 201,
				'timestamp' => 1363353927,
			),
			array(
				'article' => 1,
				'user' => 101,
				'revisionId' => 201,
				'timestamp' => 1363353927,
			),
			array(
				'article' => 1,
				'user' => 101,
				'revisionId' => 201,
				'timestamp' => 1363353927,
			),
			array(
				'article' => 1,
				'user' => 101,
				'revisionId' => 201,
				'timestamp' => 1363353927,
			),
		);
		$expectedResult = array(
			array(
				'article' => 1,
				'user' => 101,
				'revisionId' => 201,
				'timestamp' => 1363353927,
			),
			array(
				'article' => 1,
				'user' => 102,
				'revisionId' => 201,
				'timestamp' => 1363353927,
			),
			array(
				'article' => 1,
				'user' => 101,
				'revisionId' => 201,
				'timestamp' => 1363353927,
			),
		);
		$revisionService = new RevisionService( $dbMock, 0 );
		$result = $revisionService->filterDuplicates( $inputArray );

		$this->assertEquals($expectedResult, $result);
	}

	/**
	 * @dataProvider filterByArticleDataProvider
	 */
	public function testFilterByArticle( $testDescription, $input, $expected ) {
		$dbMock = $this->getMock('StdClass', array( 'selectSQLText', 'query', 'addQuotes' ));
		$revisionService = new RevisionService( $dbMock, 0 );
		$result = $revisionService->filterByArticle( $input );

		$this->assertEquals($expected, $result, $testDescription);
	}

	public function filterByArticleDataProvider() {
		return [
			[
				'Empty input',
				'input' => [],
				'expected' => [],
			],
			[
				'One result of the same page',
				'input' => [
					[
						'article' => 1,
						'user' => 101,
						'revisionId' => 201,
						'timestamp' => 1363353927,
					],
					[
						'article' => 1,
						'user' => 101,
						'revisionId' => 201,
						'timestamp' => 1363353827,
					],
					[
						'article' => 1,
						'user' => 101,
						'revisionId' => 201,
						'timestamp' => 1363353727,
					],
				],
				'expected' => [
					[
						'article' => 1,
						'user' => 101,
						'revisionId' => 201,
						'timestamp' => 1363353927,
					]
				],
			],
			[
				'Multiple results of different pages',
				'input' => [
					[
						'article' => 1,
						'user' => 101,
						'revisionId' => 201,
						'timestamp' => 1363353927,
					],
					[
						'article' => 2,
						'user' => 101,
						'revisionId' => 201,
						'timestamp' => 1363353827,
					],
					[
						'article' => 1,
						'user' => 101,
						'revisionId' => 201,
						'timestamp' => 1363353727,
					],
					[
						'article' => 1,
						'user' => 101,
						'revisionId' => 201,
						'timestamp' => 1363353627,
					],
					[
						'article' => 2,
						'user' => 101,
						'revisionId' => 201,
						'timestamp' => 1363353527,
					],
					[
						'article' => 3,
						'user' => 101,
						'revisionId' => 201,
						'timestamp' => 1363353427,
					],
				],
				'expected' => [
					[
						'article' => 1,
						'user' => 101,
						'revisionId' => 201,
						'timestamp' => 1363353927,
					],
					[
						'article' => 2,
						'user' => 101,
						'revisionId' => 201,
						'timestamp' => 1363353827,
					],
					[
						'article' => 3,
						'user' => 101,
						'revisionId' => 201,
						'timestamp' => 1363353427,
					]
				],
			],
		];
	}
}
