<?php

namespace Wikia\CreateNewWiki\Tasks;

class ConfigureCategoriesTest extends \WikiaBaseTest {
	private $taskContextMock;

	public function setUp()
	{
		$this->setupFile = dirname(__FILE__) . '/../../CreateNewWiki_setup.php';
		parent::setUp();

		$this->taskContextMock = $this->getMock( '\Wikia\CreateNewWiki\Tasks\TaskContext' );
		$this->mockClass( 'TaskContext', $this->taskContextMock );
	}

	public function tearDown()
	{
		parent::tearDown();
	}

	/**
	 * @dataProvider prepareCategoriesDataProvider
	 * @param int $vertical
	 * @param array $categories
	 * @param array $expected
	 */
	public function testPrepareCategories($vertical, $categories, $expected) {
		$configureCategoriesTask = new ConfigureCategories($this->taskContextMock);
		$result = $configureCategoriesTask->prepareCategories($vertical, $categories);
		$this->assertEquals($expected, $result);
	}

	public function prepareCategoriesDataProvider() {
		return [
			[
				// Add Gaming category if vertical is video games
				\WikiFactoryHub::VERTICAL_ID_VIDEO_GAMES,
				[\WikiFactoryHub::CATEGORY_ID_BOOKS, \WikiFactoryHub::CATEGORY_ID_COMICS],
				[\WikiFactoryHub::CATEGORY_ID_GAMING, \WikiFactoryHub::CATEGORY_ID_BOOKS, \WikiFactoryHub::CATEGORY_ID_COMICS]
			]
		];
	}
}
