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
			], [
				// Add Entertainment category if vertical is TV
				\WikiFactoryHub::VERTICAL_ID_TV,
				[\WikiFactoryHub::CATEGORY_ID_BOOKS, \WikiFactoryHub::CATEGORY_ID_COMICS],
				[\WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT, \WikiFactoryHub::CATEGORY_ID_BOOKS, \WikiFactoryHub::CATEGORY_ID_COMICS]
			], [
				// Add Entertainment category if vertical is Books
				\WikiFactoryHub::VERTICAL_ID_BOOKS,
				[\WikiFactoryHub::CATEGORY_ID_BOOKS, \WikiFactoryHub::CATEGORY_ID_COMICS],
				[\WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT, \WikiFactoryHub::CATEGORY_ID_BOOKS, \WikiFactoryHub::CATEGORY_ID_COMICS]
			], [
				// Add Entertainment category if vertical is Comics
				\WikiFactoryHub::VERTICAL_ID_COMICS,
				[\WikiFactoryHub::CATEGORY_ID_BOOKS, \WikiFactoryHub::CATEGORY_ID_COMICS],
				[\WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT, \WikiFactoryHub::CATEGORY_ID_BOOKS, \WikiFactoryHub::CATEGORY_ID_COMICS]
			], [
				// Add Entertainment category if vertical is Music
				\WikiFactoryHub::VERTICAL_ID_MUSIC,
				[\WikiFactoryHub::CATEGORY_ID_BOOKS, \WikiFactoryHub::CATEGORY_ID_COMICS],
				[\WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT, \WikiFactoryHub::CATEGORY_ID_BOOKS, \WikiFactoryHub::CATEGORY_ID_COMICS]
			], [
				// Add Gaming category if vertical is Movies
				\WikiFactoryHub::VERTICAL_ID_MOVIES,
				[\WikiFactoryHub::CATEGORY_ID_BOOKS, \WikiFactoryHub::CATEGORY_ID_COMICS],
				[\WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT, \WikiFactoryHub::CATEGORY_ID_BOOKS, \WikiFactoryHub::CATEGORY_ID_COMICS]
			], [
				// Add Lifestyle category if vertical is Lifestyle
				\WikiFactoryHub::VERTICAL_ID_LIFESTYLE,
				[\WikiFactoryHub::CATEGORY_ID_BOOKS, \WikiFactoryHub::CATEGORY_ID_COMICS],
				[\WikiFactoryHub::CATEGORY_ID_LIFESTYLE, \WikiFactoryHub::CATEGORY_ID_BOOKS, \WikiFactoryHub::CATEGORY_ID_COMICS]
			]
		];
	}
}
