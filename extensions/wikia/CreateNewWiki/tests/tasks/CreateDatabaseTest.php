<?php

namespace Wikia\CreateNewWiki\Tasks;

class CreateDatabaseTest extends \WikiaBaseTest {

	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../../CreateNewWiki_setup.php';
		parent::setUp();

	}

	public function tearDown() {
		parent::tearDown();
	}

	public function testPrepare( $taskContextInputData, $taskContextExpected ) {
		$taskContext = new TaskContext( $taskContextInputData );

		$task = new CreateDatabase( $taskContext );
		$result = $task->prepare();

		$taskContextData = (array) $taskContext;
		foreach ($taskContextExpected as $key => $value) {
			$this->assertEquals( $value, $taskContextData[ $key ] );
		}
		$this->assertEquals( true, $result->isOk());
	}

	public function dataProviderPrepare() {
		return [
			[
				[ 'wikiName' => 'testWiki', 'language' => 'en' ],
				[ 'dbName' => 'testWiki' ],
				[ 'wikiName' => 'testWiki', 'language' => 'de' ],
				[ 'dbName' => 'de_testWiki' ],
			]
		];
	}
}
