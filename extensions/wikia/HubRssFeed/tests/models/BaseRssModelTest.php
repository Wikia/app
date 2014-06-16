<?php
include_once dirname(__FILE__) . '/../../' . "models/BaseRssModel.class.php";

class DummyModel extends BaseRssModel
{
	public function getFeedTitle()
	{
	}

	public function getFeedLanguage()
	{
	}

	public function getFeedDescription()
	{
	}

	protected function loadData($lastTimestamp, $duplicates)
	{
	}

	protected function formatTitle($item)
	{
		return $item;
	}
}

class BaseRssModelTest extends WikiaBaseTest
{
	protected static function getFn($obj, $name)
	{
		$class = new ReflectionClass(get_class($obj));
		$method = $class->getMethod($name);
		$method->setAccessible(true);

		return function () use ($obj, $method) {
			$args = func_get_args();
			return $method->invokeArgs($obj, $args);
		};
	}

	public function setUp()
	{
		$dir = dirname(__FILE__) . '/../../';
		$this->setupFile = $dir . 'HubRssFeed.setup.php';

		parent::setUp();
	}

	/**
	 * @covers BaseRssModel::makeBlogTitle
	 */
	public function testMakeBlogTitle()
	{
		$dummy = new DummyModel();
		$makeBlogTitle = self::getFn($dummy, 'makeBlogTitle');
		$item = [
			"ns" => NS_BLOG_ARTICLE,
			"wikititle" => "dummy",
			"page_id" => 4,
			"wikia_id" => 831,
		];

		$this->assertEquals($makeBlogTitle($item)['title'], "Muppet Wiki from dummy");

		$item = [
			"ns" => NS_BLOG_ARTICLE,
			"page_id" => 4,
			"wikia_id" => 831,
		];
		$this->assertEquals($makeBlogTitle($item)['title'], "Muppet Wiki from Muppet Wiki");
	}

	/**
	 * @covers BaseRssModel::removeDuplicates
	 */
	public function testRemoveDuplicates()
	{
		$dummy = new DummyModel();
		$removeDuplicates = self::getFn($dummy, 'removeDuplicates');

		$this->assertEquals($removeDuplicates(null, null), []);

		$duplicatedRawData = [
			["url" => "a"],
			["url" => "a"],
			["url" => "b"],
			["url" => "c"],
		];
		$this->assertEquals($removeDuplicates($duplicatedRawData, null), [
			["url" => "a"],
			["url" => "a"],
			["url" => "b"],
			["url" => "c"]]);

		$this->assertEquals(array_values($removeDuplicates($duplicatedRawData, ["a" => true, "c" => true])), [
			["url" => "b"],
		]);

		$this->assertEquals($removeDuplicates($duplicatedRawData, ["x" => true]), [
			["url" => "a"],
			["url" => "a"],
			["url" => "b"],
			["url" => "c"]]);
	}

	/**
	 * @group UsingDB
	 * @covers BaseRssModel::processItems
	 */
	public function testProcessItems()
	{
		$dummy = new DummyModel();
		$processItems = self::getFn($dummy, 'processItems');

		$sampleItems = [
			[
				'url' => "dummy_url",
				"ns" => NS_BLOG_ARTICLE,
				"page_id" => 49, //miss piggy
				"wikia_id" => 831, //muppets
			],
			[
				'url' => "dummy_url2",
				"ns" => NS_BLOG_ARTICLE,
				"page_id" => 4,
				"wikia_id" => 831,
			],
		];

		$processedData = $processItems($sampleItems);
		$this->assertArrayHasKey('timestamp', $processedData['dummy_url']);
		$this->assertLessThan($processedData['dummy_url']['timestamp'], $processedData['dummy_url2']['timestamp']);

		$this->assertNotNull($processedData['dummy_url']['description']);
		$this->assertNotNull($processedData['dummy_url']['img']['url']);
	}

}
